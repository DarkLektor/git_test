<?php
/*
Plugin Name: Api filter
Description: Additions to WordPress
Version: 0.0.1
Author: DL
*/
define('DL_API_DIR', plugin_dir_path(__FILE__));
define('DL_API_URL', plugin_dir_url(__FILE__));
// require_once DL_URL . '/inc/search_api_shortcode.php';
// Создаем папку кеша при включении плагина
register_activation_hook(__FILE__,  'search_api_register_activation_hook');

class dl_api_search {
    function __construct() {
        // dd_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'reg_styles_scripts'));
        add_shortcode( 'api_search_shortcode', array($this, 'api_search_shortcode'));
        add_action( 'init',  array($this, 'api_post_type'));
        // add_action( 'init',  array($this, 'api_data')); // подгрузка апи
    }
    function reg_styles_scripts() {
        wp_register_style('search_api_css', DL_API_URL . '/search_api.css');
        wp_enqueue_style('search_api_css');

        wp_deregister_script('jquery');
        wp_register_script( 'jQuery', "https://code.jquery.com/jquery-3.5.1.min.js", true);
        wp_register_script('search_api_js', DL_API_URL . '/app.js', array('jQuery'), true);
        wp_enqueue_script('search_api_js', true);
    }
    // function api_data() {
    //     $ch = curl_init('http://jsonplaceholder.typicode.com/posts');
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     $res = curl_exec($ch);
    // }
    function api_post_type() {
        register_post_type( 'skills', ['label'  => null,
            'labels' => [
                'name'               => 'Search api', 
                'singular_name'      => 'Search api', 
                'menu_name'          => 'Search api',
            ],
            'description'         => '',
            'public'              => true,
            'show_in_menu'        => null,
            'show_in_rest'        => null,
            'rest_base'           => null,
            'menu_position'       => null,
            'menu_icon'           => null,
            'hierarchical'        => false,
            'supports'            => array('excerpt'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
            'taxonomies'          => [],
            'has_archive'         => false,
            'rewrite'             => true,
            'query_var'           => true,]
        );

    }
    function api_search_shortcode() {
        include DL_API_DIR . 'inc/search_api_shortcode.php';
    }

 
}
$dl_api_search = new dl_api_search();
?>