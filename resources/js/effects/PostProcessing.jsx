import React from 'react';
import { EffectComposer, Bloom, Vignette, Noise, ChromaticAberration } from '@react-three/postprocessing';
import { BlendFunction } from 'postprocessing';

export default function PostProcessing() {
    return (
        <EffectComposer disableNormalPass>
            {/* Cinematic Bloom */}
            <Bloom
                luminanceThreshold={0.55}
                luminanceSmoothing={0.85}
                intensity={1.3}
                mipmapBlur
            />

            {/* Subtle Vignette */}
            <Vignette
                eskil={false}
                offset={0.2}
                darkness={0.55}
            />

            {/* Organic Film Grain */}
            <Noise
                blendFunction={BlendFunction.OVERLAY}
                opacity={0.03}
            />

            {/* Lens Edge Aberration */}
            <ChromaticAberration
                offset={[0.0006, 0.0006]}
                radialModulation={true}
                modulationOffset={0.5}
            />
        </EffectComposer>
    );
}
