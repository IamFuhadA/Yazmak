import React from "react";
import Ground from "./Ground";
import Platform from "./Platform";
import HeroTree from "./HeroTree";
import Companion from "./Companion";
import Atmosphere from "./Atmosphere";
import Effects from "./Effects";

export default function World() {
    return (
        <>
            <Ground />
            <Platform />
            <HeroTree />
            <Companion />
            <Atmosphere />
            <Effects />
        </>
    );
}
