import React from 'react';
import { createRoot } from 'react-dom/client';
import Intro from './components/Intro/Intro.jsx';

const container = document.getElementById('home-intro-webgl-root');
if (container) {
    const root = createRoot(container);
    root.render(React.createElement(Intro));
}


