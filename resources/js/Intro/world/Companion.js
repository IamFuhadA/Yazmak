export default class Companion {
    constructor(experience) {
        this.experience = experience;
        this.scene = experience.scene;
    }

    update(progress, time, smoothMouse) {}

    destroy() {}
}
