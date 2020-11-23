<?php 



function cfwc_create_custom_field() {
 $args = array(
 'id' => 'product_video_preview',
 'type' => 'file',
 'label' => __( 'Product Video Preview', 'cfwc' ),
 'class' => 'cfwc-custom-field',
 'desc_tip' => true,
 'description' => __( 'Select preview', 'ctwc' ),
 );
 woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_inventory_product_data', 'cfwc_create_custom_field' );


function cfwc_save_custom_field( $post_id ) {
 $product = wc_get_product( $post_id );
 if (isset($_FILES["product_video_preview"]["name"])) {
    $orig = $_FILES["product_video_preview"]["name"];
    $getType = array_reverse(explode('.', $orig));
    $file_name = time() . "." . $getType[0];

    $target_dir = get_theme_root()."./../uploads/";
    $target_file = $target_dir . basename($file_name);

    if (move_uploaded_file($_FILES["product_video_preview"]["tmp_name"], $target_file)) {
        $title = isset( $_POST['product_video_preview'] ) ? $file_name : '';
        $product->update_meta_data( 'product_video_preview', $file_name );
        $product->save();
    }
 }


}
add_action( 'woocommerce_process_product_meta', 'cfwc_save_custom_field' );


remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'custom_loop_product_thumbnail', 10 );
function custom_loop_product_thumbnail() {
    global $product;
    $size = 'woocommerce_thumbnail';

    $image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );
	
    $title = $product->get_meta( 'product_video_preview' );
    $target_dir = get_site_url()."/wp-content/uploads/".$title;
    if ($title) {
        echo do_shortcode('[video width="1920" height="1080" alt="" mp4="'.$target_dir.'"][/video]');
    }else{
        echo woocommerce_get_product_thumbnail($image_size);
    }
}
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );