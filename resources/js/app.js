import './portfolio';

document.querySelectorAll('[data-delete-form]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        const dialog = document.getElementById('delete-dialog');
        if (!dialog?.showModal) {
            if (!window.confirm('Pindahkan project ke sampah?')) event.preventDefault();
            return;
        }
        event.preventDefault();
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
