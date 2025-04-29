<?php get_template_part('templates/header'); ?>
<div id="page__mv" class="pt-80 bg w-full"></div>
    <div class="gallery__content pt-12">
        <h2 class="sec__ttl--big mb-2.6">
            GALLERY
        </h2>
        <ul class="gallery__cat flex pb-13.5 justify-center">
            <li class="pr-3 text-2">
                <a href="">ALL</a>
            </li>
            <li class="px-3 text-2">
                <a href="">HAIR</a>
            </li>
            <li class="pl-3 text-2">
                <a href="">NAIL</a>
            </li>
        </ul>

        <div class="gallery__list flex justify-between pt-13.5 mx-auto flex-wrap">
            <?php
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $args = array(
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                    'paged'          => $paged,
                    'post_type'      => 'tophair-gallery',
                );
                $my_query = new WP_Query($args);
                $modal_index = 0; // 各モーダルの識別用
            ?>

            <?php if ($my_query->have_posts()) :
                while ($my_query->have_posts()) : $my_query->the_post();
                    $tophair_img = get_field('tophair_img');
                    $title = get_the_title();
                    $description = wp_strip_all_tags(get_the_content());

                    $modal_id = "modal-" . $modal_index; // 各投稿ごとに異なるID

                    // ACFの「関連」フィールドからスタッフ情報を取得
                    $related_staffs = get_field('related_staff');
            ?>
                <!-- ギャラリーアイテム -->
                <div class="gallery-item swiper-slide bg" 
                    style="background-image: url(<?php echo esc_url($tophair_img); ?>);" 
                    data-modal-id="<?php echo esc_attr($modal_id); ?>">
                </div>

                <!-- 各投稿ごとのモーダル -->
                <div class="modal" id="<?php echo esc_attr($modal_id); ?>">
                    <div class="modal__content">
                        <div class="flex">
                            <div class="modal__img bg" style="background-image: url(<?php echo esc_url($tophair_img); ?>);"></div>
                            <div class="modal__text flex">
                                <div class="text">
                                    <h2 class="modal-title"><?php echo esc_html($title); ?></h2>
                                    <p class="modal-description"><?php echo esc_html($description); ?></p>
                                </div>

                                <!-- スタッフ情報を表示 -->
                                <div class="staff">
                                    <?php if ($related_staffs): ?>
                                        <?php foreach ($related_staffs as $staff): ?>
                                            <?php 
                                                $staff_id = $staff->ID;
                                                $staff_name = get_the_title($staff_id);
                                                $staff_img = get_field('staff_img', $staff_id);
                                                $staff_roma = get_field('roma', $staff_id);
                                                $staff_job = get_field('staff_job', $staff_id);
                                                $staff_position = get_field('staff_position', $staff_id);
                                                $staff_instagram = get_field('instagram', $staff_id);
                                            ?>
                                            <div class="staff-item flex">
                                                <div class="staff-img bg" style="background-image: url(<?php echo esc_url($staff_img); ?>);"></div>
                                                <div class="staff-info">
                                                    <p class="staff-job"><?php echo esc_html($staff_job); ?></p>
                                                    <p class="staff-name"><?php echo esc_html($staff_name); ?></p>
                                                    <p class="staff-roma"><?php echo esc_html($staff_roma); ?></p>
                                                    <a href="<?php echo esc_html($staff_instagram); ?>"  target="_blank" class="insta flex">INSTAGRAM<img src="<?php echo get_template_directory_uri();?>/assets/images/gallery/insta-arrow.svg" alt="" class=""></a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>スタッフ情報はありません</p>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                        <button class="modal-close"><img src="<?php echo get_template_directory_uri();?>/assets/images/gallery/modal-close.svg" alt="" class=""></button>
                    </div>
                </div>

            <?php 
                $modal_index++; // モーダルIDを一意にする
                endwhile; 
            endif;
            wp_reset_postdata(); 
            ?>
        </div>

    </div>


<?php get_template_part('templates/footer'); ?>