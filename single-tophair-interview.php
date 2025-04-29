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
        <section id="interview-single" class=" relative">
            <!-- <strong class="block absolute">Interview of</strong>
            <strong class="block absolute">TOPHAIR people</strong> -->

            <div class="interview__wrapper flex">
                <?php 
                    $mv = get_field('mv');
                    $job = get_field('job');
                    $year = get_field('year');
                    $school = get_field('school');
                    $name = get_field('name');
                    $salon = get_field('salon');
                    $name_en = get_field('name_en');
                    $introduce = get_field('introduce');
                ?>
                <?php
                // ACFのテキストエリアの値を取得
                $catch = get_field('catch'); 

                // 改行で分割
                $lines = explode("\n", trim($catch));

                // 各行を <span> で囲む
                $formatted_text = '';
                foreach ($lines as $line) {
                    if (!empty(trim($line))) { // 空行を除外
                        $formatted_text .= '<span>' . nl2br(htmlspecialchars($line, ENT_QUOTES, 'UTF-8')) . '</span><br>';
                    }
                }
                ?>
                
                <div class="interview__content">
                    <div class="interview__content--item">
                        <div class="thumb relative bg" style="background-image: url(<?php echo $mv;?>)">
                            <p>
                                <?php echo $formatted_text; ?>
                            </p>
                            <span class="vertical vertical01">INTERVIEW OF</span>
                            <span class="vertical vertical02">TOPHAIR PEOPLE</span>
                        </div>

                        <div class="text mx-auto">
                            <span class="job"><?php echo $job;?></span>
                            <div class="profile relative">
                                <span class="corner top-left"></span>
                                <span class="corner top-right"></span>
                                <span class="corner bottom-left"></span>
                                <span class="corner bottom-right"></span>

                                <div class="flex">
                                    <div class="info">
                                        <span>01</span>
                                        <ul>
                                            <li>FROM</li>
                                            <li>SALON</li>
                                            <li>YEAR</li>
                                        </ul>
                                    </div>
                                    <div class="profile_text">
                                        <p>
                                            <?php echo $name;?>
                                            <span><?php echo $name_en;?></span>
                                        </p>
                                        <ul>
                                            <li><?php echo $school;?>卒</li>
                                            <li><?php echo $salon;?></li>
                                            <li><?php echo $year;?></li>
                                        </ul>
                                    </div>
                                </div>
                                <p class="introduce"><?php echo $introduce;?></p>
                            </div>
                        </div>

                        <div class="qa mx-auto">
                            <?php if( have_rows('qa') ): ?>
                            <?php while( have_rows('qa') ): the_row();
                                $question = get_sub_field('question');
                                $qa_img = get_sub_field('qa_img');
                                $answer = get_sub_field('answer');
                            ?>
                            <div class="qa__content mx-auto">
                                <div class="question__wrapper">
                                    <span>Q</span>
                                    <p><?php echo $question;?></p>
                                </div>

                                <div class="answer__wrapper">
                                    <div class="img bg" style="background-image: url(<?php echo $qa_img;?>)"></div>
                                    <p><?php echo $answer;?></p>
                                </div>
                            </div>

                            <?php endwhile;?>
                            <?php endif; ?>
                        </div>

                        <div class="flow">
                            <figure>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/interview/debut.svg" alt="" class="mx-auto">
                            </figure>
                            <div class="flow__wrapper">
                                <div class="flow__content mx-auto">
                                    <dl class="flex items-center">
                                        <dt class="flex items-center">
                                            <span>STEP</span>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/interview/one.svg" alt="" class="mx-auto">
                                        </dt>
                                        <?php if( have_rows('debut') ): ?>
                                        <?php while( have_rows('debut') ): the_row();
                                        ?>
                                        <?php if( have_rows('step1') ): ?>
                                            <?php while( have_rows('step1') ): the_row();
                                                $step_ttl = get_sub_field('step_ttl');
                                                $step_content = get_sub_field('step_content');
                                            ?>
                                        <dd>
                                            <p>
                                                <?php echo $step_ttl;?><br>
                                                <span><?php echo $step_content;?></span>
                                            </p>
                                        </dd>
                                        <?php endwhile;?>
                                        <?php endif; ?>
                                        <?php endwhile;?>
                                        <?php endif; ?>
                                    </dl>
                                    <dl class="flex items-center">
                                        <dt class="flex items-center">
                                            <span>STEP</span>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/interview/second.svg" alt="" class="mx-auto">
                                        </dt>
                                        <?php if( have_rows('debut') ): ?>
                                        <?php while( have_rows('debut') ): the_row();
                                        ?>
                                        <?php if( have_rows('step2') ): ?>
                                            <?php while( have_rows('step2') ): the_row();
                                                $step_ttl2 = get_sub_field('step_ttl2');
                                                $step_content2 = get_sub_field('step_content2');
                                            ?>
                                        <dd>
                                            <p>
                                                <?php echo $step_ttl2;?><br>
                                                <span><?php echo $step_content2;?></span>
                                            </p>
                                        </dd>
                                        <?php endwhile;?>
                                        <?php endif; ?>
                                        <?php endwhile;?>
                                        <?php endif; ?>
                                    </dl>
                                    <dl class="flex items-center">
                                        <dt class="flex items-center">
                                            <span>STEP</span>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/interview/three.svg" alt="" class="mx-auto">
                                        </dt>
                                        <?php if( have_rows('debut') ): ?>
                                        <?php while( have_rows('debut') ): the_row();
                                        ?>
                                        <?php if( have_rows('step3') ): ?>
                                            <?php while( have_rows('step3') ): the_row();
                                                $step_ttl3 = get_sub_field('step_ttl3');
                                                $step_content3 = get_sub_field('step_content3');
                                            ?>
                                        <dd>
                                            <p>
                                                <?php echo $step_ttl3;?><br>
                                                <span><?php echo $step_content3;?></span>
                                            </p>
                                        </dd>
                                        <?php endwhile;?>
                                        <?php endif; ?>
                                        <?php endwhile;?>
                                        <?php endif; ?>
                                    </dl>
                                    <dl class="flex items-center">
                                        <dt class="flex items-center">
                                            <span>STEP</span>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/interview/four.svg" alt="" class="mx-auto">
                                        </dt>
                                        <?php if( have_rows('debut') ): ?>
                                        <?php while( have_rows('debut') ): the_row();
                                        ?>
                                        <?php if( have_rows('step4') ): ?>
                                            <?php while( have_rows('step4') ): the_row();
                                                $step_ttl4 = get_sub_field('step_ttl4');
                                                $step_content4 = get_sub_field('step_content4');
                                            ?>
                                        <dd>
                                            <p>
                                                <?php echo $step_ttl4;?><br>
                                                <span><?php echo $step_content4;?></span>
                                            </p>
                                        </dd>
                                        <?php endwhile;?>
                                        <?php endif; ?>
                                        <?php endwhile;?>
                                        <?php endif; ?>
                                    </dl>
                                    <dl class="flex items-center">
                                        <dt class="flex items-center">
                                            <span>STEP</span>
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/interview/five.svg" alt="" class="mx-auto">
                                        </dt>
                                        <?php if( have_rows('debut') ): ?>
                                        <?php while( have_rows('debut') ): the_row();
                                        ?>
                                        <?php if( have_rows('step5') ): ?>
                                            <?php while( have_rows('step5') ): the_row();
                                                $step_ttl5 = get_sub_field('step_ttl5');
                                                $step_content5 = get_sub_field('step_content5');
                                            ?>
                                        <dd>
                                            <p>
                                                <?php echo $step_ttl5;?><br>
                                                <span><?php echo $step_content5;?></span>
                                            </p>
                                        </dd>
                                        <?php endwhile;?>
                                        <?php endif; ?>
                                        <?php endwhile;?>
                                        <?php endif; ?>
                                    </dl>

                                    <div class="flow__img flex justify-between">
                                        <?php if( have_rows('staff_img') ): ?>
                                        <?php while( have_rows('staff_img') ): the_row();
                                            $img1 = get_sub_field('img1');
                                            $img2 = get_sub_field('img2');
                                        ?>
                                        <div class="first bg" style="background-image: url(<?php echo $img1;?>)"></div>
                                        <div class="second bg" style="background-image: url(<?php echo $img2;?>)"></div>
                                        <?php endwhile;?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <a href="/interview" class="read_more mt-4">
                <span>CLOSE</span>
            </a>

            <a href="https://www.instagram.com/tophair_recruit/" target="_blank" class="insta mx-auto">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/interview/insta.jpg" alt="" class="mx-auto">
            </a>
        </section>





        <?php get_template_part('templates/footer-center'); ?>
    </div>

    <?php get_template_part('templates/parts/main-right'); ?>
</main>


<?php get_template_part('templates/footer'); ?>