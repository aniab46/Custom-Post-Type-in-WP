<?php

/*
 * Plugin Name:       Custom post Type
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       This is Custom Column Dashboard plugin. With the phone ..
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Muhammad Aniab
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */


 class CPT_custom_post_type{
	public function __construct(){
		add_action("init", array( $this,"cptui_register_my_cpts_book") );
		add_action("init", array( $this,"cptvi_register_custom_post_chapter") );
		add_action("init", array( $this,"cptui_register_my_taxonomy") );
		add_action("init", array( $this,"rewrite_url_code") );
		register_activation_hook( __FILE__, array( $this,"activation") );
	}
	
	function activation(){
		flush_rewrite_rules();
	}
	function cptui_register_my_cpts_book() {

		/**
		 * Post Type: Books.
		 */
	
		$labels = [
			"name" => esc_html__( "Book", "twentytwentytwo" ),
			"singular_name" => esc_html__( "Book", "twentytwentytwo" ),
			"add_new" => esc_html__( "Add new Book", "twentytwentytwo" ),
		];
	
		$args = [
			"label" => esc_html__( "Book", "twentytwentytwo" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"rest_namespace" => "wp/v2",
			"has_archive" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"can_export" => false,
			"rewrite" => [ "slug" => "book", "with_front" => true ],
			"query_var" => true,
			"supports" => [ "title", "editor", "thumbnail" ],
			"show_in_graphql" => false,
		];
		register_post_type( "book", $args );
	
	}

	function cptui_register_my_taxonomy() {
		

		$arg=[
			'label'=> 'genre',
			'hierarchical'=> 'false',
			'public'=> true,
		];

		register_taxonomy( 'genre', 'book', $arg);

	}

	function cptvi_register_custom_post_chapter(){

		$grp=array(
			'label'=> 'chapter',
			'public'=> true,
			'has_archive'=> true,
		);

		register_post_type('chapter',$grp);
	}
	
	function rewrite_url_code(){
		add_rewrite_rule('^book/([^/]*)/([^/]*)/?',
		'index.php?post_type=chapter&name=$matches[2]',
		'top');
	}

 }

 new CPT_custom_post_type();

?>