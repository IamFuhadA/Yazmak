export default function Platform() {
    return (
        <mesh
            position={[0, 0.12, 0]}
            receiveShadow
            castShadow
        >
            <cylinderGeometry
                args={[2.6, 2.8, 0.25, 64]}
            />

            <meshStandardMaterial
                color="#d8d1c4"
                roughness={0.95}
            />
        </mesh>
    );
}
