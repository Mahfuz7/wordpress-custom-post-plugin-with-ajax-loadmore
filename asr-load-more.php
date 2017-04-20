<?php
/**
 * ASR_Ajax_Load_More
 * 
 * Append posts images & contents at the bottom of
 * post area into the page.
 * 
 * 
 * @package 	ASR_AJAX_Load_More
 * @author 		Mahfuz <asrmahfuz8@gmail.com>
 * @license 	GPL-2
 * @link 		http://www.codermahfuz.xyz
 * @copyright 	2017
 * 
 * 
 * @wordpress-plugin
 * Plugin Name: ASR Ajax Load More Post
 * Plugin URI: http://www.codermahfuz.xyz
 * Description: Append posts images & contents at
 * the bottom of post area into the page.
 * Version: 0.1.0
 * Author: Mahfuz
 * Author URI: http://www.codermahfuz.xyz
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


//If this file called directly. aboart
if( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Including the core plugin class for executing the plugin
 */
require_once ( plugin_dir_path( __FILE__ ) . 'admin/class-asr-ajax-load-more.php');


/**
 * Renders the view that displays the contents for 
 * the front end
 * 
 * Including shortcode files
 * 
 * @since 	0.1.0
 */
require_once ( plugin_dir_path( __FILE__ ) . 'admin/shortcode-asr-ajax-load-more.php');


/**
 * Begins execution of the plugin
 * 
 * 
 * 
 */
function run_asr_load_more_posts() {

	$plugin = new ASR_Ajax_Load_More();

	$plugin->run();

}

run_asr_load_more_posts();





//when logged out 
//function return new posts based on offset and posts per page value
function load_more_func() {

  
	if ( !wp_verify_nonce( $_REQUEST['nonce'], "load_posts" ) ) {
	  exit("No naughty business please");
	}

	$offset 			= isset($_REQUEST['offset'])?intval($_REQUEST['offset']):0;
	$posts_per_page 	= isset($_REQUEST['posts_per_page'])?intval($_REQUEST['posts_per_page']):10;
	$post_type 			= isset($_REQUEST['post_type'])?$_REQUEST['post_type']:'post';

  	ob_start(); // buffer output instead of echoing it


	$args = array(
		'post_type'			=> 'projects',
		'offset' 			=> $offset,
		'posts_per_page' 	=> 3,
		'orderby' 			=> 'date',
		'order' 			=> 'DESC'
	);



  	$posts_query = new WP_Query( $args );
  
  
	if ($posts_query->have_posts()) {

		$result['have_posts'] = true; //set result array item "have_posts" to true

		while ( $posts_query->have_posts() ) : $posts_query->the_post();
	?>
		<article id="post-<?php the_ID(); ?>" class="single-article" >
			<?php //here goes your post content:?>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</article>

	<?php 
		endwhile;
		$result['html'] = ob_get_clean(); // put alloutput data into "html" item

		
	} else {
	//no posts found
		$result['have_posts'] = false; // return that there is no posts found
	}

	if(
		!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
		strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
	)
	{
		$result = json_encode($result); // encode result array into json feed
		echo $result; // by echo we return JSON feed on POST request sent via AJAX
	}
		else { 
		header("Location: ".$_SERVER["HTTP_REFERER"]);
	}
	
	die();

}