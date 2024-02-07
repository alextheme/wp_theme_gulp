import {getCookie, setCookie} from "../utils/functions.js";

/**
 * 1) notranslate
 * 2) data-text_languages="textPL || textEN || textDE"
 * 3) <?php echo _themename_get_text_lang("textPL || textEN || textDE", _themename_get_lang()); ?>
 *
 * або
 * $language_texts = 'textPL || textEN || textDE'
 * _themename_create_translate_span($language_texts, false);
 *
 * Example
 <div class="footer__copyright notranslate" data-text_languages="textPL || textEN || textDE">
 <?php echo _themename_get_text_lang("textPL || textEN || textDE", _themename_get_lang()); ?>
 </div>
 */
const gLangSwitcher = () => {
    const wrapperSwitcher = '.gtranslate_wrapper';
    const dataLanguageAttr = 'data-shppb_text_translate';
    const cookieLangName = 'lang'; // встановлюємо особистий прапорець
    const gCookieLangName = 'googtrans'; // актуально більш для PHP, тут з запізненням

    // записати код поточної мови в атрибути боді та в куки
    const setText = elem => {
        const currentLang = elem.dataset.gtLang
        setCookie(cookieLangName, currentLang)
        document.body.dataset.lang = currentLang

        Array.from(document.querySelectorAll('[data-shppb_text_translate]')).forEach(elem => {

                const objectDiffLang = JSON.parse(elem.getAttribute('data-shppb_text_translate'))

                elem.innerText = objectDiffLang[currentLang]
                    ? objectDiffLang[currentLang]
                    : objectDiffLang['default']

            });
    }

    const getIndexLang = () => {
        const lang = getCookie('lang') || document.body.dataset.lang
        const langIndex = ['pl', 'en', 'de'].findIndex(lng => lng === lang)

        return langIndex < 0 ? 1 : langIndex
    }


    // Переклад при вибору мови віджетом

    // виберемо віджет перемикання мов від гугла з класом,
    // який вказуємо в налаштуваннях в адмінці
    Array.from(document.querySelectorAll(wrapperSwitcher + ' [data-gt-lang]')).forEach(elem => {

            // додати класи до віджету G-Translate щоб підтягнути псевдо елементи з кодами мов
            // які встановлюємо функцією php "_themename_get_gtranslate_custom_style"
            elem.classList.add(elem.dataset.gtLang);

            // ініт
            if (elem.classList.contains('gt-current')) {
                setText(elem);
            }

            // зміна мови зміна тексту
            elem.addEventListener('click', event => {
                setText(event.target)
                translateTextUseDataText()
                translateTextUseClass()
                customTranslate()
            });

        })

    translateTextUseClass()

    function translateTextUseDataText() {
        const langIndex = getIndexLang()

        Array.from(document.querySelectorAll('[data-text_languages]')).forEach(el => {
            const currText = el.innerText

            const arrayTexts = el.dataset.text_languages?.split('||').map(el => el.trim())

            let textTranslate = ''

            if (arrayTexts && arrayTexts.length) {

                textTranslate = arrayTexts[langIndex];

                if (!textTranslate) {
                    textTranslate = arrayTexts[0]
                }
            }

            el.innerText = textTranslate || currText
        })
    }

    async function translateTextUseClass() {
        const langIndex = getIndexLang()

        /**
         * woocommerce attribute filter
         */
        // title
        const headerTitle = document.querySelector('.wc-blocks-filter-wrapper h3.wp-block-heading')
        if (headerTitle) {
            const headerTitles = ['Projektant plakatu', 'Poster Designer', 'Plakatdesigner']
            headerTitle.innerText = headerTitles[langIndex]
        }

        // button show more label
        setIntervalCallback('.wp-block-woocommerce-attribute-filter .show-more button', element => {
            const text = element.innerText

            const numbers = text.match(/\d+/g);
            const num = numbers ? numbers[0] + ' ' : ''

            const labels = [`wyświetl ${num}więcej`, `show ${num}more`, `${num}mehr anzeigen`]
            element.innerText = labels[langIndex]
        })

        // button show less label
        const buttonShowLess = document.querySelector('.wp-block-woocommerce-attribute-filter .show-less button')
        if (buttonShowLess) {
            const buttonShowMoreLabel = [`pokaż mniej`, `show less`, `zeige weniger`]
            buttonShowLess.innerText = buttonShowMoreLabel[langIndex]
        }
    }

    function runMutationObserver() {
        // Функція, яка буде викликана при зміні у DOM
        function handleMutation(mutationsList, observer) {
            for (const mutation of mutationsList) {
                if (mutation.type === 'childList') {
                    // Перевіряємо додані елементи
                    mutation.addedNodes.forEach(node => {
                        const langIndex = getIndexLang()

                        // Перевіряємо, чи має елемент потрібний клас
                        if (node.classList && node.classList.contains('show-less')) {
                            console.log('Елемент з класом "show-less" з\'явився в DOM.');
                            const buttonShowLess = document.querySelector('.wp-block-woocommerce-attribute-filter .show-less button')
                            if (buttonShowLess) {
                                const buttonShowMoreLabel = [`pokaż mniej`, `show less`, `zeige weniger`]
                                buttonShowLess.innerText = buttonShowMoreLabel[langIndex]
                            }
                        }
                    });
                }
            }
        }

        // Створюємо новий інстанс MutationObserver
        const observer = new MutationObserver(handleMutation);

        // Вказуємо цільовий вузол (можна вказати document.body або будь-який інший вузол)
        const targetNode = document.body;

        // Налаштовуємо налаштування для спостереження за дочірніми елементами
        const config = { childList: true, subtree: true };

        // Запускаємо спостереження
        observer.observe(targetNode, config);

        // Тепер спостереження відслідковуватиме будь-які зміни в DOM, включаючи появу елементів з класом 'show-less'.
    }

    runMutationObserver()

    async function getElementHtml(selector) {
        const maxQuery = 10000
        const startTime = Date.now()

        return new Promise(resolve => {
            const intervalId = setInterval(() => {
                const element = document.querySelector(selector)

                if (element) {
                    clearInterval(intervalId)
                    resolve(element)
                }

                if (Date.now() - startTime > maxQuery) {
                    console.log('Request Timed Out: ' + maxQuery + ' ms')
                    clearInterval(intervalId)
                    resolve(null)
                }

            }, 500)
        })
    }

    function setIntervalCallback(selector, func) {
        const maxQuery = 10000
        const startTime = Date.now()

        const intervalId = setInterval(() => {
            const element = document.querySelector(selector)

            if (element) {
                clearInterval(intervalId)
                func(element)
            }

            if (Date.now() - startTime > maxQuery) {
                console.log('Request Timed Out: ' + maxQuery + ' ms')
                clearInterval(intervalId)
            }

        }, 500)
    }

    function customTranslate() {
        const indexLang = getIndexLang()
        const paymentTitle = 'Płatność kartą || Payment by card || Zahlung per Karte'
        const paymentDescr = 'Płatność kartą (po potwierdzeniu dostępności towaru otrzymują Państwo link do opłaty zamówienia na e-mail) || Payment by card (after confirming the availability of the goods you will receive a link to pay for your order by e-mail) || Zahlung per Karte (nach Bestätigung der Verfügbarkeit der Ware erhalten Sie per E-Mail einen Link zur Bezahlung Ihrer Bestellung)'

        const $translateText = document.querySelectorAll('.shppb_custom_translate')

        $translateText.forEach($elem => {
            if ($elem.classList.contains('payment_by_card_descr')) {
                $elem.innerText = paymentDescr.split('||')[indexLang]
            }
            if ($elem.classList.contains('payment_by_card')) {
                $elem.innerText = paymentTitle.split('||')[indexLang]
            }
        })
    }

    jQuery(document.body).on('updated_checkout', function (e) {
        customTranslate()
    })



    // На додаток до повного списку посилань, ви можете піти інтерактивним шляхом і вставити наведене нижче у свою консоль JS і виконати дії в магазині, на який ви хочете націлити, спостерігати за консоллю, щоб побачити, як реєструються події, що виникли.
    jQuery(document.body).on(
        "init_checkout payment_method_selected update_checkout updated_checkout checkout_error applied_coupon_in_checkout removed_coupon_in_checkout adding_to_cart added_to_cart removed_from_cart wc_cart_button_updated cart_page_refreshed cart_totals_refreshed wc_fragments_loaded init_add_payment_method wc_cart_emptied updated_wc_div updated_cart_totals country_to_state_changed updated_shipping_method applied_coupon removed_coupon",
        function (e) {
            console.log('woo events', e.type)
        }
    )
}



export default gLangSwitcher