<?php
/**
 * Template for homepage
 */

get_header(); ?>
    <div class="front-page">
        <section class="section-desc">
            <div class="container-inner">
                <article>
                    <?php echo get_post_meta($post->ID, 'textarea_homepage', true); ?>
                </article>
            </div>
        </section>
        <section class="section-new-media">
            <div class="container-inner">
                <h2>
                    <?php echo get_post_meta($post->ID, 'mediatitle_homepage', true); ?>
                </h2>
            </div>
            <div class="media-line"></div>
            <div class="container-inner">
                <ul class="media-container">
                    <?php
                    $attachments = get_posts(array(
                        'post_type' => 'attachment',
                        'numberposts' => 6,
                        'post_mime_type' => 'video',
                        'order'=> 'ASC'
                    ));
                        if ($attachments) {
                            foreach ($attachments as $attachment) {
                                $video_url = wp_get_attachment_url($attachment->ID);
                                $video_title = get_the_title($attachment->ID);
                                $video_thumb = get_the_post_thumbnail($attachment->ID, 'media-thumbnail');
                                echo '<li class="media-inner"> <a  href=" ' . $video_url . '"> <div> ' . $video_thumb . '</div> </a>  <h4> ' . $video_title . '  </h4></li>';
                            }
                        } else {
                            echo '<h3>No video</h3>';
                        }
                    ?>
                </ul>
            </div>
        </section>
    </div>
<?php
get_footer();
