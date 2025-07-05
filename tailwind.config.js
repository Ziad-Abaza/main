/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#2563eb", // Blue-600
                accent: "#6366f1", // Indigo-500
                text: {
                    DEFAULT: "#222",
                    light: "#fff",
                },
                background: {
                    DEFAULT: "#f8fafc",
                    dark: "#18181b",
                },
                // Light Mode Palette
                light: {
                    primary: "#2563EB", // Blue-600
                    secondary: "#7C3AED", // Violet-600
                    accent: "#059669", // Emerald-600
                    surface: "#FFFFFF", // Pure white
                    "surface-soft": "#F8FAFC", // Slate-50
                    "surface-card": "#F1F5F9", // Slate-100
                    text: "#0F172A", // Slate-900
                    "text-secondary": "#334155", // Slate-700
                    "text-muted": "#64748B", // Slate-500
                    border: "#E2E8F0", // Slate-200
                    "border-soft": "#F1F5F9", // Slate-100
                    shadow: "rgba(0, 0, 0, 0.1)",
                },
                // Dark Mode Palette (Enhanced)
                dark: {
                    primary: "#3B82F6", // Blue-500
                    secondary: "#8B5CF6", // Violet-500
                    accent: "#10B981", // Emerald-500
                    surface: "#0F172A", // Slate-900
                    "surface-soft": "#1E293B", // Slate-800
                    "surface-card": "#334155", // Slate-700
                    text: "#F8FAFC", // Slate-50
                    "text-secondary": "#CBD5E1", // Slate-300
                    "text-muted": "#94A3B8", // Slate-400
                    border: "#334155", // Slate-700
                    "border-soft": "#475569", // Slate-600
                    shadow: "rgba(0, 0, 0, 0.3)",
                },
            },
            backgroundImage: {
                // Light mode gradients
                "gradient-light-main":
                    "linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 25%, #E0F2FE 50%, #F0F9FF 100%)",
                "gradient-light-hero":
                    "linear-gradient(135deg, #FFFFFF 0%, #F8FAFC 50%, #EFF6FF 100%)",
                "glass-light":
                    "linear-gradient(135deg, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.15) 100%)",

                // Dark mode gradients (current)
                "gradient-dark-main":
                    "linear-gradient(135deg, #0F172A 0%, #1E1B4B 25%, #312E81 50%, #1E293B 100%)",
                "gradient-dark-hero":
                    "linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #334155 100%)",
                "glass-dark":
                    "linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0.02) 100%)",
            },
            boxShadow: {
                "glass-light":
                    "0 8px 32px rgba(0, 0, 0, 0.08), 0 4px 16px rgba(0, 0, 0, 0.04), inset 0 1px 0 rgba(255, 255, 255, 0.6)",
                "glass-dark":
                    "0 8px 32px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.1)",
                "card-light":
                    "0 4px 24px rgba(0, 0, 0, 0.06), 0 2px 12px rgba(0, 0, 0, 0.04)",
                "card-dark": "0 8px 32px rgba(0, 0, 0, 0.3)",
                soft: "0 4px 24px 0 rgba(30, 41, 59, 0.06)",
                card: "0 2px 8px 0 rgba(30, 41, 59, 0.08)",
            },
        },
    },
    plugins: [],
};
