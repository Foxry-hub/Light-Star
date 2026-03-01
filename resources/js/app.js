import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

/* ══════════════════════════════════════════════════════
   Light Star – Landing Page Interactivity
   ══════════════════════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', () => {

    /* ── Scroll Animations (Intersection Observer) ──── */
    const animatedElements = document.querySelectorAll('.fade-up, .fade-left, .fade-right');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    animatedElements.forEach(el => observer.observe(el));

    /* ── Sticky Header with background change ──────── */
    const header = document.getElementById('main-header');
    if (header) {
        window.addEventListener('scroll', () => {
            header.classList.toggle('nav-scrolled', window.scrollY > 50);
        });
    }

    /* ── Mobile Menu Toggle ─────────────────────────── */
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            const bars = menuBtn.querySelectorAll('span');
            const isOpen = !mobileMenu.classList.contains('hidden');
            bars[0].style.transform = isOpen ? 'rotate(45deg) translate(5px, 5px)' : '';
            bars[1].style.opacity = isOpen ? '0' : '1';
            bars[2].style.transform = isOpen ? 'rotate(-45deg) translate(7px, -6px)' : '';
        });
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                const bars = menuBtn.querySelectorAll('span');
                bars[0].style.transform = ''; bars[1].style.opacity = '1'; bars[2].style.transform = '';
            });
        });
    }

    /* ── Smooth Scroll for Nav Links ────────────────── */
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offset = target.getBoundingClientRect().top + window.pageYOffset - 80;
                window.scrollTo({ top: offset, behavior: 'smooth' });
            }
        });
    });

    /* ── Testimonial Carousel ───────────────────────── */
    const track = document.getElementById('testimonial-track');
    const prevBtn = document.getElementById('carousel-prev');
    const nextBtn = document.getElementById('carousel-next');
    const dots = document.querySelectorAll('.carousel-dot');
    let currentSlide = 0, totalSlides = 0, autoPlayInterval;

    if (track) {
        totalSlides = track.children.length;
        const goToSlide = (index) => {
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;
            currentSlide = index;
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
            dots.forEach((dot, i) => {
                dot.classList.toggle('bg-cyan', i === currentSlide);
                dot.classList.toggle('w-8', i === currentSlide);
                dot.classList.toggle('bg-navy-border', i !== currentSlide);
                dot.classList.toggle('w-3', i !== currentSlide);
            });
        };
        if (prevBtn) prevBtn.addEventListener('click', () => { goToSlide(currentSlide - 1); resetAutoPlay(); });
        if (nextBtn) nextBtn.addEventListener('click', () => { goToSlide(currentSlide + 1); resetAutoPlay(); });
        dots.forEach((dot, i) => dot.addEventListener('click', () => { goToSlide(i); resetAutoPlay(); }));
        const startAutoPlay = () => { autoPlayInterval = setInterval(() => goToSlide(currentSlide + 1), 5000); };
        const resetAutoPlay = () => { clearInterval(autoPlayInterval); startAutoPlay(); };
        startAutoPlay();
        goToSlide(0);
    }

    /* ── FAQ Accordion ──────────────────────────────── */
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        item.querySelector('.faq-header').addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            faqItems.forEach(i => i.classList.remove('active'));
            if (!isActive) item.classList.add('active');
        });
    });

    /* ── FAQ Search ─────────────────────────────────── */
    const faqSearch = document.getElementById('faq-search');
    if (faqSearch) {
        faqSearch.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            faqItems.forEach(item => {
                item.style.display = item.textContent.toLowerCase().includes(query) ? '' : 'none';
            });
        });
    }

    /* ── Active Nav highlight ──────────────────────── */
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');
    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(s => { if (window.scrollY >= s.offsetTop - 100) current = s.id; });
        navLinks.forEach(l => {
            l.classList.toggle('text-cyan', l.getAttribute('href') === `#${current}`);
        });
    });

    /* ── Counter Animation ──────────────────────────── */
    const counters = document.querySelectorAll('.counter');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = +entry.target.getAttribute('data-target');
                const start = performance.now();
                const update = (now) => {
                    const p = Math.min((now - start) / 2000, 1);
                    const eased = 1 - Math.pow(1 - p, 3);
                    entry.target.textContent = Math.floor(eased * target);
                    if (p < 1) requestAnimationFrame(update);
                    else entry.target.textContent = target;
                };
                requestAnimationFrame(update);
                counterObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    counters.forEach(c => counterObserver.observe(c));
});
