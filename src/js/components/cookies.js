import {GLOBAL_VARS} from '../utils/constants.js';
import {removeClassStartsWith, onWindowResize} from "../utils/index.js";

const cookies = () => {

    /**
     * Добавити до блоку з Куками елемент для додавання фону на весь екран
     */
    const cookiesFunc = () => {

        const timeStart = new Date().getTime()
        const timeDuring = 5000

        const idInterval = setInterval(() => {

            const cookiesBanner = document.querySelector('.cmplz-cookiebanner.banner-1')

            // скинути інтервал якщо знайдено потрібний елемент
            if (cookiesBanner) {
                clearInterval(idInterval)

                const parentCookieBanner = cookiesBanner.parentElement
                const elem = document.createElement('div')
                elem.classList.add('shppb_cookie_bg')
                parentCookieBanner.append(elem)
            }

            // скинути інтервал якщо час закінчився
            const timeEnd = new Date().getTime()
            if (timeStart - timeEnd > timeDuring) {
                clearInterval(idInterval)
            }

        }, 300)
    };

    cookiesFunc();

    const functionsResize = () => {

    }

    onWindowResize(functionsResize);
};

export default cookies;
