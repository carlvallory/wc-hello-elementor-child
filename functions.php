<?php
// Cargar estilos del padre
add_action( 'wp_enqueue_scripts', 'hello_elementor_child_enqueue_styles' );
function hello_elementor_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

// Agregar opción al personalizador
add_action( 'customize_register', 'customize_free_price_toggle' );
function customize_free_price_toggle( $wp_customize ) {
    $wp_customize->add_section( 'free_price_section', array(
        'title'    => __( 'Precio gratuito', 'hello-elementor-child' ),
        'priority' => 30,
    ) );

    $wp_customize->add_setting( 'enable_free_price', array(
        'default'   => true,
        'transport' => 'refresh',
    ) );

    $wp_customize->add_control( 'enable_free_price', array(
        'label'   => __( 'Mostrar “Gratis” cuando el precio es 0', 'hello-elementor-child' ),
        'section' => 'free_price_section',
        'type'    => 'checkbox',
    ) );
}

// Mostrar texto multilingüe para precio 0
add_filter( 'woocommerce_get_price_html', 'wp_price_free_zero_empty', 100, 2 );
add_filter( 'woocommerce_variable_price_html', 'wp_price_free_zero_empty', 100, 2 );
function wp_price_free_zero_empty( $price, $product ) {
    if ( ! get_theme_mod('enable_free_price', true) ) {
        return $price;
    }

    if ( '' === $product->get_price() || 0 == $product->get_price() ) {
        $locale = get_locale();

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