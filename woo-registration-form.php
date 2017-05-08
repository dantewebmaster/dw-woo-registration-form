<?php
/**
 * Plugin Name: DW Woo Registration Form
 * Plugin URI: https://dantewebmaster.com
 * Description: Cria um shortcode para poder inserir um formulário de cadastro do WooCommerce mais completo.
 * Version: 1.0
 * Author: Dante Webmaster
 * Author URI: https://dantewebmaster.com/
 */
 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/*
 * Create the extra fields.
 */
function dw_register_extra_fields() {
    // Condition to prevent broke the default checkout form
    if ( ! is_checkout() ) {
        // Add all checkout billing fields
        global $woocommerce;
        $checkout = $woocommerce->checkout();

        foreach ($checkout->checkout_fields['billing'] as $key => $field) :
            woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
        endforeach;
    }
}
add_action( 'woocommerce_register_form', 'dw_register_extra_fields' );

/*
 * Filter the fields.
 */
function dw_filter_extra_fields( $fields ) {
    // remove email
    unset( $fields['billing_email'] );
    
    // Make some fields required
    $fields['billing_company']['required'] = true;
    $fields['billing_neighborhood']['required'] = true;
    $fields['billing_cnpj']['required'] = true;
    
    // Change and add placeholder to fields
    $fields['billing_first_name']['placeholder'] = 'Primeiro nome';
    $fields['billing_last_name']['placeholder'] = 'Seu sobrenome';
    $fields['billing_company']['placeholder'] = 'Nome da empresa';
    $fields['billing_postcode']['placeholder'] = 'Digite seu CEP';
    $fields['billing_cnpj']['placeholder'] = 'Insira um CNPJ válido';
    $fields['billing_city']['placeholder'] = 'Nome da cidade';
    $fields['billing_phone']['placeholder'] = 'Telefone fixo';
    
    return $fields;
}
add_filter( 'woocommerce_billing_fields', 'dw_filter_extra_fields', 10, 1 );

/*
 * Validate the extra fields.
 */
include "includes/validate-extra-fields.php";

/*
 * Save the extra fields.
 */
include "includes/save-extra-fields.php";

/*
 * Create the form shortcode.
 */
function dw_woo_registration_form_shortcode() {
    // Include form login HTML
    include "includes/woo-registration-form-html.php";
}
add_shortcode( 'woo-registration-form', 'dw_woo_registration_form_shortcode' );
