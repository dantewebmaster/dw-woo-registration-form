<?php
/**
 * Save the extra registered fields.
 *
 * @param int $customer_id Current customer ID.
 */
function dw_save_extra_register_fields( $customer_id ) {
	// WooCommerce email field.
    if ( isset( $_POST['email'] ) ) {
        update_user_meta( $customer_id, 'billing_email', sanitize_email( $_POST['email'] ) );
    }

    if ( isset( $_POST['billing_first_name'] ) ) {
		// WordPress default first name field.
        update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );

		// WooCommerce billing first name.
        update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
    }
	
    if ( isset( $_POST['billing_last_name'] ) ) {
		// WordPress default last name field.
        update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );

		// WooCommerce billing last name.
        update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
    }
	
    if ( isset( $_POST['billing_phone'] ) ) {
		// WooCommerce billing phone
        update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
    }
	
    if ( isset( $_POST['billing_cellphone'] ) ) {
		// WooCommerce billing cellphone
        update_user_meta( $customer_id, 'billing_cellphone', sanitize_text_field( $_POST['billing_cellphone'] ) );
    }

    if ( isset( $_POST['billing_company'] ) ) {
		// WooCommerce billing company
        update_user_meta( $customer_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) );
    }
	
	if ( isset( $_POST['billing_cnpj'] ) ) {
		// WooCommerce cnpj
        update_user_meta( $customer_id, 'billing_cnpj', sanitize_text_field( $_POST['billing_cnpj'] ) );
    }
	
	if ( isset( $_POST['billing_postcode'] ) ) {
		// WooCommerce postcode
        update_user_meta( $customer_id, 'billing_postcode', sanitize_text_field( $_POST['billing_postcode'] ) );
        //update_user_meta( $customer_id, 'shipping_postcode', sanitize_text_field( $_POST['billing_postcode'] ) );
    }
	if ( isset( $_POST['billing_address_1'] ) ) {
		// WooCommerce address 1
        update_user_meta( $customer_id, 'billing_address_1', sanitize_text_field( $_POST['billing_address_1'] ) );
    }
	if ( isset( $_POST['billing_number'] ) ) {
		// WooCommerce addres number
        update_user_meta( $customer_id, 'billing_number', sanitize_text_field( $_POST['billing_number'] ) );
    }
    if ( isset( $_POST['billing_address_2'] ) ) {
		// WooCommerce address 1
        update_user_meta( $customer_id, 'billing_address_2', sanitize_text_field( $_POST['billing_address_2'] ) );
    }
	
    if ( isset( $_POST['billing_neighborhood'] ) ) {
		// WooCommerce addres neighborhood
        update_user_meta( $customer_id, 'billing_neighborhood', sanitize_text_field( $_POST['billing_neighborhood'] ) );
    }
	
    if ( isset( $_POST['billing_city'] ) ) {
		// WooCommerce addres city
        update_user_meta( $customer_id, 'billing_city', sanitize_text_field( $_POST['billing_city'] ) );
    }
	
    if ( isset( $_POST['billing_state'] ) ) {
		// WooCommerce addres state
        update_user_meta( $customer_id, 'billing_state', $_POST['billing_state'] );
    }
	
}
add_action( 'woocommerce_created_customer', 'dw_save_extra_register_fields' );
