<?php get_template_part('templates/header'); ?>


<main id="" class="">

    <div id="mv-catch" class="relative">
        <section id="mv" class="mv">
            <div class="mv__inner">
                <img src="<?php echo get_template_directory_uri();?>/assets/images/top/welcome.svg" alt="" class="">
                <h1 class="mv__title">
                    <span>Pay it<br> Forward</span>
                    <span class="recruit">Recruit 2025</span>
                </h1>
            </div>
        </section>

        <section id="about" class="about relative">
            <div class="about__inner">
                <div class="about__left">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/top/challenge.svg" alt="Challenge" class="about__icon" alt="世界を変えるのは一歩踏み出したチャレンジャーたち。">
                    <div class="about__text">
                        <p>
                        自分の人生を豊かにするためには、<br>
                        勇気を出して一歩を踏み出せ。<br>
                        そして、その一歩は<br>
                        別の誰かも幸せにするんだ。<br>
                        ペイフォワードという場所は<br>
                        そんなチャレンジャーたちの夢を叶えて<br>
                        一緒にこれからもワクワクしていきたい。<br>
                        みんなの挑戦を待っている。
                        </p>
                    </div>
                </div>
                <div class="about__right">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/top/about-img.png" alt="About Image" class="about__image">
                </div>
            </div>
        </section>

    </div>

    <div class="scroll-img swiper">
        <div class="swiper-wrapper">
            <?php for ($i = 0; $i < 10; $i++) : // 無限に見せるために複数枚ループ ?>
                <div class="swiper-slide">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/top/scroll.png" alt="Scroll Image" />
                </div>
            <?php endfor; ?>
        </div>
    </div>
    
    <?php get_template_part('components/oursalon'); ?>


    <?php get_template_part('components/staff-list'); ?>


    <div class="welcome bg">
        <p class="roki">WELCOME PAY IT FORWARD COMPANY</p>
    </div>

    <section id="news">
        <div class="container mx-auto">
            <h2 class="section-title flex">
                <p>News&Topics<br><small>ニュース/トピックス</small></p>
                <small>(3)</small>
            </h2>

            <div class="swiper news-swiper">
                <div class="swiper-wrapper">
                    <?php
                    $news_query = new WP_Query([
                        'post_type' => 'post', // 通常の投稿
                        'posts_per_page' => 5
                    ]);
                    if ($news_query->have_posts()) :
                        while ($news_query->have_posts()) : $news_query->the_post();
                    ?>
                            <div class="news-slide swiper-slide">
                                <a href="<?php the_permalink(); ?>" class="news-card">
                                    <p class="news-date roki"><?php echo get_the_date('Y.m.d'); ?></p>
                                    <div class="news-thumb" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>');"></div>
                                    <h3 class="news-title"><?php the_title(); ?></h3>
                                    <p class="news-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>

                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news/news-arrow.svg" alt="" />
                                </a>
                            </div>
                    <?php endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
                <!-- ナビボタン -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
    </section>

    <?php get_template_part('components/qa'); ?>

    <figure class="challengers">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/top/challengers.jpg" alt="Scroll Image" />
    </figure>

    <?php get_template_part('components/data'); ?>
    <?php get_template_part('components/entry'); ?>



</main>

<?php get_template_part('templates/footer'); ?>




