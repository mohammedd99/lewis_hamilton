import * as THREE from "three";
import {
    vertexShader,
    fluidFragmentShader,
    displayFragmentShader,
} from "./shaders.js";

let canvas, renderer, scene, camera;
let mouse, prevMouse, isMoving, lastMoveTime, mouseInCanvas;
let pingPongTargets, currentTarget;
let topTexture, bottomTexture, topTextureSize, bottomTextureSize;
let trailsMaterial, displayMaterial;
let simMesh, simScene;

window.addEventListener("load", init);

function init() {
    canvas = document.querySelector("canvas");
    renderer = new THREE.WebGLRenderer({
        canvas,
        antialias: true,
        precision: "highp",
    });

    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

    scene = new THREE.Scene();
    camera = new THREE.OrthographicCamera(-1, 1, 1, -1, 0, 1);

    mouse = new THREE.Vector2(0.5, 0.5);
    prevMouse = new THREE.Vector2(0.5, 0.5);
    isMoving = false;
    lastMoveTime = 0;
    mouseInCanvas = false;

    const size = 500;
    pingPongTargets = [
        new THREE.WebGLRenderTarget(size, size, {
            minFilter: THREE.LinearFilter,
            magFilter: THREE.LinearFilter,
            format: THREE.RGBAFormat,
            type: THREE.FloatType,
        }),
        new THREE.WebGLRenderTarget(size, size, {
            minFilter: THREE.LinearFilter,
            magFilter: THREE.LinearFilter,
            format: THREE.RGBAFormat,
            type: THREE.FloatType,
        }),
    ];

    currentTarget = 0;

    // Use theme-appropriate colors for placeholders
    topTexture = createPlaceholderTexture("#ececec");
    bottomTexture = createPlaceholderTexture("#ececec");

    topTextureSize = new THREE.Vector2(1, 1);
    bottomTextureSize = new THREE.Vector2(1, 1);

    trailsMaterial = new THREE.ShaderMaterial({
        uniforms: {
            uPrevTrails: { value: null },
            uMouse: { value: mouse },
            uPrevMouse: { value: prevMouse },
            uResolution: { value: new THREE.Vector2(size, size) },
            uDecay: { value: 0.97 },
            uIsMoving: { value: false },
        },
        vertexShader,
        fragmentShader: fluidFragmentShader,
    });

    displayMaterial = new THREE.ShaderMaterial({
        uniforms: {
            uFluid: { value: null },
            uTopTexture: { value: topTexture },
            uBottomTexture: { value: bottomTexture },
            uResolution: {
                value: new THREE.Vector2(window.innerWidth, window.innerHeight),
            },
            uDpr: { value: window.devicePixelRatio },
            uTopTextureSize: { value: topTextureSize },
            uBottomTextureSize: { value: bottomTextureSize },
        },
        vertexShader,
        fragmentShader: displayFragmentShader,
    });

    // Asset tracking
    let assetsToLoad = 2;
    let assetsLoaded = 0;

    function checkAssets() {
        assetsLoaded++;
        if (assetsLoaded === assetsToLoad) {
            setTimeout(() => {
                const preloader = document.getElementById("preloader");
                if (preloader) {
                    preloader.classList.add("hidden");
                }
            }, 500);
        }
    }

    // Use #top and #bottom to satisfy the .includes("top") check in loadImage
    loadImage("img/1.jpg#top", topTexture, topTextureSize, checkAssets);
    loadImage("img/2.jpg#bottom", bottomTexture, bottomTextureSize, checkAssets);

    const planeGeometry = new THREE.PlaneGeometry(2, 2);
    const displayMesh = new THREE.Mesh(planeGeometry, displayMaterial);
    scene.add(displayMesh);

    simMesh = new THREE.Mesh(planeGeometry, trailsMaterial);
    simScene = new THREE.Scene();
    simScene.add(simMesh);

    renderer.setRenderTarget(pingPongTargets[0]);
    renderer.clear();
    renderer.setRenderTarget(pingPongTargets[1]);
    renderer.clear();
    renderer.setRenderTarget(null);

    window.addEventListener("mousemove", onMouseMove);
    window.addEventListener("touchmove", onTouchMove, { passive: false });
    window.addEventListener("resize", onWindowResize);

    // Helmet toggle functionality
    setupHelmetToggle();

    animate();
}

function setupHelmetToggle() {
    const helmetWith = document.getElementById("helmet-with");
    const helmetWithout = document.getElementById("helmet-without");
    let isHelmetOn = true; // Default state: helmet is on (6.jpg on top, 5.jpg on bottom)
    let isAnimating = false;

    // Add blend uniform for smooth transitions
    if (!displayMaterial.uniforms.uBlend) {
        displayMaterial.uniforms.uBlend = { value: 0.0 };
    }

    function swapImages() {
        if (isAnimating) return;
        isAnimating = true;

        // Animate blend from 0 to 1
        gsap.to(displayMaterial.uniforms.uBlend, {
            value: 1.0,
            duration: 0.6,
            ease: "power2.inOut",
            onComplete: () => {
                // Actually swap the textures
                const tempTexture = displayMaterial.uniforms.uTopTexture.value;
                const tempSize = displayMaterial.uniforms.uTopTextureSize.value.clone();

                displayMaterial.uniforms.uTopTexture.value = displayMaterial.uniforms.uBottomTexture.value;
                displayMaterial.uniforms.uTopTextureSize.value.copy(displayMaterial.uniforms.uBottomTextureSize.value);

                displayMaterial.uniforms.uBottomTexture.value = tempTexture;
                displayMaterial.uniforms.uBottomTextureSize.value.copy(tempSize);

                // Reset blend back to 0
                displayMaterial.uniforms.uBlend.value = 0.0;
                isAnimating = false;
            }
        });
    }

    function updateActiveState(activeElement, inactiveElement) {
        activeElement.classList.add("active");
        inactiveElement.classList.remove("active");
    }

    helmetWith.addEventListener("click", () => {
        if (!isHelmetOn && !isAnimating) {
            swapImages();
            isHelmetOn = true;
            updateActiveState(helmetWith, helmetWithout);
        }
    });

    helmetWithout.addEventListener("click", () => {
        if (isHelmetOn && !isAnimating) {
            swapImages();
            isHelmetOn = false;
            updateActiveState(helmetWithout, helmetWith);
        }
    });
}

