import React from "react";
import { motion } from "framer-motion";

export default function Overlay() {
    return (
        <div className="pointer-events-none absolute inset-0 z-50 flex items-center justify-center">
            <div className="max-w-3xl text-center">

                <motion.h1
                    initial={{ opacity: 0, y: 30 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{
                        duration: 1.2,
                        ease: "easeOut"
                    }}
                    className="mb-6 text-7xl font-light tracking-[0.35em] text-white"
                >
                    YAZMAK
                </motion.h1>

                <motion.p
                    initial={{ opacity: 0 }}
                    animate={{ opacity: 1 }}
                    transition={{
                        delay: 0.5,
                        duration: 1
                    }}
                    className="mx-auto max-w-xl text-lg leading-8 text-white/80"
                >
                    A calm place where compassionate psychiatric care,
                    emotional wellbeing, and evidence-based support come
                    together.
                </motion.p>

                <motion.div
                    initial={{ opacity: 0 }}
                    animate={{ opacity: 1 }}
                    transition={{
                        delay: 1.2,
                        duration: 1
                    }}
                    className="mt-16 flex flex-col items-center"
                >
                    <span className="text-sm tracking-[0.4em] text-white/60">
                        SCROLL
                    </span>

                    <div className="mt-4 h-12 w-[1px] bg-white/40" />
                </motion.div>

            </div>
        </div>
    );
}
