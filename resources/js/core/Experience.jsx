import React, { Suspense } from 'react';
import { Canvas } from '@react-three/fiber';
import SceneManager from './SceneManager.jsx';

export default function Experience() {
    // NOTE: the scrubbed background video, its blur mask, and the
    // fixed/sticky full-viewport wrapper all already live in
    // home.blade.php (#cinematic-wrapper). This component is mounted
    // *inside* that markup's #home-intro-webgl-root, so it should only
    // ever render the R3F canvas — duplicating the video here (with
    // the same id) created a second, never-scrubbed <video> plus an
    // opaque background sitting on top of the real one, which is why
    // the visible video looked like it wasn't tracking scroll at all.
    return (
        <Canvas
            shadows
            dpr={[1, 2]}
            camera={{
                position: [0, 14, 180],
                fov: 45,
                near: 0.1,
                far: 400
            }}
            style={{ pointerEvents: 'none', width: '100%', height: '100%' }}
        >
            {/* Atmospheric Fog */}
            <fogExp2 attach="fog" color="#1E282A" density={0.007} />

            <Suspense fallback={null}>
                <SceneManager />
            </Suspense>
        </Canvas>
    );
}
