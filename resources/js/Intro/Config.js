import * as THREE from 'three';

// ── 1. CORE DESIGN TOKENS & SYSTEM CONFIG ──
const CONFIG = {
    colors: {
        ink950: new THREE.Color('#F8F7F4'), // Warm Ivory
        ink900: new THREE.Color('#F2EEE8'), // Soft Sand
        ink850: new THREE.Color('#EEF2F3'), // Mist Gray
        ink800: new THREE.Color('#F2C9B6'), // Soft Peach
        paper: new THREE.Color('#FFFFFF'), // Pure White
        sage: new THREE.Color('#7FAE9B'), // Sage Green
        blue: new THREE.Color('#5B8FB9'), // Ocean Blue
        gold: new THREE.Color('#E8C57A'), // Golden Sunrise
        charcoal: new THREE.Color('#2C3436')  // Charcoal
    },
    // Winding S-curves spline points
    splinePoints: [
        new THREE.Vector3(0, 3, 25),
        new THREE.Vector3(0.5, 2.8, 22),
        new THREE.Vector3(1.2, 2.2, 19),
        new THREE.Vector3(2.5, 0.5, 15),
        new THREE.Vector3(0.0, -1.5, 11),
        new THREE.Vector3(-3.0, -2.5, 7),
        new THREE.Vector3(-1.5, -1.0, 3),
        new THREE.Vector3(2.0, 1.5, -1),
        new THREE.Vector3(4.5, 0.0, -5),
        new THREE.Vector3(1.5, -2.0, -9),
        new THREE.Vector3(-2.5, -3.0, -13),
        new THREE.Vector3(-4.0, -0.5, -17),
        new THREE.Vector3(-1.0, 1.8, -21),
        new THREE.Vector3(2.5, 2.5, -25),
        new THREE.Vector3(3.0, 1.5, -29),
        new THREE.Vector3(0.8, -0.5, -33),
        new THREE.Vector3(0.0, 0.2, -37),
        new THREE.Vector3(0.0, 0.0, -41)
    ]
};

// Continuous background color timeline (lerped seamlessly)
const BG_TIMELINE = [
    { p: 0.00, val: CONFIG.colors.ink950 },
    { p: 0.20, val: CONFIG.colors.ink950 },
    { p: 0.45, val: CONFIG.colors.ink900 },
    { p: 0.70, val: CONFIG.colors.ink850 },
    { p: 0.85, val: CONFIG.colors.ink800 },
    { p: 1.00, val: CONFIG.colors.paper }
];

// Continuous ribbon / particle color timeline
const RIBBON_TIMELINE = [
    { p: 0.00, val: CONFIG.colors.sage.clone().multiplyScalar(0.7) },
    { p: 0.20, val: CONFIG.colors.sage },
    { p: 0.45, val: CONFIG.colors.blue },
    { p: 0.70, val: CONFIG.colors.gold },
    { p: 0.85, val: CONFIG.colors.ink800 },
    { p: 1.00, val: CONFIG.colors.sage }
];

// Continuous exponential fog density timeline
const FOG_TIMELINE = [
    { p: 0.00, density: 0.02 },
    { p: 0.20, density: 0.015 },
    { p: 0.50, density: 0.03 },
    { p: 0.80, density: 0.01 },
    { p: 1.00, density: 0.002 }
];

// Helper: Interpolate keyframe values
function interpolateTimeline(progress, timeline, isColor = true) {
    let segment = 0;
    for (let i = 0; i < timeline.length - 1; i++) {
        if (progress >= timeline[i].p && progress <= timeline[i + 1].p) {
            segment = i;
            break;
        }
    }
    const k1 = timeline[segment];
    const k2 = timeline[segment + 1];
    const t = (progress - k1.p) / (k2.p - k1.p);
    const easedT = t * t * (3 - 2 * t); // Smoothstep easing

    if (isColor) {
        return k1.val.clone().lerp(k2.val, easedT);
    } else {
        return THREE.MathUtils.lerp(k1.density, k2.density, easedT);
    }
}

export { CONFIG, BG_TIMELINE, RIBBON_TIMELINE, FOG_TIMELINE, interpolateTimeline };
