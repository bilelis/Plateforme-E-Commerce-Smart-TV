// Ayari.tn — Minimal Script
// Navigation responsive
const navToggle = document.querySelector('.nav-toggle');
if (navToggle) {
    navToggle.addEventListener('click', () => {
        document.querySelector('.nav-links').classList.toggle('active');
    });
}
