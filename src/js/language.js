const supportedLanguages = ['es', 'en'];

const setLanguage = (language) => {
    if (!supportedLanguages.includes(language)) {
        return;
    }

    document.cookie = `language=${language}; path=/; max-age=31536000; SameSite=Lax`;
    document.documentElement.lang = language;
    window.location.reload();
};

document.querySelectorAll('[data-language]').forEach((button) => {
    button.addEventListener('click', () => {
        setLanguage(button.dataset.language);
    });
});
