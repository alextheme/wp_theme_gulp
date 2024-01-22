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
