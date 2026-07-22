import React from 'react';
import Lighting from '../effects/lighting.jsx';
import PostProcessing from '../effects/PostProcessing.jsx';
import CameraController from './CameraController.jsx';
import ScrollController from './ScrollController.jsx';
import LandingScene from '../scenes/LandingScene.jsx';
import PurposeScene from '../scenes/PurposeScene.jsx';
import ServicesScene from '../scenes/ServicesScene.jsx';
import GuideScene from '../scenes/GuideScene.jsx';

export default function SceneManager() {
    return (
        <>
            {/* Atmospheric Lighting & Post Processing */}
            <Lighting />
            <PostProcessing />

            {/* Drone Camera Spline & Parallax Controllers */}
            <CameraController />
            <ScrollController />

            {/* The 4 Continuous 3D Spatial Scenes */}
            <LandingScene />
            <PurposeScene />
            <ServicesScene />
            <GuideScene />
        </>
    );
}
