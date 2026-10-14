const sectionDialog = document.querySelector('#section-dialog');

if (sectionDialog) {
    document.querySelectorAll('[data-interest]').forEach((button) => {
        button.addEventListener('click', () => {
            document.querySelector('.mobile-nav')?.removeAttribute('open');
            sectionDialog.querySelector('#dialog-title').textContent = button.dataset.interest;
            sectionDialog.showModal();
        });
    });
}
