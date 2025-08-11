// import preset from "./vendor/filament/support/tailwind.config.preset";

/** @type {import('tailwindcss').Config} */

export default {
    // presets: [preset],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        // extend: {
        //     colors: {
        //         primary: {
        //             50: '#EEEEFB',
        //             100: '#DCDCF7',
        //             200: '#B9B8EF',
        //             300: '#9795E6',
        //             400: '#7471DE',
        //             500: '#524ED5',
        //             600: '#413CAD',
        //             700: '#342F8A',
        //             800: '#2D2B8D', // base primary
        //             900: '#1E1C5A',
        //         },
        //         secondary: {
        //             50: '#FFFBEB',
        //             100: '#FFF6D6',
        //             200: '#FFEDAD',
        //             300: '#FFE585',
        //             400: '#FFDC5C',
        //             500: '#FFD333',
        //             600: '#FFC903', // base secondary
        //             700: '#E6B500',
        //             800: '#BF9600',
        //             900: '#997800',
        //         },
        //         background: {
        //             white: '#FFFFFF',
        //             wheat: '#F9F6F0',
        //             light: '#F5F1E8',
        //             subtle: '#EDE7DB',
        //         },
        //         success: '#10B981',
        //         error: '#EF4444',
        //         warning: '#F59E0B',
        //         info: '#3B82F6',
        //     },
        // },
        extend: {
            colors: {
                primary: {
                    50: "#eff6ff",
                    100: "#dbeafe",
                    200: "#bfdbfe",
                    300: "#93c5fd",
                    400: "#60a5fa",
                    500: "#3b82f6",
                    600: "#2563eb",
                    700: "#1d4ed8",
                    800: "#1e40af",
                    900: "#1e3a8a",
                    DEFAULT: "#2563eb", // Konsisten dengan 600
                    light: "#eff6ff",
                    "dark-light": "rgba(37, 99, 235, 0.15)",
                },
                secondary: {
                    50: "#FFFBEB",
                    100: "#FFF6D6",
                    200: "#FFEDAD",
                    300: "#FFE585",
                    400: "#FFDC5C",
                    500: "#FFD333",
                    600: "#FFC903", // base secondary
                    700: "#E6B500",
                    800: "#BF9600",
                    900: "#997800",
                },
                // secondary: {
                //     50: "#f5f3ff",
                //     100: "#ede9fe",
                //     200: "#ddd6fe",
                //     300: "#c4b5fd",
                //     400: "#a78bfa",
                //     500: "#8b5cf6",
                //     600: "#7c3aed",
                //     700: "#6d28d9",
                //     800: "#805dca", // base secondary - warna yang diminta
                //     900: "#581c87",
                //     DEFAULT: "#805dca", // Diubah sesuai permintaan
                //     light: "#f5f3ff",
                //     "dark-light": "rgba(128, 93, 202, 0.15)",
                // },
                background: {
                    white: "#ffffff",
                    wheat: "#fefdfb",
                    light: "#f8fafc",
                    subtle: "#f1f5f9",
                },
                success: {
                    DEFAULT: "#10b981",
                    light: "#d1fae5",
                    "dark-light": "rgba(16, 185, 129, 0.15)",
                },
                danger: {
                    DEFAULT: "#ef4444",
                    light: "#fee2e2",
                    "dark-light": "rgba(239, 68, 68, 0.15)",
                },
                warning: {
                    DEFAULT: "#f59e0b",
                    light: "#fef3c7",
                    "dark-light": "rgba(245, 158, 11, 0.15)",
                },
                info: {
                    DEFAULT: "#3b82f6",
                    light: "#dbeafe",
                    "dark-light": "rgba(59, 130, 246, 0.15)",
                },
                dark: {
                    DEFAULT: "#374151",
                    light: "#f9fafb",
                    "dark-light": "rgba(55, 65, 81, 0.15)",
                },
                black: {
                    DEFAULT: "#111827",
                    light: "#f3f4f6",
                    "dark-light": "rgba(17, 24, 39, 0.15)",
                },
                white: {
                    DEFAULT: "#ffffff",
                    light: "#f8fafc",
                    dark: "#6b7280",
                },
            },
            fontFamily: {
                nunito: ["Nunito", "sans-serif"],
            },
            spacing: {
                4.5: "18px",
            },
            boxShadow: {
                "3xl": "0 2px 2px rgb(224 230 237 / 46%), 1px 6px 7px rgb(224 230 237 / 46%)",
            },
            typography: {
                DEFAULT: {
                    css: {
                        h1: { fontSize: "40px" },
                        h2: { fontSize: "32px" },
                        h3: { fontSize: "28px" },
                        h4: { fontSize: "24px" },
                        h5: { fontSize: "20px" },
                        h6: { fontSize: "16px" },
                    },
                },
            },
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
