<?php

global $args;

printr($args);

$name = ''; // $args['name'];
$mod = ''; //$args['mod'];

?>

<svg class="icon icon_<?= $name ?> <?= $mod; ?>">
    <use xlink:href="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/sprite/sprite.svg#' . $name ); ?>"></use>
</svg>