<?php

add_filter('aws_searchbox_markup', function ($markup, $params) {

    $search_string = '<svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>';
    $replace_string = '<svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26"><path d="M25.7,24.3L19.4,18c1.6-1.9,2.6-4.4,2.6-7c0-6.1-4.9-11-11-11S0,4.9,0,11s4.9,11,11,11c2.7,0,5.1-1,7-2.6l6.3,6.3 c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3C26.1,25.3,26.1,24.7,25.7,24.3z M2,11c0-5,4-9,9-9c5,0,9,4,9,9c0,5-4,9-9,9 C6,20,2,16,2,11z"></path></svg>';

    if ( !str_contains($markup, $replace_string) ) {
        $new_markup = str_replace($search_string, $replace_string, $markup);
    }

    return $new_markup;
}, 10, 2);

