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
    initAccordion(); 
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
        
        // 메뉴 패널이 완전히 닫힌 후 초기화
        setTimeout(resetMenu, 300); 
    }
    
    function resetMenu() {
        currentDepth = 0;
        historyStack.length = 0;
        
        const menuLevels = menuContainer.querySelectorAll('[class^="menu-level-"]');
        
        // 레벨 1 이상의 모든 동적 레벨 제거
        for (let i = 1; i < menuLevels.length; i++) {
            menuLevels[i].remove();
        }
        
        // 레벨 0 (메인 메뉴)를 초기 상태로 복원
        const level0 = menuContainer.querySelector('.menu-level-0');
        if (level0) {
            level0.style.left = '0%';
            level0.style.display = 'block'; // 숨겨져 있을 수 있으므로 다시 보이게 설정
        }

        // 컨테이너 transform 제거 (새 로직에서는 사용하지 않음)
        menuContainer.style.transform = '';

        updateBackBtnDisplay();
    }
    
    // 뒤로가기 버튼 UI만 업데이트 (이전의 updateMenuDisplay에서 transform 로직을 분리)
    function updateBackBtnDisplay() {
        if (currentDepth > 0) {
            backBtn.classList.remove('hidden');
            const parentItem = historyStack[historyStack.length - 1];
            const labelText = parentItem ? parentItem.querySelector('a').textContent : 'BACK';
            backLabel.textContent = labelText;
        } else {
            backBtn.classList.add('hidden');
        }
        menuContainer.style.transform = ''; 
    }
    
    function handleSubmenuToggle(e) {
        const toggleButton = e.target.closest('.submenu-toggle');
        if (!toggleButton) return;
        
        e.preventDefault();
        e.stopPropagation();
        
        const parentListItem = toggleButton.closest('li.menu-item-has-children');
        const submenu = parentListItem.querySelector('.sub-menu');
        
        if (!submenu) return;
        
        
        const currentLevelNav = menuContainer.querySelector(`.menu-level-${currentDepth}`);
        
        currentDepth++;
        historyStack.push(parentListItem);
        
        
        const newMenuLevel = document.createElement('nav');
        
        newMenuLevel.classList.add(`menu-level-${currentDepth}`, 'absolute', 'top-0', 'left-0', 'w-full', 'h-full', 'p-8', 'pt-0', 'transition-all', 'duration-300', 'ease-in-out');
        newMenuLevel.style.left = '100%'; 
        newMenuLevel.style.display = 'block'; 
        
        
        const submenuClone = submenu.cloneNode(true); 
        newMenuLevel.appendChild(submenuClone);
        submenuClone.style.display = 'block'; 
        
        menuContainer.appendChild(newMenuLevel);

        
        setTimeout(() => {
            newMenuLevel.style.left = '0%'; 
            
            if (currentLevelNav) {
                currentLevelNav.style.display = 'none';
            }
            
            updateBackBtnDisplay();
        }, 10);
    }
    
    function handleBackButtonClick() {
        if (currentDepth <= 0) return;
        
        const oldDepth = currentDepth;
        currentDepth--;
        
        historyStack.pop();
        
        const prevLevelNav = menuContainer.querySelector(`.menu-level-${currentDepth}`);
        
        const levelToRemove = document.querySelector(`.menu-level-${oldDepth}`);

        
        if (prevLevelNav) {
             prevLevelNav.style.display = 'block'; 
             prevLevelNav.style.left = '-100%'; 
        }

        updateBackBtnDisplay();

        
        setTimeout(() => {
            if (prevLevelNav) {
                
                prevLevelNav.style.left = '0%'; 
            }
            
            if (levelToRemove) {
                
                levelToRemove.style.left = '100%'; 
                
                
                setTimeout(() => {
                    levelToRemove.remove();
                }, 300); 
            }
        }, 10);
    }

    
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

function initAccordion() {
    const triggers = document.querySelectorAll('[data-accordion-trigger]');

    triggers.forEach(trigger => {
        trigger.addEventListener('click', () => {
            const item = trigger.closest('.accordion-item');
            const content = item.querySelector('[data-accordion-content]');
            const icon = item.querySelector('.accordion-icon');
            const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
            
            trigger.setAttribute('aria-expanded', !isExpanded);
            
            if (isExpanded) {
                content.style.maxHeight = 0;
                icon.innerHTML = '&#x2295;'; 
                icon.style.transform = 'rotate(0deg)';

            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
                icon.innerHTML = '&#x2296;'; 
                icon.style.transform = 'rotate(180deg)'; 
            }
        });
    });
}