import './portfolio';
import './landing';

document.querySelectorAll('[data-delete-form]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        const dialog = document.getElementById('delete-dialog');
        const message = form.dataset.deleteMessage || 'Project akan hilang dari landing page dan dipindahkan ke sampah. Data dan cover masih dapat dipulihkan.';
        if (!dialog?.showModal) {
            if (!window.confirm(message)) event.preventDefault();
            return;
        }
        event.preventDefault();
        dialog.querySelector('[data-delete-heading]').textContent = form.dataset.deleteTitle || 'Hapus project?';
        dialog.querySelector('[data-delete-message]').textContent = message;
        dialog.showModal();
        dialog.querySelector('[data-cancel-delete]').focus();
        dialog.querySelector('[data-confirm-delete]').onclick = () => form.submit();
        dialog.querySelector('[data-cancel-delete]').onclick = () => dialog.close();
    });
});

const upload = document.getElementById('cover-upload');
upload?.addEventListener('change', () => {
    const file = upload.files[0];
    const preview = document.getElementById('cover-preview');
    const error = document.getElementById('cover-error');
    error.textContent = '';
    if (!file) return;
    if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type) || file.size > 3 * 1024 * 1024) {
        error.textContent = 'Pilih gambar JPG, PNG, atau WebP maksimal 3 MB.';
        upload.value = '';
        preview.src = upload.dataset.currentCover || '';
        preview.hidden = !upload.dataset.currentCover;
        return;
    }
    const url = URL.createObjectURL(file);
    preview.src = url;
    preview.hidden = false;
    preview.onload = () => URL.revokeObjectURL(url);
});


document.querySelectorAll('[data-photo-field]').forEach((field) => {
    const input = field.querySelector('[data-photo-input]');
    const preview = field.querySelector('[data-photo-preview]');
    const error = field.querySelector('[data-photo-error]');
    let objectUrl;
    input.addEventListener('change', () => {
        if (objectUrl) URL.revokeObjectURL(objectUrl);
        error.textContent = '';
        const file = input.files[0];
        if (file && (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type) || file.size > 3 * 1024 * 1024)) {
            error.textContent = 'Pilih JPG, PNG, atau WebP maksimal 3 MB.';
            input.value = '';
        }
        objectUrl = file && input.value ? URL.createObjectURL(file) : null;
        preview.src = objectUrl || input.dataset.currentSrc || '';
        preview.hidden = !preview.getAttribute('src');
    });
    window.addEventListener('pagehide', () => { if (objectUrl) URL.revokeObjectURL(objectUrl); });
});
