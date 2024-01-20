import {setCookie,getCookie} from "../utils/functions.js";

/**
 * 1) php _themename_get_text_lang();
 * в PHP файлі встановити дані в JSON форматі в атрибут 'data-shppb_text_translate="<JSONFORMAT>"',
 * там, де потрібно отримати переклади
 * 2) Додати до елемента класс "notranslate", щоб гугл ігнорував
 */
const gLangSwitcher = () => {
    const wrapperSwitcher = '.gtranslate_wrapper';
    const dataLanguageAttr = 'data-shppb_text_translate';
    const cookieLangName = 'lang'; // встановлюємо особистий прапорець
    const gCookieLangName = 'googtrans'; // актуально більш для PHP, тут з запізненням

    const setText = elem => {

        // записати код поточної мови в атрибути боді та в куки
        const currentLang = elem.dataset.gtLang;
        setCookie(cookieLangName, currentLang);
        document.body.dataset.lang = currentLang;

        Array.from(document.querySelectorAll(`[${dataLanguageAttr}]`))
            .forEach(elem => {

                const objectDiffLang = JSON.parse(elem.getAttribute(dataLanguageAttr));

                elem.innerText = objectDiffLang[currentLang]
                    ? objectDiffLang[currentLang]
                    : objectDiffLang['default'];

            });
    }

    // виберемо віджет перемикання мов від гугла з класом,
    // який вказуємо в налаштуваннях в адмінці
    Array.from(document.querySelectorAll(wrapperSwitcher + ' [data-gt-lang]'))
        .forEach(elem => {

            // додати класи до віджету G-Translate щоб підтягнути псевдо елементи з кодами мов
            // які встановлюємо функцією php "_themename_get_gtranslate_custom_style"
            elem.classList.add(elem.dataset.gtLang);

            // ініт
            if (elem.classList.contains('gt-current')) {
                setText(elem);
            }

            // зміна мови зміна тексту
            elem.addEventListener('click', event => {
                setText(event.target);

                console.log('g-translate switch')
                switch_languages_text();

            });

        });
};

function switch_languages_text() {
    const lang = getCookie('lang') || document.body.dataset.lang;
    const langIndex = ['pl', 'en', 'de'].findIndex(lng => lng === lang);

    Array.from(document.querySelectorAll('[data-text_languages]')).forEach(el => {
        const currText = el.innerText;

        const arrayTexts = el.dataset.text_languages?.split('||').map(el => el.trim());

        let textTranslate = '';

        if (arrayTexts && arrayTexts.length) {

            textTranslate = arrayTexts[langIndex];

            if (!textTranslate) {
                textTranslate = arrayTexts[0];
            }
        }

        el.innerText = textTranslate || currText;


    })

}

export default gLangSwitcher;