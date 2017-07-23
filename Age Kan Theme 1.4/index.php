<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<?php get_sidebar(); ?>


<!-- loop start -->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="news fl">
		<!-- FIRST NEWS -->
		
		<ul>
			<li class="topNewsSection"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a> <img src="<?php bloginfo('template_directory'); ?>/images/fighterLogo.jpg" alt="fighterLogo" width="46" height="35" class="fighter fr" /><span><?php the_time('F jS, Y') ?></span><br /><img src="<?php bloginfo('template_directory'); ?>/images/newsTopSep.jpg" alt="newsTopSep" width="620" height="1" /></li>
			
			<li class="newsContentSection"><?php the_content(); ?></li>
			<li></li>
			<li></li>
		</ul>
		<!-- FIRST NEWS -->
		
		
		
		
	</div><!-- news -->
	
	
	<?php endwhile; else: ?>

 <!-- The very first "if" tested to see if there were any Posts to -->
 <!-- display.  This "else" part tells what do if there weren't any. -->
 <p>Sorry, no posts matched your criteria.</p>

 <!-- REALLY stop The Loop. -->
 <?php endif; ?>


<?php get_footer(); ?>