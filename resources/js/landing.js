export function parseRoles(value) {
    try {
        const roles = JSON.parse(value);
        return Array.isArray(roles) ? roles.filter(role => typeof role === 'string' && role.trim()) : [];
    } catch {
        return [];
    }
}

export function initLanding(root, {
    fetcher = window.fetch.bind(window),
    schedule = window.setTimeout.bind(window),
    cancel = window.clearTimeout.bind(window),
    reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches,
} = {}) {
    if (!root) return () => {};
    const status = document.getElementById('landing-sync-status');
    let previous = root.innerHTML.trim();
    let pollTimer, roleTimer, request, stopped = false, paused = false;

    const applyPause = () => {
        root.querySelector('[data-marquee]')?.classList.toggle('is-paused', paused);
        const button = root.querySelector('[data-marquee-pause]');
        if (button) {
            button.setAttribute('aria-pressed', String(paused));
            button.setAttribute('aria-label', paused ? 'Lanjutkan animasi' : 'Jeda animasi');
            button.textContent = paused ? '▶' : 'Ⅱ';
        }
    };

    const animate = () => {
        cancel(roleTimer);
        applyPause();
        const node = root.querySelector('[data-roles]');
        const roles = parseRoles(node?.dataset.roles);
        if (!node || !roles.length) return;
        node.textContent = roles[0];
        if (reducedMotion || roles.length < 2) return;
        let index = 0;
        const next = () => {
            if (stopped) return;
            if (!document.hidden) {
                index = (index + 1) % roles.length;
                node.textContent = roles[index];
            }
            roleTimer = schedule(next, 2600);
        };
        roleTimer = schedule(next, 2600);
    };

    const poll = async () => {
        if (stopped) return;
        if (!document.hidden && !root.contains(document.activeElement)) {
            request = new AbortController();
            const timeout = schedule(() => request?.abort(), 10000);
            try {
                const response = await fetcher(root.dataset.endpoint, {
                    cache: 'no-store', credentials: 'same-origin', signal: request.signal,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });
                if (!response.ok || !response.headers.get('content-type')?.includes('text/html')) throw new Error('Invalid content response');
                const html = (await response.text()).trim();
                if (!stopped && html && status) status.textContent = '';
                if (!stopped && html && html !== previous && !root.contains(document.activeElement)) {
                    root.innerHTML = html;
                    previous = html;
                    animate();
                    if (status) status.textContent = 'Konten portfolio telah diperbarui.';
                }
            } catch {
                if (!stopped && status) status.textContent = 'Pembaruan tertunda. Konten terakhir tetap tersedia.';
            } finally {
                cancel(timeout);
                request = null;
            }
        }
        if (!stopped) pollTimer = schedule(poll, 5000);
    };
    const onClick = event => {
        if (event.target.closest('[data-marquee-pause]')) { paused = !paused; applyPause(); }
    };
    root.addEventListener('click', onClick);
    animate();
    pollTimer = schedule(poll, 5000);
    return () => {
        stopped = true;
        cancel(pollTimer);
        cancel(roleTimer);
        request?.abort();
        root.removeEventListener('click', onClick);
    };
}

if (typeof document !== 'undefined') {
    const stop = initLanding(document.getElementById('landing-content'));
    window.addEventListener('pagehide', stop, { once: true });
    document.addEventListener('error', event => {
        if (event.target.matches?.('[data-skill-icon]')) event.target.hidden = true;
    }, true);
}
