<?php
function theme_enqueue_scripts() {

/* ===== 共通 CSS / JS ===== */
wp_enqueue_style( 'main-css',
  get_template_directory_uri() . '/assets/css/dist/main.css', [], null );
wp_enqueue_script( 'main-js',
  get_template_directory_uri() . '/assets/js/main.js', [], null, true );
wp_enqueue_script( 'sub-js',
  get_template_directory_uri() . '/assets/js/sub.js', [], null, true );

/* ===== ページ固有 CSS ===== */
$slug_css_map = [
  'concept'   => 'concept.css',
  'menu'      => 'menu.css',
  'about'     => 'about.css',
  'news'      => 'news.css',
  'gallery'   => 'gallery.css',
  'qa'        => 'qa.css',
  'interview' => 'interview.css',
  'recruit'   => 'recruit.css',   // ★ 追加
];

foreach ( $slug_css_map as $slug => $file ) {
  if ( is_page( $slug ) ) {
    wp_enqueue_style(
      $slug . '-css',
      get_template_directory_uri() . '/assets/css/dist/' . $file,
      [],
      null
    );
  }
}

/* ===== 複数 slug をまとめて指定するページ ===== */
if ( is_page( [ 'contact', 'confirm', 'thanks', 'policy' ] ) ) {
  wp_enqueue_style(
    'contact-css',
    get_template_directory_uri() . '/assets/css/dist/contact.css',
    [],
    null
  );
}

/* ===== 投稿 / CPT の単一記事 ===== */
if ( is_singular() ) {          // 空文字列は不要
  wp_enqueue_style(
    'single-css',
    get_template_directory_uri() . '/assets/css/dist/single.css',
    [],
    null
  );
}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );



// クエリパラメータを追加
// クエリ変数を登録
function add_custom_query_vars($vars) {
  $vars[] = 'menus';
  $vars[] = 'active';
  return $vars;
}
add_filter('query_vars', 'add_custom_query_vars');



// アイキャッチ画像の設定
add_theme_support('post-thumbnails');
the_post_thumbnail('thumbnail');
the_post_thumbnail('medium');
the_post_thumbnail('large');

function my_styles()  {
    // page-sample用のCSS

    if ( is_page('works') ) {
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      }
    if ( is_tax() ) {
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      }
    if ( is_page('news') ) {
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'news_css', get_template_directory_uri() . '/scss/news/index.css');
      }
    if ( is_category() ) {
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'news_css', get_template_directory_uri() . '/scss/news/index.css');
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      }
    if ( is_archive() ) {
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'news_css', get_template_directory_uri() . '/scss/news/index.css');
      }
    if ( is_page('voice') ) {
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'news_css', get_template_directory_uri() . '/scss/news/index.css');
      }
    if ( is_page('blog') ) {
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'news_css', get_template_directory_uri() . '/scss/news/index.css');
      }

    if ( is_page('reform') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'reform_css', get_template_directory_uri() . '/scss/reform/index.css');
      }
    if ( is_page('contact') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'contact_css', get_template_directory_uri() . '/scss/contact/index.css');
      }
    if ( is_page('book') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'contact_css', get_template_directory_uri() . '/scss/contact/index.css');
      }
    if ( is_page('visit') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'contact_css', get_template_directory_uri() . '/scss/contact/index.css');
      }
    if ( is_page('book-confirm') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'contact_css', get_template_directory_uri() . '/scss/contact/index.css');
      }
    if ( is_page('event-confirm') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'contact_css', get_template_directory_uri() . '/scss/contact/index.css');
      }
    if ( is_page('confirm') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'contact_css', get_template_directory_uri() . '/scss/contact/index.css');
      }
    if ( is_page('works-confirm') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'contact_css', get_template_directory_uri() . '/scss/contact/index.css');
      }
    if ( is_page('visit-confirm') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'contact_css', get_template_directory_uri() . '/scss/contact/index.css');
      }
    if ( is_page('thanks') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'contact_css', get_template_directory_uri() . '/scss/contact/index.css');
      }
    if ( is_404() ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( '404_css', get_template_directory_uri() . '/scss/404/index.css');
      }
    if ( is_page('pre') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( '404_css', get_template_directory_uri() . '/scss/404/index.css');
      }
    if ( is_page('renovation') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'renovation_css', get_template_directory_uri() . '/scss/renovation/index.css');
      }
    if ( is_page('estate') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'estate_css', get_template_directory_uri() . '/scss/estate/index.css');
      }
    if ( is_page('staff') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'staff_css', get_template_directory_uri() . '/scss/staff/index.css');
      }
    if ( is_page('company') ) {
      wp_enqueue_style( 'page_css', get_template_directory_uri() . '/scss/page/index.css');
      wp_enqueue_style( 'works_css', get_template_directory_uri() . '/scss/works/index.css');
      wp_enqueue_style( 'company_css', get_template_directory_uri() . '/scss/company/index.css');
      }
    if ( is_single('') ) {
      wp_enqueue_style( 'single_css', get_template_directory_uri() . '/scss/single/index.css');
      
      }


    }
  add_action( 'wp_enqueue_scripts', 'my_styles' );
  


  add_filter('wpcf7_form_elements', function($form) {
    $form = do_shortcode($form);
    return $form;
});


