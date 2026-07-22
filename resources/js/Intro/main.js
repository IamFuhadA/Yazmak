import Experience from "./Experience.js";

const canvas = document.querySelector("canvas.webgl");

if (canvas) {
    new Experience(canvas);
}
