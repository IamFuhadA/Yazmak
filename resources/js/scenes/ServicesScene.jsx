import React, { useRef } from 'react';
import { useFrame } from '@react-three/fiber';
import { Float } from '@react-three/drei';
import * as THREE from 'three';
import FloatingText from '../components/FloatingText.jsx';
import ParticleSystem from '../components/ParticleSystem.jsx';
import { useStore } from '../utils/store.js';

const services = [
    { title: "Anxiety Care", desc: "Reclaim inner stability & quiet your mind." },
    { title: "Depression Support", desc: "Gentle, compassionate path to vitality." },
    { title: "Trauma Recovery", desc: "Safe, confidential healing space." },
    { title: "Relationship Therapy", desc: "Restoring harmonious connections." },
    { title: "Online Consultation", desc: "Expert guidance from your home." }
];

export default function ServicesScene() {
    const monolithsGroupRef = useRef();
    const centralTreeRef = useRef();
    const activeMonolith = useStore((state) => state.activeMonolith);

    useFrame((state) => {
        const time = state.clock.getElapsedTime();

        // Slow orbital rotation of the 5 monoliths around the central tree
        if (monolithsGroupRef.current) {
            monolithsGroupRef.current.rotation.y = time * 0.05;
        }

        // Pulse central tree light
        if (centralTreeRef.current) {
            const pulse = (Math.sin(time * 2) + 1) * 0.5;
            centralTreeRef.current.material.emissiveIntensity = 0.8 + pulse * 0.6;
        }
    });

    return (
        <group position={[0, 0, -100]}>
            {/* Glowing Lantern Motes */}
            <ParticleSystem count={500} color="#F5E8C7" size={0.08} radius={35} />

            {/* Sacred Lake Water */}
            <mesh position={[0, -2, 0]} rotation={[-Math.PI / 2, 0, 0]}>
                <planeGeometry args={[100, 100]} />
                <meshStandardMaterial
                    color="#1F2A30"
                    roughness={0.05}
                    metalness={0.9}
                    envMapIntensity={1.5}
                />
            </mesh>

            {/* Sanctuary Archways */}
            <group position={[0, 4, 25]}>
                <mesh position={[-8, 0, 0]}>
                    <cylinderGeometry args={[1.2, 1.5, 16, 12]} />
                    <meshStandardMaterial color="#2B3638" roughness={0.8} />
                </mesh>
                <mesh position={[8, 0, 0]}>
                    <cylinderGeometry args={[1.2, 1.5, 16, 12]} />
                    <meshStandardMaterial color="#2B3638" roughness={0.8} />
                </mesh>
                <mesh position={[0, 7.5, 0]} rotation={[0, 0, Math.PI / 2]}>
                    <cylinderGeometry args={[1.2, 1.2, 16, 12]} />
                    <meshStandardMaterial color="#2B3638" roughness={0.8} />
                </mesh>
            </group>

            {/* Central Glowing Tree of Light */}
            <group position={[0, 3, 0]}>
                <mesh ref={centralTreeRef}>
                    <cylinderGeometry args={[0.8, 2.2, 10, 16]} />
                    <meshStandardMaterial
                        color="#7FAE9B"
                        emissive="#8FD3C7"
                        emissiveIntensity={1.2}
                        roughness={0.2}
                    />
                </mesh>
                <pointLight intensity={5} distance={30} color="#8FD3C7" />
            </group>

            {/* 5 Orbiting Monoliths Circle */}
            <group ref={monolithsGroupRef} position={[0, 2, 0]}>
                {services.map((service, index) => {
                    const angle = (index / services.length) * Math.PI * 2;
                    const radius = 14;
                    const x = Math.cos(angle) * radius;
                    const z = Math.sin(angle) * radius;
                    const isActive = activeMonolith === index || activeMonolith === -1;

                    return (
                        <Float key={service.title} speed={2} rotationIntensity={0.1} floatIntensity={0.3}>
                            <group position={[x, 1, z]} rotation={[0, -angle + Math.PI / 2, 0]}>
                                {/* Monolith Body */}
                                <mesh castShadow receiveShadow>
                                    <boxGeometry args={[4.5, 7.5, 1.2]} />
                                    <meshStandardMaterial
                                        color={isActive ? "#37474F" : "#212121"}
                                        roughness={0.7}
                                        emissive={isActive ? "#8FD3C7" : "#000000"}
                                        emissiveIntensity={isActive ? 0.25 : 0}
                                    />
                                </mesh>

                                {/* Engraved Service Title */}
                                <FloatingText
                                    text={service.title}
                                    position={[0, 1.2, 0.65]}
                                    fontSize={0.5}
                                    color="#FEFEFE"
                                    emissive={isActive ? "#8FD3C7" : "#F5E8C7"}
                                    emissiveIntensity={isActive ? 0.8 : 0.2}
                                    maxWidth={4}
                                />

                                {/* Engraved Service Description */}
                                <FloatingText
                                    text={service.desc}
                                    position={[0, -0.8, 0.65]}
                                    fontSize={0.28}
                                    color="#F5E8C7"
                                    emissive="#F5E8C7"
                                    emissiveIntensity={0.3}
                                    maxWidth={3.8}
                                    italic
                                />

                                {/* Monolith Base Glow Line */}
                                <mesh position={[0, -3.7, 0.62]}>
                                    <boxGeometry args={[4.2, 0.1, 0.05]} />
                                    <meshStandardMaterial
                                        color="#8FD3C7"
                                        emissive="#8FD3C7"
                                        emissiveIntensity={isActive ? 1.5 : 0.3}
                                    />
                                </mesh>
                            </group>
                        </Float>
                    );
                })}
            </group>
        </group>
    );
}
