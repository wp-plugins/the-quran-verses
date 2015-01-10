<?php
/*
Plugin Name: The Quran Verses
Version: 1.0.0
Description: Read verses from The Holy Quran on your wordpress sidebar and share on facebook.
Author: noblesoft
Author URI: http://noble-soft.com
Plugin URI: http://noble-soft.com/demo/wordpress/the-quran-verses/
*/


    add_action('widgets_init', 'widget_tqv_admin');
    add_action('widgets_init', 'widget_tqv_frontend');
	add_action('init', 'ajax_action_init');
	

	function widget_tqv_admin()
	  {
		  function widget_tqv_settings() {
			//plugin settings
			?>
			<p>
			Important! Because most of the hosting servers do not allow download of large files, we have introduced this plugin with 200 verses only. To download full version, please do not forget to visit author's <a href="http://noble-soft.com/product/the-quran-verses/" target="_blank">website</a> for this plugin.</p>
			<?php
		  }
	  	register_widget_control(array('The Quran Verses', 'widgets'), 'widget_tqv_settings');
	  }

  
	function tqv_enqueue_scripts()
	  {
		wp_enqueue_script('jquery');
		wp_enqueue_script('tqv-refresh', plugins_url( 'js/load-next-verse.js', __FILE__ ));
		wp_enqueue_script('tqv-facebook-api', 'http://connect.facebook.net/en_US/all.js');
		wp_enqueue_script('tqv-facebook', plugins_url( 'js/facebook-share.js', __FILE__ ));
	  }
	

	function ajax_action_init()
	  {
		if($_GET['act'] == 'tqv-refresh-contents') {
		  echo get_random_contents();
		  die;
		}
	  }

  
	function get_random_contents()
	  {
		$reference = rand(0,199);
		$versenumber = $reference+1;
		include"data/arabic/verses.php";
		include"data/english/translation-sahih-international.php";
		
		?>
		<script type="text/javascript">
		document.getElementById("tqv-picture-url").value = '<?=plugins_url( 'generate/picture.php?verse='.$versenumber, __FILE__ )?>';
		</script>
		
		<?php
	
		$contents = '<span id="content-arabic">'.htmlentities($verses_arabic[$reference]['content']).'</span>';
		$contents .= '<br />';
		$contents .= '<span id="content-translation">'.$verses_translation[$reference]['content'].'</span>';
		$contents .= '<br />';
		$contents .= '<span id="translation-description">'.$translation_description.'</span>';
		$contents .= '<br />';
		$contents .= '<span id="quran-reference">Quran: '.$verses_arabic[$reference]['chapter_number'].':'.$verses_arabic[$reference]['verse_number'].'</span>';
		return $contents;
	  
	  }


  function widget_tqv_frontend()  {
    
  if (!function_exists('register_sidebar_widget')) {
  return;
  }
  
  add_action('wp_enqueue_scripts', 'tqv_enqueue_scripts');
    
  function widget_tqv_sidebar($args) {
  extract($args);

  echo '<input type="hidden"  id="tqv-picture-url"/>';

  echo '<link rel="stylesheet" href="'.plugins_url( 'css/style.css', __FILE__ ).'"text/css" media="screen" />';
  echo $before_widget;
  echo '<div style="text-align: center;">';
  echo '<div id="tqv-heading">';
	echo "Al-Quran";
  echo '</div>';
  
  echo '<div id="tqv-contents">';
	echo get_random_contents();   
  echo '</div>';
    
  echo '<span id="tqv-refresh-button" style="cursor: pointer">';
	echo '<img src="'.plugins_url( 'images/reload.png', __FILE__ ).'" alt="Read another verse"/>';
  echo '</span>';
  
  echo '<span id="tqv-reloading" style="display:none">';
	echo '<img src="'.plugins_url( 'images/loading.gif', __FILE__ ).'" alt="Loading another verse"/>';
  echo '</span>';
  
  echo '<br />';
  echo '<br />';
  echo '<span id="tqv-sharing-tools" onclick="postToFeed(); return false;">';
	echo '<img src="'.plugins_url( 'images/facebook-share.png', __FILE__ ).'" alt="Share on facebook"/>';
  echo '</span>';
  
  echo '<div id="fb_post_id" style="display:none"></div>';
  
  echo '</div>';
	//
  echo  $after_widget;
  }

  register_sidebar_widget(array('The Quran Verses', 'widgets'), 'widget_tqv_sidebar');

  }