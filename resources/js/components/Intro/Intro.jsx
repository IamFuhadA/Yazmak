import React, { Suspense } from "react";
import { Canvas } from "@react-three/fiber";
import Scene from "./Scene";
import Overlay from "./UI/Overlay";

export default function Intro() {
    return (
        <div className="fixed inset-0 h-screen w-screen overflow-hidden">
            <Canvas
                shadows
                dpr={[1, 2]}
                camera={{
                    position: [0, 1.7, 8],
                    fov: 45,
                    near: 0.1,
                    far: 100
                }}
            >
                <Suspense fallback={null}>
                    <Scene />
                </Suspense>
            </Canvas>

            <Overlay />
        </div>
    );
}
