import React from "react";
import {
    EffectComposer,
    Bloom,
    Vignette,
    Noise
} from "@react-three/postprocessing";

export default function Effects() {
    return (
        <EffectComposer multisampling={4}>
            <Bloom
                intensity={0.8}
                luminanceThreshold={0.7}
                luminanceSmoothing={0.9}
                mipmapBlur
            />

            <Vignette
                eskil={false}
                offset={0.2}
                darkness={0.7}
            />

            <Noise
                opacity={0.015}
            />
        </EffectComposer>
    );
}
