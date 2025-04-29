<section class="our-salon">
    <div class="container mx-auto">
        <h2 class="section-title flex">
            <p class="flex"><span>P</span>Our Salons</p>
            <small>(1)</small>
        </h2>

        <div class="salon-list">
            <?php
            $args = array(
                'post_type'      => 'payitfoward-salon',
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'orderby'        => 'menu_order',
                'order'          => 'ASC'
            );
            $salon_query = new WP_Query($args);

            if ($salon_query->have_posts()) :
                while ($salon_query->have_posts()) : $salon_query->the_post();
                    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    $address = get_field('address');
                    $phone = get_field('tel');
                    $instagram = get_field('instagram');
                    $map_link = get_field('map');
            ?>
            <div class="salon-card">
                <a href="<?php the_permalink(); ?>">
                    <div class="thumbnail" style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');"></div>
                    <div class="salon-info">
                        <h3 class="salon-name"><?php the_title(); ?></h3>
                        <p class="salon-address"><?php echo esc_html($address); ?></p>
                        <div class="contact-row">
                            <span class="phone">TEL｜<?php echo esc_html($phone); ?></span>
                            <span class="instagram">IG｜<?php echo esc_html($instagram); ?></span>
                        </div>
                        <?php if ($map_link) : ?>
                        <p class="map-link">
                            <a href="<?php echo esc_url($map_link); ?>" target="_blank" rel="noopener noreferrer">
                                [ Google Map <span class="map-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/common/map-icon.svg" alt="" /></span>]
                            </a>
                        </p>
                        <?php endif; ?>
                    </div>
                </a>
            </div>

            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
            <p>サロン情報が見つかりませんでした。</p>
            <?php endif; ?>
        </div>
    </div>
</section>
