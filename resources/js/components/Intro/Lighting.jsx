import React from "react";

export default function Lighting() {
    return (
        <>
            <ambientLight intensity={1.2} />

            <hemisphereLight
                intensity={0.8}
                groundColor="#d7e6c8"
            />

            <directionalLight
                position={[8, 10, 6]}
                intensity={2}
                castShadow
                shadow-mapSize-width={2048}
                shadow-mapSize-height={2048}
            />
        </>
    );
}
