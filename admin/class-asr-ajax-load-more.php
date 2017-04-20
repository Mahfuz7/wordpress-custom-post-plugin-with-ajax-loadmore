<?php
/**
 * The dashboard-specific functionality of the plugin.
 * 
 * 
 * @link 		http://www.codermahfuz.xyz
 * @since 		0.1.0
 * 
 * @package 	ASR_Ajax_Load_More
 * @subpackage 	ASR_Ajax_Load_More/admin
 */


/**
 * The dashboard-specific functionality of the plugin
 * 
 * 
 * Defines the plugin name, version, the post functionality
 * and the JavaScript loading for the Load More button.
 * 
 * @package 	ASR_Ajax_Load_More
 * @subpackage 	ASR_Ajax_Load_More/admin
 * @author 		Mahfuz <asrmahfuz8@gmail.com>
 */
class ASR_Ajax_Load_More {

	/**
	 * The ID of this plugin.
	 * 
	 * @since 	0.1.0
	 * @access 	private
	 * @var 	string $name The ID of this plugin
	 */
	private $name;

	/**
	 * The current version of this plugin
	 * 
	 * @since 	0.1.0
	 * @access 	private
	 * @var 	string $version 	The Version of this plugin
	 */
	private $version;


	/**
	 * Initialize the plugin by defining the properties
	 * 
	 * @since 0.1.0
	 */
	public function __construct() {

		$this->name 	= 'asr-ajax-load-more-posts';
		$this->version 	= '0.1.0';

	}


	/**
	 * Defines the hook that will register and enqueue the JavaScript
	 * make sure to include ajaxurl, so we know where to send the post
	 * request
	 * 
	 * 
	 * @since 0.1.0
	 */
	public function run() {

		add_action( 'wp_enqueue_scripts', array( $this, 'dt_add_main_js' ) );
		add_action( 'init', array( $this, 'asr_projects_custom_post') );
		
		add_action( "wp_ajax_load_more", "load_more_func" );
		add_action( "wp_ajax_nopriv_load_more", "load_more_func" );

	}


	/**
	 * Register the JavaScript for handling load more button
	 * 
	 * @since 	0.1.0
	 */
	public function dt_add_main_js(){
	  
		wp_register_script (
			'main-js',
			plugin_dir_url( __FILE__ ) . '/js/script.js',
			array( 'jquery' ),
			'1.0',
			false
		);
		wp_enqueue_script( 'main-js' );

		wp_localize_script( 'main-js', 'headJS', array(
			'ajaxurl'			=> admin_url( 'admin-ajax.php' ),
			'templateurl'		=> get_template_directory_uri(),
			'posts_per_page'	=> get_option('posts_per_page')
		));
	  
	}



	/**
	 * Register a custom post for handling posts inside the 
	 * dashboard.
	 * 
	 * @since 	0.1.0
	 * @todo 	improve register post type function
	 */
	public function asr_projects_custom_post() {
	    $args = array(
	      'public' 	=> true,
	      'label'  	=> 'Projects',
	      'supports'	=> array('title', 'editor', 'thumbnail' )
	    );
	    register_post_type( 'projects', $args );
	}







}