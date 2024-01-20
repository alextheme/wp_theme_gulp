import {GLOBAL_VARS} from '../utils/constants.js';
import {removeClassStartsWith, onWindowResize} from "../utils/index.js";

const wcQuantityButton = () => {
    const quantityButton = () => {
        const updateCartButton = document.querySelector('.shop_table.cart .actions button[name="update_cart"]');

        document.querySelectorAll('.input_group__quantity').forEach(quantity => {
            const inputQty = quantity.querySelector('input')
            const min = +inputQty.getAttribute('min');
            const max = +inputQty.getAttribute('max');
            const step = +inputQty.getAttribute('step');
            const currentValue = inputQty.value;

            quantity.querySelectorAll('button.button').forEach(button => {

                button.addEventListener('click', function (event) {
                    event.preventDefault();

                    if (event.currentTarget.classList.contains('button_minus')) {

                        if (+inputQty.value > min) {
                            inputQty.value = +inputQty.value - step;
                        } else {
                            inputQty.value = min;
                        }

                    } else {
                        inputQty.value = +inputQty.value + step;
                    }

                    if (updateCartButton && currentValue !== inputQty.value) {
                        updateCartButton.disabled = false;
                    }
                });
            })
        });
    };



    quantityButton();






    const functionsResize = () => {

    }

    onWindowResize(functionsResize);
};

export default wcQuantityButton;
