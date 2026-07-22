import React, { Suspense } from 'react';
import { Canvas } from '@react-three/fiber';
import SceneManager from './SceneManager.jsx';

export default function Experience() {
    return (
        <div className="fixed inset-0 h-screen w-screen overflow-hidden bg-[#090B10]">
            {/* Loop-free scroll-scrubbed background video */}
            <video
                id="scroll-journey-video"
                src="/video/no_in_my_video_thers_no_charac.mp4"
                muted
                playsInline
                preload="auto"
                className="absolute inset-0 w-full h-[130%] object-cover object-top z-0 pointer-events-none"
                style={{ opacity: 0.8 }}
            />

            {/* Bottom Blur Mask Overlay */}
            <div 
                className="absolute inset-0 z-10 pointer-events-none backdrop-blur-xl"
                style={{
                    maskImage: 'linear-gradient(to top, black 0%, transparent 45%)',
                    WebkitMaskImage: 'linear-gradient(to top, black 0%, transparent 45%)'
                }}
            />

            {/* R3F Canvas Container */}
            <div className="absolute inset-0 z-20 pointer-events-none">
                <Canvas
                    shadows
                    dpr={[1, 2]}
                    camera={{
                        position: [0, 14, 180],
                        fov: 45,
                        near: 0.1,
                        far: 400
                    }}
                    style={{ pointerEvents: 'none' }}
                >
                    {/* Atmospheric Fog */}
                    <fogExp2 attach="fog" color="#1E282A" density={0.007} />

                    <Suspense fallback={null}>
                        <SceneManager />
                    </Suspense>
                </Canvas>
            </div>
        </div>
    );
}
