import React, { useRef } from 'react';
import { useFrame } from '@react-three/fiber';
import * as THREE from 'three';

export default function Lighting() {
    const sunRef = useRef();

    useFrame((state) => {
        if (sunRef.current) {
            const t = state.clock.getElapsedTime() * 0.1;
            // Slow orbital movement of sunrise light
            sunRef.current.position.x = Math.sin(t) * 15 + 10;
            sunRef.current.position.z = Math.cos(t) * 15 - 50;
        }
    });

    return (
        <>
            {/* Ambient Base Light */}
            <ambientLight intensity={0.6} color="#E8F1F2" />

            {/* Sky Hemisphere Gradient */}
            <hemisphereLight
                skyColor="#FFE4C4"
                groundColor="#2D3B3A"
                intensity={0.8}
            />

            {/* Main Sunrise Sun Light */}
            <directionalLight
                ref={sunRef}
                position={[25, 20, 40]}
                intensity={2.2}
                color="#F5E8C7"
                castShadow
                shadow-mapSize-width={2048}
                shadow-mapSize-height={2048}
                shadow-camera-near={0.5}
                shadow-camera-far={200}
                shadow-camera-left={-30}
                shadow-camera-right={30}
                shadow-camera-top={30}
                shadow-camera-bottom={-30}
                shadow-bias={-0.0001}
            />

            {/* Secondary Soft Fill Light */}
            <directionalLight
                position={[-20, 10, -80]}
                intensity={0.9}
                color="#8FD3C7"
            />

            {/* Fog / Horizon Glow Point Lights */}
            <pointLight position={[0, 8, -120]} intensity={3} distance={50} color="#8FD3C7" />
            <pointLight position={[0, 12, -240]} intensity={4} distance={60} color="#F5E8C7" />
        </>
    );
}
