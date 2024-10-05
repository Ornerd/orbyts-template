<?php
/*
Template Name: Homepage
*/
get_header(); ?>

<div class="homepage-content">
  <!-- Add custom content here -->
  <main>
        
        <article>
            <?php the_content(); ?>  <!-- the protion alloted to editing on the admin's end.-->
        </article>

        <div class="container">
            <section class="input-area">
                <h1>Contact Us</h1>
                <span class="span"></span>

                 <?php echo do_shortcode('[contact-form-7 id="7ee3102" title="Untitled"]') ?> <!--form from contact-form-7 -->

            </section>
            
            <section class="contact-details">
                <h1>Reach Us</h1>
                <span></span>
                <h4>Coalition skills test</h4>
                
                <p><?php echo esc_html(get_option('c_custom_address')); ?></p>
             
                <p>Phone: <?php echo esc_html(get_option('c_custom_phone_number'));?> 
                <br/> 
                Fax: <?php echo esc_html(get_option('c_custom_fax_number'));?></p>

                

                <div class="socials">
                    <a href="<?php echo esc_url(get_option('c_custom_facebook')); ?>" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/CT_SkillTest_v1_03.jpg" alt="facebook icon">
                    </a>
                    <a href="">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/CT_SkillTest_v1_05.jpg" alt="facebook icon">
                    </a>
                    <a href="<?php echo esc_url(get_option('c_custom_linkedIn')); ?>" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/CT_SkillTest_v1_08.jpg" alt="facebook icon">
                    </a>
                    <a href="<?php echo esc_url(get_option('c_custom_pinterest')); ?>" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/CT_SkillTest_v1_10.jpg" alt="facebook icon">
                    </a>
                </div>
            </section>
        </div>

    </main>
</div>

<?php get_footer(); ?>
