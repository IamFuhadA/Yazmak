import * as THREE from 'three';
import { CONFIG } from '../Config.js';

export default class Particles {
    constructor(scene, curve, isMobile) {
        this.scene = scene;
        this.curve = curve;
        this.isMobile = isMobile;

        this.count = this.isMobile ? 500 : 1800;
        this.geometry = new THREE.BufferGeometry();
        this.positions = new Float32Array(this.count * 3);
        this.seeds = new Float32Array(this.count);
        this.offsets = [];

        for (let i = 0; i < this.count; i++) {
            const t = Math.random();
            const curvePoint = this.curve.getPointAt(t);

            const angle = Math.random() * Math.PI * 2;
            const dist = 0.25 + Math.random() * 1.55;

            const ox = Math.cos(angle) * dist;
            const oy = Math.sin(angle) * dist;
            const oz = (Math.random() - 0.5) * 0.4;

            this.positions[i * 3] = curvePoint.x + ox;
            this.positions[i * 3 + 1] = curvePoint.y + oy;
            this.positions[i * 3 + 2] = curvePoint.z + oz;

            this.seeds[i] = Math.random() * 100;
            this.offsets.push({ t, ox, oy, oz });
        }

        this.geometry.setAttribute('position', new THREE.BufferAttribute(this.positions, 3));

        this.material = new THREE.PointsMaterial({
            color: CONFIG.colors.sage.clone().multiplyScalar(0.7),
            size: this.isMobile ? 0.06 : 0.10,
            transparent: true,
            opacity: 0.65,
            blending: THREE.NormalBlending,
            depthWrite: false,
            sizeAttenuation: true
        });

        this.instance = new THREE.Points(this.geometry, this.material);
        this.scene.add(this.instance);
    }

    update(time, mouse3D, currentColor) {
        this.material.color.copy(currentColor);

        const positions = this.geometry.attributes.position.array;
        for (let i = 0; i < this.count; i++) {
            const offset = this.offsets[i];
            const basePoint = this.curve.getPointAt(offset.t);
            const seed = this.seeds[i];

            const driftX = Math.sin(time * 0.4 + seed) * 0.08;
            const driftY = Math.cos(time * 0.35 + seed * 1.3) * 0.08;
            const driftZ = Math.sin(time * 0.25 + seed * 0.7) * 0.08;

            let targetX = basePoint.x + offset.ox + driftX;
            let targetY = basePoint.y + offset.oy + driftY;
            let targetZ = basePoint.z + offset.oz + driftZ;

            const dx = targetX - mouse3D.x;
            const dy = targetY - mouse3D.y;
            const dz = targetZ - mouse3D.z;
            const dist = Math.sqrt(dx * dx + dy * dy + dz * dz);

            if (dist < 2.2) {
                const force = (1.0 - dist / 2.2) * 0.65;
                targetX += (dx / (dist || 1)) * force;
                targetY += (dy / (dist || 1)) * force;
                targetZ += (dz / (dist || 1)) * force;
            }

            positions[i * 3] = targetX;
            positions[i * 3 + 1] = targetY;
            positions[i * 3 + 2] = targetZ;
        }
        this.geometry.attributes.position.needsUpdate = true;
    }

    destroy() {
        this.scene.remove(this.instance);
        this.geometry.dispose();
        this.material.dispose();
    }
}
