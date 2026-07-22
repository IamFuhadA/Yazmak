import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export default class ScrollController {
    constructor(spacer, onUpdate) {
        this.spacer = spacer;
        this.onUpdate = onUpdate;
        this.progress = 0;
        this.trigger = null;

        this.init();
    }

    init() {
        if (!this.spacer) return;

        this.trigger = ScrollTrigger.create({
            trigger: this.spacer,
            start: 'top top',
            end: 'bottom bottom',
            scrub: 0.5,
            onUpdate: (self) => {
                this.progress = self.progress;
                if (typeof this.onUpdate === 'function') {
                    this.onUpdate(self.progress);
                }
            }
        });
    }

    destroy() {
        if (this.trigger) {
            this.trigger.kill();
            this.trigger = null;
        }
    }
}
