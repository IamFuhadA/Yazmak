import * as THREE from 'three';

export default class Environment {
    constructor(experience) {
        this.experience = experience;
        this.scene = experience.scene;
    }

    update(progress, time) {}

    destroy() {}
}
