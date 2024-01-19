<?php
/**
 * Template Name:  Page with Sidebar on the Left
 *

 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="py-5 py-xl-6 bg-light-subtle text-dark-emphasis">
    <div class="container text-center">
        <h1 class="display-4"><?php the_title(); ?></h1>
        
  </div>
</div>

<div id="container-content-page" class="container">
    <div class="row">
        <div class="col-md-9 py-5 order-2">
            <?php 

            if ( have_posts() ) : 
                while ( have_posts() ) : the_post();
                    the_content();
                endwhile;
            else :
                _e( 'Sorry, no posts matched your criteria.', 'textdomain' );
            endif;
            ?>
        </div>

        <div class="col-md-3 pt-5 order-1">
            <?php 
            get_sidebar();
            ?>
        </div>

    </div>
</div>


<?php get_footer();
