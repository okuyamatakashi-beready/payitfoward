<!DOCTYPE html>
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		
		
		<title>PAYITFORWARD</title>


		<!-- CSS -->
		<link href="<?php echo get_template_directory_uri(); ?>/style.css" rel="stylesheet" type="text/css">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/common/favicon.ico" id="favicon">

		<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Gloock&family=Lexend:wght@100..900&family=Noto+Sans+JP:wght@100..900&family=Rokkitt:ital,wght@0,100..900;1,100..900&family=Zen+Kaku+Gothic+New:wght@300;400;500;700;900&display=swap" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="https://www.unpkg.com/fullpage.js@4.0.15/dist/fullpage.min.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
		
		<script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.19/bundled/lenis.min.js"></script>
		
		<?php wp_head();?>
	</head>
<body>
<div class="overlay"></div>

<header id="header" class="w-full fixed top-0 left-0 z-50">
    <div class="header__inner flex justify-between items-center px-6 py-4">
        <!-- 左側：ロゴ -->
        <div class="header__logo">
            <a href="<?php echo home_url('/'); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/common/logo.svg" alt="Site Logo">
            </a>
        </div>

        <!-- 右側 -->
        <div class="header__right flex items-center gap-6">
            <!-- 応募ボタン -->
            <a href="/entry" class="btn entry-btn flex items-center gap-2">
                応募してみる・エントリー
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/common/entry-btn-icon.svg" alt="Entry Arrow" />
            </a>

            <!-- ハンバーガーボタン -->
            <div class="header__toggle text-center">
                <button class="hamburger" aria-label="Menu Toggle">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </button>
                <span class="menu-label block text-sm mt-1 roki">menu</span>
            </div>
        </div>
    </div>
</header>



<div id="toggle">
	<div class="relative">
		<span></span>
		<span></span>
	</div>
</div>