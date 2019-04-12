<?php
/**
 * Plugin Name: Code EAN
 * Description: Ajoutez un champs pour saisir le code EAN dans l&#39;onglet Inventaire des fiches produits et l&#39;affichez sur votre boutique
 * Version:     1.0.0
 * Author:      Kevin S.
 * Author URI:  https://github.com/abraham63
 * License:     GPL2
 */


 //ADD THE FIELD IN ADMIN PAGE
 add_action('woocommerce_product_options_inventory_product_data','add_ean_field', 10, 1 );
 function add_ean_field(){
    global $woocommerce, $post;
    $produit = new WC_Product(get_the_ID());
    echo '<div id="ean_code" class="options_group">';
    //add GTIN field for simple product
    woocommerce_wp_text_input(
       array(
          'id' => '_cean',
          'label' => 'Code EAN',
          'desc_tip' => 'true',
          'description' => 'Entrez le code EAN du produit')
    );
    echo '</div>';
 }



 //SAVE THE FIELD IN POST META
 add_action('woocommerce_process_product_meta','save_ean_field');
 function save_ean_field($post_id){
    $product_ean_code = $_POST['_ean'];
    if(isset($product_ean_code)){
       update_post_meta($post_id,'_ean', esc_attr($product_ean_code));
    }
    $product_ean_code = get_post_meta($post_id,'_ean', true);
    if (empty($product_ean_code)){
       delete_post_meta($post_id,'_ean', '');
    }
 }

  //DISPLAY FIELD IN FRONTEND
 add_action( 'woocommerce_product_meta_end', 'display_ean_field' );
 function display_ean_field()
 {
 	global $post;
 	if ( $eancode = get_post_meta($post->ID,'_ean', true))
 	{
 		echo '<span class="meta-codeean">Code EAN : '.$eancode."</span>";
 	}

 }
