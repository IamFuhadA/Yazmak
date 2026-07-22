import React, { useRef, useMemo } from 'react';
import { useFrame } from '@react-three/fiber';
import * as THREE from 'three';

export default function ParticleSystem({ count = 600, color = "#F5E8C7", size = 0.08, speed = 0.2, radius = 40 }) {
    const pointsRef = useRef();

    // Generate random particle positions and drift seeds
    const [positions, seeds] = useMemo(() => {
        const pos = new Float32Array(count * 3);
        const s = new Float32Array(count * 3);
        for (let i = 0; i < count; i++) {
            pos[i * 3] = (Math.random() - 0.5) * radius * 2;
            pos[i * 3 + 1] = (Math.random() - 0.5) * radius * 1.5;
            pos[i * 3 + 2] = (Math.random() - 0.5) * radius * 3 - 50; // spread along z

            s[i * 3] = Math.random() * Math.PI * 2;
            s[i * 3 + 1] = Math.random() * Math.PI * 2;
            s[i * 3 + 2] = Math.random() * 0.5 + 0.5;
        }
        return [pos, s];
    }, [count, radius]);

    useFrame((state) => {
        if (!pointsRef.current) return;
        const time = state.clock.getElapsedTime() * speed;
        const posAttr = pointsRef.current.geometry.attributes.position;
        const array = posAttr.array;

        for (let i = 0; i < count; i++) {
            const idx = i * 3;
            // Organic wind oscillation
            array[idx] += Math.sin(time + seeds[idx]) * 0.015;
            array[idx + 1] += Math.cos(time + seeds[idx + 1]) * 0.01;
            array[idx + 2] += Math.sin(time * 0.5 + seeds[idx + 2]) * 0.02;

            // Reset bounds if drifted too far
            if (Math.abs(array[idx]) > radius * 1.5) array[idx] *= -0.8;
            if (Math.abs(array[idx + 1]) > radius) array[idx + 1] *= -0.8;
        }

        posAttr.needsUpdate = true;
    });

    // Custom circle texture for soft glowing particles
    const particleTexture = useMemo(() => {
        const canvas = document.createElement('canvas');
        canvas.width = 64;
        canvas.height = 64;
        const ctx = canvas.getContext('2d');
        const grad = ctx.createRadialGradient(32, 32, 0, 32, 32, 32);
        grad.addColorStop(0, 'rgba(255, 255, 255, 1)');
        grad.addColorStop(0.3, 'rgba(245, 232, 199, 0.8)');
        grad.addColorStop(1, 'rgba(245, 232, 199, 0)');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, 64, 64);
        return new THREE.CanvasTexture(canvas);
    }, []);

    return (
        <points ref={pointsRef}>
            <bufferGeometry>
                <bufferAttribute
                    attach="attributes-position"
                    args={[positions, 3]}
                />
            </bufferGeometry>
            <pointsMaterial
                size={size}
                color={color}
                map={particleTexture}
                transparent
                depthWrite={false}
                blending={THREE.AdditiveBlending}
                opacity={0.75}
            />
        </points>
    );
}
