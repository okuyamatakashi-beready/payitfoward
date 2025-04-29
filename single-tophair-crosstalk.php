<?php get_template_part('templates/header'); ?>
<main id="main">
    <?php get_template_part('templates/parts/main-left'); ?>
    <div class="mainCenter">
        <header id="header" class="w-full py-3.6 pl-2.8">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/header_logo.svg" alt="" class="">
        </header>
        <?php get_template_part('templates/parts/gnav'); ?>
        <!-- <div class="fixed__btn">
            <a href="" class="relative">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/insta_img.jpg" alt="" class="btn">
            </a>`
            </a>
        </div> -->
        <section id="crosstalk" class=" relative">
            <!-- <strong class="block absolute">Interview of</strong>
            <strong class="block absolute">TOPHAIR people</strong> -->
            <h1 class="mx-auto single__ttl">
                CROSSTALK
                <span class="block"># 3人のスタイリストによるクロストーク</span>
            </h1>
            <?php 
                $catch_img = get_field('catch_img');
                $stylist = get_field('stylist');
                $theme = get_field('theme');
                $between_img = get_field('between_img');

            ?>
            <div class="crosstalk__thumb">
                <div class="thumb bg mx-auto" style="background-image: url(<?php echo $catch_img;?>)">
            </div>

            </div>

            <p class="ttl">
                <span>3人のスタイリストによる赤裸々トーク！</span>
            </p>

            <div class="stylist__wrapper">
                <div class="stylist__content flex flex-wrap justify-between mx-auto">
                    <?php if( have_rows('stylist') ): ?>
                        <?php while( have_rows('stylist') ): the_row();
                            $img = get_sub_field('img');
                            $job = get_sub_field('job');
                            $name = get_sub_field('name');
                            $name_en = get_sub_field('name_en');
                            $salon = get_sub_field('salon');
                            $from = get_sub_field('from');
                        ?>
                    <div class="stylist flex items-center">
                        <div class="img bg" style="background-image: url(<?php echo $img;?>)"></div>
                        <div class="info">
                            <p class="job"><?php echo $job;?></p>
                            <p class="name"><?php echo $name;?></p>
                            <p class="name_en"><?php echo $name_en;?></p>
                            <p class="salon"><?php echo $salon;?></p>
                            <p class="from"><?php echo $from;?>出身</p>
                        </div>
                    </div>

                    <?php endwhile;?>
                    <?php endif; ?>
                </div>
            </div>

            <p class="theme"><span>ー<?php echo $theme;?>ー</span></p>

            <div class="talk__wrapper mx-auto">
                <?php if( have_rows('crosstalk01') ): ?>
                    <?php while( have_rows('crosstalk01') ): the_row();
                    ?>
                    <?php if( have_rows('talker01') ): ?>
                        <?php while( have_rows('talker01') ): the_row();
                            $talker_img = get_sub_field('talker_img');
                            $talker_name = get_sub_field('talker_name');
                            $talk_content = get_sub_field('talk_content');
                        ?>
                <div class="talk__content left flex">
                    <div class="img">
                        <div class="talker__thumb bg" style="background-image: url(<?php echo $talker_img;?>)"></div>
                        <p><?php echo $talker_name;?></p>
                    </div>

                    <p class="talk"><?php echo $talk_content;?></p>
                </div>

                <?php endwhile;?>
                <?php endif; ?>

                <?php if( have_rows('talker02') ): ?>
                        <?php while( have_rows('talker02') ): the_row();
                            $talker_img = get_sub_field('talker_img');
                            $talker_name = get_sub_field('talker_name');
                            $talk_content = get_sub_field('talk_content');
                        ?>
                <div class="talk__content right flex">
                    

                    <p class="talk"><?php echo $talk_content;?></p>
                    <div class="img">
                        <div class="talker__thumb bg" style="background-image: url(<?php echo $talker_img;?>)"></div>
                        <p><?php echo $talker_name;?></p>
                    </div>
                </div>

                <?php endwhile;?>
                <?php endif; ?>
                <?php endwhile;?>
                <?php endif; ?>

            </div>

            <div class="between__img bg" style="background-image: url(<?php echo $between_img;?>)">

            </div>

            <div class="talk__wrapper mx-auto">
                <?php if( have_rows('crosstalk02') ): ?>
                    <?php while( have_rows('crosstalk02') ): the_row();
                    ?>
                    <?php if( have_rows('talker01') ): ?>
                        <?php while( have_rows('talker01') ): the_row();
                            $talker_img = get_sub_field('talker_img');
                            $talker_name = get_sub_field('talker_name');
                            $talk_content = get_sub_field('talk_content');
                        ?>
                <div class="talk__content left flex">
                    <div class="img">
                        <div class="talker__thumb bg" style="background-image: url(<?php echo $talker_img;?>)"></div>
                        <p><?php echo $talker_name;?></p>
                    </div>

                    <p class="talk"><?php echo $talk_content;?></p>
                </div>

                <?php endwhile;?>
                <?php endif; ?>

                <?php if( have_rows('talker02') ): ?>
                        <?php while( have_rows('talker02') ): the_row();
                            $talker_img = get_sub_field('talker_img');
                            $talker_name = get_sub_field('talker_name');
                            $talk_content = get_sub_field('talk_content');
                        ?>
                <div class="talk__content right flex">
                    

                    <p class="talk"><?php echo $talk_content;?></p>
                    <div class="img">
                        <div class="talker__thumb bg" style="background-image: url(<?php echo $talker_img;?>)"></div>
                        <p><?php echo $talker_name;?></p>
                    </div>
                </div>

                <?php endwhile;?>
                <?php endif; ?>
                <?php endwhile;?>
                <?php endif; ?>

            </div>



            <a href="" class="insta mx-auto">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/interview/insta.jpg" alt="" class="mx-auto">
            </a>

            <div class="backto container">
                <a href="" class="backtoTop text-center block" >
                TOP PAGEに戻る
                </a>
            </div>
        </section>



        <?php get_template_part('templates/parts/common-slider'); ?>

        <?php get_template_part('templates/footer-center'); ?>
    </div>

    <?php get_template_part('templates/parts/main-right'); ?>
</main>


<?php get_template_part('templates/footer'); ?>