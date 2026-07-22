import { MeshReflectorMaterial } from "@react-three/drei";

export default function Ground() {
    return (
        <mesh
            rotation={[-Math.PI / 2, 0, 0]}
            position={[0, -0.01, 0]}
            receiveShadow
        >
            <circleGeometry args={[25, 128]} />

            <MeshReflectorMaterial
                color="#b8c9a7"
                roughness={1}
                metalness={0}
                blur={[400, 100]}
                resolution={1024}
                mixStrength={2}
            />
        </mesh>
    );
}
