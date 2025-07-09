import { ref, computed, watch } from "vue";

const systemPreference = ref(
    window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"
);
// Set theme to null initially, will be set below
const theme = ref(null);

export const useTheme = () => {
    const isDark = computed(() => {
        if (theme.value === "system") {
            return systemPreference.value === "dark";
        }
        return theme.value === "dark";
    });

    const toggleTheme = () => {
        // If theme is system, toggle to the opposite of system preference
        if (theme.value === "system") {
            theme.value = systemPreference.value === "dark" ? "light" : "dark";
        } else {
            theme.value = theme.value === "light" ? "dark" : "light";
        }
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
    } else {
        // Use system preference as default
        theme.value = systemPreference.value;
    }

    // Apply theme to HTML
    watch(
        isDark,
        (newValue) => {
            document.documentElement.classList.toggle("dark", newValue);
        }, { immediate: true }
    );

    return {
        theme,
        isDark,
        toggleTheme,
        setTheme,
    };
};
