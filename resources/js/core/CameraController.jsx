import { useFrame, useThree } from "@react-three/fiber";
import { useRef } from "react";
import * as THREE from "three";

export default function CameraController() {
    const { camera } = useThree();
    const mousePos = useRef({ x: 0, y: 0 });

    // Track subtle mouse parallax
    if (typeof window !== "undefined") {
        window.onmousemove = (e) => {
            mousePos.current.x = (e.clientX / window.innerWidth - 0.5) * 0.4;
            mousePos.current.y = (e.clientY / window.innerHeight - 0.5) * 0.4;
        };
    }

    useFrame((state, delta) => {
        const time = state.clock.getElapsedTime();

        // Subtle camera breathing
        const breathY = Math.sin(time * 0.6) * 0.04;
        const breathX = Math.cos(time * 0.4) * 0.03;

        camera.position.x += (mousePos.current.x + breathX - camera.position.x * 0.001) * delta;
        camera.position.y += (-mousePos.current.y + breathY - camera.position.y * 0.001) * delta;
    });

    return null;
}
