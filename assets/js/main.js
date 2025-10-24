// Import Swiper and required modules
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

// Import AOS
import AOS from 'aos';

/**
 * Initialize when DOM is ready
 */
document.addEventListener('DOMContentLoaded', () => {
  AOS.init();
  initHeroSwiper();
  initProjectSwiper();
  initHeroVideo();
  initScrollHeader();
  initMobileMenu();
});

/**
 * Initialize Hero Image Swiper
 */
function initHeroSwiper() {
  const heroSwiper = document.querySelector('.hero-swiper');
  if (!heroSwiper) return;
  
  new Swiper('.hero-swiper', {
    modules: [Navigation, Pagination, Autoplay, EffectFade],
    effect: 'fade',
    fadeEffect: { crossFade: true },
    speed: 1000,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true
    },
    loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
      dynamicBullets: true
    }
  });
}

/**
 * Initialize Project Swiper (Carousel)
 */
function initProjectSwiper() {
  const projectSwiper = document.querySelector('.project-swiper');
  if (!projectSwiper) return;
  
  new Swiper('.project-swiper', {
    modules: [Navigation, Autoplay], 
    slidesPerView: 1.2, 
    spaceBetween: 20, 
    loop: true, 
    
    autoplay: {
      delay: 2000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true
    },
    
    navigation: {
      nextEl: '.project-swiper-next', 
      prevEl: '.project-swiper-prev', 
    },
    
    breakpoints: {
      768: {
        slidesPerView: 3.2,
        spaceBetween: 30
      },
      1024: {
        slidesPerView: 4, 
        spaceBetween: 30
      }
    }
  });
}

/**
 * Initialize Hero Video Background
 */
function initHeroVideo() {
  const videoElement = document.querySelector('.hero-video-bg video');
  if (!videoElement) return;
  
  const playVideo = () => {
    videoElement.play().catch(error => {
      console.log('Video autoplay prevented:', error);
    });
  };
  
  playVideo();
  
  document.addEventListener('visibilitychange', () => {
    document.hidden ? videoElement.pause() : playVideo();
  });
}

/**
 * Initialize Scroll Header
 */
function initScrollHeader() {
  const header = document.getElementById('masthead');
  if (!header) return;

  window.addEventListener('scroll', () => {
    if (window.pageYOffset > 400) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });
}

/**
 * Initialize Mobile Menu
 */
function initMobileMenu() {
  const toggleBtn = document.getElementById('secondary-menu-toggle');
  const panel = document.getElementById('secondary-menu-panel');
  const overlay = document.getElementById('secondary-menu-overlay');

  if (!toggleBtn || !panel) return;

  // Open menu
  function openMenu() {
    toggleBtn.classList.add('open');
    panel.classList.remove('-translate-x-full');
    panel.classList.add('translate-x-0');
    if (overlay) overlay.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  // Close menu
  function closeMenu() {
    toggleBtn.classList.remove('open');
    panel.classList.remove('translate-x-0');
    panel.classList.add('-translate-x-full');
    if (overlay) overlay.classList.add('hidden');
    document.body.style.overflow = '';
  }

  // Toggle on button click
  toggleBtn.addEventListener('click', () => {
    if (toggleBtn.classList.contains('open')) {
      closeMenu();
    } else {
      openMenu();
    }
  });

  // Close on overlay click
  if (overlay) {
    overlay.addEventListener('click', closeMenu);
  }

  // Close on ESC key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && toggleBtn.classList.contains('open')) {
      closeMenu();
    }
  });
}