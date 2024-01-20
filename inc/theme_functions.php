<?php

if ( ! function_exists('_themename_get_gtranslate_custom_style')) {
    function _themename_get_gtranslate_custom_style() {
        $languages = get_option('GTranslate')['fincl_langs'];

        $styles = '<style>';

        foreach ($languages as $lang) {
            $styles .= ".gtranslate_wrapper a.".$lang.":before{content:'".$lang."'}";
        }

        return $styles ."</style>";
    }
}

if ( ! function_exists('_themename_get_text_lang')) {

    /**
     * 1) Додати до перемикача псевдо елемент абсолютом для заміни виводу лейби мови на сайті
     * 2) Встановити для кожної мови контент через функцію "_themename_get_gtranslate_custom_style"
     * 3) в PHP файлі встановити дані в JSON форматі в атрибут 'data-shppb_text_translate="<JSONFORMAT>"',
     * data-shppb_text_translate="<?php echo esc_attr(wp_json_encode(_themename_get_text_lang($product->get_title(), '', true))); ?>"
     * там, де потрібно отримати переклади
     * 4) Додати до елемента класс "notranslate", щоб гугл ігнорував
     * мова відслідковується по атрибутам перемикача "data-gt-lang"
     *
     * @param $text string Багоатомовний текст з роздільником ||
     * @param $lang string Мова для отримання тексту на цій мові
     * @param $get_array boolean Правда, щоб отримати дані в масиві, для передачі в JSON
     * @return string|String[] Масив з перекладами, ключ - символ мови
     */
    function _themename_get_text_lang($language_text = '', $lang = 'pl', $get_array = false, $product_id = 0) {
        $text = $language_text;

        if ($text === '' && $product_id === 0) {
            global $post;

            if (is_null($post)) {
                $text = '404';
            } else {
                $text = $post->post_title;
            }
        }

        if ($text === '' && $product_id !== 0) {
            global $wpdb;
            $wpdb_title = $wpdb->get_results("SELECT post_title FROM {$wpdb->prefix}posts WHERE ID = " . $product_id . " AND post_type = 'product'");
            if (count($wpdb_title) > 0) {
                $text = $wpdb_title[0]->post_title;
            } else {
                return '';
            }
        }

        $array_text = array_map('trim', explode('||', $text));

        $translate_text = array(
            'pl' => $array_text[0],
            'en' => $array_text[0],
            'de' => $array_text[0],
            'default' => $array_text[0],
        );

        if (key_exists('1', $array_text)) {
            $translate_text['en'] = $array_text[1];
            $translate_text['de'] = $array_text[1];
        }

        if (key_exists('2', $array_text)) {
            $translate_text['de'] = $array_text[2];
        }

        if ($get_array) {
            return $translate_text;
        } else {
            return key_exists($lang, $translate_text) ? $translate_text[$lang] : $translate_text['default'];
        }
    }
}

if ( ! function_exists('_themename_get_lang') ) {
    function _themename_get_lang() {

        if (key_exists('googtrans', $_COOKIE)) {

            $array_langs = explode('/', $_COOKIE['googtrans']);
            $lang = array_pop($array_langs);

        } else if (key_exists('lang', $_COOKIE)) {

            $lang = $_COOKIE['lang'];

        } else {

            // set default language
            $_COOKIE['lang'] = 'de';
            $lang = 'de';

        }

        return $lang;
    }
}

if ( ! function_exists('_themename_sort_by_term_name') ) {
    function _themename_sort_by_term_name($a, $b) {
        return strcmp($a['term']->name, $b['term']->name);
    }
}

if ( ! function_exists('_themename_get_title_designer_single_page') ) {
    function _themename_get_title_designer_single_page() {
        $term_designer = null;

        if (isset($_GET['single-page']) && $_GET['single-page'] === '1') {

            if (isset($_GET['filter_poster-designer'])) {
                $term_designer = get_term_by('slug', $_GET['filter_poster-designer'], 'pa_poster-designer');
            }

        }
        if ($term_designer) {
            return $term_designer->name;
        } else {
            return '';
        }

    }
}

if ( ! function_exists('_themename_kses') ) {
    function _themename_kses($text, $args = null) {
       return '';
    }
}


/**
 * Patch
 */
if ( ! function_exists('_themename_replace_file_wc_blocks_checkout_js' )) {
    function _themename_replace_file_wc_blocks_checkout_js() {
//        $files = array(
//          array(
//              'path' => WP_PLUGIN_DIR . '/woocommerce/packages/woocommerce-blocks/build/blocks-checkout.js',
//              'replace' => array(
//                  ['wc-block-components-checkbox__label', 'wc-block-components-checkbox__label shppb notranslate']
//              ),
//          ),
//          array(
//              'file_path' => WP_PLUGIN_DIR . '/advanced-woo-search/includes/class-aws-markup.php',
//              'replace' => array(
//                  [
//                      'viewBox="0 0 24 24" width="24px"',
//                      'viewBox="0 0 26 26"'
//                  ],
//                  [
//                      '<path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>',
//                      '<path d="M25.7,24.3L19.4,18c1.6-1.9,2.6-4.4,2.6-7c0-6.1-4.9-11-11-11S0,4.9,0,11s4.9,11,11,11c2.7,0,5.1-1,7-2.6l6.3,6.3 c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3C26.1,25.3,26.1,24.7,25.7,24.3z M2,11c0-5,4-9,9-9c5,0,9,4,9,9c0,5-4,9-9,9 C6,20,2,16,2,11z"></path>'
//                  ],
//              ),
//          ),
//        );
//
//
//        foreach ($files as $file) {
//            $file_content = file_get_contents($file['path']);
//
//            foreach ($file['replace'] as $replace) {
//
//                if ( !str_contains($file_content, $replace[1]) ) {
//                    $new_content = str_replace($replace[0], $replace[1], $file_content);
//                    file_put_contents($file['path'], $new_content);
//                }
//            }
//        }

        $file_path = WP_PLUGIN_DIR . '/woocommerce/packages/woocommerce-blocks/build/blocks-checkout.js';
//        $file_path = WP_PLUGIN_DIR . '/advanced-woo-search/includes/class-aws-markup.php';

        $search_string = 'wc-block-components-checkbox__label';
        $replace_string = $search_string . ' shppb notranslate';

        $file_content = file_get_contents($file_path);

        if ( !str_contains($file_content, $replace_string) ) {
            $new_content = str_replace($search_string, $replace_string, $file_content);
            file_put_contents($file_path, $new_content);
        }

        add_option('patch__replace_file_wc_blocks_checkout_js_executed', '1');
    }

    if (get_option('patch__replace_file_wc_blocks_checkout_js_executed') !== '1') {
        _themename_replace_file_wc_blocks_checkout_js();
    }
}
