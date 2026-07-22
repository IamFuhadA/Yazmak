import * as THREE from "three";

export default class Renderer
{
    constructor(experience)
    {
        this.experience = experience;

        this.canvas = experience.canvas;
        this.scene = experience.scene;
        this.sizes = experience.sizes;
        this.camera = experience.camera;

        this.setInstance();
    }

    setInstance()
    {
        this.instance = new THREE.WebGLRenderer({
            canvas: this.canvas,
            antialias: true,
            alpha: true,
            powerPreference: "high-performance"
        });

        this.instance.setSize(
            this.sizes.width,
            this.sizes.height
        );

        this.instance.setPixelRatio(
            this.sizes.pixelRatio
        );

        this.instance.outputColorSpace = THREE.SRGBColorSpace;

        this.instance.toneMapping = THREE.ACESFilmicToneMapping;

        this.instance.toneMappingExposure = 1.2;

        this.instance.shadowMap.enabled = true;

        this.instance.shadowMap.type = THREE.PCFSoftShadowMap;

        this.instance.setClearColor(0xf4f7fa, 1);
    }

    resize()
    {
        this.instance.setSize(
            this.sizes.width,
            this.sizes.height
        );

        this.instance.setPixelRatio(
            this.sizes.pixelRatio
        );
    }

    update()
    {
        this.instance.render(
            this.scene,
            this.camera.instance
        );
    }

    destroy()
    {
        this.instance.dispose();
    }
}
