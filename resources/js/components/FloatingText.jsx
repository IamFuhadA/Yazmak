import React, { useRef } from 'react';
import { Text } from '@react-three/drei';
import { useFrame } from '@react-three/fiber';
import * as THREE from 'three';

export default function FloatingText({
    text,
    position = [0, 0, 0],
    rotation = [0, 0, 0],
    fontSize = 1.2,
    color = "#F5E8C7",
    emissive = "#8FD3C7",
    emissiveIntensity = 0.5,
    font = "https://fonts.gstatic.com/s/instrumentserif/v3/pxicypQ28e1j0Sg3v6pC0dJ7f9c.woff",
    italic = false,
    letterSpacing = 0.05,
    maxWidth = 20,
    opacity = 1
}) {
    const textRef = useRef();

    useFrame((state) => {
        if (textRef.current && textRef.current.material) {
            // Subtle breathing glow
            const t = state.clock.getElapsedTime();
            const pulse = (Math.sin(t * 1.5) + 1) * 0.2 + 0.3;
            textRef.current.material.emissiveIntensity = emissiveIntensity + pulse * 0.3;
        }
    });

    return (
        <Text
            ref={textRef}
            position={position}
            rotation={rotation}
            fontSize={fontSize}
            color={color}
            font={font}
            italic={italic}
            letterSpacing={letterSpacing}
            maxWidth={maxWidth}
            anchorX="center"
            anchorY="middle"
            textAlign="center"
        >
            {text}
            <meshStandardMaterial
                attach="material"
                color={color}
                roughness={0.3}
                metalness={0.2}
                emissive={new THREE.Color(emissive)}
                emissiveIntensity={emissiveIntensity}
                transparent
                opacity={opacity}
            />
        </Text>
    );
}
