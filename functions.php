<?php
// Cargar hojas de estilo del tema padre
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_styles' );
function hello_elementor_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

// Mostrar "Gratis", "Free", o "Grátis" según el idioma
add_filter( 'woocommerce_get_price_html', 'wp_price_free_zero_empty', 100, 2 );
add_filter( 'woocommerce_variable_price_html', 'wp_price_free_zero_empty', 100, 2 );
function wp_price_free_zero_empty( $price, $product ) {
    if ( '' === $product->get_price() || 0 == $product->get_price() ) {

        // Detectar el idioma actual del sitio
        $locale = get_locale(); // ejemplo: en_US, es_ES, pt_BR

        switch ( substr($locale, 0, 2) ) {
            case 'es':
                $price = 'GRATIS';
                break;
            case 'pt':
                $price = 'GRÁTIS';
                break;
            case 'en':
            default:
                $price = 'FREE';
                break;
        }
    }
    return $price;
}