function set_post_title_to_cf7_tag( $tag ){
  if ( ! is_array( $tag ) ){
      return $tag;    
  }

  $name = $tag['name'];
  if( $name == 'post_title' ){
      $res_get_the_title = get_the_title();
      $tag['values'] = (array)$res_get_the_title;
  }
  return $tag;
}
add_filter( 'wpcf7_form_tag', 'set_post_title_to_cf7_tag', 11 );




  /*------------------------------------*\
    pagenation
\*------------------------------------*/
/**
* ページネーション出力関数
* $paged : 現在のページ
* $pages : 全ページ数
* $range : 左右に何ページ表示するか
* $show_only : 1ページしかない時に表示するかどうか
*/
function pagination( $pages, $paged, $range = 1, $show_only = false ) {

  $pages = ( int ) $pages;

  //表示テキスト
  $text_before  = "back";
  $text_next    = "next";

  if ( $show_only && $pages === 1 ) {
      echo '<div class="pagination flex flex_start"><span class="current pager">1</span></div>';
      return;
  }

  if ( $pages === 1 ) return;

  if ( 1 !== $pages ) {
      echo '<div class="pagination flex">';
      if ( $paged > 1 ) {
          echo '<a href="', get_pagenum_link( $paged - 1 ) ,'" class="prev">', $text_before ,'</a>';
      }
      for ( $i = 1; $i <= $pages; $i++ ) {

          if ($paged <= $range) { //最初のページの場合
            if ( $i <= ($range * 2 + 1)) {
              if ( $paged === $i || $paged === 0 && $i === 1) { //ここが修正されました
                  echo '<a class="current pager">', $i ,'</a>';
              } else {
                  echo '<a href="', get_pagenum_link( $i ) ,'" class="pager">', $i ,'</a>';
              }
            }
          } elseif ($paged > ($pages - $range)) { //最後のページの場合
            if ( $i > ($pages - $range * 2)) {
              if ( $paged === $i ) {
                  echo '<a class="current pager">', $i ,'</a>';
              } else {
                  echo '<a href="', get_pagenum_link( $i ) ,'" class="pager">', $i ,'</a>';
              }
            }
          } else { //中間のページの場合
            if ( $i <= $paged + $range && $i >= $paged - $range ) {
              if ( $paged === $i ) {
                  echo '<a class="current pager">', $i ,'</a>';
              } else {
                  echo '<a href="', get_pagenum_link( $i ) ,'" class="pager">', $i ,'</a>';
              }
            }
          }

      }
      if ( $paged < $pages ) {
          echo '<a href="', get_pagenum_link( $paged + 1 ) ,'" class="next">', $text_next ,'</a>';
      }
      echo '</div>';
  }
}





function theme_enqueue_slider_scripts() {

	/* ===== 既存の共通 CSS / JS ===== */
	// … main.css / main.js など …

	/* ===== Recruit 専用 ===== */
	if ( is_page( 'recruit' ) ) {

		/* Swiper の本体 */
		wp_enqueue_style(
			'swiper-css',
			'https://unpkg.com/swiper@9/swiper-bundle.min.css',
			[],
			null
		);
		wp_enqueue_script(
			'swiper-js',
			'https://unpkg.com/swiper@9/swiper-bundle.min.js',
			[],
			null,
			true               // フッター読込
		);

		/* 初期化コードを外部ファイルへ */
		wp_enqueue_script(
			'recruit-js',
			get_template_directory_uri() . '/assets/js/recruit.js',
			[ 'swiper-js' ],   // 依存に Swiper を指定
			filemtime( get_template_directory() . '/assets/js/recruit.js' ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );

