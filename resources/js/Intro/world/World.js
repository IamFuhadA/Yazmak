import Environment from './Environment.js';
import Lighting from './Lighting.js';
import Companion from './Companion.js';
import SceneManager from './SceneManager.js';
import Particles from './Particles.js';
import Typography from './Typography.js';

export default class World {
    constructor(experience) {
        this.experience = experience;
        this.scene = experience.scene;

        this.lighting = new Lighting(this.experience);
        this.environment = new Environment(this.experience);
        this.companion = new Companion(this.experience);
        this.sceneManager = new SceneManager(this.experience);
        this.particles = new Particles(this.scene, experience.camera.curve, experience.isMobile);
        this.typography = new Typography(experience.camera.curve);
    }

    update(progress, time, smoothMouse) {
        if (this.lighting) this.lighting.update(progress, time);
        if (this.environment) this.environment.update(progress, time);
        if (this.companion) this.companion.update(progress, time, smoothMouse);
        if (this.sceneManager) this.sceneManager.update(progress, time);
    }

    destroy() {
        if (this.particles) this.particles.destroy();
        if (this.lighting) this.lighting.destroy();
        if (this.environment) this.environment.destroy();
        if (this.companion) this.companion.destroy();
        if (this.sceneManager) this.sceneManager.destroy();
    }
}
