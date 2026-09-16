const results = document.getElementById('project-results');
const status = document.getElementById('project-sync-status');
let pending = false;
let lastMarkup = results?.innerHTML.trim();

async function refreshProjects() {
    if (!results || pending || document.hidden || results.contains(document.activeElement)) return;
    pending = true;
    try {
        const response = await fetch(results.dataset.endpoint + window.location.search, {
            headers: { Accept: 'text/html' },
            cache: 'no-store',
            signal: AbortSignal.timeout(10000),
        });
        if (!response.ok) throw new Error('Failed to refresh');
        const markup = (await response.text()).trim();
        if (markup !== lastMarkup && !results.contains(document.activeElement)) {
            // HTML is rendered and escaped by the same-origin Blade template.
            results.replaceChildren(document.createRange().createContextualFragment(markup));
            lastMarkup = markup;
        }
        if (status) status.textContent = '';
    } catch {
        if (status) status.textContent = 'Pembaruan otomatis tertunda. Project terakhir tetap ditampilkan.';
    } finally {
        pending = false;
    }
}
if (results) {
    window.setInterval(refreshProjects, 5000);
    window.addEventListener('focus', refreshProjects);
    document.addEventListener('visibilitychange', refreshProjects);
}
