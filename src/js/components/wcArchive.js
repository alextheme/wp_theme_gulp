import {GLOBAL_VARS} from '../utils/constants.js';
import {onWindowResize} from "../utils/index.js";
import {removeClassStartsWith} from '../utils/functions.js';

const wcArchive = () => {
    const orderBySelectorAnimateArrow = () => {
        document.querySelectorAll('.woocommerce-ordering .orderby').forEach(select => {
            select.addEventListener('click', event => {
                event.target.parentElement.classList.add('click_on_element');
            });

            select.addEventListener('blur', event => {
                event.target.parentElement.classList.remove('click_on_element');
            });
        });
    };

    const displayGridOrRow = () => {
        const radioButtons = document.querySelectorAll('input[name="display_by"]');
        const changeClassList = value => {
            if (value === '1') {
                document.body.classList.remove('posters--list_mod');
            }
            if (value === '2') {
                document.body.classList.add('posters--list_mod');
            }
        }

        radioButtons.forEach(radio => {
            if (radio.checked) {
                changeClassList(radio.value)
            }

            radio.addEventListener('change', e => changeClassList(e.target.value));
        });
    }

    const switcherColumnWcProductGrid = () => {

        // all UL.products
        const productWrappers = document.querySelectorAll('ul.products');

        productWrappers.forEach(productWrapper => {

            removeClassStartsWith(productWrapper, 'columns-');

            const setGrid = (perRow) => {
                productWrapper.classList.add('columns-' + perRow);

                // LI.product
                Array.from(productWrapper.children).forEach((product, i) => {
                    product.classList.remove('first');
                    product.classList.remove('last');

                    if (i % perRow === 0) {
                        product.classList.add('first');
                    } else if ((i + 1) % perRow === 0) {
                        product.classList.add('last');
                    }

                });
            }

            if (document.querySelector('.single-product')) {

                if (window.innerWidth >= GLOBAL_VARS.mediaPoint1) {
                    setGrid(4);
                } else if (window.innerWidth < GLOBAL_VARS.mediaPoint0 && window.innerWidth >= GLOBAL_VARS.mediaPoint2) {
                    setGrid(3);
                } else {
                    setGrid(2);
                }
            }

            else {
                if (window.innerWidth >= GLOBAL_VARS.mediaPoint0) {
                    setGrid(3);
                } else {
                    setGrid(2);
                }

            }
        });
    }

    const changePositionFilterAttributes = () => {
        const blocks = document.querySelectorAll('.base.shop #sidebar');

        blocks.forEach(block => {
            const descktopParent = document.querySelector('.archive__main_content');
            const mobileParent = document.querySelector('.archive__designers_filter_wrapper');

            if (window.innerWidth < GLOBAL_VARS.mediaPoint1) { // 1024
                mobileParent?.appendChild(block);
            } else {
                descktopParent?.appendChild(block);
            }
        })

    }

    const setCountProductsToAttributeDesigners = () => {
        const attributeTermsCountProducts = document.querySelector('.archive__main_content')?.dataset.attribute_terms_count_products;

        let dataJSON = '';

        if (attributeTermsCountProducts) {
            try {
                dataJSON = JSON.parse(attributeTermsCountProducts);
            } catch (e) {
                console.log('Не вдалося розпарсити json рядок', e.message)
            }
        }

        if (dataJSON) {
            let wcBlockAttributeFilterList = null;
            const intervalId = setInterval(() => {
                wcBlockAttributeFilterList = document.querySelector('.wc-block-attribute-filter-list');

                if (wcBlockAttributeFilterList) {
                    clearInterval(intervalId);

                    Array.from(wcBlockAttributeFilterList.children).forEach(elem => {
                        if (!elem.classList.contains('show-more')) {
                            const label = elem.querySelector('label');
                            // label.classList.add('notranslate');
                            const termSlug = label.getAttribute('for');
                            const countProducts = dataJSON[termSlug];
                            const span = document.createElement('span');
                            span.classList.add('wc-block-components-checkbox__label');
                            span.classList.add('count_products');
                            span.innerHTML = `(${countProducts})`;
                            label.append(span);
                        }
                    })
                }
            }, 500);
        }

    }

    const posterDesignerListFilter = () => {
        document.querySelector('.wp-block-heading')?.addEventListener('click', event => {

            if (window.innerWidth < GLOBAL_VARS.mediaPoint1) {
                const wcAttrFilterList = document.querySelector('.wp-block-woocommerce-attribute-filter');
                const attrFilterList = document.querySelector('.wc-block-attribute-filter');

                const target = event.target;
                const parentTarget = target.parentElement;
                const button = target.getBoundingClientRect();
                attrFilterList.style.maxHeight = (document.documentElement.clientHeight - button.height - button.y - 70) + 'px';

                console.log( attrFilterList.style.maxHeight)

                if (parentTarget.classList.contains('open')) {
                    wcAttrFilterList.style.opacity = '0';
                    wcAttrFilterList.style.transform = 'translateY(-200%)';
                    parentTarget.classList.remove('open');
                } else {
                    wcAttrFilterList.style.opacity = '1';
                    wcAttrFilterList.style.transform = 'translateY(0)';
                    parentTarget.classList.add('open');
                }
            }

        });
    }






    orderBySelectorAnimateArrow();
    displayGridOrRow();
    switcherColumnWcProductGrid();
    changePositionFilterAttributes();
    setCountProductsToAttributeDesigners();
    posterDesignerListFilter();

    const functionsResize = () => {
        switcherColumnWcProductGrid();
        changePositionFilterAttributes();
    }

    onWindowResize(functionsResize);
};

export default wcArchive;
