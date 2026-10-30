(function() {
    const THEME_KEY = 'gsmui-theme';
    
    function getSystemTheme() {
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }
    
    function getStoredTheme() {
        return localStorage.getItem(THEME_KEY) || 'system';
    }
    
    function applyTheme(theme) {
        const effective = theme === 'system' ? getSystemTheme() : theme;
        document.documentElement.classList.toggle('dark', effective === 'dark');
    }
    
    function toggleTheme() {
        const current = getStoredTheme();
        const next = current === 'light' ? 'dark' : current === 'dark' ? 'system' : 'light';
        localStorage.setItem(THEME_KEY, next);
        applyTheme(next);
    }
    
    applyTheme(getStoredTheme());
    document.querySelectorAll('#theme-toggle').forEach(btn => btn.addEventListener('click', toggleTheme));
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if (getStoredTheme() === 'system') applyTheme('system');
    });
})();
