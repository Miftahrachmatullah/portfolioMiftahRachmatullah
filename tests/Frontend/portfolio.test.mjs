import assert from 'node:assert/strict';
import { readFile } from 'node:fs/promises';
import { test } from 'node:test';
import vm from 'node:vm';

const source = await readFile(new URL('../../resources/js/portfolio.js', import.meta.url), 'utf8');

function page() {
    const updates = [];
    const requests = [];
    const results = {
        innerHTML: '<article>Old project</article>',
        dataset: { endpoint: '/projects/fragment' },
        contains: () => false,
        replaceChildren: (fragment) => updates.push(fragment),
    };
    const status = { textContent: '' };
    const context = vm.createContext({
        AbortSignal,
        document: {
            hidden: false,
            activeElement: null,
            getElementById: (id) => id === 'project-results' ? results : status,
            addEventListener() {},
            createRange: () => ({ createContextualFragment: (html) => html }),
        },
        window: { location: { search: '?category=frontend&page=2' }, setInterval() {}, addEventListener() {} },
        fetch: async (url, options) => {
            requests.push({ url, options });
            return { ok: true, text: async () => '<article>Updated project</article>' };
        },
    });
    vm.runInContext(source, context);
    return { context, results, status, updates, requests, refresh: () => context.refreshProjects() };
}

test('polling refreshes changed project markup with the current filters and page', async () => {
    const app = page();
    await app.refresh();
    assert.equal(app.requests[0].url, '/projects/fragment?category=frontend&page=2');
    assert.equal(app.requests[0].options.cache, 'no-store');
    assert.deepEqual(app.updates, ['<article>Updated project</article>']);
    await app.refresh();
    assert.equal(app.updates.length, 1, 'unchanged markup must not replace focused content');
});

test('polling pauses for hidden tabs and while keyboard focus is in the results', async () => {
    const app = page();
    app.context.document.hidden = true;
    await app.refresh();
    app.context.document.hidden = false;
    app.results.contains = () => true;
    await app.refresh();
    assert.equal(app.requests.length, 0);
});

test('network failure keeps existing project cards and displays a recoverable message', async () => {
    const app = page();
    app.context.fetch = async () => { throw new Error('offline'); };
    await app.refresh();
    assert.equal(app.updates.length, 0);
    assert.match(app.status.textContent, /Pembaruan otomatis tertunda/);
    app.context.fetch = async () => ({ ok: true, text: async () => '<article>Recovered</article>' });
    await app.refresh();
    assert.deepEqual(app.updates, ['<article>Recovered</article>']);
    assert.equal(app.status.textContent, '');
});

test('polling never replaces results if focus moves into them during the request', async () => {
    const app = page();
    app.context.fetch = async () => {
        app.results.contains = () => true;
        return { ok: true, text: async () => '<article>New</article>' };
    };
    await app.refresh();
    assert.equal(app.updates.length, 0);
});
