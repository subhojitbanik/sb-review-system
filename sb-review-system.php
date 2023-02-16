<?php
//error_reporting(0);
/*
Plugin Name: Fast Grades Reviews System.
Description: reviews-App.
Author: Subhojit Banik And Muhammad Burhan
Version: 1.0.0
Author URI: #
 */



define('SB_REVIEWS_VERSION', '1.0.0');
define('SB_REVIEWS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SB_REVIEWS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SB_REVIEWS_PLUGIN_FILE', __FILE__);


/*
required files..
 */
  require SB_REVIEWS_PLUGIN_DIR . 'review.php';



/**
 * enqueue_scripts
 */

function sb_review_enqueue_scripts(){
  if(is_single() ){
    wp_enqueue_style('sb-slick-css','https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_enqueue_style('sb-reviews-css', SB_REVIEWS_PLUGIN_URL . 'style.css');

    wp_enqueue_script( 'sb-slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery') );
    
  }
}
add_action('wp_enqueue_scripts', 'sb_review_enqueue_scripts');

/*
*create reviews table..
*/

 function sb_create_reviews_table_fn(){

    global $wpdb;
    $table_name = $wpdb->prefix . 'reviews_table';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
    review_ID mediumint(9) NOT NULL AUTO_INCREMENT,
    review_content varchar(255) NOT NULL,
    review_ratings varchar(255) NOT NULL,
    student_id varchar(255) NOT NULL,
    tutor_id varchar(255) NOT NULL,
    request_id varchar(255) NOT NULL,
    status mediumint(9) DEFAULT '0',
    date_time TIMESTAMP NOT NULL,
    PRIMARY KEY  (review_ID),
    UNIQUE KEY (request_id)
  ) $charset_collate;";
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}
register_activation_hook(SB_REVIEWS_PLUGIN_FILE, 'sb_create_reviews_table_fn');