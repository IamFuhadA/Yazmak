import * as THREE from 'three';

export default class Typography {
    constructor(curve) {
        this.curve = curve;
        this.beats = [
            {
                element: document.getElementById('intro-beat-1'),
                start: 0.00, peak: 0.00, end: 0.15,
                pos3D: this.curve.getPointAt(0.05).clone()
            },
            {
                element: document.getElementById('intro-beat-2'),
                start: 0.18, peak: 0.26, end: 0.34,
                pos3D: this.curve.getPointAt(0.30).clone().add(new THREE.Vector3(0.7, 0.3, 0))
            },
            {
                element: document.getElementById('intro-beat-3'),
                start: 0.38, peak: 0.46, end: 0.54,
                pos3D: this.curve.getPointAt(0.50).clone().add(new THREE.Vector3(-0.7, -0.3, 0))
            },
            {
                element: document.getElementById('intro-beat-4'),
                start: 0.58, peak: 0.66, end: 0.74,
                pos3D: this.curve.getPointAt(0.70).clone().add(new THREE.Vector3(0.8, 0.4, 0))
            },
            {
                element: document.getElementById('intro-beat-5'),
                start: 0.78, peak: 0.86, end: 0.94,
                pos3D: this.curve.getPointAt(0.90).clone().add(new THREE.Vector3(-0.5, 0.5, 0))
            }
        ];
    }

    update(camera, smoothProgress, width, height) {
        const cameraDirection = new THREE.Vector3();
        camera.getWorldDirection(cameraDirection);
        const tempV = new THREE.Vector3();

        this.beats.forEach(beat => {
            if (!beat.element) return;

            const toPoint = new THREE.Vector3().subVectors(beat.pos3D, camera.position);
            const isBehind = toPoint.dot(cameraDirection) < 0;

            if (isBehind) {
                beat.element.classList.add('hidden');
                beat.element.style.opacity = 0;
                return;
            }

            tempV.copy(beat.pos3D).project(camera);

            if (tempV.x < -1 || tempV.x > 1 || tempV.y < -1 || tempV.y > 1) {
                beat.element.classList.add('hidden');
                beat.element.style.opacity = 0;
                return;
            }

            const x = (tempV.x * 0.5 + 0.5) * width;
            const y = (tempV.y * -0.5 + 0.5) * height;

            let opacity = 0;
            if (smoothProgress >= beat.start && smoothProgress <= beat.end) {
                if (smoothProgress <= beat.peak) {
                    const denom = beat.peak - beat.start;
                    opacity = denom > 0.0001 ? (smoothProgress - beat.start) / denom : 1.0;
                } else {
                    const denom = beat.end - beat.peak;
                    opacity = denom > 0.0001 ? 1.0 - (smoothProgress - beat.peak) / denom : 0.0;
                }
            }

            if (opacity > 0.02) {
                beat.element.classList.remove('hidden');
                beat.element.style.left = `${x}px`;
                beat.element.style.top = `${y}px`;
                beat.element.style.opacity = opacity;

                const scale = 0.84 + opacity * 0.16;
                beat.element.style.transform = `translate(-50%, -50%) scale(${scale})`;
            } else {
                beat.element.classList.add('hidden');
                beat.element.style.opacity = 0;
            }
        });
    }
}
