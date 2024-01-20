import {GLOBAL_VARS} from './utils/constants.js';
import {jqDocumentReady} from './utils/index.js';
import header from './components/header.js';
import wcArchive from './components/wcArchive.js';
import wcQuantityButton from './components/wcQuantityButton.js';
import gLangSwitcher from "./components/gLangSwitcher.js";
import wcCart from "./components/wcCart.js";

jqDocumentReady(() => {
    header();
    gLangSwitcher();
    wcArchive();
    wcQuantityButton();
    wcCart();
})
