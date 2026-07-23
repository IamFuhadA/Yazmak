import React, { useRef } from 'react';
import { useFrame } from '@react-three/fiber';
import { Float } from '@react-three/drei';
import * as THREE from 'three';
import ParticleSystem from '../components/ParticleSystem.jsx';
import Model from '../components/Model.jsx';

export default function HomeScene() {
    const sakuraRef = useRef();
    const groundRef = useRef();

    useFrame((state) => {
        const time = state.clock.getElapsedTime();

        // Gentle sakura sway
        if (sakuraRef.current) {
            sakuraRef.current.rotation.z = Math.sin(time * 0.4) * 0.02;
        }

        // Subtle ground shimmer
        if (groundRef.current) {
            groundRef.current.material.emissiveIntensity = 0.04 + Math.sin(time * 0.8) * 0.02;
        }
    });

    return (
        <group>
            {/* Warm ambient firefly particles */}
            <ParticleSystem count={350} color="#F5E8C7" size={0.07} radius={28} />
            {/* Cool misty particles low near ground */}
            <ParticleSystem count={200} color="#8FD3C7" size={0.05} radius={15} />

            {/* Ground plane — mossy earth */}
            <mesh ref={groundRef} rotation={[-Math.PI / 2, 0, 0]} position={[0, -2.5, 0]} receiveShadow>
                <planeGeometry args={[120, 120, 1, 1]} />
                <meshStandardMaterial
                    color="#1E2B25"
                    roughness={0.95}
                    emissive="#2D3B30"
                    emissiveIntensity={0.04}
                />
            </mesh>

            {/* Stone pathway leading into the scene */}
            <Model
                path="/assets/structures/stone_pathway.glb"
                scale={[0.9, 0.9, 0.9]}
                position={[0, -2.5, 5]}
                rotation={[0, 0, 0]}
            />

            {/* Hero Sakura Tree — centre focal point */}
            <group ref={sakuraRef} position={[0, -2.5, -8]}>
                <Model
                    path="/assets/nature/sakura.glb"
                    scale={[1.8, 1.8, 1.8]}
                    position={[0, 0, 0]}
                />
                {/* Warm blossom glow beneath the tree */}
                <pointLight position={[0, 4, 0]} intensity={3.5} distance={22} color="#F5C8C0" />
            </group>

            {/* Left side — low-poly rock terrain with pine */}
            <Float speed={0.6} floatIntensity={0.15}>
                <group position={[-18, -2, -15]} rotation={[0, 0.4, 0]}>
                    <Model path="/assets/environment/lowpoly_rock_terrain.glb" scale={[2.2, 2.2, 2.2]} position={[0, 0, 0]} />
                    <Model path="/assets/nature/pine_tree.glb" scale={[1.4, 1.4, 1.4]} position={[2, 2.5, 0]} />
                </group>
            </Float>

            {/* Right side — roots hill with candle lanterns */}
            <group position={[18, -2.5, -12]} rotation={[0, -0.3, 0]}>
                <Model path="/assets/smallprops/roots_on_hill_free.glb" scale={[0.7, 0.7, 0.7]} position={[0, 0, 0]} />
                <Model path="/assets/smallprops/candle_lantern.glb" scale={[0.6, 0.6, 0.6]} position={[1.5, 2, 0]} />
                <pointLight position={[1.5, 3.5, 0]} intensity={2} distance={8} color="#F5C878" />
            </group>

            {/* Wooden bridge — low-poly, lightweight */}
            <Model
                path="/assets/structures/bridge_woodenlow-poly.glb"
                scale={[1.2, 1.2, 1.2]}
                position={[-6, -2.5, 0]}
                rotation={[0, Math.PI / 4, 0]}
            />

            {/* Background shrine tucked in the forest */}
            <group position={[4, -2.5, -28]}>
                <Model
                    path="/assets/structures/low-pol_shrine.glb"
                    scale={[1.5, 1.5, 1.5]}
                    position={[0, 0, 0]}
                />
                {/* Shrine lantern glow */}
                <pointLight position={[0, 3, 0]} intensity={2.5} distance={14} color="#F5E8C7" />
            </group>

            {/* Ground ferns scattered around */}
            <Model path="/assets/nature/fern_grass_02.glb" scale={[0.8, 0.8, 0.8]} position={[-4, -2.5, 2]} />
            <Model path="/assets/nature/fern_grass_02.glb" scale={[0.6, 0.6, 0.6]} position={[5, -2.5, 3]} rotation={[0, 1.2, 0]} />
            <Model path="/assets/nature/fern_grass_02.glb" scale={[0.7, 0.7, 0.7]} position={[10, -2.5, -5]} rotation={[0, 2.1, 0]} />

            {/* Mossy stump to the left */}
            <Model path="/assets/smallprops/boubin_stump.glb" scale={[1.0, 1.0, 1.0]} position={[-9, -2.5, 1]} rotation={[0, 0.8, 0]} />
        </group>
    );
}
