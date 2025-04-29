<?php get_template_part('templates/header'); ?>
<div id="page__mv" class="pt-80 bg w-full" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>)"></div>

<?php 
    $top_img = get_field('top_img');
    $city = get_field('city');
    $furigana = get_field('furigana');
    $salon_img = get_field('salon_img');
    $concept = get_field('concept');
    $salon_img02 = get_field('salon_img02');
    $salon_info = get_field('salon_info');
?>

<div class="salon__wrapper pt-13">
    <p class="text-center text-2 mb-5 city"><?php echo $city;?></p>
    <h1 class="text-7 text-center mb-8">
        <?php the_title(); ?>
        <span class="block text-center text-2"><?php echo $furigana;?></span>
    </h1>

    <ul class="flex flex-wrap justify-center mb-23 cat__list mx-auto">
<?php
$terms = get_the_terms(get_the_ID(), 'tophair_menu');

if ($terms && !is_wp_error($terms)) :
    $custom_order = array(
        'hair' => 1,
        'headspa' => 2,
        'eyelash' => 3,
        'nail' => 4,
        'esthe' => 5,
    );

    // 除外するスラッグ一覧
    $exclude_slugs = ['gardenvilla', 'hills', 'lounge', 'sparesort', 'terracespa'];

    // 並び替え
    usort($terms, function ($a, $b) use ($custom_order) {
        $slug_a = strtolower($a->slug);
        $slug_b = strtolower($b->slug);
        $pos_a = isset($custom_order[$slug_a]) ? $custom_order[$slug_a] : 999;
        $pos_b = isset($custom_order[$slug_b]) ? $custom_order[$slug_b] : 999;
        return $pos_a - $pos_b;
    });

    // 出力（除外を含む）
    foreach ($terms as $term) :
        if (in_array($term->slug, $exclude_slugs)) continue; // 🔥 このスラッグは出力しない
?>
        <li class="mr-1">
            <div class="salon__menu--list"><?php echo esc_html($term->name); ?></div>
        </li>
<?php
    endforeach;
else :
?>
    <li class="mr-1">
        <span class="salon__menu--list">メニュー情報がありません</span>
    </li>
