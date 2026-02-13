<style>
    /* --- Staggered Menu CSS --- */
    .sm-scope .staggered-menu-wrapper { position: relative; width: 100%; height: 100%; z-index: 40; }
    .sm-scope .staggered-menu-header { position: absolute; top: 0; left: 0; width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 2em; background: transparent; pointer-events: none; z-index: 20; }
    .sm-scope .staggered-menu-header > * { pointer-events: auto; }
    .sm-scope .sm-logo { display: flex; align-items: center; user-select: none; }
    .sm-scope .sm-logo-img { display: block; height: 32px; width: auto; object-fit: contain; }
    .sm-scope .sm-toggle { position: relative; display: inline-flex; align-items: center; gap: 0.3rem; background: transparent; border: none; cursor: pointer; color: #e9e9ef; font-weight: 500; line-height: 1; overflow: visible; }
    .sm-scope .sm-toggle:focus-visible { outline: 2px solid #ffffffaa; outline-offset: 4px; border-radius: 4px; }
    .sm-scope .sm-toggle-textWrap { position: relative; margin-right: 0.5em; display: inline-block; height: 1em; overflow: hidden; white-space: nowrap; width: var(--sm-toggle-width, auto); min-width: var(--sm-toggle-width, auto); }
    .sm-scope .sm-toggle-textInner { display: flex; flex-direction: column; line-height: 1; }
    .sm-scope .sm-toggle-line { display: block; height: 1em; line-height: 1; }
    .sm-scope .sm-icon { position: relative; width: 14px; height: 14px; flex: 0 0 14px; display: inline-flex; align-items: center; justify-content: center; will-change: transform; }
    .sm-scope .sm-panel-itemWrap { position: relative; overflow: hidden; line-height: 1; }
    .sm-scope .sm-icon-line { position: absolute; left: 50%; top: 50%; width: 100%; height: 2px; background: currentColor; border-radius: 2px; transform: translate(-50%, -50%); will-change: transform; }
    .sm-scope .staggered-menu-panel { position: absolute; top: 0; right: 0; width: clamp(260px, 38vw, 420px); height: 100%; background: white; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); display: flex; flex-direction: column; padding: 6em 2em 2em 2em; overflow-y: auto; z-index: 10; }
    .sm-scope [data-position='left'] .staggered-menu-panel { right: auto; left: 0; }
    .sm-scope .sm-prelayers { position: absolute; top: 0; right: 0; bottom: 0; width: clamp(260px, 38vw, 420px); pointer-events: none; z-index: 5; }
    .sm-scope [data-position='left'] .sm-prelayers { right: auto; left: 0; }
    .sm-scope .sm-prelayer { position: absolute; top: 0; right: 0; height: 100%; width: 100%; transform: translateX(0); }
    .sm-scope .sm-panel-inner { flex: 1; display: flex; flex-direction: column; gap: 1.25rem; }
    .sm-scope .sm-socials { margin-top: auto; padding-top: 2rem; display: flex; flex-direction: column; gap: 0.75rem; }
    .sm-scope .sm-socials-title { margin: 0; font-size: 1rem; font-weight: 500; color: var(--sm-accent, #ff0000); }
    .sm-scope .sm-socials-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: row; align-items: center; gap: 1rem; flex-wrap: wrap; }
    .sm-scope .sm-socials-list .sm-socials-link { opacity: 1; transition: opacity 0.3s ease; }
    .sm-scope .sm-socials-list:hover .sm-socials-link:not(:hover) { opacity: 0.35; }
    .sm-scope .sm-socials-list:focus-within .sm-socials-link:not(:focus-visible) { opacity: 0.35; }
    .sm-scope .sm-socials-list .sm-socials-link:hover,
    .sm-scope .sm-socials-list .sm-socials-link:focus-visible { opacity: 1; }
    .sm-scope .sm-socials-link:focus-visible { outline: 2px solid var(--sm-accent, #ff0000); outline-offset: 3px; }
    .sm-scope .sm-socials-link { font-size: 1.2rem; font-weight: 500; color: #111; text-decoration: none; position: relative; padding: 2px 0; display: inline-block; transition: color 0.3s ease, opacity 0.3s ease; }
    .sm-scope .sm-socials-link:hover { color: var(--sm-accent, #ff0000); }
    .sm-scope .sm-panel-title { margin: 0; font-size: 1rem; font-weight: 600; color: #fff; text-transform: uppercase; }
    .sm-scope .sm-panel-list { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 0.5rem; }
    .sm-scope .sm-panel-item { position: relative; color: #000; font-weight: 600; font-size: 3.5rem; cursor: pointer; line-height: 1; letter-spacing: -2px; text-transform: uppercase; transition: background 0.25s, color 0.25s; display: inline-block; text-decoration: none; padding-right: 1.4em; }
    .sm-scope .sm-panel-itemLabel { display: inline-block; will-change: transform; transform-origin: 50% 100%; }
    .sm-scope .sm-panel-item:hover { color: var(--sm-accent, #ff0000); }
    .sm-scope .sm-panel-list[data-numbering] { counter-reset: smItem; }
    .sm-scope .sm-panel-list[data-numbering] .sm-panel-item::after { counter-increment: smItem; content: counter(smItem, decimal-leading-zero); position: absolute; top: 0.1em; right: 2.9em; font-size: 18px; font-weight: 400; color: var(--sm-accent, #ff0000); letter-spacing: 0; pointer-events: none; user-select: none; opacity: var(--sm-num-opacity, 0); }
    @media (max-width: 1024px) { .sm-scope .staggered-menu-panel { width: 100%; left: 0; right: 0; } .sm-scope .staggered-menu-wrapper[data-open] .sm-logo-img { filter: invert(100%); } }
    @media (max-width: 640px) { .sm-scope .staggered-menu-panel { width: 100%; left: 0; right: 0; } .sm-scope .staggered-menu-wrapper[data-open] .sm-logo-img { filter: invert(100%); } }
</style>

<!-- START STAGGERED MENU -->
<div class="sm-scope fixed top-0 left-0 w-screen h-screen overflow-hidden pointer-events-none z-50" id="staggered-menu-root">
    <!-- Changed accent color to purple to match screenshot -->
    <div class="staggered-menu-wrapper relative w-full h-full" style="--sm-accent: #006bb3ff;" data-position="right">
        
        <div class="sm-prelayers absolute top-0 right-0 bottom-0 pointer-events-none z-[5]" aria-hidden="true">
            <div class="sm-prelayer absolute top-0 right-0 h-full w-full translate-x-0" style="background: #accde4ff;"></div>
            <div class="sm-prelayer absolute top-0 right-0 h-full w-full translate-x-0" style="background: #006bb3ff;"></div>
        </div>

        <header class="staggered-menu-header absolute top-0 left-0 w-full flex items-center justify-between p-[2em] bg-transparent pointer-events-none z-20">
            <a href="index.php" class="sm-logo flex items-center select-none pointer-events-auto" aria-label="Logo">
                <img src="img/logo/qyam3.png" alt="Qyam Group Logo" class="sm-logo-img block h-[32px] w-auto object-contain">
            </a>

            <button class="sm-toggle relative inline-flex items-center gap-[0.3rem] bg-transparent border-0 cursor-pointer text-[#fff] font-medium leading-none overflow-visible pointer-events-auto"
                    aria-label="Open menu"
                    type="button"
                    id="sm-toggle-btn">
                <span class="sm-toggle-textWrap relative inline-block h-[1em] overflow-hidden whitespace-nowrap w-[var(--sm-toggle-width,auto)] min-w-[var(--sm-toggle-width,auto)]" aria-hidden="true">
                    <span class="sm-toggle-textInner flex flex-col leading-none" id="sm-text-inner">
                        <span class="sm-toggle-line block h-[1em] leading-none">Menu</span>
                        <span class="sm-toggle-line block h-[1em] leading-none">Close</span>
                        <span class="sm-toggle-line block h-[1em] leading-none">Menu</span>
                        <span class="sm-toggle-line block h-[1em] leading-none">Close</span>
                    </span>
                </span>

                <span class="sm-icon relative w-[14px] h-[14px] shrink-0 inline-flex items-center justify-center [will-change:transform]" aria-hidden="true" id="sm-icon">
                    <span class="sm-icon-line absolute left-1/2 top-1/2 w-full h-[2px] bg-current rounded-[2px] -translate-x-1/2 -translate-y-1/2 [will-change:transform]" id="sm-plus-h"></span>
                    <span class="sm-icon-line sm-icon-line-v absolute left-1/2 top-1/2 w-full h-[2px] bg-current rounded-[2px] -translate-x-1/2 -translate-y-1/2 [will-change:transform]" id="sm-plus-v"></span>
                </span>
            </button>
        </header>

        <!-- Removed inline transform to allow GSAP to handle it -->
        <aside id="staggered-menu-panel" class="staggered-menu-panel absolute top-0 right-0 h-full bg-white flex flex-col p-[6em_2em_2em_2em] overflow-y-auto z-10 backdrop-blur-[12px]" aria-hidden="true">
            <div class="sm-panel-inner flex-1 flex flex-col gap-5">
                <ul class="sm-panel-list list-none m-0 p-0 flex flex-col gap-2" role="list" data-numbering="true">
                    <li class="sm-panel-itemWrap relative overflow-hidden leading-none">
                        <a class="sm-panel-item relative text-black font-semibold text-[3.5rem] cursor-pointer leading-none tracking-[-2px] uppercase transition-[background,color] duration-150 ease-linear inline-block no-underline pr-[1.4em]" href="index.php">
                            <span class="sm-panel-itemLabel inline-block [transform-origin:50%_100%] will-change-transform">Home</span>
                        </a>
                    </li>
                    <li class="sm-panel-itemWrap relative overflow-hidden leading-none">
                        <a class="sm-panel-item relative text-black font-semibold text-[3.5rem] cursor-pointer leading-none tracking-[-2px] uppercase transition-[background,color] duration-150 ease-linear inline-block no-underline pr-[1.4em]" href="about.php">
                            <span class="sm-panel-itemLabel inline-block [transform-origin:50%_100%] will-change-transform">About</span>
                        </a>
                    </li>
                    <li class="sm-panel-itemWrap relative overflow-hidden leading-none">
                        <!-- Changed Services to Projects to match screenshot -->
                        <a class="sm-panel-item relative text-black font-semibold text-[3.5rem] cursor-pointer leading-none tracking-[-2px] uppercase transition-[background,color] duration-150 ease-linear inline-block no-underline pr-[1.4em]" href="companies.php">
                            <span class="sm-panel-itemLabel inline-block [transform-origin:50%_100%] will-change-transform">Companies</span>
                        </a>
                    </li>
                    <li class="sm-panel-itemWrap relative overflow-hidden leading-none">
                        <a class="sm-panel-item relative text-black font-semibold text-[3.5rem] cursor-pointer leading-none tracking-[-2px] uppercase transition-[background,color] duration-150 ease-linear inline-block no-underline pr-[1.4em]" href="contact.php">
                            <span class="sm-panel-itemLabel inline-block [transform-origin:50%_100%] will-change-transform">Contact</span>
                        </a>
                    </li>
                </ul>

                <div class="sm-socials mt-auto pt-8 flex flex-col gap-3" aria-label="Social links">
                    <h3 class="sm-socials-title m-0 text-base font-medium [color:var(--sm-accent,#ff0000)]">Socials</h3>
                    <ul class="sm-socials-list list-none m-0 p-0 flex flex-row items-center gap-4 flex-wrap" role="list">
                        <li class="sm-socials-item">
                            <a href="" target="_blank" rel="noopener noreferrer" aria-label="Instagram" class="sm-socials-link text-[1.2rem] font-medium text-[#111] no-underline relative inline-block py-[2px] transition-[color,opacity] duration-300 ease-linear">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            </a>
                        </li>
                        <li class="sm-socials-item">
                            <a href="" target="_blank" rel="noopener noreferrer" aria-label="Facebook" class="sm-socials-link text-[1.2rem] font-medium text-[#111] no-underline relative inline-block py-[2px] transition-[color,opacity] duration-300 ease-linear">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            </a>
                        </li>
                        <li class="sm-socials-item">
                            <a href="" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn" class="sm-socials-link text-[1.2rem] font-medium text-[#111] no-underline relative inline-block py-[2px] transition-[color,opacity] duration-300 ease-linear">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                            </a>
                        </li>
                        <li class="sm-socials-item">
                            <a href="" target="_blank" rel="noopener noreferrer" aria-label="YouTube" class="sm-socials-link text-[1.2rem] font-medium text-[#111] no-underline relative inline-block py-[2px] transition-[color,opacity] duration-300 ease-linear">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>
<!-- END STAGGERED MENU -->

<!-- START STAGGERED MENU SCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Configuration
        const config = {
            menuButtonColor: '#fff',
            openMenuButtonColor: '#000', // Changed to black for white background
            changeMenuColorOnOpen: true,
            position: 'right'
        };

        // Elements
        const root = document.getElementById('staggered-menu-root');
        const toggleBtn = document.getElementById('sm-toggle-btn');
        const panel = document.getElementById('staggered-menu-panel');
        const preLayers = Array.from(document.querySelectorAll('.sm-prelayer'));
        const textInner = document.getElementById('sm-text-inner');
        const icon = document.getElementById('sm-icon');
        const plusH = document.getElementById('sm-plus-h');
        const plusV = document.getElementById('sm-plus-v');
        const wrapper = document.querySelector('.staggered-menu-wrapper');

        // State
        let isOpen = false;
        let isBusy = false;
        let openTl = null;
        let closeTween = null;
        let spinTween = null;
        let colorTween = null;
        let textCycleAnim = null;

        // Initial Setup
        function init() {
            const offscreen = config.position === 'left' ? -100 : 100;
            gsap.set([panel, ...preLayers], { xPercent: offscreen });
            gsap.set(plusH, { transformOrigin: '50% 50%', rotate: 0 });
            gsap.set(plusV, { transformOrigin: '50% 50%', rotate: 90 });
            gsap.set(icon, { rotate: 0, transformOrigin: '50% 50%' });
            gsap.set(textInner, { yPercent: 0 });
            gsap.set(toggleBtn, { color: config.menuButtonColor });
        }

        // Animations
        function buildOpenTimeline() {
            if (openTl) openTl.kill();
            if (closeTween) {
                closeTween.kill();
                closeTween = null;
            }

            const itemEls = Array.from(panel.querySelectorAll('.sm-panel-itemLabel'));
            const numberEls = Array.from(panel.querySelectorAll('.sm-panel-list[data-numbering] .sm-panel-item'));
            const socialTitle = panel.querySelector('.sm-socials-title');
            const socialLinks = Array.from(panel.querySelectorAll('.sm-socials-link'));

            const layerStates = preLayers.map(el => ({ el, start: Number(gsap.getProperty(el, 'xPercent')) }));
            // Force panel start to 100 if it's 0 to ensure animation works
            let panelStart = Number(gsap.getProperty(panel, 'xPercent'));
            if (panelStart === 0) panelStart = 100;

            if (itemEls.length) gsap.set(itemEls, { yPercent: 140, rotate: 10 });
            if (numberEls.length) gsap.set(numberEls, { '--sm-num-opacity': 0 });
            if (socialTitle) gsap.set(socialTitle, { opacity: 0 });
            if (socialLinks.length) gsap.set(socialLinks, { y: 25, opacity: 0 });

            const tl = gsap.timeline({ paused: true });

            layerStates.forEach((ls, i) => {
                tl.fromTo(ls.el, { xPercent: ls.start || 100 }, { xPercent: 0, duration: 0.5, ease: 'power4.out' }, i * 0.07);
            });

            const lastTime = layerStates.length ? (layerStates.length - 1) * 0.07 : 0;
            const panelInsertTime = lastTime + (layerStates.length ? 0.08 : 0);
            const panelDuration = 0.65;

            tl.fromTo(
                panel,
                { xPercent: panelStart },
                { xPercent: 0, duration: panelDuration, ease: 'power4.out' },
                panelInsertTime
            );

            if (itemEls.length) {
                const itemsStartRatio = 0.15;
                const itemsStart = panelInsertTime + panelDuration * itemsStartRatio;

                tl.to(
                    itemEls,
                    { yPercent: 0, rotate: 0, duration: 1, ease: 'power4.out', stagger: { each: 0.1, from: 'start' } },
                    itemsStart
                );

                if (numberEls.length) {
                    tl.to(
                        numberEls,
                        { duration: 0.6, ease: 'power2.out', '--sm-num-opacity': 1, stagger: { each: 0.08, from: 'start' } },
                        itemsStart + 0.1
                    );
                }
            }

            if (socialTitle || socialLinks.length) {
                const socialsStart = panelInsertTime + panelDuration * 0.4;

                if (socialTitle) tl.to(socialTitle, { opacity: 1, duration: 0.5, ease: 'power2.out' }, socialsStart);
                if (socialLinks.length) {
                    tl.to(
                        socialLinks,
                        {
                            y: 0,
                            opacity: 1,
                            duration: 0.55,
                            ease: 'power3.out',
                            stagger: { each: 0.08, from: 'start' },
                            onComplete: () => gsap.set(socialLinks, { clearProps: 'opacity' })
                        },
                        socialsStart + 0.04
                    );
                }
            }

            openTl = tl;
            return tl;
        }

        function playOpen() {
            if (isBusy) return;
            isBusy = true;
            root.classList.remove('pointer-events-none'); // Enable interactions
            wrapper.setAttribute('data-open', 'true');
            
            const tl = buildOpenTimeline();
            if (tl) {
                tl.eventCallback('onComplete', () => {
                    isBusy = false;
                });
                tl.play(0);
            } else {
                isBusy = false;
            }
        }

        function playClose() {
            if (openTl) {
                openTl.kill();
                openTl = null;
            }

            const all = [...preLayers, panel];
            if (closeTween) closeTween.kill();

            const offscreen = config.position === 'left' ? -100 : 100;

            closeTween = gsap.to(all, {
                xPercent: offscreen,
                duration: 0.32,
                ease: 'power3.in',
                overwrite: 'auto',
                onComplete: () => {
                    root.classList.add('pointer-events-none'); // Disable interactions
                    wrapper.removeAttribute('data-open');
                    
                    const itemEls = Array.from(panel.querySelectorAll('.sm-panel-itemLabel'));
                    if (itemEls.length) gsap.set(itemEls, { yPercent: 140, rotate: 10 });

                    const numberEls = Array.from(panel.querySelectorAll('.sm-panel-list[data-numbering] .sm-panel-item'));
                    if (numberEls.length) gsap.set(numberEls, { '--sm-num-opacity': 0 });

                    const socialTitle = panel.querySelector('.sm-socials-title');
                    const socialLinks = Array.from(panel.querySelectorAll('.sm-socials-link'));
                    if (socialTitle) gsap.set(socialTitle, { opacity: 0 });
                    if (socialLinks.length) gsap.set(socialLinks, { y: 25, opacity: 0 });

                    isBusy = false;
                }
            });
        }

        function animateIcon(opening) {
            if (spinTween) spinTween.kill();

            if (opening) {
                gsap.set(icon, { rotate: 0, transformOrigin: '50% 50%' });
                spinTween = gsap.timeline({ defaults: { ease: 'power4.out' } })
                    .to(plusH, { rotate: 45, duration: 0.5 }, 0)
                    .to(plusV, { rotate: -45, duration: 0.5 }, 0);
            } else {
                spinTween = gsap.timeline({ defaults: { ease: 'power3.inOut' } })
                    .to(plusH, { rotate: 0, duration: 0.35 }, 0)
                    .to(plusV, { rotate: 90, duration: 0.35 }, 0)
                    .to(icon, { rotate: 0, duration: 0.001 }, 0);
            }
        }

        function animateColor(opening) {
            if (colorTween) colorTween.kill();
            if (config.changeMenuColorOnOpen) {
                const targetColor = opening ? config.openMenuButtonColor : config.menuButtonColor;
                colorTween = gsap.to(toggleBtn, { color: targetColor, delay: 0.18, duration: 0.3, ease: 'power2.out' });
            } else {
                gsap.set(toggleBtn, { color: config.menuButtonColor });
            }
        }

        function animateText(opening) {
            if (textCycleAnim) textCycleAnim.kill();

            let targetY = 0;
            let duration = 0.5;
            
            // We have 4 lines. Total height is 100%. Each line is 25%.
            // 0% = 1st line (Menu)
            // -25% = 2nd line (Close)
            // -50% = 3rd line (Menu)
            // -75% = 4th line (Close)
            
            if (opening) {
                targetY = -75; 
                duration = 0.8;
            } else {
                targetY = 0;
                duration = 0.8;
            }

            textCycleAnim = gsap.to(textInner, {
                yPercent: targetY,
                duration: duration,
                ease: 'power4.out'
            });
        }

        // Event Listeners
        toggleBtn.addEventListener('click', () => {
            isOpen = !isOpen;
            
            if (isOpen) {
                playOpen();
            } else {
                playClose();
            }
            
            animateIcon(isOpen);
            animateColor(isOpen);
            animateText(isOpen);
        });

        // Run init
        init();
    });
</script>
<!-- END STAGGERED MENU SCRIPT -->
