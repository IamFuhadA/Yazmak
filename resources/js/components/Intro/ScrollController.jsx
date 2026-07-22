import React, { useEffect } from "react";
import { useThree } from "@react-three/fiber";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

export default function ScrollController() {
    const { camera } = useThree();

    useEffect(() => {
        const timeline = gsap.timeline({
            scrollTrigger: {
                trigger: document.body,
                start: "top top",
                end: "+=6000",
                scrub: 1,
                pin: false,
                invalidateOnRefresh: true,
            },
        });

        // Scene 0 → Idle Push
        timeline.to(
            camera.position,
            {
                x: 0,
                y: 1.7,
                z: 6,
                duration: 1,
                ease: "none",
            },
            0
        );

        // Move toward Scene 1
        timeline.to(
            camera.position,
            {
                x: 0,
                y: 1.7,
                z: 0,
                duration: 2,
                ease: "none",
            },
            1
        );

        // Gentle curve
        timeline.to(
            camera.position,
            {
                x: 2,
                y: 1.8,
                z: -8,
                duration: 2,
                ease: "none",
            },
            3
        );

        return () => {
            timeline.kill();
            ScrollTrigger.getAll().forEach((trigger) => trigger.kill());
        };
    }, [camera]);

    return null;
}
