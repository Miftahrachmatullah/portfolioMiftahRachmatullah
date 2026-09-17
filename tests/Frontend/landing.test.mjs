import assert from 'node:assert/strict';
import { readFile } from 'node:fs/promises';
import { test } from 'node:test';
import vm from 'node:vm';

const source = (await readFile(new URL('../../resources/js/landing.js', import.meta.url), 'utf8'))
    .replaceAll('export function', 'function').split("if (typeof document !== 'undefined')")[0];

function page({ reducedMotion = true } = {}) {
    const timers = new Map();
    let counter = 0;
    const requests = [];
    const status = { textContent: '' };
    const role = { dataset: { roles: '["Designer","Developer"]' }, textContent: '' };
    const button = { attrs: {}, setAttribute(name, value) { this.attrs[name] = value; } };
    const marquee = { paused: false, classList: { toggle(name, value) { marquee.paused = value; } } };
    const root = {
        innerHTML: '<section>Original</section>', dataset: { endpoint: '/landing-content' },
        contains: () => false,
        querySelector(selector) { return { '[data-roles]': role, '[data-marquee]': marquee, '[data-marquee-pause]': button }[selector]; },
        addEventListener(name, fn) { this.listener = fn; }, removeEventListener() {},
    };
    const context = vm.createContext({
        AbortController,
        document: { hidden: false, activeElement: null, getElementById: () => status },
        window: {
            fetch: async (url, options) => { requests.push({ url, options }); return response('<section>Updated</section>'); },
            setTimeout(fn, delay) { const id = ++counter; timers.set(id, { fn, delay }); return id; },
            clearTimeout(id) { timers.delete(id); },
            matchMedia: () => ({ matches: reducedMotion }),
        },
    });
    vm.runInContext(source, context);
    const stop = context.initLanding(root);
    const run = async delay => {
        const entry = [...timers].find(([, task]) => task.delay === delay);
        assert.ok(entry, 'expected a scheduled timer');
        timers.delete(entry[0]);
        await entry[1].fn();
    };
    return { root, role, status, context, requests, button, marquee, timers, stop, run };
}

function response(html, { ok = true, contentType = 'text/html; charset=UTF-8' } = {}) {
    return { ok, headers: { get: () => contentType }, text: async () => html };
}

test('CMS refresh updates markup, preserves unchanged content and sends no-store', async () => {
    const app = page();
    await app.run(5000);
    assert.equal(app.root.innerHTML, '<section>Updated</section>');
    assert.equal(app.requests[0].url, '/landing-content');
    assert.equal(app.requests[0].options.cache, 'no-store');
    assert.match(app.status.textContent, /diperbarui/);
    app.root.innerHTML = '<section>Current animation state</section>';
    await app.run(5000);
    assert.equal(app.root.innerHTML, '<section>Current animation state</section>');
    app.stop();
    assert.equal(app.timers.size, 0);
});

test('CMS refresh pauses for background tabs or focused content', async () => {
    const app = page();
    app.context.document.hidden = true;
    await app.run(5000);
    app.context.document.hidden = false;
    app.root.contains = () => true;
    await app.run(5000);
    assert.equal(app.requests.length, 0);
});

test('CMS failures retain current content and recover on the next poll', async () => {
    const app = page();
    // Reinitialize with a controlled fetcher since initLanding captures its dependency.
    app.stop();
    let fail = true;
    app.context.window.fetch = async () => { if (fail) throw new Error('offline'); return response('<section>Recovered</section>'); };
    app.context.initLanding(app.root);
    await app.run(5000);
    assert.equal(app.root.innerHTML, '<section>Original</section>');
    assert.match(app.status.textContent, /tertunda/);
    fail = false;
    await app.run(5000);
    assert.equal(app.root.innerHTML, '<section>Recovered</section>');
    assert.match(app.status.textContent, /diperbarui/);
});

test('CMS never inserts error pages, empty responses, or non-HTML responses', async () => {
    const app = page();
    app.stop();
    for (const result of [response('error', { ok: false }), response('{}', { contentType: 'application/json' }), response('')]) {
        app.context.window.fetch = async () => result;
        const stop = app.context.initLanding(app.root);
        await app.run(5000);
        assert.equal(app.root.innerHTML, '<section>Original</section>');
        stop();
    }
});

test('CMS retains keyboard focus if it moves during a request and aborts on cleanup', async () => {
    const app = page();
    app.stop();
    let signal;
    app.context.window.fetch = async (url, options) => {
        signal = options.signal;
        app.root.contains = () => true;
        return response('<section>Do not replace</section>');
    };
    let stop = app.context.initLanding(app.root);
    await app.run(5000);
    assert.equal(app.root.innerHTML, '<section>Original</section>');
    stop();
    app.root.contains = () => false;
    app.context.window.fetch = (url, options) => {
        signal = options.signal;
        return new Promise((resolve, reject) => signal.addEventListener('abort', () => reject(new Error('aborted'))));
    };
    stop = app.context.initLanding(app.root);
    const pending = app.run(5000);
    stop();
    await pending;
    assert.equal(signal.aborted, true);
    assert.equal(app.timers.size, 0);
});

test('roles come from CMS data and reduced-motion disables their rotation', async () => {
    const still = page();
    assert.equal(still.role.textContent, 'Designer');
    assert.equal([...still.timers.values()].some(task => task.delay === 2600), false);
    const animated = page({ reducedMotion: false });
    await animated.run(2600);
    assert.equal(animated.role.textContent, 'Developer');
    assert.deepEqual(Array.from(animated.context.parseRoles('{"invalid":true}')), []);
    assert.deepEqual(Array.from(animated.context.parseRoles('bad json')), []);
    assert.deepEqual(Array.from(animated.context.parseRoles('["Valid",42,null,""]')), ['Valid']);
});

test('marquee pause control persists when the CMS markup refreshes', async () => {
    const app = page();
    app.root.listener({ target: { closest: () => app.button } });
    assert.equal(app.button.attrs['aria-pressed'], 'true');
    assert.equal(app.marquee.paused, true);
    await app.run(5000);
    assert.equal(app.marquee.paused, true);
    assert.equal(app.button.attrs['aria-label'], 'Lanjutkan animasi');
});
