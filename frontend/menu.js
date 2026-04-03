document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('menu-toggle');
    const nav = document.getElementById('primary-nav');
    if (!btn || !nav) return;

    const toggle = () => {
        const open = nav.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    };

    btn.addEventListener('click', toggle);

   
    nav.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
        if (nav.classList.contains('is-open')) toggle();
    }));
});
