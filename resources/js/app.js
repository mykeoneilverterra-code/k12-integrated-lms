import 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {

    const sidebar = document.querySelector('.k12-sidebar');
    const overlay = document.querySelector('.k12-sidebar-overlay');
    const toggle = document.querySelector('[data-sidebar-toggle]');

    if (toggle && sidebar) {
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');

            if (overlay) {
                overlay.classList.toggle('show');
            }
        });
    }

    if (overlay) {
        overlay.addEventListener('click', () => {
            sidebar?.classList.remove('show');
            overlay.classList.remove('show');
        });
    }

});