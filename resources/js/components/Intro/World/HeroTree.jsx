export default function HeroTree() {
    return (
        <group position={[-2.2, 0, -1]}>
            <mesh
                position={[0, 1.2, 0]}
                castShadow
            >
                <cylinderGeometry
                    args={[0.18, 0.25, 2.4, 12]}
                />

                <meshStandardMaterial
                    color="#7d5d42"
                />
            </mesh>

            <mesh
                position={[0, 3, 0]}
                castShadow
            >
                <sphereGeometry
                    args={[1.2, 32, 32]}
                />

                <meshStandardMaterial
                    color="#7aa76b"
                />
            </mesh>
        </group>
    );
}
