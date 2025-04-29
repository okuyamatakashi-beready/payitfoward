<?php get_template_part('templates/header'); ?>

<main id="recruit">
    <div class="container mx-auto">
        <!-- 1. ヒーロー -->
        <section class="recruit__hero">
            <h2 class="section-title flex">
                <p class="flex">Recruit</p>
                <small>(7)</small>
            </h2>
        </section>

        <!-- 2. キービジュアル -->
        <div class="recruit__kv mx-auto"></div>

        <!-- 3. ラベル -->
        <div class="recruit__label">
            <span>中途採用</span><span>新卒採用</span>
        </div>

        <!-- 4. 募集要項 -->
        <section class="recruit__table">
            <dl>
                <dt>募集職種</dt>
                <dd>スタイリスト／アシスタント</dd>

                <dt>雇用形態</dt>
                <dd>正社員</dd>

                <dt>応募対象</dt>
                <dd>中途採用／新卒採用（美容専門学校卒業見込みの方）</dd>

                <dt>勤務地</dt>
                <dd>
                    Belle&nbsp;BIANCA　名古屋市中区栄3‑15‑1 セントヒサヤビル9F<br>
                    Emma&nbsp;école　名古屋市中区栄3‑15‑1 セントヒサヤビル6F<br>
                    NOA&nbsp;soîe　名古屋市中区栄3‑15‑1 セントヒサヤビル7F<br>
                    JILL&nbsp;STUDIO　名古屋市中区大須3‑6‑25 ミュプレ本場3F<br>
                    <small>※新卒採用は JILL STUDIO の勤務となります。</small>
                </dd>

                <dt>給与</dt>
                <dd>
                    <p><strong>スタイリスト（正社員）</strong><br>
                        月給：33万円〜<br>
                        基本給：330,000円<br>
                        + 店販手当 + 交通費<br>
                        <span class="indent">＜月収イメージ：平均 40 万円＞</span><br>
                        ※試用期間なし
                    </p>
                    <br>
                    <p><strong>アシスタント（正社員）</strong><br>
                        月給：20万円〜<br>
                        基本給：200,000円<br>
                        + 店販手当 + 交通費<br>
                        <span class="indent">＜月収イメージ：平均 30 万円＞</span><br>
                        ※試用期間なし
                    </p>
                </dd>

                <dt>勤務時間</dt>
                <dd>営業時間内（08:00〜24:00）で自由出勤制（最低勤務時間あり・面接時に応相談）</dd>

                <dt>福利厚生</dt>
                <dd>
                    社会保険（雇用／労災）<br>
                    交通費支給（月◯◯円迄）<br>
                    ウィッグ代支給<br>
                    昇給随時（業績による）<br>
                    外部講師サポート
                </dd>

                <dt>休日休暇</dt>
                <dd>
                    月 10 日休み<br>
                    ・2 か月の有休を 4 回の半休にすることも ◎<br>
                    ・前後の月から 2 日ずつ休みを移動させるため、最大 14 日休み
                </dd>
            </dl>
        </section>
    </div>


    <!-- 6. Flow セクション -->
    <section class="recruit__flow">
        <div class="recruit__flow-grid">
            <!-- left: タイトル・椅子写真・ステップ -->
            <div class="flow-left relative">
                <figure class="flow-chair absolute">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/recruit/flow_chair.jpg" alt="">
                </figure>

                <h2 class="flow-title roki">Flow</h2>
                <p class="flow-caption">採用までの流れ</p>

                <ol class="flow-steps">
                    <li>
                        <div class="flex">
                            <span class="num roki">01</span>
                            <h3>エントリー</h3>
                        </div>

                        <p>エントリーフォームよりご応募ください。<br>
                            担当よりメールまたはお電話でご連絡させていただきます。</p>
                    </li>

                    <li>
                        <div class="flex">
                            <span class="num roki">02</span>
                            <h3>サロンにて面接</h3>
                        </div>

                        <p>サロンにて、オーナーと面接を行います。<br>
                            不安点やご質問などあれば、なんでもお話しください。</p>
                    </li>

                    <li>
                        <div class="flex">
                            <span class="num roki">03</span>
                            <h3>サロン見学 or 施術 1 日体験</h3>
                        </div>

                        <p>まずはお気軽に、サロン見学へお越しください。<br>
                            施術一日体験を行うこともできます。ご相談ください。</p>
                    </li>

                    <li>
                        <div class="flex">
                            <span class="num roki">04</span>
                            <h3>採用通知</h3>
                        </div>

                        <p>正式に採用のご連絡をいたします。<br>
                            Pay it Forward で、一緒に美容師を楽しみましょう。</p>
                    </li>
                </ol>
            </div>

            <!-- right: メインビジュアル & コピー（SP では上に来る） -->
            <div class="flow-right flex">
                <figure class="flow-girls">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/recruit/flow_girls.jpg" alt="">
                </figure>
                <p class="flow-quote roki">
                    THINK OF AN<br>
                    IDEA TO CHANGE<br>
                    OUR WORLD‑AND<br>
                    PUT IT INTO<br>
                    ACTION.
                </p>

            </div>



        </div>
    </section>

    <!-- 7. gallery swiper -->
    <section class="recruit__gallery swiper recruit-gallery-swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/recruit/slide-01.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/recruit/slide-02.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/recruit/slide-03.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/recruit/slide-04.jpg" alt="">
            </div>
            <div class="swiper-slide">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/recruit/slide-05.jpg" alt="">
            </div>
        </div>

        <!-- ドットページネーション（任意で削除可） -->
        <div class="recruit-gallery-pagination swiper-pagination"></div>
    </section>



    <?php get_template_part('components/entry'); ?>



</main>


<?php get_template_part('templates/footer'); ?>