<footer id="footer">
    <div class="footer__inner">
        <div class="footer__left">
            <h3>
                <p>
                    Pay it<br>
                    Forward
                </p>
                <span>世界を変えるのは一歩を踏みだしたチャレンジャーたち。</span>
                <small>Challengers change the world.</small>
            </h3>

            <nav class="footer__sitemap">
                <ul>
                    <li class="roki"><a href="/"><span>ー</span> HOME</a></li>
                    <li class="roki"><a href="/qa"><span>ー</span> QUESTION & ANSWER</a></li>
                    <li class="roki"><a href="/concept"><span>ー</span> RECRUIT CONCEPT</a></li>
                    <li class="roki"><a href="/data"><span>ー</span> DATA</a></li>
                    <li class="roki"><a href="/#our-salon"><span>ー</span> OUR SALONS</a></li>
                    <li class="roki"><a href="/recruit"><span>ー</span> RECRUIT</a></li>
                    <li class="roki"><a href="/interview"><span>ー</span> CHALLENGERS FILE</a></li>
                    <li class="roki"><a href="/company"><span>ー</span> COMPANY</a></li>
                    <li class="roki"><a href="/news"><span>ー</span> NEWS & TOPICS</a></li>
                    <li class="roki"><a href="/contact"><span>ー</span> CONTACT</a></li>
                </ul>
            </nav>

            <div class="footer__buttons">
                <a href="/entry" class="btn entry-btn flex">応募してみる・エントリー<img src="<?php echo get_template_directory_uri(); ?>/assets/images/top/footer-entry-arrow.svg" alt="Scroll Image" /></a>
                <a href="/policy" class="btn policy-btn flex"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/top/blank.svg" alt="Scroll Image" /><span>プライバシーポリシー</span></a>
            </div>

            <p class="copyright">© <?php echo date('Y'); ?> Pay it Forward, Inc.</p>
        </div>

        <div class="footer__right">
            <div class="salon__list">
                <?php
                $args = array(
                    'post_type' => 'payitfoward-salon',
                    'posts_per_page' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                );
                $salon_query = new WP_Query($args);
                if ($salon_query->have_posts()) :
                    while ($salon_query->have_posts()) : $salon_query->the_post();
                        $thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium');
                        $address = get_field('address');
                        $instagram = get_field('instagram');
                        $map = get_field('map');
                ?>
                    <div class="salon__card">
                        <a href="<?php the_permalink(); ?>">
                            <div class="salon__img" style="background-image: url('<?php echo esc_url($thumb); ?>');"></div>
                            <div class="salon__info">
                                <p class="salon__name"><?php the_title(); ?></p>
                                <p class="salon__address"><?php echo esc_html($address); ?></p>
                                <p class="salon__insta">
                                    <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="flex"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/top/footer-insta.svg" alt="" />IG｜@Instagram</a>
                                </p>
                                <p class="salon__map flex">
                                    <a href="<?php echo esc_url($map); ?>" target="_blank" class="flex" rel="noopener noreferrer">
                                        [ Google Map <span class="map-icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/common/map-icon-white.svg" alt="" /></span>]
                                    </a>
                                </p>
                            </div>
                        </a>
                    </div>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>

            <div class="footer__brand">
                <p>Pay it Forward, Inc.</p>
                <a href="<?php echo esc_url($instagram); ?>" target="_blank" class="flex"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/top/footer-insta.svg" alt="" />IG｜pay_it_forward___company</a>
            </div>
        </div>
    </div>

    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/common/pageTop.png" alt="" class="pageTop">
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://www.unpkg.com/fullpage.js@4.0.15/dist/fullpage.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.7/vendors/jquery.easings.min.js" integrity="sha512-rXZZDfRSa6rsBuT78nRTbh1ccwpXhTCspKUDqox3hUQNYdjB6KB6mSj6mXcB9/5F5wODAJnkztXPxzkTalp11w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/main.js"></script>

</body>
<?php wp_footer();?>
</html>