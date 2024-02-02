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
     * Example
        <div class="footer__copyright notranslate" data-text_languages="textPL || textEN || textDE">
            <?php echo _themename_get_text_lang("textPL || textEN || textDE", _themename_get_lang()); ?>
        </div>
     *
     * @param $text string Багоатомовний текст з роздільником ||
     * @param $lang string Мова для отримання тексту на цій мові
     * @return string|String[] Масив з перекладами, ключ - символ мови
     */
    function _themename_get_text_lang($language_text = '', $lang = 'pl', $product_id = 0) {
        global $post, $wpdb;

        $text = $language_text;

        if ($text === '' && $product_id === 0) {
            if (is_null($post)) {
                $text = '404';
            } else {
                $text = $post->post_title;
            }
        }

        if ($text === '' && $product_id !== 0) {
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

        return key_exists($lang, $translate_text) ? $translate_text[$lang] : $translate_text['default'];
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

//if ( ! function_exists('_themename_sort_by_term_name') ) {
//    function _themename_sort_by_term_name($a, $b) {
//        return strcmp($a['term']->name, $b['term']->name);
//    }
//}

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

if ( ! function_exists('_themename_create_translate_span') ) {
    function _themename_create_translate_span($string, $echo = true) {

        // ? is_array( $type ) && in_array( $this->get_type(), $type, true ) )

        $string_result = '';
        $allowed_html = array(
            'span' => array(
                'class' => array(),
                'data-text_languages' => array()
            ),
        );

        if (str_contains($string, '||')) {

            $string_clear = strip_tags($string);

            $string_result .= '<span class="notranslate" data-text_languages="';
            $string_result .= esc_attr($string_clear);
            $string_result .= '">';
            $string_result .= esc_html(_themename_get_text_lang($string_clear, _themename_get_lang()));
            $string_result .= '</span>';

        } else {

            $string_result = $string;

        }

        if ($echo) {
            echo wp_kses($string_result, $allowed_html);
        } else {
            return wp_kses($string_result, $allowed_html);
        }
    }
}
