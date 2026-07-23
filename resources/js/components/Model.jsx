import React from 'react';
import { useGLTF } from '@react-three/drei';

export default function Model({ path, ...props }) {
    const { scene } = useGLTF(path);
    // Clone scene to avoid sharing reference mutations in R3F
    const cloned = React.useMemo(() => scene.clone(), [scene]);
    
    // Auto-enable shadow casting and receiving for all children meshes
    React.useLayoutEffect(() => {
        cloned.traverse((child) => {
            if (child.isMesh) {
                child.castShadow = true;
                child.receiveShadow = true;
            }
        });
    }, [cloned]);

    return <primitive object={cloned} {...props} />;
}
