import { useFrame } from "@react-three/fiber";
import { useRef } from "react";
import * as THREE from "three";

export default function Companion() {
    const orb = useRef();
    const light = useRef();

    useFrame((state) => {
        const t = state.clock.elapsedTime;

        if (orb.current) {
            orb.current.position.x = Math.sin(t * 0.4) * 0.15;
            orb.current.position.y = 2 + Math.sin(t * 1.5) * 0.12;
            orb.current.position.z = Math.cos(t * 0.5) * 0.15;

            orb.current.rotation.y += 0.01;
        }

        if (light.current) {
            light.current.position.copy(orb.current.position);

            light.current.intensity =
                2.2 + Math.sin(t * 3) * 0.2;
        }
    });

    return (
        <>
            <pointLight
                ref={light}
                intensity={2}
                distance={5}
                color="#ffffff"
            />

            <mesh
                ref={orb}
                position={[0, 2, 0]}
                castShadow
            >
                <sphereGeometry args={[0.08, 32, 32]} />

                <meshStandardMaterial
                    color="#ffffff"
                    emissive={new THREE.Color("#dff8ff")}
                    emissiveIntensity={6}
                    toneMapped={false}
                />
            </mesh>
        </>
    );
}
