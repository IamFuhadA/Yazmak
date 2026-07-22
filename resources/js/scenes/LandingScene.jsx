import React, { useRef } from 'react';
import { useFrame } from '@react-three/fiber';
import { Float } from '@react-three/drei';
import * as THREE from 'three';
import FloatingText from '../components/FloatingText.jsx';
import ParticleSystem from '../components/ParticleSystem.jsx';

export default function LandingScene() {
    const monolithRef = useRef();
    const cloudsRef = useRef();

    useFrame((state) => {
        const time = state.clock.getElapsedTime();

        // Slow floating rotation & hover for the main monolith
        if (monolithRef.current) {
            monolithRef.current.rotation.y = Math.sin(time * 0.15) * 0.08;
            monolithRef.current.rotation.z = Math.sin(time * 0.1) * 0.03;
        }

        // Slow cloud drift
        if (cloudsRef.current) {
            cloudsRef.current.rotation.y = time * 0.005;
        }
    });

    return (
        <group position={[0, 0, 80]}>
            {/* Ambient Particle Dust */}
            <ParticleSystem count={500} color="#F5E8C7" size={0.09} radius={35} />

            {/* Giant Floating YAZMAK Monolith */}
            <Float speed={1.5} rotationIntensity={0.2} floatIntensity={0.5}>
                <group ref={monolithRef} position={[0, 4, 0]}>
                    {/* Main Stone Slab */}
                    <mesh castShadow receiveShadow>
                        <boxGeometry args={[10, 18, 4]} />
                        <meshStandardMaterial
                            color="#2C3436"
                            roughness={0.8}
                            metalness={0.1}
                            bumpScale={0.05}
                        />
                    </mesh>

                    {/* Side Gold Accent Inlays */}
                    <mesh position={[5.05, 0, 0]}>
                        <boxGeometry args={[0.1, 17.8, 3.8]} />
                        <meshStandardMaterial color="#8FD3C7" emissive="#8FD3C7" emissiveIntensity={0.6} />
                    </mesh>
                    <mesh position={[-5.05, 0, 0]}>
                        <boxGeometry args={[0.1, 17.8, 3.8]} />
                        <meshStandardMaterial color="#8FD3C7" emissive="#8FD3C7" emissiveIntensity={0.6} />
                    </mesh>

                    {/* Engraved Carved 3D Title "YAZMAK" */}
                    <FloatingText
                        text="YAZMAK"
                        position={[0, 3.5, 2.05]}
                        fontSize={2.2}
                        color="#FEFEFE"
                        emissive="#8FD3C7"
                        emissiveIntensity={0.8}
                        letterSpacing={0.2}
                    />

                    {/* Engraved Subtext Quote */}
                    <FloatingText
                        text="Sometimes healing begins before the first conversation."
                        position={[0, -2, 2.05]}
                        fontSize={0.45}
                        color="#F5E8C7"
                        emissive="#F5E8C7"
                        emissiveIntensity={0.4}
                        maxWidth={7}
                        italic
                    />
                </group>
            </Float>

            {/* Surrounding Drifting Monolith Cliffs */}
            <group ref={cloudsRef}>
                <mesh position={[-25, 2, -15]} rotation={[0.2, 0.5, 0]}>
                    <dodecahedronGeometry args={[6, 1]} />
                    <meshStandardMaterial color="#1E282A" roughness={0.9} />
                </mesh>
                <mesh position={[28, -5, -20]} rotation={[-0.1, -0.4, 0.2]}>
                    <dodecahedronGeometry args={[8, 1]} />
                    <meshStandardMaterial color="#1E282A" roughness={0.9} />
                </mesh>
                <mesh position={[-30, -12, 10]} rotation={[0.4, 0.2, -0.1]}>
                    <icosahedronGeometry args={[9, 1]} />
                    <meshStandardMaterial color="#192224" roughness={0.95} />
                </mesh>

                {/* Cloud Ocean Layer */}
                <mesh position={[0, -18, -10]} rotation={[-Math.PI / 2, 0, 0]}>
                    <planeGeometry args={[180, 180, 16, 16]} />
                    <meshStandardMaterial
                        color="#FFE4C4"
                        transparent
                        opacity={0.35}
                        roughness={1}
                    />
                </mesh>
            </group>
        </group>
    );
}
