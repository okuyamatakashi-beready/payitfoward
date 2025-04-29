<?php get_template_part('templates/header'); ?>
<div class="page-news">
    <section id="news">
        <div class="container mx-auto">
            <h2 class="section-title flex">
                <p>News&Topics<br><small>ニュース/トピックス</small></p>
                <small>(3)</small>
            </h2>
            <div class="thumb"></div>

            <div class="news-list">
                <?php
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $news_query = new WP_Query([
                    'post_type' => 'post',
                    'posts_per_page' => 5,
                    'paged' => $paged
                ]);

                if ($news_query->have_posts()) {
                    $count = 0;
                    while ($news_query->have_posts()) {
                        $news_query->the_post();

                        if ($count % 3 === 0) {
                            echo '<div class="news-row">';
                        }
                        ?>
                        <div class="news-card">
                            <a href="<?php the_permalink(); ?>">
                                <p class="news-date roki"><?php echo get_the_date('Y.m.d'); ?></p>
                                <div class="news-thumb" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>');"></div>
                                <h3 class="news-title"><?php the_title(); ?></h3>
                                <p class="news-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/news/news-arrow.svg" alt="" />
                            </a>
                        </div>
                        <?php
                        $count++;
                        if ($count % 3 === 0 || $count === $news_query->post_count) {
                            echo '</div>';
                        }
                    }
                    wp_reset_postdata();
                }
                ?>

            </div>
            

        </div>
        <?php
        $total_pages = $news_query->max_num_pages;
        if ($total_pages > 1) {
            echo '<div class="pagination roki">';
            echo paginate_links([
                'current' => max(1, get_query_var('paged')),
                'total' => $total_pages,
                'prev_text' => '<img src="' . get_template_directory_uri() . '/assets/images/news/prev.svg" alt="前へ">',
                'next_text' => '<img src="' . get_template_directory_uri() . '/assets/images/news/next.svg" alt="次へ">',
                'mid_size'  => 2,
                'type' => 'list' // <ul><li>構造で出力される（CSS制御しやすくなります）
            ]);
            echo '</div>';
        }
        ?>

    </section>
</div>
<?php get_template_part('components/data'); ?>
<?php get_template_part('components/entry'); ?>
<?php get_template_part('templates/footer'); ?>