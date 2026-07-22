import * as THREE from "three";

export default class Camera {
    constructor(experience) {
        this.experience = experience;

        this.scene = experience.scene;
        this.sizes = experience.sizes;
        this.canvas = experience.canvas;

        this.setInstance();
    }

    setInstance() {
        this.instance = new THREE.PerspectiveCamera(
            45,
            this.sizes.width / this.sizes.height,
            0.1,
            1000
        );

        // Scene 0 cinematic position
        this.instance.position.set(0, 1.7, 8);

        this.scene.add(this.instance);
    }

    resize() {
        this.instance.aspect = this.sizes.width / this.sizes.height;
        this.instance.updateProjectionMatrix();
    }

    update() {
        // Idle breathing animation
        const t = this.experience.time.elapsed * 0.001;

        this.instance.position.y = 1.7 + Math.sin(t * 0.6) * 0.03;

        this.instance.lookAt(0, 1.2, 0);
    }
}