function createPlaceholderTexture(color) {
    const canvasObj = document.createElement("canvas");
    canvasObj.width = 512;
    canvasObj.height = 512;
    const ctx = canvasObj.getContext("2d");
    ctx.fillStyle = color;
    ctx.fillRect(0, 0, 512, 512);

    const texture = new THREE.CanvasTexture(canvasObj);
    texture.minFilter = THREE.LinearFilter;
    return texture;
}

function loadImage(url, targetTexture, textureSizeVector, callback) {
    const img = new Image();
    img.crossOrigin = "Anonymous";

    img.onload = function () {
        const originalWidth = img.width;
        const originalHeight = img.height;
        textureSizeVector.set(originalWidth, originalHeight);

        console.log(
            `Loaded texture: ${url}, size: ${originalWidth}x${originalHeight}`
        );

        const maxSize = 4096;
        let newWidth = originalWidth;
        let newHeight = originalHeight;

        if (originalWidth > maxSize || originalHeight > maxSize) {
            console.log(`Image exceeds max texture size, resizing...`);
            if (originalWidth > originalHeight) {
                newWidth = maxSize;
                newHeight = Math.floor(originalHeight * (maxSize / originalWidth));
            } else {
                newHeight = maxSize;
                newWidth = Math.floor(originalWidth * (maxSize / originalHeight));
            }
        }

        const canvasObj = document.createElement("canvas");
        canvasObj.width = newWidth;
        canvasObj.height = newHeight;
        const ctx = canvasObj.getContext("2d");
        ctx.drawImage(img, 0, 0, newWidth, newHeight);

        const newTexture = new THREE.CanvasTexture(canvasObj);
        newTexture.minFilter = THREE.LinearFilter;
        newTexture.magFilter = THREE.LinearFilter;

        if (url.includes("top")) {
            displayMaterial.uniforms.uTopTexture.value = newTexture;
        } else {
            displayMaterial.uniforms.uBottomTexture.value = newTexture;
        }

        if (callback) callback();
    };

    img.onerror = function (err) {
        console.error(`Error loading image ${url}:`, err);
        if (callback) callback();
    };

    img.src = url;
}

function onMouseMove(event) {
    const canvasRect = canvas.getBoundingClientRect();

    if (
        event.clientX >= canvasRect.left &&
        event.clientX <= canvasRect.right &&
        event.clientY >= canvasRect.top &&
        event.clientY <= canvasRect.bottom
    ) {
        prevMouse.copy(mouse);

        mouse.x = (event.clientX - canvasRect.left) / canvasRect.width;
        mouse.y = 1 - (event.clientY - canvasRect.top) / canvasRect.height;

        isMoving = true;
        lastMoveTime = performance.now();
    } else {
        isMoving = false;
    }
}

function onTouchMove(event) {
    if (event.touches.length > 0) {
        const touchX = event.touches[0].clientX;
        const touchY = event.touches[0].clientY;

        // Allow native scroll when touching the menu panel (e.g. mobile menu scroll)
        const menuPanel = document.getElementById("staggered-menu-panel");
        if (menuPanel) {
            const panelRect = menuPanel.getBoundingClientRect();
            if (
                touchX >= panelRect.left &&
                touchX <= panelRect.right &&
                touchY >= panelRect.top &&
                touchY <= panelRect.bottom
            ) {
                return; // do not preventDefault — let the menu scroll
            }
        }

        const canvasRect = canvas.getBoundingClientRect();
        if (
            touchX >= canvasRect.left &&
            touchX <= canvasRect.right &&
            touchY >= canvasRect.top &&
            touchY <= canvasRect.bottom
        ) {
            event.preventDefault();
            prevMouse.copy(mouse);

            mouse.x = (touchX - canvasRect.left) / canvasRect.width;
            mouse.y = 1 - (touchY - canvasRect.top) / canvasRect.height;

            isMoving = true;
            lastMoveTime = performance.now();
        } else {
            isMoving = false;
        }
    }
}

function onWindowResize() {
    renderer.setSize(window.innerWidth, window.innerHeight);

    displayMaterial.uniforms.uResolution.value.set(
        window.innerWidth,
        window.innerHeight
    );

    displayMaterial.uniforms.uDpr.value = window.devicePixelRatio;
}

function animate() {
    requestAnimationFrame(animate);

    if (isMoving && performance.now() - lastMoveTime > 50) {
        isMoving = false;
    }

    const prevTarget = pingPongTargets[currentTarget];
    currentTarget = (currentTarget + 1) % 2;
    const currentRenderTgt = pingPongTargets[currentTarget];

    trailsMaterial.uniforms.uPrevTrails.value = prevTarget.texture;
    trailsMaterial.uniforms.uMouse.value.copy(mouse);
    trailsMaterial.uniforms.uPrevMouse.value.copy(prevMouse);
    trailsMaterial.uniforms.uIsMoving.value = isMoving;

    renderer.setRenderTarget(currentRenderTgt);
    renderer.render(simScene, camera);

    displayMaterial.uniforms.uFluid.value = currentRenderTgt.texture;

    renderer.setRenderTarget(null);
    renderer.render(scene, camera);
}
