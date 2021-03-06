<?php

/**

 * The Header for our theme.

 *

 * Displays all of the <head> section and everything up till <div id="main">

 *

 * @package WordPress

 * @subpackage Twenty_Ten

 * @since Twenty Ten 1.0

 */

?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />

<title><?php

	/*

	 * Print the <title> tag based on what is being viewed.

	 */

	global $page, $paged;



	wp_title( '|', true, 'right' );



	// Add the blog name.

	bloginfo( 'name' );



	// Add the blog description for the home/front page.

	$site_description = get_bloginfo( 'description', 'display' );

	if ( $site_description && ( is_home() || is_front_page() ) )

		echo " | $site_description";



	// Add a page number if necessary:

	if ( $paged >= 2 || $page >= 2 )

		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );



	?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php

	/* We add some JavaScript to pages with the comment form

	 * to support sites with threaded comments (when in use).

	 */

	if ( is_singular() && get_option( 'thread_comments' ) )

		wp_enqueue_script( 'comment-reply' );



	/* Always have wp_head() just before the closing </head>

	 * tag of your theme, or you will break many plugins, which

	 * generally use this hook to add elements to <head> such

	 * as styles, scripts, and meta tags.

	 */

	wp_head();

?>

</head>



<body>



	<div id="topSection">

	

		<div id='topContainer'><img src='<?php bloginfo('template_directory'); ?>/partners/romaSupport.png' class='fr' style="margin-top:100px; margin-right: 10px;" /></div>

		

		<div id="menuContainer">

			

				<ul id="nav">

					<li><a href="http://agekan.22web.net/">Home<span>start here</span></a></li>

					<li><a href="?page_id=6">Services <span>what we do</span></a></li>

					<li><a href="?page_id=12">Gallery <span>our pictures</span></a></li>

					<li><a href="?page_id=14">Students <span>our student's ranking</span></a></li>

					<li><a href="?page_id=16">About US<span>who we are</span></a></li>

					<li><a href="?page_id=18">Contact <span>how to find us</span></a></li>

				</ul>

		</div> <!-- Menu Container -->



	</div> <!-- Top Section -->

<div id='content'>

