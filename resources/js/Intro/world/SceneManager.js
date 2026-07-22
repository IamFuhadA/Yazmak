import Scene0 from '../scenes/Scene0.js';
import Scene1 from '../scenes/Scene1.js';
import Scene2 from '../scenes/Scene2.js';
import Scene3 from '../scenes/Scene3.js';
import Scene4 from '../scenes/Scene4.js';

export default class SceneManager {
    constructor(experience) {
        this.experience = experience;
        this.scenes = [
            new Scene0(experience),
            new Scene1(experience),
            new Scene2(experience),
            new Scene3(experience),
            new Scene4(experience)
        ];
        this.activeSceneIndex = 0;
    }

    update(progress, time) {
        const index = Math.min(Math.floor(progress * 5), 4);
        if (index !== this.activeSceneIndex) {
            this.activeSceneIndex = index;
        }
        if (this.scenes[this.activeSceneIndex]) {
            this.scenes[this.activeSceneIndex].update(progress, time);
        }
    }

    destroy() {
        this.scenes.forEach(scene => {
            if (scene && typeof scene.destroy === 'function') {
                scene.destroy();
            }
        });
    }
}
