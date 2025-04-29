<?php get_template_part('templates/header-news'); ?>
<div class="contact">
    <div class="faq__container mx-auto pt-20 pb-15">
        <h2 class="sec__ttl--big mb-8 text-center">
            CONTACT
        </h2>
        <div class="ttl mb-15">
        <p class="mb-10">
                トップヘアーに関するお問い合わせは<br class="sp">こちらのフォームから承ります。<br>
                【必須】は入力必須項目です。<br class="sp">ご記入漏れのないようにお願い致します。
            </p>


            <ul class="states flex justify-center">
                <li class="active">入力</li>
                <li>確認</li>
                <li>完了</li>
            </ul>

            <div class="form__wrapper mx-auto">
                <?php echo do_shortcode('[contact-form-7 id="1475" title="tophair オフィシャルサイトお問い合わせ"]'); ?>
                <!-- <dl class="flex">
                    <dt>【必須】個人/法人</dt>
                    <dd>[select* kojin "個人" "法人"]</dd>
                </dl>
                <dl class="flex">
                    <dt>【必須】お問い合わせ店舗</dt>
                    <dd>[checkbox checkbox-521 class:salon use_label_element "TOP HAIR TERRACE" "Lounge 知立" "TOP HAIR HILLS" "Garden Villa. 安城" "spa&relaxation 安城" "MIKAWA ANJO 安城" "Avenue 刈谷" "spa＆resort 鳴海" "HONTEN 刈谷" "わからない"]</dd>
                </dl>
                <dl class="flex">
                    <dt>【必須】お名前</dt>
                    <dd>[text* namae placeholder "例) 田中 太郎"]</dd>
                </dl>
                <dl class="flex">
                    <dt>【必須】メールアドレス</dt>
                    <dd>[email* email-265 placeholder "例) xxxxx@sample.co.jp"]</dd>
                </dl>
                <dl class="flex">
                    <dt>【必須】郵便番号</dt>
                    <dd>[text* address placeholder "例) 000-0000"]</dd>
                </dl>
                <dl class="flex">
                    <dt>【必須】ご住所</dt>
                    <dd>[text* address02 placeholder "例) 愛知県○○市○○○○0-00"]</dd>
                </dl>
                <dl class="flex">
                    <dt>【必須】お電話番号</dt>
                    <dd>[tel* tel-525 placeholder "例) 0120-000-000"]</dd>
                </dl>
                <dl class="flex items-start">
                    <dt>【必須】お問い合わせ内容</dt>
                    <dd>[textarea* naiyo]</dd>
                </dl>

                <div class="policy">
                    <p><a href="/policy">プライバシーポリシー</a>をお読みいただき、同意の上送信してください。</p>
                    <p>[acceptance acceptance-314 class:accept optional] 個人情報取扱について同意します [/acceptance]</p>
                </div>

                <div class="send">
                    [submit class:send "確認する"][multistep multistep-45 first_step "confirm"]
                </div> -->

            </div>
        </div>

    </div>
</div>

<footer id="footer" class="w-full relative bg">

    <div class="footer__content pt-10 pb-5">
        <div class="footer__wrapper mx-auto">
            <h2 class="sec__ttl--big text-3 ml-13 mb-5">
                CONTENTS
            </h2>
            <div class="footer__wrapper--link pt-7 pb-3">
                <div class="sitemap justify-between flex">
                    <ul class="flex ml-12 flex-wrap">
                        <li>
                            <a href="/concept"><span class="pr-1.5">ー</span>コンセプト</a>
                        </li>
                        <li>
                            <a href="/gallery"><span class="pr-1.5">ー</span>ギャラリー</a>
                        </li>
                        <li>
                            <a href="/concept#four_features"><span class="pr-1.5">ー</span>トップヘアの特徴</a>
                        </li>
                        <li>
                            <a href="https://stg.tophair-recruit.llc-beready.com/" target="_blank"><span class="pr-1.5">ー</span>リクルート</a>
                        </li>
                        <li>
                            <a href="/#salons"><span class="pr-1.5">ー</span>サロン</a>
                        </li>
                        <li>
                            <a href="/about"><span class="pr-1.5">ー</span>会社概要</a>
                        </li>
                        <li>
                            <a href="/menu"><span class="pr-1.5">ー</span>メニュー</a>
                        </li>
                        <li>
                            <a href="/contact"><span class="pr-1.5">ー</span>コンタクト</a>
                        </li>
                        <li>
                            <a href="/news"><span class="pr-1.5">ー</span>ニュース</a>
                        </li>
                        <li>
                            <a href="/faq"><span class="pr-1.5">ー</span>よくある質問</a>
                        </li>
                    </ul>

                    <div class="reserve">
                        <a href="https://stg.tophair-recruit.llc-beready.com/" class="ft__reserve block mb-1" target="_blank">
                            <span class="py-2.4 block text-center text-1.5">リクルート ｜ 採用情報</span>
                        </a>

                    </div>
                </div>

                <div class="info__content text-1.5 ml-auto flex justify-between">
                    <div class="info__content--address"><p>株式会社トップヘアー<br class="sp">　〒472-0056　愛知県知立市宝3-5-1</p></div>
                    <div class="info__content--policy flex">
                        <!-- <a href="" class="block mr-3">プレスリリース</a> -->
                        <a href="/policy" class="block">プライバシーポリシー</a>
                    </div>
                    <!-- <div class="info__content--sns flex">
                        <p>SNS</p>
                        <ul class="flex">
                            <li class=" mr-2.5">
                                <a href="">
                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/common/footer_insta.svg" alt="" class="">
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="<?php echo get_template_directory_uri();?>/assets/images/common/footer_tiktok.svg" alt="" class="">
                                </a>
                            </li>
                        </ul>
                        <div class="top-scroll"><img src="<?php echo get_template_directory_uri();?>/assets/images/common/top-scroll.svg" alt="" class=""></div>
                    </div> -->
                </div>
            </div>

            <small class="copy block text-center pt-3 text-1.5">©︎2024 TOP HAIR Co.,LTD. All Rights Reserved.</small>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://www.unpkg.com/fullpage.js@4.0.15/dist/fullpage.min.js"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.7/vendors/jquery.easings.min.js" integrity="sha512-rXZZDfRSa6rsBuT78nRTbh1ccwpXhTCspKUDqox3hUQNYdjB6KB6mSj6mXcB9/5F5wODAJnkztXPxzkTalp11w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

</body>
<?php wp_footer();?>




</html>