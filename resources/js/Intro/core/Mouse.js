import * as THREE from 'three';

export default class Mouse {
    constructor() {
        this.x = 0;
        this.y = 0;
        this.smoothX = 0;
        this.smoothY = 0;

        this._onMouseMove = this._onMouseMove.bind(this);
        this._onTouchMove = this._onTouchMove.bind(this);

        window.addEventListener('mousemove', this._onMouseMove);
        window.addEventListener('touchmove', this._onTouchMove, { passive: true });
    }

    _onMouseMove(e) {
        this.x = (e.clientX / window.innerWidth) * 2 - 1;
        this.y = -(e.clientY / window.innerHeight) * 2 + 1;
    }

    _onTouchMove(e) {
        if (e.touches.length > 0) {
            this.x = (e.touches[0].clientX / window.innerWidth) * 2 - 1;
            this.y = -(e.touches[0].clientY / window.innerHeight) * 2 + 1;
        }
    }

    update() {
        this.smoothX += (this.x - this.smoothX) * 0.08;
        this.smoothY += (this.y - this.smoothY) * 0.08;
    }

    destroy() {
        window.removeEventListener('mousemove', this._onMouseMove);
        window.removeEventListener('touchmove', this._onTouchMove);
    }
}
