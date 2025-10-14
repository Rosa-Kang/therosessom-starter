// Import Swiper and required modules
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

/**
 * Initialize when DOM is ready
 */
document.addEventListener('DOMContentLoaded', () => {
  initHeroSwiper();
  initHeroVideo();
  initScrollHeader(); 
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
    fadeEffect: {
      crossFade: true
    },
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
    },
    keyboard: {
      enabled: true,
      onlyInViewport: false
    },
    a11y: {
      prevSlideMessage: 'Previous slide',
      nextSlideMessage: 'Next slide',
    }
  });
}

/**
 * Initialize Hero Video Background
 */
function initHeroVideo() {
  const videoElement = document.querySelector('.hero-video-bg video');
  
  if (!videoElement) return;
  
  // Ensure video plays
  const playVideo = () => {
    videoElement.play().catch(error => {
      console.log('Video autoplay prevented:', error);
    });
  };
  
  // Initial play
  playVideo();
  
  // Handle visibility change to pause/play video
  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      videoElement.pause();
    } else {
      playVideo();
    }
  });
  
  // Ensure video is always playing when in viewport
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        playVideo();
      } else {
        videoElement.pause();
      }
    });
  }, {
    threshold: 0.5
  });
  
  observer.observe(videoElement);
}

/**
 * Initialize Scroll-based Header Animations
 */
function initScrollHeader() {
  const header = document.getElementById('masthead');
  if (!header) return; 
  const scrollThreshold = 400; 

  window.addEventListener('scroll', () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    
    if (scrollTop > scrollThreshold) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  }, false);
}