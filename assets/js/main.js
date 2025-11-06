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

    // 메뉴 아이템에 토글 버튼을 동적으로 추가하는 함수
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
            // 부모 메뉴 항목의 텍스트를 백 버튼 레이블로 설정
            const labelText = parentItem ? parentItem.querySelector('a').textContent : 'BACK';
            backLabel.textContent = labelText;
        } else {
            backBtn.classList.add('hidden');
        }
        // 이 함수에서 menuContainer.style.transform 로직은 완전히 제거됨
        menuContainer.style.transform = ''; 
    }
    
    // 서브 메뉴 토글 처리 함수 (슬라이드 인 로직 변경)
    function handleSubmenuToggle(e) {
        const toggleButton = e.target.closest('.submenu-toggle');
        if (!toggleButton) return;
        
        e.preventDefault();
        e.stopPropagation();
        
        const parentListItem = toggleButton.closest('li.menu-item-has-children');
        const submenu = parentListItem.querySelector('.sub-menu');
        
        if (!submenu) return;
        
        // 현재 레벨 (곧 숨겨질 레벨)
        const currentLevelNav = menuContainer.querySelector(`.menu-level-${currentDepth}`);
        
        currentDepth++;
        historyStack.push(parentListItem);
        
        // 새로운 메뉴 레벨 컨테이너 생성
        const newMenuLevel = document.createElement('nav');
        // 'left-0'과 'absolute'로 위치를 제어하고, 초기 위치는 100% (오른쪽 화면 밖)로 설정
        newMenuLevel.classList.add(`menu-level-${currentDepth}`, 'absolute', 'top-0', 'left-0', 'w-full', 'h-full', 'p-8', 'pt-0', 'transition-all', 'duration-300', 'ease-in-out');
        newMenuLevel.style.left = '100%'; // 시작 위치: 오른쪽 화면 밖
        newMenuLevel.style.display = 'block'; // 혹시 모를 SCSS의 display:none 방지
        
        // 서브 메뉴 내용 복제 및 추가
        const submenuClone = submenu.cloneNode(true); 
        newMenuLevel.appendChild(submenuClone);
        submenuClone.style.display = 'block'; // 복제된 서브 메뉴를 보이도록 설정
        
        menuContainer.appendChild(newMenuLevel);

        // 애니메이션 시작: DOM 추가 후 다음 틱에 left 속성 변경
        setTimeout(() => {
            // (1) 새로운 레벨 슬라이드 인
            newMenuLevel.style.left = '0%'; 
            
            // (2) 현재 레벨 숨기기 (사용자 요청: display: none)
            if (currentLevelNav) {
                currentLevelNav.style.display = 'none';
            }
            
            updateBackBtnDisplay(); // 뒤로가기 버튼 업데이트
        }, 10);
    }
    
    // 뒤로가기 버튼 처리 함수 (슬라이드 아웃/인 로직 변경)
    function handleBackButtonClick() {
        if (currentDepth <= 0) return;
        
        const oldDepth = currentDepth;
        currentDepth--;
        
        historyStack.pop();
        
        // 1. 돌아갈 이전 레벨 (새로운 현재 레벨) 찾기
        const prevLevelNav = menuContainer.querySelector(`.menu-level-${currentDepth}`);
        // 2. 슬라이드 아웃될 레벨 (이전 깊이 레벨)
        const levelToRemove = document.querySelector(`.menu-level-${oldDepth}`);

        // 애니메이션 준비
        if (prevLevelNav) {
             // 숨겨진 이전 레벨을 보이게 하고, 왼쪽 화면 밖으로 이동 (-100%)
             prevLevelNav.style.display = 'block'; 
             // transform 대신 left 사용: left가 -100%이므로 왼쪽 화면 밖에서 시작합니다.
             prevLevelNav.style.left = '-100%'; 
        }

        updateBackBtnDisplay();

        // 애니메이션 실행
        setTimeout(() => {
            if (prevLevelNav) {
                // 이전 레벨 (메인 메뉴 등) 슬라이드 인
                prevLevelNav.style.left = '0%'; 
            }
            
            if (levelToRemove) {
                // 현재 레벨 슬라이드 아웃 (오른쪽 화면 밖으로)
                levelToRemove.style.left = '100%'; 
                
                // transition duration 후 제거
                setTimeout(() => {
                    levelToRemove.remove();
                }, 300); 
            }
        }, 10);
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