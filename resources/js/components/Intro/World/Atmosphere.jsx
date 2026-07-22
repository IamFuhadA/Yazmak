import { Environment, Sparkles } from "@react-three/drei";

export default function Atmosphere() {
    return (
        <>
            <Environment preset="sunset" />

            <Sparkles
                count={60}
                scale={20}
                size={2}
                speed={0.15}
                opacity={0.25}
                color="#ffffff"
            />
        </>
    );
}
