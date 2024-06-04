<?php
// Sigle - Blog post
// Wp Estate Pack
get_header();
$wpestate_options = wpestate_page_details($post->ID);
global $more;
$more = 0;




if ('wpestate_message' == get_post_type() || 'wpestate_invoice' == get_post_type()) {
    exit();
}
?>
<?php if (!function_exists('elementor_theme_do_location') || !elementor_theme_do_location('single')) { ?>
    <div id="post" <?php post_class('row'); ?>>
        <?php get_template_part('templates/breadcrumbs'); ?>
        <div class=" <?php print esc_html($wpestate_options['content_class']); ?> single_width_blog">
            <?php get_template_part('templates/ajax_container'); ?>
            <?php
            while (have_posts()) : the_post();

                if (has_post_thumbnail()) {
                    $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_full_map');
                }
                $email_link     =   'subject=' . urlencode(get_the_title()) . '&body=' . urlencode(esc_url(get_permalink()));
            ?>
                <div class="single-content single-blog">
                    <?php
                    global $more;
                    $more = 0;
                    include(locate_template('templates/postslider.php'));
                    ?>

                    <?php
                    if (esc_html(get_post_meta($post->ID, 'post_show_title', true)) != 'no') { ?>
                        <h1 class="entry-title single-title"><?php the_title(); ?></h1>
                    <?php } ?>

                    <?php $agent = get_field('agent')[0]; ?>

                    <div class="meta-info">
                        <div class="meta-element">
                            <?php if ($agent != null) {
                                print '<a href="' . get_permalink($agent->ID) . '">';
                                print get_the_post_thumbnail($agent->ID, 'post-thumbnail', ['class' => 'rounded author-icon']);
                                print ' By ' . $agent->post_title . ' ';
                                print '</a>';
                                esc_html_e('on', 'wpresidence');
                            } else {
                                print '<i class="far fa-calendar-alt meta_icon firsof"></i> On';
                            }
                            print ' ' . the_date('', '', '', false); ?>
                        </div>
                        <?php if (strip_tags(get_the_category_list(', ')) != 'Uncategorised') { ?>
                            <div class="meta-element"> <?php print '<i class="far fa-file meta_icon"></i> ';
                                                        the_category(', ') ?></div>
                        <?php } ?>
                        <!--<div class="meta-element"> <?php //print '<i class="far fa-comment meta_icon"></i> '; comments_number('0', '1');  
                                                        ?>   </div>-->
                        <div class="meta-element"> <?php print '<i class="far fa-clock meta_icon"></i> ';
                                                    echo reading_time()  ?> read</div>
                    </div>


                    <?php
                    the_content('Continue Reading');
                    $args = array(
                        'before'           => '<p>' . esc_html__('Pages:', 'wpresidence'),
                        'after'            => '</p>',
                        'link_before'      => '',
                        'link_after'       => '',
                        'next_or_number'   => 'number',
                        'nextpagelink'     => esc_html__('Next page', 'wpresidence'),
                        'previouspagelink' => esc_html__('Previous page', 'wpresidence'),
                        'pagelink'         => '%',
                        'echo'             => 1
                    );
                    wp_link_pages($args);

                    $whatsup_link       =  wpestate_return_agent_whatsapp_call($post->ID, '');
                    ?>


                    <div class="prop_social_single">

                        <a href="https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_facebook" rel="noreferrer"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title() . ' ' .  esc_url(get_permalink())); ?>" class="share_tweet" target="_blank" rel="noreferrer"><i class="fa-brands fa-x-twitter"></i></a>
                        <?php if (isset($pinterest[0])) { ?>
                            <a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo esc_url($pinterest[0]); ?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_pinterest" rel="noreferrer"> <i class="fab fa-pinterest-p"></i> </a>
                        <?php } ?>
                        <a href="<?php echo esc_url($whatsup_link); ?>" class="" rel="noreferrer"><i class="fab fa-whatsapp" aria-hidden="true"></i></a>

                        <a href="mailto:email@email.com?<?php echo trim(esc_html($email_link)); ?>" class="social_email"> <i class="far fa-envelope"></i></a>

                    </div>


                </div>

                <!-- #comments start-->
                <?php
                if (comments_open() || get_comments_number()) :
                    comments_template('', true);
                endif;
                ?>

                <!-- end comments -->

                <!-- #related posts start-->
                <?php include(locate_template('templates/related_posts.php')); ?>
                <!-- #end related posts -->



            <?php endwhile; // end of the loop.
            ?>
        </div>
        <?php include get_theme_file_path('sidebar.php'); ?>
    </div>
<?php } ?>
<?php get_footer(); ?>