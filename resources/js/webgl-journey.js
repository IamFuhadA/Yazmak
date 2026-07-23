import './main.js';
import React from 'react';
import { createRoot } from 'react-dom/client';
import HomeExperience from './core/HomeExperience.jsx';

// Mount the home page 3D world if the root container exists
const homeRoot = document.getElementById('home-3d-root');
if (homeRoot) {
    const root = createRoot(homeRoot);
    root.render(React.createElement(HomeExperience));
}