<?php endif; ?>
</ul>

    <div class="salon__slider salon__swiper w-full">
        <div class="swiper-wrapper">
            <?php if( have_rows('salon_img') ): ?>
                <?php while( have_rows('salon_img') ): the_row();
                    $salon_img_item = get_sub_field('salon_img_item');
                ?>
                    <div class="swiper-slide pt-69 bg" style="background-image: url(<?php echo $salon_img_item;?>);"></div>
                <?php endwhile;?>
            <?php endif; ?>


        </div>
    </div>

    <div class="salon__concept pt-27 w-full pb-21 relative">
        <div class="concept__wrapper">
            <?php if( have_rows('concept') ): ?>
                <?php while( have_rows('concept') ): the_row();
                    $concept_catch = get_sub_field('concept_catch');
                    $concept_text = get_sub_field('concept_text');
                ?>
                    <div class="concept__ttl">
                        <span class="text-center block text-2 mb-5">SALON CONCEPT</span>
                        <strong class="block text-center text-5 mb-7 font-normal"><?php echo $concept_catch;?></strong>
                        <p class="text-center leading-loose text-2 block "><?php echo $concept_text;?></p>
                    </div>
                <?php endwhile;?>
            <?php endif; ?>
        </div>
    </div>

    <div class="salon__solo--img mx-auto pb-38 relative">
        <div class="bg solo__img" style="background-image: url(<?php echo $salon_img02;?>)"></div>
    </div>

    <div id="salon__staff">
        <div class="staff__container">
            <h2 class="sec__ttl--big mb-7">STAFF</h2>
            <div class="staff__content mx-auto flex justify-between items-start">
                <?php
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $current_post_slug = get_post_field('post_name', get_the_ID());

                $args = array(
                    'posts_per_page' => '-1',
                    'post_status' => 'publish',
                    'paged' => $paged,
                    'post_type' => 'tophair_staff',
                    'order' => 'ASC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'tophair_staff_salon',
                            'field' => 'slug',
                            'terms' => $current_post_slug,
                        ),
                    ),
                );

                $my_query = new WP_Query($args);
                if ($my_query->have_posts()) :
                    while ($my_query->have_posts()) : $my_query->the_post();
                        $staff_img = get_field('staff_img');
                    ?>
                        <div class="staff__content--item mb-10" data-id="<?php echo get_the_ID(); ?>">
                            <div class="thumb bg mb-2.4" style="background-image: url(<?php echo esc_url($staff_img); ?>);"></div>
                            <div class="flex info items-end justify-between">
                                <p class="text-2.5">
                                    <span class="block text-1.4 mb-1.8"><?php the_field('staff_job'); ?></span>
                                    <?php the_field('name'); ?>
                                </p>
                                <small class="block"><?php the_field('roma'); ?></small>
                            </div>
                        </div>
                    <?php
                    endwhile;
                else :
                    echo '<p>該当するスタッフ情報が見つかりません。</p>';
                endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>

    <!-- モーダル本体 -->
    <div id="staff-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div id="staff-details"></div> <!-- Ajaxで差し込まれる部分 -->
        </div>
    </div>



        <?php
        $terms = get_the_terms(get_the_ID(), 'tophair_menu');

        $registered_menus = ($terms && !is_wp_error($terms)) ? wp_list_pluck($terms, 'slug') : [];

        $active_menu = isset($_GET['active']) ? $_GET['active'] : '';

        $show_hair = in_array('hair', $registered_menus);
        $show_eyelash = in_array('eyelash', $registered_menus);
        $show_nail = in_array('nail', $registered_menus);
        $show_esthe = in_array('esthe', $registered_menus);
        $show_headspa = in_array('headspa', $registered_menus);
        $show_terracespa = in_array('terracespa', $registered_menus);
        $show_hills = in_array('hills', $registered_menus);
        $show_lounge = in_array('lounge', $registered_menus);
        $show_sparesort = in_array('sparesort', $registered_menus);
        $show_gardenvilla = in_array('gardenvilla', $registered_menus);
        ?>

    <!-- <div id="menu" class="pt-12 w-full mx-auto pb-24">
        <div class="menu__wrapper">
            <?php
            $all_menus = ["hair", "eyelash", "nail", "esthe", "headspa"];
            ?>

            <?php if ($show_hair) : ?>
                <dl class="menu__list">
                    <dt class="flex mx-auto items-center relative pt-11 pb-9">
                        <p class="text-4">HAIR</p>
                        <span class="text-2 block">ヘア</span>
                    </dt>

                    <dd class="pt-5">
                        <div class="menu__content">

                                <ul class="flex flex-wrap mb-8">
                                        
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                                CUT
                                                <span>シャンプー + スタイリング付</span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline">
                                                <p>カット</p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <span class="price">￥5,500</span>
                                                    </span>
                                                </div>
                                            </div>

                                            <p class="notes">
                                                初回ご利用の場合はランク料金はかかりません<br>
                                                スクール割引　中高校生 ￥550 OFF／ジュニア（小学生以下）￥1,100 OFF<br>
                                                ディレクター +¥550　クリエイティブディレクター　+　¥1100 UP
                                            </p>
                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                                COLOR
                                                <span>シャンプー付 ／ブロー料金別</span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>グレイカラー<span>暗めの白髪染めです</span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2"><span class="price">￥5,940</span></span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                カラー（イルミナカラー）
                                                    <span>イルミナカラーを使用するカラーです　<br class="sp">肌やライフワークに合わせたオシャレ染めです</span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥7,150</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                プレミアムカラー
                                                <span>ランクアップのツヤと質感で頭皮と<br class="sp">髪に負担が少ないオシャレ染めです</span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥8,800</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                ケアブリーチ<br class="sp">（リタッチ・フル同じ）
                                                <span>ファイバープレックストリートメント込みです　※2回目フルブリーチ ¥8,800</span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥15,400</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                ポイントブリーチ
                                                <span>イヤリングカラーetc…</span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥7,150</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p class="single">
                                                インナーカラー部分にのみ<br class="sp">オンカラー
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥5,170</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                ダブルカラー
                                                <span>ブリーチを１回してからもう一度染ます　<br class="sp">発色の良い透明感溢れるカラーに仕上がります</span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥23,430</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                ハイライト＆ローライト
                                                <span>※ハイライト＆ローライトのみは<br class="sp">シャンプー・ブロー料金別</span>
                                                </p>
                                                <div class="menu__content--price">
                                                    <div class="menu__content--item flex justify-end items-baseline">
                                                        <span class="text-2">
                                                            <span class="small"><セレクト>1セクション　10枚まで</span>
                                                        </span>
                                                    </div>
                                                    <div class="menu__content--item flex justify-end items-baseline">
                                                        <span class="text-2">
                                                            <span class="small"><ハーフ>2セクション　20枚まで</span>
                                                        </span>
                                                    </div>
                                                    <div class="menu__content--item flex justify-end items-baseline">
                                                        <span class="text-2">
                                                            <span class="small"><フル>3セクション　20枚以上</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="second__list flex items-baseline">
                                                <p class="single">
                                                ヘアマニキュア<br class="sp">（スキャルプカラー付き）
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥7,700</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                スキャルプカラー
                                                <span>地肌に直接カラーをつけない<br class="sp">コームテクニックです</span>
                                                </p>
                                                <div class="menu__content--price">
                                                    <div class="menu__content--item flex justify-end items-baseline">
                                                        <span class="text-2">
                                                            <span class="small">各アートコース</span>
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p class="single">
                                                ヘナ
                                                <span>植物由来のカラーで頭皮と<br class="sp">髪の負担を減らします</span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                    ￥7,150
                                                    </span>
                                                </div>
                                            </div>

                                            <p class="notes notes--right">
                                            ※M ¥550　L ¥1,100　LL ¥1,650　LLL ¥2,200　UP
                                            </p>
                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline premium">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                                PERM
                                                <span>カット + スタイリング付</span>
                                            </b>
                                            <div class="menu__content--price flex justify-between items-baseline premium__price ">
                                                <span class="text-2">ノーマル</span>
                                                <span class="text-2">プレミアム</span>
                                            </div>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ナチュラルパーマ<span>髪の質感を柔らかく<br class="sp">見せるパーマです</span></p>
                                                <div class="menu__content--price flex justify-between items-baseline two-price">
                                                    <span class="text-2">￥11,550</span>
                                                    <span class="text-2">￥14,300</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>デザインパーマ<span>ウェーブ・カールなど<br class="sp">毛先に動きをつけるパーマです</span></p>
                                                <div class="menu__content--price flex justify-between items-baseline two-price">
                                                    <span class="text-2">￥12,100</span>
                                                    <span class="text-2">￥15,400</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ポイントカール<br class="sp">（部分パーマ）<span>（カット＆スタイリング別）</span></p>
                                                <div class="menu__content--price flex justify-between items-baseline two-price">
                                                    <span class="text-2">￥3,300〜</span>
                                                    <span class="text-2">￥4,400〜</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>テクニックパーマ<span>ツイスト・ピンパーマetc…　<br class="sp">※デザインにより値段が変動します</span></p>
                                                <div class="menu__content--price flex justify-between items-baseline two-price">
                                                    <span class="text-2">￥11,000〜</span>
                                                    <span class="text-2">￥13,200〜</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ストレートパーマ<span>パーマを落としたり、癖っ毛を緩くするメニューです　<br class="sp">アイロンなしの施術になります</span></p>
                                                <div class="menu__content--price flex justify-between items-baseline two-price">
                                                    <span class="text-2">￥11,400〜</span>
                                                    <span class="text-2">￥14,300〜</span>
                                                </div>

                                            </div>

                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            STRAIGHT
                                                <span>カット + スタイリング付</span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>縮毛矯正／<br class="sp">ファーバーストレート<span>アイロンによる熱ダメージを抑制する成分が配合されているので柔らかさを保ちつつ、クセをしっかり伸ばしダメージも最小限に抑えます</span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2"><span class="price">￥22,440</span></span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                縮毛矯正／<br class="sp">ファイバーストカール
                                                    <span>毛先が自然な仕上がりに。コテを使ってスタイリングする方にもオススメです</span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥26,400</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                ハーフコース
                                                </p>

                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                前髪のみ
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">各コースの半額（カット・長さ料金別）</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                顔まわり（耳よりフロント）
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2"></span>
                                                </div>
                                            </div>

                                            <p class="notes notes--right">
                                                ※M ￥550　L ￥1,100　LL ￥1,650　LLL ￥2,200　UP<br>
                                                ※クリエイティブディレクター￥2,200 　　ディレクター￥1,650　<br class="sp">トップスタイリスト￥1,100　スタイリスト￥550　UP
                                            </p>
                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            TREATMENT
                                                <span></span>
                                            </b>
                                            <div class="menu__content--price flex justify-between items-baseline premium__price">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">通常料金</span>
                                                </div>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ファイバーグルー<br class="sp">（事前処理）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥880</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>マグネットトリートメント（事前処理）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥1,650</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>リジュライト（事前処理）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥1,100</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>リジュノーマル<br class="sp">（アフタートリートメント）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥2,750</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>リジュエクストラ<br class="sp">（事前処理＆アフタートリートメント）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥3,850</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>リジュプレミアム<br class="sp">（事前処理＆中間処理＆アフタートリートメント）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥4,950</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>トステア<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥4,950</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>酸熱美髪トリートメント<span>髪質に合わせたトリートメント 5 種類を7STEPで行います。アイロンを使いしっかり補修します</span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥9,350</span>
                                                </div>

                                            </div>
                                            <p class="notes notes--right">
                                                ※L ￥550　LL ￥1,100　LLL ￥1,650　UP                                           
                                            </p>

                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline ">
                                            OTHERS
                                                <span></span>
                                            </b>
                                            <div class="menu__content--price flex justify-between items-baseline premium__price">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">通常料金</span>
                                                </div>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>シャンプー<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥550</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>スタイリング<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥1,650</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>セット（アレンジ）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥4,400</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>アップセット<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥6,600</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>メイク<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥3,850</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>アイブローカット<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥1,100</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>電動バリブラシ<br class="sp">（クイックアルファ）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥1,650〜</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>着付（留袖・振袖）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥8,800</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>着付（袴）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥7,700</span>
                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>着付（浴衣）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2">￥5,500</span>
                                                </div>

                                            </div>
                                            <p class="notes">
                                                ※成人式、前撮りの料金は異なります<br>
                                                ※お子様の着付は受け付けておりません<br>
                                                ※アップセット/メイクは営業時間外のみの受付とさせて頂いております                                          
                                            </p>

                                        </div>

                                    </li>

                                </ul>


                        </div>
                        

                        <div class="menu__salon mx-auto pt-14 pb-24">
                            <div class="menu__salon--ttl mb-10">
                                <h3 class="sec__ttl--big mb-5">
                                    SALONS
                                </h3>
                                <p class="text-center text-2">ヘアメニューが利用可能な店舗</p>
                            </div>

                            <ul class="menu__list flex justify-between w-full flex-wrap">

                            <?php
                                $paged = get_query_var('paged') ? get_query_var('paged') : 1;

                                $args = array(
                                    'post_type'      => 'tophair-salon', // カスタム投稿タイプ
                                    'posts_per_page' => -1, // 1ページに表示する記事数
                                    'post_status'    => 'publish',
                                    'paged'          => $paged,
                                    'tax_query'      => array(
                                        array(
                                            'taxonomy' => 'tophair_menu', // タクソノミー名
                                            'field'    => 'slug', // タームの指定方法（'slug' or 'term_id'）
                                            'terms'    => 'hair', // 出力したいタクソノミーのスラッグ
                                        ),
                                    ),
                                );

                                $my_query = new WP_Query($args); // クエリの実行

                                if ($my_query->have_posts()) :
                                    while ($my_query->have_posts()) : $my_query->the_post();
                                        // 投稿の内容を出力
                                        ?>
                                <li class="menu__list--items mb-5.5">
                                    <a href="<?php the_permalink();?>" class="">
                                        <div class="thumb bg mb-2" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>)"></div>
                                        <p class="text-center text-2"><?php the_title();?></p>
                                    </a>
                                </li>
                                <?php
                                endwhile;
                                else :
                                    echo '<p>該当する店舗が見つかりません。</p>';
                                endif;
                                wp_reset_postdata(); // クエリのリセット
                            ?>

                            </ul>
                        </div>
                    </dd>
                </dl>
            <?php endif; ?>
            <?php if ($show_nail) : ?>
                <dl class="menu__list">
                    <dt class="flex mx-auto items-center relative pt-11 pb-9">
                        <p class="text-4">NAIL</p>
                        <span class="text-2 block">ネイル</span>
                    </dt>

                    <dd class="pt-5">
                        <div class="menu__content">

                                <ul class="flex flex-wrap mb-8">
                                        
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            GEL NAIL
                                                <span>ジェルネイル</span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ワンカラー<span>（サロンにあるカラーでワンカラーorグラデーションシンプルがお好きな方やお急ぎの方にお勧めです）</span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2"><span class="price">￥5,500</span></span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                オーダーワンカラー
                                                    <span>（似合わせカラーを調合して作り、ワンカラーorグラデーション自分だけのネイルがしたい方にお勧めです）</span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥6,600</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                ワンカラープラス
                                                <span>（上記カラーにラメ・ストーン・ミラー・色替えなどをプラスしてシンプルだけど少しデザインを入れたい方にお勧めです）</span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥1,100</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                アートコース
                                                <span>（上記カラーにデザインを4～6本入れたネイルおしゃれなネイルを楽しみたい方にお勧めです）</span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥11,000</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                アートプラスコース
                                                <span>（10本のフルデザインネイル左右違うデザインなど個性的なネイルにしたい方にお勧めです）</span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥11,550</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p class="single">
                                                長さ出し
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2 mr-1.5">
                                                        <small>1本</small>￥550
                                                    </span>
                                                    <span class="text-2">
                                                        <small>10本</small>￥3,300
                                                    </span>
                                                </div>
                                            </div>

                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            CARE
                                                <span>ケア</span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ケア<span>（整爪・甘皮処理・バッフィング・マッサージ）</span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>45分</small>
                                                        <span class="price">￥2,750</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>フットケア ハーフ<span>（整爪・甘皮処理・角質ケア）</span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">￥4,400</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>フットケア フル<span>（整爪・甘皮処理・角質ケア・バッフィング・マッサージ）</span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>60分</small>
                                                        <span class="price">￥7,700</span>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            PARAGEL
                                                <span>パラジェル</span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>HILLS・Lounge店のみ</p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <span class="price">ジェルネイル同料金</span>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>

                                        
                                    </li>

                                </ul>


                        </div>
                        

                        <div class="menu__salon mx-auto pt-14 pb-24">
                            <div class="menu__salon--ttl mb-10">
                                <h3 class="sec__ttl--big mb-5">
                                    SALONS
                                </h3>
                                <p class="text-center text-2">ネイルメニューが利用可能な店舗</p>
                            </div>

                            <ul class="menu__list flex justify-between w-full flex-wrap">

                            <?php
                                $paged = get_query_var('paged') ? get_query_var('paged') : 1;

                                $args = array(
                                    'post_type'      => 'tophair-salon', // カスタム投稿タイプ
                                    'posts_per_page' => -1, // 1ページに表示する記事数
                                    'post_status'    => 'publish',
                                    'paged'          => $paged,
                                    'tax_query'      => array(
                                        array(
                                            'taxonomy' => 'tophair_menu', // タクソノミー名
                                            'field'    => 'slug', // タームの指定方法（'slug' or 'term_id'）
                                            'terms'    => 'nail', // 出力したいタクソノミーのスラッグ
                                        ),
                                    ),
                                );

                                $my_query = new WP_Query($args); // クエリの実行

                                if ($my_query->have_posts()) :
                                    while ($my_query->have_posts()) : $my_query->the_post();
                                        // 投稿の内容を出力
                                        ?>
                                <li class="menu__list--items mb-5.5">
                                    <a href="<?php the_permalink();?>" class="">
                                        <div class="thumb bg mb-2" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>)"></div>
                                        <p class="text-center text-2"><?php the_title();?></p>
                                    </a>
                                </li>
                                <?php
                                endwhile;
                                else :
                                    echo '<p>該当する店舗が見つかりません。</p>';
                                endif;
                                wp_reset_postdata(); // クエリのリセット
                            ?>

                            </ul>
                        </div>
                    </dd>
                </dl>            
            <?php endif; ?>
            <?php if ($show_eyelash) : ?>
                <dl class="menu__list">
                    <dt class="flex mx-auto items-center relative pt-11 pb-9">
                        <p class="text-4">EYELASH</p>
                        <span class="text-2 block">アイラッシュ</span>
                    </dt>

                    <dd class="pt-5">
                        <div class="menu__content">

                                <ul class="flex flex-wrap mb-8">
                                        
                                    <li class=" mb-5.5 w-full justify-between items-baseline">

                                        <div class="second second--show">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>アイラッシュ／60本</p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2"><span class="price">￥8,580</span></span>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="second second--show">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>アイラッシュ／80本</p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2"><span class="price">￥11,440</span></span>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="second second--show">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>アイラッシュ／100本</p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2"><span class="price">￥14,300</span></span>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="second second--show">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>カラーエクステンション</p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2"><span class="price">+￥2,200</span></span>
                                                </div>
                                            </div>


                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">

                                        <div class="second second--show">
                                            <div class="second__list flex items-baseline non-border" data-mh="group-name">
                                                <p>ご来店時の注意事項
                                                    <span class=" mt-2 leading-loose">
                                                        ・マスカラ・ビューラーはせずにご来店ください<br>
                                                        　※エクステンションのモチが悪くなる原因となりますのでご注意ください<br>
                                                        ・コンタクトレンズのご使用の場合は保存ケース、またはメガネをご持参ください<br>
                                                        　※メガネの使用時間が長い方はエクステの長さを調節いたしますので、必ずお持ちください<br>
                                                        ・施術後、最低４時間はクレンジングをお控え下さい
                                                    </span>
                                                </p>

                                            </div>

                                        </div>

                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">

                                        <div class="second second--show">
                                            <div class="second__list flex items-baseline non-border" data-mh="group-name">
                                                <p>施術前確認事項
                                                    <span class=" mt-2 leading-loose">
                                                    ・他店のエクステがついている方<br>
                                                    お店によって使用しているグルー(接着剤)の種類が違い、グルー同士の相性があるので、中には有毒ガスが発生する場合もございます。他店のエクステはすべて外してから装着させて頂いております。<br>
                                                    ※エクステンションオフ代として別途￥4,000がかかります。<br>
                                                    ・２ヶ月以内にまつげパーマをされた方<br>
                                                    まつげパーマが残っていると外れやすく、仕上がりにバラつきが生じます。<br>
                                                    どうしてもされたい方はスタッフまでご相談ください。<br>
                                                    ・アートメイク・レーシックを2ヶ月以内にされた方、妊娠中の方<br>
                                                    施術をお受けできません。
                                                    </span>
                                                </p>

                                            </div>

                                        </div>

                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">

                                        <div class="second second--show">
                                            <div class="second__list flex items-baseline non-border" data-mh="group-name">
                                                <p>アフターケア
                                                    <span class=" mt-2 leading-loose">
                                                        ・グルー（接着剤）が完全に乾くまで約６時間かかるため、その間に洗顔やプール・まつげに触れることがないようにしてください。<br>
                                                        ・エクステンションは油分に弱いため、オイルクレンジングなど油分を含んだものはお避けください。<br>
                                                        ・うつ伏せで寝ないようにお願いいたします。<br>
                                                        ・市販のマスカラはご利用いただけません。専用のコーティングマスカラをお薦めしております。<br>
                                                        ・ビューラーはご使用にならないようにお願いいたします。<br>
                                                        ・プール・サウナを頻繁にご利用される方は油分や熱の影響により、利用されない方に比べてエクステンションが取れやすくなりますのでご注意をお願いいたします。
                                                    </span>
                                                </p>

                                            </div>

                                        </div>

                                    </li>


                                </ul>


                        </div>
                        

                        <div class="menu__salon mx-auto pt-14 pb-24">
                            <div class="menu__salon--ttl mb-10">
                                <h3 class="sec__ttl--big mb-5">
                                    SALONS
                                </h3>
                                <p class="text-center text-2">アイラッシュメニューが利用可能な店舗</p>
                            </div>

                            <ul class="menu__list flex justify-between w-full flex-wrap">

                            <?php
                                $paged = get_query_var('paged') ? get_query_var('paged') : 1;

                                $args = array(
                                    'post_type'      => 'tophair-salon', // カスタム投稿タイプ
                                    'posts_per_page' => -1, // 1ページに表示する記事数
                                    'post_status'    => 'publish',
                                    'paged'          => $paged,
                                    'tax_query'      => array(
                                        array(
                                            'taxonomy' => 'tophair_menu', // タクソノミー名
                                            'field'    => 'slug', // タームの指定方法（'slug' or 'term_id'）
                                            'terms'    => 'eyelash', // 出力したいタクソノミーのスラッグ
                                        ),
                                    ),
                                );

                                $my_query = new WP_Query($args); // クエリの実行

                                if ($my_query->have_posts()) :
                                    while ($my_query->have_posts()) : $my_query->the_post();
                                        // 投稿の内容を出力
                                        ?>
                                <li class="menu__list--items mb-5.5">
                                    <a href="<?php the_permalink();?>" class="">
                                        <div class="thumb bg mb-2" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>)"></div>
                                        <p class="text-center text-2"><?php the_title();?></p>
                                    </a>
                                </li>
                                <?php
                                endwhile;
                                else :
                                    echo '<p>該当する店舗が見つかりません。</p>';
                                endif;
                                wp_reset_postdata(); // クエリのリセット
                            ?>

                            </ul>
                        </div>
                    </dd>
                </dl>            
            <?php endif; ?>
            <?php if ($show_headspa) : ?>
                <dl class="menu__list">
                    <dt class="flex mx-auto items-center relative pt-11 pb-9">
                        <p class="text-4">HEAD SPA</p>
                        <span class="text-2 block">ヘッドスパ</span>
                    </dt>

                    <dd class="pt-5">
                        <div class="menu__content">

                                <ul class="flex flex-wrap mb-8">
                                        
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            SPA
                                                <span>スパ</span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>Scalp spa<span>頭皮の奥の汚れや皮脂などの老廃物を取り除いていくディープクレンジングです。</span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2"><span class="price">￥5,500</span></span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                Relaxation spa
                                                    <span>マッサージにより、血液循環・リンパの流れを促進し老廃物を排出させます。頭皮のコリ・むくみをじっくりほぐしていきます。</span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥6,600</span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                Aging Head spa
                                                <span>頭皮のコリ、首筋をほぐすことによって、頭皮が持ち上がりたるみを解消され、お顔のたるみが自然に解消されます。</span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">￥1,100</span>
                                                </div>
                                            </div>
                                            

                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            Option Menu
                                                <span>オプション</span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ハンドマッサージ<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>20分</small>
                                                        <span class="price">￥2.200</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>フェイスツボ押し<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>10分</small>
                                                        <span class="price">￥1,100</span>
                                                    </span>
                                                </div>
                                            </div>



                                        </div>

                                        
                                    </li>
                                
                                </ul>


                        </div>
                        

                        <div class="menu__salon mx-auto pt-14 pb-24">
                            <div class="menu__salon--ttl mb-10">
                                <h3 class="sec__ttl--big mb-5">
                                    SALONS
                                </h3>
                                <p class="text-center text-2">ヘッドスパメニューが利用可能な店舗</p>
                            </div>

                            <ul class="menu__list flex justify-between w-full flex-wrap">

                            <?php
                                $paged = get_query_var('paged') ? get_query_var('paged') : 1;

                                $args = array(
                                    'post_type'      => 'tophair-salon', // カスタム投稿タイプ
                                    'posts_per_page' => -1, // 1ページに表示する記事数
                                    'post_status'    => 'publish',
                                    'paged'          => $paged,
                                    'tax_query'      => array(
                                        array(
                                            'taxonomy' => 'tophair_menu', // タクソノミー名
                                            'field'    => 'slug', // タームの指定方法（'slug' or 'term_id'）
                                            'terms'    => 'headspa', // 出力したいタクソノミーのスラッグ
                                        ),
                                    ),
                                );

                                $my_query = new WP_Query($args); // クエリの実行

                                if ($my_query->have_posts()) :
                                    while ($my_query->have_posts()) : $my_query->the_post();
                                        // 投稿の内容を出力
                                        ?>
                                <li class="menu__list--items mb-5.5">
                                    <a href="<?php the_permalink();?>" class="">
                                        <div class="thumb bg mb-2" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>)"></div>
                                        <p class="text-center text-2"><?php the_title();?></p>
                                    </a>
                                </li>
                                <?php
                                endwhile;
                                else :
                                    echo '<p>該当する店舗が見つかりません。</p>';
                                endif;
                                wp_reset_postdata(); // クエリのリセット
                            ?>

                            </ul>
                        </div>
                    </dd>
                </dl>            
            <?php endif; ?>
            <?php if ($show_terracespa) : ?>
                <dl class="menu__list">
                    <dt class="flex mx-auto items-center relative pt-11 pb-9">
                        <p class="text-4">ESTHE</p>
                        <span class="text-2 block">エステ</span>
                    </dt>

                    <dd class="pt-5 pb-14">
                        <div class="menu__content">

                                <ul class="flex flex-wrap">
                                        
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            TERRACE SPA
                                                <span></span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>フェイシャル・ケア（顔）<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>45分</small>
                                                        <span class="price">￥6,600</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                松やにパック（顔＋首）
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>90分</small>
                                                        <span class="price">￥8,360</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                骨盤矯正
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>40分</small>
                                                        <span class="price">￥5,500</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline　non-border">
                                                <p>
                                                肩
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>10分</small>
                                                        <span class="price">￥1,100</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline non-border">
                                                <p>
                                                
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                <span class="text-2">
                                                        <small>20分</small>
                                                        <span class="price">￥2,200</span>
                                                    </span>

                                                </div>
                                            </div>
                                            

                                        </div>

                                        
                                    </li>

                                
                                </ul>


                        </div>
                        


                    </dd>
                </dl>
            <?php endif; ?> 
            <?php if ($show_hills) : ?>
                <dl class="menu__list">
                    <dt class="flex mx-auto items-center relative pt-11 pb-9">
                        <p class="text-4">ESTHE</p>
                        <span class="text-2 block">エステ</span>
                    </dt>

                    <dd class="pt-5 pb-14">
                        <div class="menu__content">

                                <ul class="flex flex-wrap">
                                        
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            フェイシャル
                                                <span></span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>フェイシャル・ケア（顔）<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>120分</small>
                                                        <span class="price">¥11,000~</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                松やに【ベッド】
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>120分</small>
                                                        <span class="price">¥11,000~</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                松やに【椅子】
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>90分</small>
                                                        <span class="price">¥7,260</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                松やに【セルフ】
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>90分</small>
                                                        <span class="price">¥3,960</span>
                                                    </span>

                                                </div>
                                            </div>
                                            

                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            ボディ
                                                <span></span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ハレクラニSPA<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>45分</small>
                                                        <span class="price">¥5,500</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                筋ゆる
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>16分</small>
                                                        <span class="price">¥3,300</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                骨盤矯正
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>60分</small>
                                                        <span class="price">¥5,500</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                アロマオイルフットマッサージ
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥3,360</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                経路ヘッドマッサージ
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥2,750</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                指圧マッサージ
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥3,300</span>
                                                    </span>

                                                </div>
                                            </div>
                                            

                                        </div>

                                        
                                    </li>

                                
                                </ul>


                        </div>
                        


                    </dd>
                </dl>
            <?php endif; ?> 
            <?php if ($show_lounge) : ?>
                <dl class="menu__list">
                    <dt class="flex mx-auto items-center relative pt-11 pb-9">
                        <p class="text-4">ESTHE</p>
                        <span class="text-2 block">エステ</span>
                    </dt>

                    <dd class="pt-5 pb-14">
                        <div class="menu__content">

                                <ul class="flex flex-wrap">
                                        
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            フェイシャル
                                                <span></span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ベーシック・ケア<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>45分</small>
                                                        <span class="price">¥6,600</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                美白ケアⅠ
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>65分</small>
                                                        <span class="price">¥9,735</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                美白ケアⅡ
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>90分</small>
                                                        <span class="price">¥12,485</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                リフトアップ・ケアⅠ
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>65分</small>
                                                        <span class="price">¥10,835</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                リフトアップ・ケアⅡ
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>90分</small>
                                                        <span class="price">¥13,585</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                ハリと美白のスペシャル・ケア
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>110分</small>
                                                        <span class="price">¥14,685</span>
                                                    </span>

                                                </div>
                                            </div>
                                            

                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            フェイシャルオプション
                                                <span></span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ハンドマッサージ<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>20分</small>
                                                        <span class="price">¥2,200</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p><span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>10分</small>
                                                        <span class="price">¥1,100</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                デコルテマッサージ
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥4,070</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline non-border" data-mh="group-name">
                                                <p>
                                                
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>15分</small>
                                                        <span class="price">¥2,035</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                フットマッサージ
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥3,630</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                背中マッサージ
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥3,850</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline non-border">
                                                <p>
                                                
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>45分</small>
                                                        <span class="price">¥5,500</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                炭酸DSパック
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <span class="price">¥1,100</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                メリハリ3D パック
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <span class="price">¥1,650</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                超音波クレンジング
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <span class="price">¥2,200</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                リンパ美顔器
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <span class="price">¥2,200</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                経絡ヘッドマッサージ
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>20分</small>
                                                        <span class="price">¥2,750</span>
                                                    </span>

                                                </div>
                                            </div>
                                            

                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            ボディ
                                                <span></span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>フットマッサージ<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥3,630</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p><span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>60分</small>
                                                        <span class="price">¥7,150</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                デコルテマッサージ
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥4,070</span>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="second__list flex items-baseline">
                                                <p>
                                                アロマオイルマッサージ
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>60分</small>
                                                        <span class="price">¥7,150</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>90分</small>
                                                        <span class="price">¥10,230</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                背中（腰から肩、首まで）
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>45分</small>
                                                        <span class="price">¥5,500</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                ハンドマッサージ
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>20分</small>
                                                        <span class="price">¥2,200</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                角質ケア（足裏のみ）
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥3,630</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>50分</small>
                                                        <span class="price">¥6,050</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                筋ゆるマッサージ（全身）
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥3,300</span>
                                                    </span>

                                                </div>
                                            </div>
                                        </div>

                                        
                                    </li>

                                
                                </ul>


                        </div>
                        

                    </dd>
                </dl>
            <?php endif; ?> 
            <?php if ($show_sparesort) : ?>
                <dl class="menu__list">
                    <dt class="flex mx-auto items-center relative pt-11 pb-9">
                        <p class="text-4">ESTHE</p>
                        <span class="text-2 block">エステ</span>
                    </dt>

                    <dd class="pt-5 pb-14">
                        <div class="menu__content">

                                <ul class="flex flex-wrap">
                                        
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            フェイシャル
                                                <span></span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ベーシック・ケア<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>45分</small>
                                                        <span class="price">¥6,600</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                リフトアップ・ケア
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>65分</small>
                                                        <span class="price">¥10,835</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                美白ケア
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>65分</small>
                                                        <span class="price">¥9,735</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                リフトアップ・ケア
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>90分</small>
                                                        <span class="price">¥14,300</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                背中のトリートメントケア
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>60分</small>
                                                        <span class="price">¥8,250</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                スペシャル・ケア
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>110分</small>
                                                        <span class="price">¥17,050</span>
                                                    </span>

                                                </div>
                                            </div>
                                            

                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            フェイシャルオプション
                                                <span></span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ハンドマッサージ<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <small>20分</small>
                                                        <span class="price">¥2,200</span>
                                                    </span>
                                                    <span class="text-2">
                                                        <small>10分</small>
                                                        <span class="price">¥1,100</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>デコルテマッサージ<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥4,070</span>
                                                    </span>
                                                    <span class="text-2">
                                                        <small>15分</small>
                                                        <span class="price">¥2,035</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                フットマッサージ
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥3,630</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                背中マッサージ
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥3,850</span>
                                                    </span>
                                                    <span class="text-2">
                                                        <small>45分</small>
                                                        <span class="price">¥5,500</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                経路ヘッド
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>20分</small>
                                                        <span class="price">¥2,750</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                炭酸DSパック
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small></small>
                                                        <span class="price">¥1,100</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                メリハリ3D パック
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small></small>
                                                        <span class="price">¥1,650</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                背中ケア
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <span class="price">¥3,850</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                超音波クレンジング
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <span class="price">¥2,200</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                リンパ美顔器
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <span class="price">¥2,200</span>
                                                    </span>

                                                </div>
                                            </div>
                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline premium">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                                ボディ
                                                <span></span>
                                            </b>
                                            <div class="menu__content--price flex justify-between items-baseline premium__price">
                                                    <span class="text-2">ノーマル</span>
                                                    <span class="text-2">プレミアム</span>
                                                </div>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>フットマッサージ<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>30分</small>
                                                            <span>¥3,630</span>
                                                        </div>
                                                        <div class="flex justify-start items-baseline">
                                                            <small>60分</small>
                                                            <span>¥7,150</span>
                                                        </div>
                                                    </span>

                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>アロマオイルマッサージ<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>60分</small>
                                                            <span>¥7,150</span>
                                                        </div>
                                                        <div class="flex justify-start items-baseline">
                                                            <small>90分</small>
                                                            <span>¥10,230</span>
                                                        </div>
                                                    </span>

                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>背中（腰から肩、首まで）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <div class="flex justify-start items-baseline">
                                                        <small>45分</small>
                                                        <span>¥5,500</span>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>角質ケア（足裏のみ）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <div class="flex justify-between items-baseline">
                                                            <small>30分</small>
                                                            <span>¥3,630</span>
                                                        </div>
                                                        <div class="flex justify-between items-baseline">
                                                            <small>50分</small>
                                                            <span>¥6,050</span>
                                                        </div>
                                                    </span>

                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ハンドマッサージ<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <small>20分</small>
                                                        <span>¥2,200</span>
                                                    </span>

                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>リンパドレナージュコース<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>60分</small>
                                                            <span>¥9,900</span>
                                                        </div>
                                                        <div class="flex justify-start items-baseline">
                                                            <small>90分</small>
                                                            <span>¥14,850</span>
                                                        </div>
                                                        <div class="flex justify-start items-baseline">
                                                            <small>120分</small>
                                                            <span>¥19,800</span>
                                                        </div>
                                                    </span>
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>60分</small>
                                                            <span>¥7,920</span>
                                                        </div>
                                                        <div class="flex justify-start items-baseline">
                                                            <small>90分</small>
                                                            <span>¥10,395</span>
                                                        </div>
                                                        <div class="flex justify-start items-baseline">
                                                            <small>120分</small>
                                                            <span>¥13,860</span>
                                                        </div>
                                                    </span>

                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>デコルテマッサージ<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span>¥4,070</span>
                                                    </span>

                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>筋ゆるマッサージ（全身）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span>¥2,200</span>
                                                    </span>

                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>指圧マッサージ（着衣）<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>30分</small>
                                                            <span>¥3,300</span>
                                                        </div>
                                                        <div class="flex justify-start items-baseline">
                                                            <small>60分</small>
                                                            <span>¥6,600</span>
                                                        </div>
                                                    </span>

                                                </div>

                                            </div>
                                        </div>

                                        
                                    </li>

                                
                                </ul>


                        </div>
                        

                    </dd>
                </dl>
            <?php endif; ?> 
            <?php if ($show_gardenvilla) : ?>
                <dl class="menu__list">
                    <dt class="flex mx-auto items-center relative pt-11 pb-9">
                        <p class="text-4">ESTHE</p>
                        <span class="text-2 block">エステ</span>
                    </dt>

                    <dd class="pt-5 pb-14">
                        <div class="menu__content">

                                <ul class="flex flex-wrap">
                                        
                                    <li class=" mb-5.5 w-full justify-between items-baseline premium">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline ">
                                                フェイシャル
                                                <span></span>
                                            </b>
                                            <div class="menu__content--price flex justify-between items-baseline premium__price">
                                                <span class="text-2">ノーマル</span>
                                                <span class="text-2">プレミアム</span>
                                            </div>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>美白ケア<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline two-price">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>60分</small>
                                                            <span>¥6,600</span>
                                                        </div>
                                                    </span>

                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>リフトアップ・ケア<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline two-price">
                                                    <span class="text-2">

                                                        <div class="flex justify-start items-baseline">
                                                            <small>60分</small>
                                                            <span>¥6,600</span>
                                                        </div>
                                                    </span>

                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>スペシャル・ケア<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline two-price">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>80分</small>
                                                            <span>¥12,100</span>
                                                        </div>
                                                    </span>
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>80分</small>
                                                            <span>¥8,800</span>
                                                        </div>
                                                    </span>

                                                </div>

                                            </div>
                                        </div>

                                        
                                    </li>


                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            フェイシャルオプション
                                                <span></span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>3GFパック<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">

                                                    <span class="text-2">
                                                        <small></small>
                                                        <span class="price">¥1,100</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>筋肉マッサージ<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small></small>
                                                        <span class="price">¥1,100</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                経絡ヘッドマッサージ
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small></small>
                                                        <span class="price">¥2,750</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                デコルテ
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small></small>
                                                        <span class="price">¥1,100</span>
                                                    </span>
 
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline">
                                                <p>
                                                超音波毛穴洗浄
                                                <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small></small>
                                                        <span class="price">¥2,200</span>
                                                    </span>
                                                </div>
                                            </div>

                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                            ボディ
                                                <span></span>
                                            </b>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                    マシンによる超音波の効果
                                                    <span class="mt-2 leading-loose">
                                                        ・低周波…新陳代謝を高めるのでシミ・シワ・たるみ等に大きな効果を期待できます。<br>
                                                        ・中周波…振動が3cm深く入り、ほぐしたりやわらかくしたり筋肉運動させるので部分痩せできます。<br>
                                                        ・超音波…皮下脂肪を分解し、すぐ隣の筋肉によって燃えて熱になります。
                                                    </span>
                                                </p>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ヒーリング(背中）<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥4,400</span>
                                                    </span>

                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                ウエスト
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥4,400</span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>
                                                フット
                                                    <span></span>
                                                </p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <small>30分</small>
                                                        <span class="price">¥4,400</span>
                                                    </span>
 
                                                </div>
                                            </div>


                                        </div>

                                        
                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                                ボディDETOX
                                                <span></span>
                                            </b>
                                            <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2"></span>
                                                </div>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>ゲルマドーム<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>30分</small>
                                                            <span>¥3,300</span>
                                                        </div>

                                                    </span>

                                                </div>

                                            </div>
                                        </div>

                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                                ボディオプション
                                                <span></span>
                                            </b>
                                            <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2"></span>
                                                </div>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>セル（セルライト除去）<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>10分</small>
                                                            <span>¥2,200</span>
                                                        </div>

                                                    </span>

                                                </div>

                                            </div>
                                        </div>

                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline premium">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                                スペシャルコース
                                                <span></span>
                                            </b>
                                            <div class="menu__content--price flex justify-between items-baseline">
                                                <span class="text-2">ノーマル</span>
                                                <span class="text-2">プレミアム</span>
                                            </div>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>背中・フット+ゲルマドーム<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>90分</small>
                                                            <span>¥12,100</span>
                                                        </div>
                                                    </span>
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small></small>
                                                            <span>¥8,470</span>
                                                        </div>
                                                    </span>

                                                </div>

                                            </div>

                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>背中・フット+ゲルマドーム+セル<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>100分</small>
                                                            <span>¥14,300</span>
                                                        </div>
                                                    </span>
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small></small>
                                                            <span>¥10,010</span>
                                                        </div>
                                                    </span>

                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>背中・ウエスト・フット+ゲルマドーム<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>120分</small>
                                                            <span>¥16,500</span>
                                                        </div>
                                                    </span>
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small></small>
                                                            <span>¥11,550</span>
                                                        </div>
                                                    </span>

                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>背中・ウエスト・フット+ゲルマドーム+セル<span></span></p>
                                                <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>130分</small>
                                                            <span>¥18,700</span>
                                                        </div>
                                                    </span>
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small></small>
                                                            <span>¥13,090</span>
                                                        </div>
                                                    </span>

                                                </div>

                                            </div>
                                        </div>

                                    </li>
                                    <li class=" mb-5.5 w-full justify-between items-baseline">
                                        <div class="first flex item-center">
                                            <b class="block font-normal text-4 items-baseline">
                                                ボディマッサージ(オールハンド・着衣）
                                                <span></span>
                                            </b>
                                            <div class="menu__content--price flex justify-between items-baseline">
                                                    <span class="text-2"></span>
                                                    <span class="text-2"></span>
                                                </div>

                                        </div>
                                        <div class="second">
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>筋ゆるマッサージ<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>30分</small>
                                                            <span>¥3,300</span>
                                                        </div>

                                                    </span>

                                                </div>

                                            </div>
                                            <div class="second__list flex items-baseline" data-mh="group-name">
                                                <p>指圧マッサージ<span></span></p>
                                                <div class="menu__content--price flex justify-end items-baseline">
                                                    <span class="text-2">
                                                        <div class="flex justify-start items-baseline">
                                                            <small>30分</small>
                                                            <span>¥3,300</span>
                                                        </div>

                                                    </span>

                                                </div>

                                            </div>
                                        </div>

                                    </li>

                                
                                </ul>


                        </div>
                        

                    </dd>
                </dl>
            <?php endif; ?> 

            <dl class="menu__list">
                <dt class="flex mx-auto items-center relative pt-11 pb-9">
                    <p class="text-4">頭顔リリース</p>
                </dt>
                <dd class="pt-5 solo">
                    <div class="menu__content">

                            <ul class="flex flex-wrap mb-8">
                                    
                                <li class=" mb-5.5 w-full justify-between items-baseline">

                                    <div class="second second--show">
                                        <div class="second__list flex items-baseline non-border" data-mh="group-name">
                                            <p>頭顔リリース</p>
                                            <div class="menu__content--price flex justify-end items-baseline">
                                                <span class="text-2"><span class="price">￥8,800</span></span>
                                            </div>
                                        </div>
                                    </div>
                                
                                </li>
                            </ul>
                    </div>
                    
                </dd>
            </dl>            
            <dl class="menu__list">
                <dt class="flex mx-auto items-center relative pt-11 pb-9">
                    <p class="text-4">成人式</p>
                </dt>
                <dd class="pt-5">
                    <div class="menu__content">

                            <ul class="flex flex-wrap mb-8">
                                    
                                <li class=" mb-5.5 w-full justify-between items-baseline">

                                    <div class="second second--show">
                                        <div class="second__list flex items-baseline" data-mh="group-name">
                                            <p>ヘアセット + 着付け + メイク</p>
                                            <div class="menu__content--price flex justify-end items-baseline">
                                                <span class="text-2"><span class="price">￥36,300</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="second second--show">
                                        <div class="second__list flex items-baseline" data-mh="group-name">
                                            <p>ヘアセット + 着付け</p>
                                            <div class="menu__content--price flex justify-end items-baseline">
                                                <span class="text-2"><span class="price">￥33,000</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="second second--show">
                                        <div class="second__list flex items-baseline" data-mh="group-name">
                                            <p>ヘアセット + メイク</p>
                                            <div class="menu__content--price flex justify-end items-baseline">
                                                <span class="text-2"><span class="price">￥23,100</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="second second--show">
                                        <div class="second__list flex items-baseline" data-mh="group-name">
                                            <p>ヘアセットのみ</p>
                                            <div class="menu__content--price flex justify-end items-baseline">
                                                <span class="text-2"><span class="price">￥16,500</span></span>
                                            </div>
                                        </div>
                                    </div>
                                
                                </li>
                            </ul>
                    </div>
                    
                </dd>
            </dl>            



        </div>
    </div> -->


    <div id="infomation" class="mx-auto pt-15 w-4\/5 mb-10 relative">
        <h2 class="sec__ttl--big mb-8">
            INFOMATION
        </h2>
        <div class="info__container flex items-start">
            <?php if( have_rows('salon_info') ): ?>
                <?php while( have_rows('salon_info') ): the_row();
                    $address = get_sub_field('address');
                    $map = get_sub_field('map');
                    $iframe = get_sub_field('iframe');
                    $tel = get_sub_field('tel');
                    $business_time1 = get_sub_field('business_time1');
                    $holiday = get_sub_field('holiday');
                    $parking = get_sub_field('parking');
                    $tel_time = get_sub_field('tel_time');
                    $reserved_link = get_sub_field('reserved_link');
                ?>
            <div class="info__content pt-4">

                <dl class="flex mb-6">
                
                    <dt>住所</dt>
                    <dd>
                        <a href="<?php echo $map;?>" class="flex">
                            <span><?php echo $address;?></span>
                            <img src="<?php echo get_template_directory_uri();?>/assets/images/salon/map-icon.svg" alt="">
                        </a>
                    </dd>
                </dl>
                <dl class="flex mb-6">
                    <dt>TEL</dt>
                    <dd><?php echo $tel;?></dd>
                </dl>
                <dl class="flex mb-6">
                    <dt>営業時間</dt>
                    
                    <dd>
                        <?php if( have_rows('business_time1') ): ?>
                            <?php while( have_rows('business_time1') ): the_row();
                            ?>
                            <?php if( have_rows('business_sub_time') ): ?>
                                <?php while( have_rows('business_sub_time') ): the_row();
                                    $business1 = get_sub_field('business1');
                                    $time = get_sub_field('time');
                                ?>
                        <dl class="flex">
                            <dt><?php echo $business1;?></dt>
                            <dd><?php echo $time;?></dd>
                        </dl>
                        <?php endwhile;?>
                        <?php endif; ?>
                        <?php endwhile;?>
                        <?php endif; ?>
                    </dd>
                </dl>
                <dl class="flex mb-6">
                    <dt>定休日</dt>
                    <dd>
                        <p><?php echo $holiday;?></p>
                    </dd>
                </dl>
                <dl class="flex mb-6">
                    <dt>駐車場</dt>
                    <dd><?php echo $parking;?></dd>
                </dl>

            </div>

            <?php echo $iframe;?>
            <?php endwhile;?>
            <?php endif; ?>
            
        </div>
    </div>

    <div id="reserve" class="pt-9 pb-15">
        <h2 class="sec__ttl--big mb-6">
            RESERVE
        </h2>
        <p class="text-center text-2 mb-6">お電話または、WEB予約（24時間受付）より<br class="sp">ご予約を承っております。</p>
        <?php if( have_rows('salon_info') ): ?>
                <?php while( have_rows('salon_info') ): the_row();
                    $tel = get_sub_field('tel');
                    $tel_time = get_sub_field('tel_time');
                    $reserved_link = get_sub_field('reserved_link');
                ?>
            <a href="tel:<?php echo $tel;?>" class="button mb-1.6 mx-auto block text-2.5"><?php echo $tel;?></a>
            <p class="text-center text-2 mb-3">受付時間<?php echo $tel_time;?></p>
            <a href="<?php echo $reserved_link;?>" target="_blank" class="button mb-1.6 mx-auto block text-2.5">WEB</a>
            <p class="text-center text-2">24時間受付</p>
            <?php endwhile;?>
            <?php endif; ?>
    </div>

</div>


<?php get_template_part('templates/footer'); ?>