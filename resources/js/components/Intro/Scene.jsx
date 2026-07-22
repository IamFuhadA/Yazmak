import React from "react";
import Lighting from "./Lighting";
import World from "./World/World";
import CameraRig from "./CameraRig";
import ScrollController from "./ScrollController";

export default function Scene() {
    return (
        <>
            <Lighting />
            <CameraRig />
            <ScrollController />
            <World />
        </>
    );
}
