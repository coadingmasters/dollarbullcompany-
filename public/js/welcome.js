(function () {
    'use strict';

    const AUTOPLAY_MS = 5500;

    const track      = document.getElementById('slidesTrack');
    const slides     = Array.from(track.querySelectorAll('.slide'));
    const dots       = Array.from(document.querySelectorAll('.dot'));
    const counterEl  = document.getElementById('counterCurrent');
    const progressEl = document.getElementById('slideProgress');
    const prevBtn    = document.getElementById('arrowPrev');
    const nextBtn    = document.getElementById('arrowNext');
    const total      = slides.length;

    let current  = 0;
    let timer    = null;
    let paused   = false;
    function goTo(idx) {
        idx = ((idx % total) + total) % total;
        slides[current].classList.remove('active');
        slides[current].setAttribute('aria-hidden', 'true');
        dots[current].classList.remove('active');
        dots[current].setAttribute('aria-selected', 'false');
        current = idx;
        track.style.transform = 'translateX(-' + (current * 100) + '%)';
        slides[current].classList.add('active');
        slides[current].setAttribute('aria-hidden', 'false');
        dots[current].classList.add('active');
        dots[current].setAttribute('aria-selected', 'true');
        counterEl.textContent = String(current + 1).padStart(2, '0');
        progressEl.style.transition = 'none';
        progressEl.style.width = '0%';
        void progressEl.offsetWidth; 
        progressEl.style.transition = 'width ' + AUTOPLAY_MS + 'ms linear';
        progressEl.style.width = '100%';
    }
    function startAuto() {
        stopAuto();
        if (!paused) {
            timer = setInterval(function () { goTo(current + 1); }, AUTOPLAY_MS);
        }
    }
    function stopAuto() { clearInterval(timer); }
    prevBtn.addEventListener('click', function () { goTo(current - 1); startAuto(); });
    nextBtn.addEventListener('click', function () { goTo(current + 1); startAuto(); });
    dots.forEach(function (dot, i) {
        dot.addEventListener('click', function () {
            if (i !== current) { goTo(i); startAuto(); }
        });
    });
    var touchX = 0;
    track.addEventListener('touchstart', function (e) {
        touchX = e.changedTouches[0].screenX;
    }, { passive: true });
    track.addEventListener('touchend', function (e) {
        var diff = touchX - e.changedTouches[0].screenX;
        if (Math.abs(diff) > 45) { goTo(diff > 0 ? current + 1 : current - 1); startAuto(); }
    }, { passive: true });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft')  { goTo(current - 1); startAuto(); }
        if (e.key === 'ArrowRight') { goTo(current + 1); startAuto(); }
    });
    var slider = document.getElementById('heroSlider');
    slider.addEventListener('mouseenter', function () { paused = true;  stopAuto(); progressEl.style.animationPlayState = 'paused'; });
    slider.addEventListener('mouseleave', function () { paused = false; startAuto(); });
    document.addEventListener('visibilitychange', function () {
        document.hidden ? stopAuto() : startAuto();
    });
    goTo(0);
    startAuto();

})();


(function () {
    var cards = document.querySelectorAll('[data-card]');
    if (!cards.length) return;

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        cards.forEach(function (c) { io.observe(c); });
    } else {
        cards.forEach(function (c) { c.classList.add('in-view'); });
    }
})();

(function () {
    var cols = document.querySelectorAll('[data-about-col]');
    if (!cols.length) return;
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) {
                if (e.isIntersecting) { e.target.classList.add('in-view'); io.unobserve(e.target); }
            });
        }, { threshold: 0.12 });
        cols.forEach(function (c) { io.observe(c); });
    } else {
        cols.forEach(function (c) { c.classList.add('in-view'); });
    }
})();
