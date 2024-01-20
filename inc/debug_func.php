<?php

// Helpers Functions Shppb
function printr($var, $title = '') {
    static $int=0;

    if ($title !== '') {
        echo '<h3 class="notranslate">', $title, '</h3>';
    }

    echo '<pre class="notranslate" style="background-color: wheat"><b style="display:inline-block;background:red;color:white;padding:5px 10px;font-size:20px;">'.$int.'</b> ';
    print_r($var);
    echo '</pre>';

    $int++;
}
function br() { echo '<br>'; }

function test() { ?>
    <div style="font-size:32px;color:#e529b8;" class="shppb_test">TEST</div>
<?php }



