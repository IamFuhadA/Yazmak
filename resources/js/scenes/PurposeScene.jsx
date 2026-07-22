import React, { useRef } from 'react';
import { useFrame } from '@react-three/fiber';
import * as THREE from 'three';
import FloatingText from '../components/FloatingText.jsx';
import ParticleSystem from '../components/ParticleSystem.jsx';

export default function PurposeScene() {
    const riverRef = useRef();
    const waterfallRef = useRef();

    useFrame((state) => {
        const time = state.clock.getElapsedTime();

        // Animate water flow surface
        if (riverRef.current) {
            riverRef.current.position.x = Math.sin(time * 0.5) * 0.2;
        }

        if (waterfallRef.current) {
            waterfallRef.current.material.opacity = 0.6 + Math.sin(time * 2) * 0.15;
        }
    });

    return (
        <group position={[0, 0, 0]}>
            {/* Pollen & Water Spray Particles */}
            <ParticleSystem count={450} color="#8FD3C7" size={0.07} radius={30} />

            {/* Living River Surface */}
            <mesh ref={riverRef} position={[0, -1.8, 0]} rotation={[-Math.PI / 2, 0, 0]}>
                <planeGeometry args={[14, 80]} />
                <meshStandardMaterial
                    color="#5B8FB9"
                    emissive="#7FAE9B"
                    emissiveIntensity={0.25}
                    roughness={0.1}
                    metalness={0.8}
                    transparent
                    opacity={0.85}
                />
            </mesh>

            {/* River Banks (Terrain Meshes) */}
            <mesh position={[-12, -0.5, 0]}>
                <boxGeometry args={[10, 4, 80]} />
                <meshStandardMaterial color="#2B3D34" roughness={0.9} />
            </mesh>
            <mesh position={[12, -0.5, 0]}>
                <boxGeometry args={[10, 4, 80]} />
                <meshStandardMaterial color="#2B3D34" roughness={0.9} />
            </mesh>

            {/* Giant Arching Tree Roots crossing over the river */}
            <mesh position={[0, 2, 10]} rotation={[0.4, 0.3, 0.8]}>
                <torusGeometry args={[6, 0.8, 8, 24, Math.PI]} />
                <meshStandardMaterial color="#3A2B20" roughness={0.85} />
            </mesh>
            <mesh position={[0, 3, -15]} rotation={[-0.3, -0.5, -0.7]}>
                <torusGeometry args={[7, 0.9, 8, 24, Math.PI]} />
                <meshStandardMaterial color="#3A2B20" roughness={0.85} />
            </mesh>

            {/* Waterfall Curtain */}
            <mesh ref={waterfallRef} position={[-8, 4, -25]} rotation={[0, 0.4, 0]}>
                <planeGeometry args={[12, 20]} />
                <meshStandardMaterial
                    color="#8FD3C7"
                    emissive="#8FD3C7"
                    emissiveIntensity={0.5}
                    transparent
                    opacity={0.7}
                />
            </mesh>

            {/* Engraved Cliff Wall */}
            <group position={[0, 3, -35]}>
                <mesh receiveShadow>
                    <boxGeometry args={[24, 14, 3]} />
                    <meshStandardMaterial color="#263238" roughness={0.85} />
                </mesh>

                {/* Engraved Carved Quote */}
                <FloatingText
                    text="Every emotion deserves to be understood."
                    position={[0, 0, 1.6]}
                    fontSize={1.1}
                    color="#FEFEFE"
                    emissive="#8FD3C7"
                    emissiveIntensity={0.6}
                    maxWidth={16}
                    font="https://fonts.gstatic.com/s/instrumentserif/v3/pxicypQ28e1j0Sg3v6pC0dJ7f9c.woff"
                />
            </group>
        </group>
    );
}
