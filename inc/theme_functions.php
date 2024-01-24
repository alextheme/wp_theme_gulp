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









/**
 * Method to delete Woo Product
 *
 * @param int $id the product ID.
 * @param bool $force true to permanently delete product, false to move to trash.
 * @return \WP_Error|boolean
 */
function _themename_deleteProduct($id, $force = FALSE)
{
    $product = wc_get_product($id);

    if(empty($product))
        return new WP_Error(999, sprintf(__('No %s is associated with #%d', 'woocommerce'), 'product', $id));

    // If we're forcing, then delete permanently.
    if ($force)
    {
        if ($product->is_type('variable'))
        {
            foreach ($product->get_children() as $child_id)
            {
                $child = wc_get_product($child_id);
                $child->delete(true);
            }
        }
        elseif ($product->is_type('grouped'))
        {
            foreach ($product->get_children() as $child_id)
            {
                $child = wc_get_product($child_id);
                $child->set_parent_id(0);
                $child->save();
            }
        }

        $product->delete(true);
        $result = $product->get_id() > 0 ? false : true;
    }
    else
    {
        $product->delete();
        $result = 'trash' === $product->get_status();
    }

    if (!$result)
    {
        return new WP_Error(999, sprintf(__('This %s cannot be deleted', 'woocommerce'), 'product'));
    }

    // Delete parent product transients.
    if ($parent_id = wp_get_post_parent_id($id))
    {
        wc_delete_product_transients($parent_id);
    }
    return true;
}

function _themename_delete_all_woocommerce_products() {
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
    );

    $products = wc_get_products($args);

    echo '<pre style="margin:80px 0 0 180px;"><b style="display:inline-block;background:red;color:white;padding:5px 10px;font-size:20px;">1</b> ';

    print_r($products);

    foreach ($products as $product) {
        // Access product data
        $product_id    = $product->get_id();
        $product_title = $product->get_name();
        $product_price = $product->get_price();

        // Output or process product data as needed
        echo "Product ID: $product_id, Title: $product_title, Price: $product_price<br>";



    }

    echo '</pre>';

    // Loop through product IDs and delete each product
//    foreach ($product_ids as $product_id) {
//        //wp_delete_post($product_id, true); // Set the second parameter to true to force delete
//    }

    // Optional: Clear product transients to ensure proper refreshing
//    wc_delete_product_transients();

    // Optional: Clear WooCommerce cache
//    wc_flush_product_cache();

    // Output a success message (you can modify or remove this)
    echo 'All WooCommerce products deleted successfully!';
}

//_themename_delete_all_woocommerce_products();