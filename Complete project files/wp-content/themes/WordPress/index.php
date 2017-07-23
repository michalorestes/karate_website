<?php



get_header(); ?>



<?php get_sidebar(); ?>

 <!-- Start the Loop. -->

 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

 

<div class="fl newsContainer">

			<p class='nTitle'><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a><img src="<?php bloginfo('template_directory'); ?>/images/Bfighter.jpg" alt="Bfighter" width="82" height="33" class="fr" /></p>

			

			

			<p class='newsTextContent'>

			<?php the_content('Read on...'); ?></p>

			

<p class='newsSepBottom'><img src="<?php bloginfo('template_directory'); ?>/images/newsSep.png" alt="newsSep" width="481" height="15" align="middle" /></p>

<p class='newsFooter'> <?php the_time('F jS, Y') ?> by <?php the_author_posts_link() ?> <span class="fr"><a class='links' href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><u>>Czytaj Dalej<</u></a></span></p>











				

	

		</div><!-- end of newsContainer -->

		

		

		<?php endwhile; else: ?>



 <!-- The very first "if" tested to see if there were any Posts to -->

 <!-- display.  This "else" part tells what do if there weren't any. -->

 <p>Sorry, no posts matched your criteria.</p>



 <!-- REALLY stop The Loop. -->

 <?php endif; ?>

		



<?php get_footer(); ?>

















