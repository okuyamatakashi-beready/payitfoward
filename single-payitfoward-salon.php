<?php get_template_part('templates/header'); ?>
<?php
$slug = get_post_field('post_name', get_post());
$mv_image = get_field('mv');
?>
<div class="salon__mv bg <?php echo esc_attr($slug); ?>"
    style="background-image: url('<?php echo esc_url($mv_image); ?>');">
    <div class="container mx-auto">
        <div class="salon__mv--upper flex">
            <div class="salon__mv--left">
                <h1><?php the_field('jp'); ?></h1>
                <div class="salon__mv--intro">
                    <h2 class="roki"><?php the_title(); ?></h2>
                    <p><?php the_field('salon_intro'); ?></p>
                </div>
            </div>
            <div class="salon__mv--right">
                <?php if (have_rows('salon_img')):
                    the_row(); ?>
                    <?php $main_img = get_sub_field('img-item'); ?>
                    <div class="main-image" style="background-image: url('<?php echo esc_url($main_img); ?>');"></div>
                <?php endif; ?>
            </div>
        </div>

        <?php
        $thumbs = get_field('salon_img');
        $thumb_count = is_array($thumbs) ? count($thumbs) : 0;
        $use_swiper = $thumb_count > 6;
        ?>

        <div class="salon__mv--thumbs <?php echo $use_swiper ? 'swiper swiper-thumbs' : 'flex-thumbs'; ?>">
            <div class="<?php echo $use_swiper ? 'swiper-wrapper' : 'thumbs-wrapper'; ?>">
                <?php
                $count = 0;
                foreach ($thumbs as $thumb):
                    $img = $thumb['img-item'];
                    ?>
                    <div class="<?php echo $use_swiper ? 'swiper-slide' : 'thumb-slide'; ?>">
                        <div class="thumb <?php echo $count === 0 ? 'active' : ''; ?>" data-index="<?php echo $count; ?>"
                            style="background-image: url('<?php echo esc_url($img); ?>');"></div>
                    </div>
                    <?php $count++; endforeach; ?>
            </div>
        </div>

    </div>
</div>

<div class="salon__concept <?php echo esc_attr($slug); ?>">
    <div class="container mx-auto">
        <div class="concept__wrapper">
            <div class="concept__left">
                <h2 class="roki">
                    Concept<br>
                    <span>サロンコンセプト</span>
                </h2>
                <strong><?php the_field('concept'); ?></strong>
                <p><?php the_field('concept_text'); ?></p>
            </div>
            <div class="concept__right">
                <?php $concept_img = get_field('concept_img'); ?>
                <?php if ($concept_img): ?>
                    <div class="concept__image--wrapper">
                        <div class="concept__image" style="background-image: url('<?php echo esc_url($concept_img); ?>');">
                        </div>
                        <div class="concept__image--gray"
                            style="background-image: url('<?php echo esc_url($concept_img); ?>');"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
/* ---------- 前段で現在の店舗スラッグを取得 ---------- */
$current_salon_slug = get_post_field('post_name', get_the_ID()); // belle-bianca 等

$args = array(
    'post_type' => 'payitforward-staff',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'tax_query' => array(
        array(
            'taxonomy' => 'salon',     // ★ カスタムタクソノミー名
            'field' => 'slug',
            'terms' => $current_salon_slug,
        ),
    ),
);

$staff_query = new WP_Query($args);
?>
<div class="salon__staff <?php echo esc_attr($current_salon_slug); ?>">
    <div class="container mx-auto">
        <h2 class="section-title flex">
            <p class="flex"><span>P</span>STAFF</p>
        </h2>

        <div class="staff__list flex">
            <?php if ($staff_query->have_posts()): ?>
                <?php while ($staff_query->have_posts()):
                    $staff_query->the_post(); ?>
                    <?php
                    // ACF フィールド
                    $position = get_field('position');
                    $name_en = get_field('name_en');
                    $name_jp = get_field('name_jp');
                    $staff_img = get_field('staff_img');
                    $instagram = get_field('instagram');
                    ?>
                    <div class="staff__card">
                        <div class="staff__img" style="background-image:url('<?php echo esc_url($staff_img); ?>');"></div>

                        <div class="staff__meta">
                            <?php if ($position): ?>
                                <p class="staff__position"><?php echo esc_html($position); ?></p><?php endif; ?>
                            <?php if ($name_en): ?>
                                <p class="staff__name-en"><?php echo esc_html($name_en); ?></p><?php endif; ?>
                            <?php if ($name_jp): ?>
                                <p class="staff__name-jp"><?php echo esc_html($name_jp); ?></p><?php endif; ?>
                        </div>

                        <?php if ($instagram): ?>
                            <a class="staff__insta" href="<?php echo esc_url($instagram); ?>" target="_blank" rel="noopener">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/salon/staff-insta-icon.svg"
                                    alt="Instagram">
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endwhile;
                wp_reset_postdata(); ?>
            <?php else: ?>
                <p class="text-center w-full py-10">該当のスタッフは登録されていません。</p>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="infomation <?php echo esc_attr($slug); ?>">
    <div class="container mx-auto">
        <div class="infomation__wrapper">
            <?php $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>
            <div class="infomation__img" style="background-image: url('<?php echo esc_url($thumbnail_url); ?>');"></div>

            <div class="infomation__content mx-auto">
                <div class="infomation__head">
                    <b class="roki">INFOMATION</b>

                </div>

                <dl class="infomation__detail">
                    <dd><?php the_field('address'); ?></dd>

                    <dd>
                        <div class="inline-items">
                            <span class="phone">TEL｜<?php echo esc_html($phone); ?></span>
                            <span class="instagram">IG｜<?php echo esc_html($instagram); ?></span>
                        </div>
                    </dd>

                    <dd>
                        <a href="<?php echo esc_url($map_link); ?>" target="_blank" rel="noopener noreferrer"
                            class="flex">
                            [ Google Map <span class="map-icon"><img
                                    src="<?php echo get_template_directory_uri(); ?>/assets/images/salon/map-icon.svg"
                                    alt="" /></span>]
                        </a>
                    </dd>
                </dl>

                <div class="infomation__icons">
                    <a href="<?php echo esc_url(get_field('instagram')); ?>" target="_blank" rel="noopener">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/salon/insta-icon.svg"
                            alt="Instagram">
                    </a>
                    <a href="<?php echo esc_url(get_field('hotpepper')); ?>" target="_blank" rel="noopener">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/salon/hotpepper-icon.svg"
                            alt="Hotpepper">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>





<?php get_template_part('components/oursalon'); ?>

<?php get_template_part('templates/footer'); ?>