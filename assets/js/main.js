// Import Swiper and required modules
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/effect-fade';

import AOS from 'aos';

document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
  once: true,
  mirror: false,
  disableMutationObserver: true,
});

  initHeroSwiper();
  initProjectSwiper();
  initHeroVideo();
  initScrollHeader();
  initMobileMenu();
});
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

function initMobileMenu() {
  const toggleBtn = document.getElementById('secondary-menu-toggle');
  const panel = document.getElementById('secondary-menu-panel');
  const overlay = document.getElementById('secondary-menu-overlay');
  
  const backBtn = document.getElementById('submenu-back-btn');
  const closeBtn = document.getElementById('menu-close-btn');
  const backLabel = document.getElementById('back-button-label');
  const menuContainer = document.getElementById('menu-levels-container');
  
  if (!toggleBtn || !panel) return;

  // Function to dynamically add toggle buttons to menu items with children
  function addSubmenuToggles() {
    const menu = document.getElementById('secondary-menu');
    if (!menu) return;

    const itemsWithChildren = menu.querySelectorAll('.menu-item-has-children');

    itemsWithChildren.forEach(item => {
      if (item.querySelector('.submenu-toggle')) {
        return;
      }
      const toggle = document.createElement('button');
      toggle.className = 'submenu-toggle';
      toggle.setAttribute('aria-label', 'Open submenu');
      toggle.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path></svg>';
      item.querySelector('a').after(toggle);
    });
  }

  let currentDepth = 0;
  const historyStack = [];

  function openMenu() {
    toggleBtn.classList.add('open');
    panel.classList.remove('-translate-x-full');
    panel.classList.add('translate-x-0');
    if (overlay) overlay.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    resetMenu();
  }

  function closeMenu() {
    toggleBtn.classList.remove('open');
    panel.classList.remove('translate-x-0');
    panel.classList.add('-translate-x-full');
    if (overlay) overlay.classList.add('hidden');
    document.body.style.overflow = '';
    
    setTimeout(resetMenu, 300); 
  }
  
  function resetMenu() {
    currentDepth = 0;
    historyStack.length = 0;
    
    const menuLevels = menuContainer.querySelectorAll('[class^="menu-level-"]');
    if (menuLevels.length > 1) {
        for (let i = 1; i < menuLevels.length; i++) {
            menuLevels[i].remove();
        }
    }
    
    const level0 = menuContainer.querySelector('.menu-level-0');
    if (level0) {
        level0.style.left = '0%';
    }

    updateMenuDisplay();
  }
  
  function updateMenuDisplay() {
    if (currentDepth > 0) {
      backBtn.classList.remove('hidden');
      const parentItem = historyStack[historyStack.length - 1];
      backLabel.textContent = parentItem ? parentItem.querySelector('a').textContent : 'BACK';
    } else {
      backBtn.classList.add('hidden');
    }
    
    menuContainer.style.transform = `translateX(-${currentDepth * 100}%)`;
  }
  
  function handleSubmenuToggle(e) {
    const toggleButton = e.target.closest('.submenu-toggle');
    if (!toggleButton) return;
    
    e.preventDefault();
    e.stopPropagation();
    
    const parentListItem = toggleButton.closest('li.menu-item-has-children');
    const submenu = parentListItem.querySelector('.sub-menu');
    
    if (!submenu) return;
    
    currentDepth++;
    historyStack.push(parentListItem);
    
    const newMenuLevel = document.createElement('nav');
    newMenuLevel.classList.add(`menu-level-${currentDepth}`, 'absolute', 'top-0', 'left-full', 'w-full', 'h-full', 'p-8', 'pt-0', 'transition-transform', 'duration-300', 'ease-in-out');
    
    const submenuClone = submenu.cloneNode(true); 
    newMenuLevel.appendChild(submenuClone);
    
    menuContainer.appendChild(newMenuLevel);

    setTimeout(() => {
        updateMenuDisplay();
    }, 10);
  }
  
  function handleBackButtonClick() {
    if (currentDepth <= 0) return;
    
    const oldDepth = currentDepth;
    currentDepth--;
    
    historyStack.pop();
    
    updateMenuDisplay();
    
    const menuLevelToRemove = document.querySelector(`.menu-level-${oldDepth}`);
    
    if (menuLevelToRemove) {
      menuLevelToRemove.style.left = '100%'; 
      setTimeout(() => {
        menuLevelToRemove.remove();
      }, 300);
    }
  }

  // Initial setup
  addSubmenuToggles();

  toggleBtn.addEventListener('click', () => {
    if (toggleBtn.classList.contains('open')) {
      closeMenu();
    } else {
      openMenu();
    }
  });
  
  if (overlay) {
    overlay.addEventListener('click', closeMenu);
  }
  
  if (closeBtn) {
      closeBtn.addEventListener('click', closeMenu);
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && toggleBtn.classList.contains('open')) {
      closeMenu();
    }
  });
  
  panel.addEventListener('click', handleSubmenuToggle);
  
  backBtn.addEventListener('click', handleBackButtonClick);
}