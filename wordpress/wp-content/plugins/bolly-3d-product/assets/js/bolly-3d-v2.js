document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('bolly-3d-bottle-viewer');
    if (!container) return;

    // Wait for Google Fonts to be fully loaded before starting Three.js.
    // This ensures the canvas draws text using the custom 'Outfit' and 'Inter' fonts instead of falling back to standard Arial.
    document.fonts.ready.then(() => {
        // --- Scene Setup ---
        const scene = new THREE.Scene();

        // Perspective Camera with proper Field of View for closer, premium framing
        const camera = new THREE.PerspectiveCamera(36, container.clientWidth / container.clientHeight, 0.1, 100);
        camera.position.set(0, 0.15, 7.8);

        // WebGL Renderer with Antialiasing and Alpha transparency
        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, powerPreference: "high-performance" });
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        renderer.setSize(container.clientWidth, container.clientHeight);
        renderer.shadowMap.enabled = true;
        renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        renderer.physicallyCorrectLights = true;
        renderer.outputEncoding = THREE.sRGBEncoding;
        renderer.toneMapping = THREE.ACESFilmicToneMapping;
        renderer.toneMappingExposure = 1.15;

        container.appendChild(renderer.domElement);

        // --- Lighting ---
        // Ambient light - lowered to create deep rich shadows and prevent color wash
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.22);
        scene.add(ambientLight);

        // Front-Left Key Light (strong illumination and specular highlight on the bottle shoulder)
        const keyLight = new THREE.DirectionalLight(0xffffff, 1.4);
        keyLight.position.set(4, 3, 5);
        keyLight.castShadow = true;
        keyLight.shadow.mapSize.width = 1024;
        keyLight.shadow.mapSize.height = 1024;
        keyLight.shadow.bias = -0.001;
        scene.add(keyLight);

        // Right Fill Light (soft periwinkle fill)
        const fillLight = new THREE.DirectionalLight(0xe8e6f5, 0.7);
        fillLight.position.set(-5, 2, 4);
        scene.add(fillLight);

        // Back Rim Light (creates highlights on edges, crucial for matte purple)
        const rimLight = new THREE.DirectionalLight(0xffffff, 2.0);
        rimLight.position.set(-3, 3, -6);
        scene.add(rimLight);

        // Top Light (adds shine to the white pump)
        const topLight = new THREE.DirectionalLight(0xffffff, 0.9);
        topLight.position.set(0, 8, 2);
        scene.add(topLight);

        // --- Bottle Model Construction ---
        const bottleGroup = new THREE.Group();

        // 1. Create Bottle Body using LatheGeometry (Stout & Wide profile matching reference design)
        const bodyPoints = [];
        
        // Bottom cap base curve
        bodyPoints.push(new THREE.Vector2(0, -1.35));
        bodyPoints.push(new THREE.Vector2(1.28, -1.35));
        bodyPoints.push(new THREE.Vector2(1.39, -1.25));
        bodyPoints.push(new THREE.Vector2(1.4, -1.15));

        // Cylinder body segments (almost straight vertical cylinder with slight taper for elegance)
        const bodySegments = 30;
        for (let i = 0; i <= bodySegments; i++) {
            const t = i / bodySegments;
            const y = -1.15 + t * 1.95; // y goes from -1.15 to 0.8
            const x = 1.4 - 0.03 * t;
            bodyPoints.push(new THREE.Vector2(x, y));
        }

        // Shoulder slope (defined but smooth curve)
        bodyPoints.push(new THREE.Vector2(1.35, 0.9));
        bodyPoints.push(new THREE.Vector2(1.28, 1.0));
        bodyPoints.push(new THREE.Vector2(1.15, 1.1));
        bodyPoints.push(new THREE.Vector2(0.85, 1.2));
        bodyPoints.push(new THREE.Vector2(0.55, 1.25));
        bodyPoints.push(new THREE.Vector2(0.42, 1.3));
        bodyPoints.push(new THREE.Vector2(0.38, 1.35));

        // Neck
        bodyPoints.push(new THREE.Vector2(0.38, 1.45));
        bodyPoints.push(new THREE.Vector2(0.35, 1.5));

        const bottleGeometry = new THREE.LatheGeometry(bodyPoints, 64);
        
        // Canvas setup for texture (2048x2048 high resolution)
        const labelCanvas = document.createElement('canvas');
        labelCanvas.width = 2048;
        labelCanvas.height = 2048;
        const labelCtx = labelCanvas.getContext('2d');

        // Drawing function that can be re-called when fonts load to update texture dynamically
        function drawLabel() {
            // Fill background with exact deep royal purple color from reference design (darker and richer)
            labelCtx.fillStyle = '#311a8c';
            labelCtx.fillRect(0, 0, labelCanvas.width, labelCanvas.height);

            // Save clean state
            labelCtx.save();

            // Center drawing around (1024, 1024)
            // Apply scale transformation ctx.scale(1 / 1.86, 1) around center to cancel out cylindrical wrap stretch in 3D
            labelCtx.translate(1024, 1024);
            labelCtx.scale(1 / 1.86, 1.0);
            labelCtx.translate(-1024, -1024);

            labelCtx.textBaseline = 'middle';
            labelCtx.fillStyle = '#ffffff'; // White text

            // 1. Brand Name "bolly" (Centered, lowercase, massive 480px font size)
            labelCtx.font = '900 480px "Outfit", sans-serif';
            labelCtx.textAlign = 'center';
            labelCtx.fillStyle = '#ffffff';
            labelCtx.letterSpacing = '-10px'; // Tighter kerning for massive size
            labelCtx.fillText('bolly', 1024, 740);
            labelCtx.letterSpacing = 'normal';

            // 2. Product Title "clarify shampoo"
            labelCtx.font = '400 170px "Outfit", sans-serif';
            labelCtx.fillText('clarify shampoo', 1024, 1100);

            // 3. Subtext line 1
            labelCtx.font = '700 52px "Inter", sans-serif';
            labelCtx.fillStyle = 'rgba(255, 255, 255, 0.85)';
            labelCtx.fillText('REVITALIZE & BALANCE', 1024, 1310);

            // 4. Subtext line 2
            labelCtx.font = '400 44px "Inter", sans-serif';
            labelCtx.fillStyle = 'rgba(255, 255, 255, 0.7)';
            labelCtx.fillText('For All Hair Types \u2022 250ml \u2107 8.5fl.oz.', 1024, 1390);

            // 5. Volume text "250ml" printed vertically on the right
            labelCtx.save();
            labelCtx.translate(1540, 1100);
            labelCtx.rotate(-Math.PI / 2);
            labelCtx.font = '700 44px "Outfit", sans-serif';
            labelCtx.fillStyle = 'rgba(255, 255, 255, 0.6)';
            labelCtx.textAlign = 'center';
            labelCtx.fillText('250ml', 0, 0);
            labelCtx.restore();

            labelCtx.restore(); // Restore context
        }

        // Initial draw
        drawLabel();

        const bottleTexture = new THREE.CanvasTexture(labelCanvas);
        bottleTexture.wrapS = THREE.ClampToEdgeWrapping;
        bottleTexture.wrapT = THREE.ClampToEdgeWrapping;
        
        // Mapping repeat & offset adjustments to narrow label wrapping on front face (U = 0.75)
        bottleTexture.repeat.set(2.4, 1.0);
        bottleTexture.offset.set(-1.3, 0.0);

        // Premium Matte/Glossy Physical Material for exact look
        // Color set to white (0xffffff) so texture colors and white text render exactly as drawn
        const bottleMaterial = new THREE.MeshPhysicalMaterial({
            color: 0xffffff,
            map: bottleTexture,
            roughness: 0.38,             // Satin-gloss roughness to capture highlights nicely
            metalness: 0.0,
            clearcoat: 0.15,             // Soft outer clearcoat shine
            clearcoatRoughness: 0.2,
            flatShading: false
        });

        const bottleMesh = new THREE.Mesh(bottleGeometry, bottleMaterial);
        bottleMesh.castShadow = true;
        bottleMesh.receiveShadow = true;
        bottleMesh.rotation.y = 0.0; // Text is already centered on the front face (U = 0.75)
        bottleGroup.add(bottleMesh);

        // 2. Cap & Pump Assembly (Clean Matte White Plastic)
        const whitePlasticMaterial = new THREE.MeshStandardMaterial({
            color: 0xffffff,
            roughness: 0.35,
            metalness: 0.05
        });

        // Cap Collar (base cylinder)
        const collarGeom = new THREE.CylinderGeometry(0.44, 0.44, 0.5, 32);
        const collarMesh = new THREE.Mesh(collarGeom, whitePlasticMaterial);
        collarMesh.position.y = 1.45;
        collarMesh.castShadow = true;
        collarMesh.receiveShadow = true;
        bottleGroup.add(collarMesh);

        // Pump Stem (collar neck)
        const stemGeom = new THREE.CylinderGeometry(0.16, 0.16, 0.35, 16);
        const stemMesh = new THREE.Mesh(stemGeom, whitePlasticMaterial);
        stemMesh.position.y = 1.95;
        bottleGroup.add(stemMesh);

        // Pump Head (Flat, wide button-style cylinder matching reference)
        const pumpHeadGeom = new THREE.CylinderGeometry(0.36, 0.38, 0.24, 32);
        const pumpHeadMesh = new THREE.Mesh(pumpHeadGeom, whitePlasticMaterial);
        pumpHeadMesh.position.y = 2.24;
        pumpHeadMesh.castShadow = true;
        pumpHeadMesh.receiveShadow = true;
        bottleGroup.add(pumpHeadMesh);

        // Top ring on pump head
        const topCapGeom = new THREE.CylinderGeometry(0.30, 0.36, 0.06, 32);
        const topCapMesh = new THREE.Mesh(topCapGeom, whitePlasticMaterial);
        topCapMesh.position.y = 2.39;
        bottleGroup.add(topCapMesh);

        // Pump Nozzle - Extruded Shape matching the flat-topped, tapered design of the reference
        const nozzleShape = new THREE.Shape();
        // Start flush with the top surface of the button
        nozzleShape.moveTo(-0.15, 0.12);
        // Almost horizontal top line with a very slight peak
        nozzleShape.lineTo(-0.35, 0.13);
        // Smooth curve down to the tip
        nozzleShape.quadraticCurveTo(-0.68, 0.13, -0.85, -0.12);
        // Bottom profile of the tip
        nozzleShape.lineTo(-0.85, -0.18);
        // Smooth curve back to the cylinder base
        nozzleShape.quadraticCurveTo(-0.68, -0.18, -0.15, -0.06);
        nozzleShape.closePath();

        const extrudeSettings = {
            depth: 0.38,
            bevelEnabled: true,
            bevelSegments: 4,
            steps: 1,
            bevelSize: 0.015,
            bevelThickness: 0.015
        };

        const nozzleGeom = new THREE.ExtrudeGeometry(nozzleShape, extrudeSettings);

        // Center Z axis and taper width (Z coord) from base (x = -0.15) to tip (x = -0.85)
        nozzleGeom.translate(0, 0, -0.19); // Center the depth
        
        const posAttr = nozzleGeom.attributes.position;
        for (let i = 0; i < posAttr.count; i++) {
            let x = posAttr.getX(i);
            let y = posAttr.getY(i);
            let z = posAttr.getZ(i);

            // Compute t: 0 at the cylinder surface (x = -0.15), 1 at the tip (x = -0.85)
            const t = Math.min(1, Math.max(0, (x - (-0.15)) / (-0.85 - (-0.15))));

            // Taper width from 100% at base to 35% at the tip
            const scaleZ = 1.0 - 0.65 * t;
            z *= scaleZ;

            posAttr.setZ(i, z);
        }
        nozzleGeom.computeVertexNormals();

        const nozzleMesh = new THREE.Mesh(nozzleGeom, whitePlasticMaterial);
        // Position at the button height (2.30)
        nozzleMesh.position.set(0, 2.30, 0);
        nozzleMesh.castShadow = true;
        bottleGroup.add(nozzleMesh);

        // Center the entire bottle group pivot
        bottleGroup.children.forEach(child => {
            child.position.y -= 0.1;
        });

        // Set initial natural studio rotation / tilt matching the PDF design
        bottleGroup.rotation.y = 0.1;    // Turned slightly to show depth
        bottleGroup.rotation.x = 0.15;   // Tilted forward
        bottleGroup.rotation.z = -0.28;  // Tilted to the right side (top points right, bottom points left)

        scene.add(bottleGroup);

        // Ground Shadow Plane (subtle ambient occlusion shadow)
        const shadowGeo = new THREE.PlaneGeometry(6, 6);
        const shadowCanvas = document.createElement('canvas');
        shadowCanvas.width = 128;
        shadowCanvas.height = 128;
        const sCtx = shadowCanvas.getContext('2d');
        const grad = sCtx.createRadialGradient(64, 64, 5, 64, 64, 55);
        grad.addColorStop(0, 'rgba(18, 19, 28, 0.35)'); // Dark shade
        grad.addColorStop(1, 'rgba(243, 241, 247, 0)');
        sCtx.fillStyle = grad;
        sCtx.fillRect(0, 0, 128, 128);

        const shadowTexture = new THREE.CanvasTexture(shadowCanvas);
        const shadowMat = new THREE.MeshBasicMaterial({
            map: shadowTexture,
            transparent: true,
            depthWrite: false
        });
        const shadowMesh = new THREE.Mesh(shadowGeo, shadowMat);
        shadowMesh.rotation.x = -Math.PI / 2;
        shadowMesh.position.y = -1.5;
        scene.add(shadowMesh);

        // --- Interaction Logic ---
        let isDragging = false;
        let previousMousePosition = { x: 0, y: 0 };
        
        // Match initial rot target to set initial position
        let targetRotationY = 0.1;
        let targetRotationX = 0.15;
        let targetRotationZ = -0.28;
        let lastInteractionTime = Date.now();

        // Auto-rotation parameters
        const autoRotationSpeed = 0.0035;

        // Mouse Down / Touch Start
        const onPointerDown = (e) => {
            isDragging = true;
            lastInteractionTime = Date.now();
            
            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;

            previousMousePosition = { x: clientX, y: clientY };
        };

        // Mouse Move / Touch Move
        const onPointerMove = (e) => {
            if (!isDragging) return;
            lastInteractionTime = Date.now();

            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
            const clientY = e.touches ? e.touches[0].clientY : e.clientY;

            const deltaX = clientX - previousMousePosition.x;
            const deltaY = clientY - previousMousePosition.y;

            // Scale factors for sensitivity
            targetRotationY += deltaX * 0.007;
            targetRotationX += deltaY * 0.005;

            // Limit vertical tilt (X axis) to prevent unnatural flipping
            targetRotationX = Math.max(-0.25, Math.min(0.25, targetRotationX));

            previousMousePosition = { x: clientX, y: clientY };
        };

        // Mouse Up / Touch End
        const onPointerUp = () => {
            isDragging = false;
        };

        // Attach drag event listeners to container
        container.addEventListener('mousedown', onPointerDown);
        document.addEventListener('mousemove', onPointerMove);
        document.addEventListener('mouseup', onPointerUp);

        container.addEventListener('touchstart', onPointerDown, { passive: true });
        document.addEventListener('touchmove', onPointerMove, { passive: true });
        document.addEventListener('touchend', onPointerUp);

        // --- Animation / Render Loop ---
        const clock = new THREE.Clock();
        let frames = 0;

        const animate = () => {
            requestAnimationFrame(animate);

            const elapsedTime = clock.getElapsedTime();

            // Redraw canvas texture repeatedly in the first 60 frames to ensure custom Google Fonts (Outfit & Inter) 
            // are fully rendered once loaded, preventing Arial fallbacks.
            if (frames < 60) {
                frames++;
                if (frames === 10 || frames === 30 || frames === 59) {
                    drawLabel();
                    bottleTexture.needsUpdate = true;
                }
            }

            // Idle Auto-Rotation
            if (!isDragging && (Date.now() - lastInteractionTime > 2500)) {
                targetRotationY += autoRotationSpeed;
                // Return vertical tilt gently to baseline
                targetRotationX += (0.15 - targetRotationX) * 0.05;
                targetRotationZ += (-0.28 - targetRotationZ) * 0.05;
            }

            // Apply Damping (Inertia lerp)
            bottleGroup.rotation.y += (targetRotationY - bottleGroup.rotation.y) * 0.08;
            bottleGroup.rotation.x += (targetRotationX - bottleGroup.rotation.x) * 0.08;
            
            if (!isDragging) {
                bottleGroup.rotation.z += (targetRotationZ - bottleGroup.rotation.z) * 0.08;
            }

            // Add a very subtle floating animation (up and down) for natural showcase look
            const floatOffset = Math.sin(elapsedTime * 1.5) * 0.04;
            bottleGroup.position.y = floatOffset;

            // Soft wobble rotation on Z to look organic during idle
            if (!isDragging && (Date.now() - lastInteractionTime > 2500)) {
                bottleGroup.rotation.z = -0.28 + Math.sin(elapsedTime * 1.0) * 0.015;
            }

            renderer.render(scene, camera);
        };

        // --- Responsive Scaling ---
        const resizeObserver = new ResizeObserver((entries) => {
            for (let entry of entries) {
                const width = entry.contentRect.width;
                const height = entry.contentRect.height;
                
                camera.aspect = width / height;
                
                // Adjust camera field of view or position based on viewport width for perfect fitting
                if (width < 500) {
                    camera.position.z = 8.5; // push camera back on small mobile viewports
                } else {
                    camera.position.z = 7.8;
                }
                
                camera.updateProjectionMatrix();
                renderer.setSize(width, height);
            }
        });

        resizeObserver.observe(container);

        // Start rendering and trigger loaded CSS class
        animate();
        
        setTimeout(() => {
            container.classList.add('loaded');
        }, 200);
    });
});
