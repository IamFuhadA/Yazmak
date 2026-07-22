import * as THREE from 'three';

export default class Lighting {
    constructor(experience) {
        this.experience = experience;
        this.scene = experience.scene;

        this.ambientLight = new THREE.AmbientLight('#ffffff', 0.65);
        this.dirLight = new THREE.DirectionalLight('#ffffff', 0.85);
        this.dirLight.position.set(5, 10, 7);
        this.rimLight = new THREE.DirectionalLight('#7FAE9B', 0.3);
        this.rimLight.position.set(-5, 3, -5);

        this.scene.add(this.ambientLight);
        this.scene.add(this.dirLight);
        this.scene.add(this.rimLight);
    }

    update(progress, time) {}

    destroy() {
        this.scene.remove(this.ambientLight);
        this.scene.remove(this.dirLight);
        this.scene.remove(this.rimLight);
    }
}
