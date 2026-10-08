const translations = window.devconTranslations ?? {};

export const t = (text) => translations[text] ?? text;
