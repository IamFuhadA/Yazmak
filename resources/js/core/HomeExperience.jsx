import React, { Suspense, useRef } from 'react';
import { Canvas, useFrame, useThree } from '@react-three/fiber';
import Lighting from '../effects/lighting.jsx';
import HomeScene from '../scenes/HomeScene.jsx';
import PostProcessing from '../effects/PostProcessing.jsx';

// Subtle mouse-driven parallax camera
function HomeCameraController() {
    const { camera } = useThree();
    const mouse = useRef({ x: 0, y: 0 });
    const target = useRef({ x: 0, y: 0 });

    if (typeof window !== 'undefined') {
        window.onmousemove = (e) => {
            mouse.current.x = (e.clientX / window.innerWidth - 0.5) * 1.8;
            mouse.current.y = (e.clientY / window.innerHeight - 0.5) * -0.8;
        };
    }

    useFrame((state, delta) => {
        const time = state.clock.getElapsedTime();
        // Slow breathing drift
        target.current.x += (mouse.current.x - target.current.x) * delta * 1.5;
        target.current.y += (mouse.current.y - target.current.y) * delta * 1.5;

        camera.position.x = target.current.x;
        camera.position.y = 1.5 + target.current.y + Math.sin(time * 0.5) * 0.08;
        camera.lookAt(0, 0, -10);
    });

    return null;
}

export default function HomeExperience() {
    return (
        <Canvas
            shadows
            dpr={[1, 1.5]}
            camera={{ position: [0, 1.5, 18], fov: 52, near: 0.1, far: 300 }}
            style={{ width: '100%', height: '100%', display: 'block' }}
        >
            {/* Depth Fog */}
            <fogExp2 attach="fog" color="#0D1A18" density={0.025} />

            <Lighting />
            <HomeCameraController />

            <Suspense fallback={null}>
                <HomeScene />
            </Suspense>

            <PostProcessing />
        </Canvas>
    );
}
