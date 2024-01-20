import {GLOBAL_VARS} from '../utils/constants.js';
import {removeClassStartsWith, onWindowResize} from "../utils/index.js";

const wcCart = () => {
    const openMiniCart = () => {
        const miniCart = document.querySelector('.popup_mini_cart_wrapper');
        if (!miniCart) return;

        document.querySelectorAll('.miniCartTrigger').forEach(buttonOpenMiniCart => {
            buttonOpenMiniCart.addEventListener('click', function (event) {
                event.preventDefault();
                document.body.classList.add('open_mini_cart')
            });

            document.addEventListener('click', event => {
                const el = event.target;

                if (document.body.classList.contains('open_mini_cart')) {

                    if (
                        !(el.closest('.widget_shopping_cart_content') || el.closest('.miniCartTrigger'))
                    ) {
                        document.body.classList.remove('open_mini_cart')
                    }
                }
            });
        });
    };

    openMiniCart();

    const functionsResize = () => {

    }

    onWindowResize(functionsResize);
};

export default wcCart;
