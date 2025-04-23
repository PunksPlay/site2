

document.addEventListener('scroll', () => {
    const scrollTop = document.getElementById('scrollTop');
    if (window.scrollY > 200) {
        scrollTop.style.display = 'block';
    } else {
        scrollTop.style.display = 'none';
    }
});

document.getElementById('scrollTop').addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});