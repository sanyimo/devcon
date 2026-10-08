const backToTop = document.querySelector('.back-to-top');

if (backToTop) {
    const updateVisibility = () => {
        backToTop.classList.toggle('back-to-top--visible', window.scrollY >= window.innerHeight);
    };

    window.addEventListener('scroll', updateVisibility, { passive: true });
    updateVisibility();
}
