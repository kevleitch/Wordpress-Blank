<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="description" content="">
        <meta name="author" content="Kev Leitch">

        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/load.css" />
		<link type="text/plain" rel="author" href="<?php bloginfo('template_directory'); ?>/humans.txt" />
        
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        
        <!--[if lt IE 8]>
            <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/load-ie-7.css" />
        <![endif]-->
        
        <!--[if lt IE 9]>
            <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/assets/css/load-ie-8.css" />
        <![endif]-->
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript">
            if (typeof jQuery == 'undefined') {
                document.write(unescape("%3Cscript src='%3C?php bloginfo(\'template_directory\'); ?%3E/assets/js/jquery.js' type='text/javascript'%3E%3C/script%3E"));
            }
        </script>
		<?php
			$thumb = get_post_meta($post->ID,'_thumbnail_id',false);
			$thumb = wp_get_attachment_image_src($thumb[0], false);
			$thumb = $thumb[0];
			$default_img = get_bloginfo('template_directory').'/assets/img/fb-icon.jpg'; //make this 150x150px
		 
			?>
		 
		<?php if(is_single() || is_page()) { ?>
			<meta property="og:type" content="article" />
			<meta property="og:title" content="<?php single_post_title(''); ?>" />
			<meta property="og:description" content="<?php 
			while(have_posts()):the_post();
			$out_excerpt = str_replace(array("\r\n", "\r", "\n"), "", get_the_excerpt());
			echo apply_filters('the_excerpt_rss', $out_excerpt);
			endwhile; 	?>" />
			<meta property="og:url" content="<?php the_permalink(); ?>"/>
			<meta property="og:image" content="<?php if ( $thumb[0] == null ) { echo $default_img; } else { echo $thumb; } ?>" />
		<?php  } else { ?>
			<meta property="og:type" content="article" />
			<meta property="og:title" content="<?php bloginfo('name'); ?>" />
			<meta property="og:url" content="<?php bloginfo('url'); ?>"/>
			<meta property="og:description" content="<?php bloginfo('description'); ?>" />
			<meta property="og:image" content="<?php  if ( $thumb[0] == null ) { echo $default_img; } else { echo $thumb; } ?>" />
		<?php  }  ?>	
        <?php wp_head(); ?>
    </head>
    <body>
        <div class="wrapper">
            <header>
            </header>