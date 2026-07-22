import { create } from 'zustand';

export const useStore = create((set) => ({
    scrollProgress: 0,
    activeScene: 0,
    activeMonolith: -1,
    portalActive: false,
    setScrollProgress: (progress) => set({ scrollProgress: progress }),
    setActiveScene: (activeScene) => set({ activeScene }),
    setActiveMonolith: (activeMonolith) => set({ activeMonolith }),
    setPortalActive: (portalActive) => set({ portalActive }),
}));
