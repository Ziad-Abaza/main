import { ref, computed, watch } from "vue";

const theme = ref("system"); // 'light', 'dark', 'system'
const systemPreference = ref(
    window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"
);

export const useTheme = () => {
    const isDark = computed(() => {
        if (theme.value === "system") {
            return systemPreference.value === "dark";
        }
        return theme.value === "dark";
    });

    const toggleTheme = () => {
        theme.value = theme.value === "light" ? "dark" : "light";
        localStorage.setItem("theme", theme.value);
    };

    const setTheme = (newTheme) => {
        theme.value = newTheme;
        localStorage.setItem("theme", newTheme);
    };

    // Monitor system changes
    const mediaQuery = window.matchMedia("(prefers-color-scheme: dark)");
    mediaQuery.addEventListener("change", (e) => {
        systemPreference.value = e.matches ? "dark" : "light";
    });

    // Load saved theme
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme && ["light", "dark", "system"].includes(savedTheme)) {
        theme.value = savedTheme;
    }

    // Apply theme to HTML
    watch(
        isDark,
        (newValue) => {
            document.documentElement.classList.toggle("dark", newValue);
        },
        { immediate: true }
    );

    return {
        theme,
        isDark,
        toggleTheme,
        setTheme,
    };
};
