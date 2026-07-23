import { useEffect, useMemo, useRef } from "react";
import { useThree, useFrame } from "@react-three/fiber";
import * as THREE from "three";
import { useStore } from "../utils/store.js";

export default function ScrollController() {
    const { camera } = useThree();
    const setScrollProgress = useStore((state) => state.setScrollProgress);
    const setActiveScene = useStore((state) => state.setActiveScene);
    const setActiveMonolith = useStore((state) => state.setActiveMonolith);

    // Live scroll progress ref — written by the cinematic-scroll event
    const progressRef = useRef(0);
    const hasSettledRef = useRef(false);

    // ── 1. Subscribe to Lenis scroll event broadcast from app.js ──────────
    useEffect(() => {
        const handler = (e) => {
            const p = e.detail.progress;
            progressRef.current = p;
            setScrollProgress(p);

            // Scene thresholds
            if (p < 0.22) {
                setActiveScene(0);
            } else if (p < 0.48) {
                setActiveScene(1);
            } else if (p < 0.76) {
                setActiveScene(2);
                const monIdx = Math.floor(((p - 0.48) / 0.28) * 5);
                setActiveMonolith(Math.min(4, Math.max(0, monIdx)));
            } else if (p < 0.95) {
                setActiveScene(3);
            } else {
                setActiveScene(4);
            }
        };

        window.addEventListener('cinematic-scroll', handler);
        return () => window.removeEventListener('cinematic-scroll', handler);
    }, [setScrollProgress, setActiveScene, setActiveMonolith]);

    // ── 2. Camera Spline (CatmullRom) ────────────────────────────────────
    const [cameraPath, lookAtPath] = useMemo(() => {
        const camPoints = [
            new THREE.Vector3(0, 14, 180),    // Landing start
            new THREE.Vector3(-12, 10, 140),   // Bank left
            new THREE.Vector3(6, 4, 85),      // Monolith pass
            new THREE.Vector3(0, 2, 45),      // Cloud dive
            new THREE.Vector3(-2, 0.5, 20),    // River skim
            new THREE.Vector3(4, 1.2, -5),    // River S-curve
            new THREE.Vector3(-8, 3, -20),    // Waterfall pass
            new THREE.Vector3(0, 2.5, -45),   // Cliff quote
            new THREE.Vector3(0, 3, -65),     // Sanctuary archway
            new THREE.Vector3(-15, 2, -95),   // Monolith orbit 1
            new THREE.Vector3(0, 4, -115),    // Monolith orbit 2
            new THREE.Vector3(15, 3, -100),   // Monolith orbit 3
            new THREE.Vector3(0, 4, -135),    // Tree passage
            new THREE.Vector3(10, 16, -170),  // Summit exit
            new THREE.Vector3(-6, 6, -200),   // Waterfall dive
            new THREE.Vector3(18, 8, -230),   // Gateway orbit 1
            new THREE.Vector3(-12, 10, -240), // Gateway orbit 2
            new THREE.Vector3(0, 5, -248),    // Portal exit
        ];

        const lookPoints = [
            new THREE.Vector3(0, 4, 80),
            new THREE.Vector3(0, 4, 80),
            new THREE.Vector3(0, 2, 40),
            new THREE.Vector3(0, 0, 10),
            new THREE.Vector3(0, 0, -10),
            new THREE.Vector3(-8, 2, -25),
            new THREE.Vector3(0, 3, -35),
            new THREE.Vector3(0, 3, -65),
            new THREE.Vector3(0, 3, -100),
            new THREE.Vector3(0, 3, -100),
            new THREE.Vector3(0, 3, -100),
            new THREE.Vector3(0, 4, -135),
            new THREE.Vector3(0, 10, -220),
            new THREE.Vector3(0, 5, -220),
            new THREE.Vector3(0, 5, -240),
            new THREE.Vector3(0, 5, -240),
            new THREE.Vector3(0, 5, -240),
            new THREE.Vector3(0, 5, -280),
        ];

        return [
            new THREE.CatmullRomCurve3(camPoints, false, 'centripetal', 0.5),
            new THREE.CatmullRomCurve3(lookPoints, false, 'centripetal', 0.5),
        ];
    }, []);

    // ── 3. Per-frame camera lerp ──────────────────────────────────────────
    useFrame((_, delta) => {
        const p = Math.max(0, Math.min(1, progressRef.current));
        const targetPos = cameraPath.getPointAt(p);
        const targetLook = lookAtPath.getPointAt(p);

        // Slow down camera movement at the end of the scroll range (p > 0.95) to drift gently
        const lerpFactor = p > 0.95 ? 1.2 : 3.5;

        // Lerp position smoothly
        camera.position.lerp(targetPos, delta * lerpFactor);
        camera.lookAt(targetLook);

        // Monitor camera settle state at the end of the scroll range
        if (p >= 0.98 && !hasSettledRef.current) {
            const distance = camera.position.distanceTo(targetPos);
            if (distance < 0.5) { // camera has settled
                hasSettledRef.current = true;
                window.dispatchEvent(new CustomEvent('cinematic-settled'));
            }
        } else if (p < 0.95 && hasSettledRef.current) {
            // Reset if user scrolls back up
            hasSettledRef.current = false;
            window.dispatchEvent(new CustomEvent('cinematic-unsettled'));
        }
    });

    return null;
}
