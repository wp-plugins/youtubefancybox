<?php
/**
 * @package Videolightbox
 * @version 1.1
 */
/*
Plugin Name: Video Light Box
Plugin URI: http://milindmore22.blogspot.com/
Description: This plugin runs with shortcodes [youtube videoid="as-H0sZbbd0" height="100" width="100"] OR [youtube url="https://www.youtube.com/watch?v=DYojBZG5d1Q" height="100" width="100"] for colorbox /lightbox (thanks to  Jack Moore(http://www.jacklmoore.com/colorbox/) )
Author: Milind More
Version: 1.1
Author URI: 
*/
if ( is_admin() )
	require_once dirname( __FILE__ ) . '/admin.php';

add_shortcode('youtube','getyoutubeURL');
add_action('wp_head', 'load_js_file');
add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');


function load_js_file(){
	wp_enqueue_style('colorboxcss',plugins_url('css/colorbox.css',__FILE__));
	wp_enqueue_script('jquery');
	wp_enqueue_script('colorboxjs', plugins_url('js/jquery.colorbox-min.js',__FILE__) );
	wp_enqueue_script('colorboxcaller', plugins_url('js/caller.js',__FILE__) );
}

function getyoutubeURL($attr){
	
	if(!isset($attr['height'])){
		$attr['height']=get_option('youtube_height');
	}
	if(!isset($attr['width']))	{
		$attr['width']=get_option('youtube_width');
	}
	if(!isset($attr['videoid']))
	{
		if(isset($attr['url'])){
			preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $attr['url'], $matches);
			$attr['videoid']=$matches[0];
		}
	}
	
	if(get_option('autoplay'))
	{
		$autoplay=get_option('autoplay');
		if($autoplay=="yes")
		{
			$autoplay="1";
		}else{
			$autoplay="0";
		}
	}else{
		$autoplay="1";
	}
	if(isset($attr['videoid']))
	{
	?>
	<a class='youtube' href="http://www.youtube.com/v/<?php echo $attr['videoid']?>?rel=0&amp&autoplay=<?php echo $autoplay?>;wmode=transparent"><img src="http://img.youtube.com/vi/<?php echo $attr['videoid'];?>/0.jpg" width="<?php echo $attr['width']?>" height="<?php echo $attr['height']?>"/></a>
	<?php
	}else{
		echo "\n<br /><span style='clear:both;color:red'>Please Enter Youtube ID or Youtube URL as [youtube videoid='XXXXX']</span>";
	} 
}