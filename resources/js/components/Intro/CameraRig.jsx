import { useFrame, useThree } from "@react-three/fiber";
import { useRef } from "react";
import * as THREE from "three";

export default function CameraRig() {
    const { camera } = useThree();

    const targetPosition = useRef(
        new THREE.Vector3(0, 1.7, 8)
    );

    useFrame((state, delta) => {
        const t = state.clock.elapsedTime;

        // Idle breathing
        targetPosition.current.y =
            1.7 + Math.sin(t * 0.5) * 0.03;

        camera.position.lerp(
            targetPosition.current,
            delta * 2
        );

        camera.lookAt(
            camera.position.x,
            1.2,
            camera.position.z - 5
        );
    });

    return null;
}
