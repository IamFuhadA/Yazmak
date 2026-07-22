import React, { useRef } from 'react';
import { useFrame } from '@react-three/fiber';
import { Float } from '@react-three/drei';
import * as THREE from 'three';
import FloatingText from '../components/FloatingText.jsx';
import ParticleSystem from '../components/ParticleSystem.jsx';

export default function GuideScene() {
    const gatewayRef = useRef();
    const vortexRef = useRef();

    useFrame((state) => {
        const time = state.clock.getElapsedTime();

        // Slow portal ring rotation
        if (gatewayRef.current) {
            gatewayRef.current.rotation.z = time * 0.08;
        }

        // Swirling inner vortex glow
        if (vortexRef.current) {
            vortexRef.current.rotation.z = -time * 0.15;
            vortexRef.current.material.opacity = 0.7 + Math.sin(time * 2.5) * 0.25;
        }
    });

    return (
        <group position={[0, 0, -220]}>
            {/* Floating Golden Portal Motes */}
            <ParticleSystem count={600} color="#F5E8C7" size={0.1} radius={40} />

            {/* Floating Sky Islands */}
            <Float speed={1.2} rotationIntensity={0.2} floatIntensity={0.4}>
                <mesh position={[-28, 6, 20]} rotation={[0.2, 0.4, 0]}>
                    <dodecahedronGeometry args={[12, 1]} />
                    <meshStandardMaterial color="#212F35" roughness={0.85} />
                </mesh>
            </Float>
            <Float speed={1.5} rotationIntensity={0.25} floatIntensity={0.5}>
                <mesh position={[30, 8, 10]} rotation={[-0.3, -0.2, 0.1]}>
                    <dodecahedronGeometry args={[14, 1]} />
                    <meshStandardMaterial color="#212F35" roughness={0.85} />
                </mesh>
            </Float>

            {/* Circular Gateway Portal Assembly */}
            <group position={[0, 5, -20]}>
                {/* Outer Stone Gateway Ring */}
                <mesh ref={gatewayRef} castShadow receiveShadow>
                    <torusGeometry args={[11, 1.4, 16, 64]} />
                    <meshStandardMaterial
                        color="#2C3A3E"
                        roughness={0.7}
                        metalness={0.2}
                    />
                </mesh>

                {/* Inner Glowing Swirling Portal Disc */}
                <mesh ref={vortexRef} position={[0, 0, -0.1]}>
                    <circleGeometry args={[9.5, 64]} />
                    <meshStandardMaterial
                        color="#8FD3C7"
                        emissive="#F5E8C7"
                        emissiveIntensity={1.5}
                        transparent
                        opacity={0.8}
                        side={THREE.DoubleSide}
                    />
                </mesh>

                {/* Portal Beam Light */}
                <pointLight position={[0, 0, 5]} intensity={8} distance={80} color="#F5E8C7" />

                {/* Engraved Final Portal Quote */}
                <FloatingText
                    text="You were never meant to walk alone."
                    position={[0, 0, 1.2]}
                    fontSize={1.2}
                    color="#FEFEFE"
                    emissive="#F5E8C7"
                    emissiveIntensity={0.9}
                    maxWidth={14}
                    font="https://fonts.gstatic.com/s/instrumentserif/v3/pxicypQ28e1j0Sg3v6pC0dJ7f9c.woff"
                />

                {/* Gateway Base Pedestal */}
                <mesh position={[0, -12, 0]}>
                    <cylinderGeometry args={[4, 6, 6, 16]} />
                    <meshStandardMaterial color="#1E282A" roughness={0.9} />
                </mesh>
            </group>
        </group>
    );
}
