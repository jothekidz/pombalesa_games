document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('theme-toggle');
    
    const currentTheme = localStorage.getItem('ecotrade_theme') || 'light';
    document.body.classList.toggle('dark-theme', currentTheme === 'dark');
    themeToggle.querySelector('.icon').textContent = currentTheme === 'dark' ? '☀️' : '🌙';

    themeToggle.addEventListener('click', () => {
        const isDark = document.body.classList.toggle('dark-theme');
        const newTheme = isDark ? 'dark' : 'light';
        localStorage.setItem('ecotrade_theme', newTheme);
        themeToggle.querySelector('.icon').textContent = isDark ? '☀️' : '🌙';
    });

    const langToggle = document.getElementById('lang-toggle');
    langToggle.addEventListener('click', () => {
        alert('Funcionalidade de troca de idioma será implementada na próxima fase!');
    });
});