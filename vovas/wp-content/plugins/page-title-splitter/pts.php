<?php  
	/* 
	Plugin Name: Page Title Splitter
	Plugin URI: http://plugins.15kmtoexit.com/page-title-splitter/
	Description: Add breakpoints to post, page and custom post titles.
	Author: Chris Steman
	Version: 2.0.7
	Author URI: http://15kmtoexit.com
	*/
	
$pt_splitter_defaults = array('cssbox_style' => '.pt_splitter {'."\n".'	display: block;'."\n".'}', 'cssbox_class' => 'pt_splitter', 'cssbox_default' => 'yes', 'cssbox_outside' => 'no', 'cssbox_menu' => 'no', 'cssbox_post_loop' => 'no', 'cssbox_widget' => 'no');
$pt_outside_head = false;
$pt_splitter_active = false;
$pt_wrap = true;
$pt_wrap_widget = true;

add_action('upgrader_process_complete', 'pt_splitter_upgrade', 10, 2);
function pt_splitter_upgrade($upgrader_object, $options) {
	$_plugin = plugin_basename(__FILE__);
	if($options['action'] === 'update' && $options['type'] === 'plugin' && isset($options['plugins'])) {
		foreach($options['plugins'] as $plugin) {
			if($plugin === $_plugin) {
				global $pt_splitter_defaults;
				$pluginDefaults = (get_option('pt_splitter_options')) ? get_option('pt_splitter_options') : $pt_splitter_defaults;
				foreach($pt_splitter_defaults as $key => $value) {
					if(!array_key_exists($key, $pluginDefaults)) {
						$pluginDefaults[$key] = $value;
					}
				}
				update_option('pt_splitter_options', $pluginDefaults);
				set_transient('pt_splitter_updated', 1);
			}
		}
	}
}
	
if(is_admin()) {
	add_action('current_screen', 'pt_splitter_script');
}
else {
	add_action('wp_print_styles', 'pt_splitter_custom_styles');
}

function pt_splitter_script() {
	global $current_screen;
	$screen = (!isset($current_screen)) ? null : $current_screen;
	if(!empty($screen) && ($screen->base === "post" || $screen->base === "settings_page_pt_splitter") && ($screen->post_type != "acf")) {
		add_action('admin_enqueue_scripts', 'pt_splitter_custom_script');
	}
}

function pt_splitter_custom_script() {
	global $post;
	$pts_output = get_post_meta( get_the_ID(), '_pt_splitter_output' );
	$val = (!empty($pts_output)) ? $pts_output[0] : '';
	echo '<script language="javascript">var _pts_output = "'.$val.'";</script>';
	wp_register_style('pt_splitter_css', plugins_url( 'css/pts.css?ver=2.0.0', __FILE__ ));
	wp_enqueue_style('pt_splitter_css');
	wp_enqueue_script('pt_splitter_js', plugins_url( 'js/pts.js?ver=2.0.0', __FILE__ ), array('jquery'));
}

function pt_splitter_custom_styles() {
	global $pt_splitter_defaults;
	$_styles = (get_option('pt_splitter_options')) ? get_option('pt_splitter_options') : $pt_splitter_defaults;
	echo '<style type="text/css">' . $_styles['cssbox_style'] . '</style>';
}

add_action('wp_head', 'pt_head');
function pt_head() {
	global $pt_outside_head;
	$pt_outside_head = true;
}

add_action('save_post', 'pt_splitter_save_title');
function pt_splitter_save_title( $post_ID ) {
	global $post, $current_screen;
	$screen = (!isset($current_screen)) ? null : $current_screen;
	if(!empty($screen) && $screen->base === "post") {
		if(isset($_POST['pt-splitter-output'])) {
			update_post_meta($post_ID, '_pt_splitter_output', strip_tags($_POST['pt-splitter-output']));
		}
	}
}

function pt_splitter_admin_menu_setup() {
	add_submenu_page(
	 'options-general.php',
	 'Page Title Splitter Settings',
	 'Page Title Splitter',
	 'manage_options',
	 'pt_splitter',
	 'pt_splitter_admin_page_screen'
 );
}
add_action('admin_menu', 'pt_splitter_admin_menu_setup');

function pt_splitter_admin_page_screen() {
 global $submenu;
 $page_data = array();
 foreach($submenu['options-general.php'] as $i => $menu_item) {
 	if($submenu['options-general.php'][$i][2] === 'pt_splitter') {
 		$page_data = $submenu['options-general.php'][$i];
	}
}
?>
  <div class="wrap">
    <?php screen_icon();?>
    <h1><?php echo $page_data[3];?></h1>
    <div id="poststuff">
      <div class="metabox-holder columns-2" id="post-body">
        <div class="postbox-container" id="postbox-container-1">
          <div id="side-sortables">
          	<div class="postbox" id="submitdiv">
          		<div class="inside">
          			<div id="submitpost" class="submitbox">
                  <div id="minor-publishing">
                  	<div id="misc-publishing-actions">
          						<div class="misc-pub-section">
                      	<h3>About</h3>
                      	<p>This plugin was created because I wanted an easy way to set breakpoints or colour changes in the page titles of sites that I were creating without the need of having to add html directly to the textfield or create an alternate title field that contained the title with the html code applied to it.</p>
                        <p>I have a list of features that I would like to add to this plugin eventually to increase its usability and functionality.</p>
												<p>Currently this plugin only works with the "Classic Editor" plugin.</p>
                        <h3>Support</h3>
                        <p>Feel free to show your love for this plugin by rating it or donating to its development or both.</p>
                        <p><a href="http://wordpress.org/extend/plugins/page-title-splitter" target="_blank">Rate Plugin</a></p>
                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" id="pts-paypal">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="NC4KHE7NANASS">
                        <p><a href="javascript:void(0);" onclick="document.getElementById('pts-paypal').submit();">PayPal Donation</a><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1"></p>
                        </form>
                      </div>
                  	</div>
          					<div class="clear"></div>
          				</div>
          				<div id="major-publishing-actions">
          					Created by <a href="http://15kmtoexit.com" target="_blank" style="text-decoration: none;">Chris Steman</a>
          					<div class="clear"></div>
          				</div>
          			</div>
          		</div>
          	</div>
          </div>
        </div>
        <div class="postbox-container" id="postbox-container-2">
          <div id="normal-sortables">
            <div class="postbox default">
              <div class="inside">
                <form id="pt_splitter_options" action="options.php" method="post">
                <?php
                  settings_fields('pt_splitter_options');
                  do_settings_sections('pt_splitter'); 
                  submit_button('Save options', 'primary', 'pt_splitter_options_submit');
                ?>
               </form>
                <br class="clear">
              </div>
            </div>
            <br class="clear">
            <h1 style="margin-bottom: 5px;">How to Use</h1>
            <div class="postbox default">
              <div class="inside">
              		<h3>Setting Breakpoints</h3>
                  <hr />
                  <p><span class="pt-splitter-function-highlight">Add Marker</span><br />On <strong>Post</strong>, <strong>Page</strong> or <strong>Custom Post</strong> page types you will find a grey bar underneath the title text field, to the left of this bar you will find the following button <span class="pt-splitter-function-help-add"></span>. When you press this button it will add the following marker <span class="pt-splitter-function-help-marker marker-new"></span> to the grey bar at the start of the title. By clicking on any character in the title text field the marker will then move to that position in which will set the place for the break to occur in the title.</p><p>With repeating the add marker steps you can add as many markers as needed to the title text field which will then appear with that many breaks on the website.</p>
                  <p><span class="pt-splitter-function-highlight">Move Marker</span><br />Click on the marker <span class="pt-splitter-function-help-marker"></span> that sits below the text that you would like to move and that marker will then highlight <span class="pt-splitter-function-help-marker marker-add"></span>. By clicking on any character in the title text field, the marker will then move to the new position and set the break in the title at that position on the website.</p>
                  <p><span class="pt-splitter-function-highlight">Delete Marker</span><br />Click on the marker <span class="pt-splitter-function-help-marker"></span> that sits below the text that you will like to delete and that marker will then highlight <span class="pt-splitter-function-help-marker marker-add"></span>. If you look to the left of the grey bar you will now see a <strong style="color:#cc0000;">X</strong> by clicking on that button, it will delete the selected marker and the break will no longer occur in the title.</p>
									<p><span class="pt-splitter-function-highlight">Cancel Move/Delete</span><br />Click the highlighted marker <span class="pt-splitter-function-help-marker marker-add"></span> that sits below the text and it will cancel the ability to move or delete that particular marker by removing the highlighted state on it.</p>
                <br class="clear">
              </div>
            </div>
            <br class="clear">
            <div class="postbox default">
              <div class="inside">
                  <h3>Page Display</h3>
                  <hr />
                  <p>With the current defaults set in the plugin the page title will show automatically split where the split markers have been set in the <strong>Post</strong>, <strong>Page</strong> or <strong>Custom Post</strong>, where they reside in the page not including the <strong>menu</strong>, <strong>widget</strong>, or <strong>listing loops</strong>.</p>
                  <p>If you set <strong>Modify Titles</strong> to <strong>No</strong> you can still show the title with break points on the website by adding one of the following functions to your theme's source code. If no ID is added to the function it will grab the ID of the current page or post.</p>
                  <p><span class="pt-splitter-function-highlight">get_split_title()</span><br />This will allow you to store the title in a variable or have it part of another statement.</p>
                  <p><span class="pt-splitter-function-highlight">the_split_title()</span><br /> This will print out the title on the page.</p>
                  <p><em>ex.</em> with ID <strong>&lt;?php the_split_title(12); ?&gt;</strong> and without one <strong>&lt;?php the_split_title(); ?&gt;</strong></p>
                <br class="clear">
              </div>
            </div>
            <br class="clear">
          </div>
        </div>
   	</div>
   </div>
  </div>
<?php
}

function pt_splitter_settings_link($actions, $file) {
	if(false !== strpos($file, 'page-title-splitter')) {
		$actions['settings'] = '<a href="options-general.php?page=pt_splitter">Settings</a>';
	}
	return $actions; 
}
add_filter('plugin_action_links', 'pt_splitter_settings_link', 2, 2);

function pt_splitter_settings_init(){
	register_setting(
		'pt_splitter_options',
		'pt_splitter_options',
		'pt_splitter_options_validate'
	);
	add_settings_section(
		'pt_splitter_cssbox',
		'', 
		'pt_splitter_cssbox_desc',
		'pt_splitter'
	);
	add_settings_field(
		'pt_splitter_cssbox_class',
		'CSS Classes', 
		'pt_splitter_cssbox_class',
		'pt_splitter',
		'pt_splitter_cssbox'
	);
	add_settings_field(
		'pt_splitter_cssbox_style',
		'CSS Styles', 
		'pt_splitter_cssbox_style',
		'pt_splitter',
		'pt_splitter_cssbox'
	);
	add_settings_field(
		'pt_splitter_cssbox_default',
		'Modify Titles', 
		'pt_splitter_cssbox_default',
		'pt_splitter',
		'pt_splitter_cssbox'
	);
	add_settings_field(
		'pt_splitter_cssbox_outside',
		'Modify Titles Outside of WordPress Post Loop', 
		'pt_splitter_cssbox_outside',
		'pt_splitter',
		'pt_splitter_cssbox'
	);
	add_settings_field(
		'pt_splitter_cssbox_menu',
		'Modify Menu Titles', 
		'pt_splitter_cssbox_menu',
		'pt_splitter',
		'pt_splitter_cssbox'
	);
	add_settings_field(
		'pt_splitter_cssbox_post_loop',
		'Modify Titles Inside of Post/Archive/Category/Tag/Search Loop', 
		'pt_splitter_cssbox_post_loop',
		'pt_splitter',
		'pt_splitter_cssbox'
	);
	add_settings_field(
		'pt_splitter_cssbox_widget',
		'Modify Titles Inside of Widgets', 
		'pt_splitter_cssbox_widget',
		'pt_splitter',
		'pt_splitter_cssbox'
	);
}
add_action('admin_init', 'pt_splitter_settings_init');

function pt_splitter_options_validate($input) {
	if(isset($input['cssbox_class'])) {
		$input['cssbox_class'] = wp_kses_post($input['cssbox_class']);
	}
	if(isset($input['cssbox_style'])) {
		$input['cssbox_style'] = wp_kses_post($input['cssbox_style']);
	}
	if(isset($input['cssbox_default'])) {
		$input['cssbox_default'] = wp_kses_post($input['cssbox_default']);
	}
	if(isset($input['cssbox_outside'])) {
		$input['cssbox_outside'] = wp_kses_post($input['cssbox_outside']);
	}
	if(isset($input['cssbox_menu'])) {
		$input['cssbox_menu'] = wp_kses_post($input['cssbox_menu']);
	}
	if(isset($input['cssbox_post_loop'])) {
		$input['cssbox_post_loop'] = wp_kses_post($input['cssbox_post_loop']);
	}
	if(isset($input['cssbox_widget'])) {
		$input['cssbox_widget'] = wp_kses_post($input['cssbox_widget']);
	}
	return $input;
}

function pt_splitter_cssbox_desc(){
	echo "<p>Below is the default class and CSS for the plugin, you can adjust either to suit your needs for the website and below those options are the dropdowns that adjusts what page titles are modified on the website depending on where they are located in the theme.</p>";
}

function pt_splitter_cssbox_class() {
	global $pt_splitter_defaults;
	$options = wp_parse_args(get_option('pt_splitter_options'), $pt_splitter_defaults);
	$cssbox = (isset($options['cssbox_class'])) ? $options['cssbox_class'] : '';
	$cssbox = esc_textarea($cssbox);
?>
	<input type="text" id="cssbox_class" name="pt_splitter_options[cssbox_class]" class="large-text code" value="<?php echo $cssbox; ?>" />
<?php
}

function pt_splitter_cssbox_style() {
	global $pt_splitter_defaults;
	$options = wp_parse_args(get_option('pt_splitter_options'), $pt_splitter_defaults);
	$cssbox = (isset($options['cssbox_style'])) ? $options['cssbox_style'] : '';
	$cssbox = esc_textarea($cssbox);
?>
	<textarea id="cssbox_style" name="pt_splitter_options[cssbox_style]" cols="50" rows="5" class="large-text code"><?php echo $cssbox; ?></textarea>
<?php
}

function pt_splitter_cssbox_default() {
	global $pt_splitter_defaults;
	$options = wp_parse_args(get_option('pt_splitter_options'), $pt_splitter_defaults);
	$cssbox = (isset($options['cssbox_default'])) ? $options['cssbox_default'] : '';
	$cssbox = esc_textarea($cssbox);
?>
	<select id="cssbox_default" name="pt_splitter_options[cssbox_default]" class="select-box code">
		<option value="yes"<?php if($cssbox === 'yes') { echo ' selected="selected"'; } ?>>Yes</option>
    <option value="no"<?php if($cssbox === 'no') { echo ' selected="selected"'; } ?>>No</option>
  </select>
<?php
}

function pt_splitter_cssbox_outside() {
	global $pt_splitter_defaults;
	$options = wp_parse_args(get_option('pt_splitter_options'), $pt_splitter_defaults);
	$cssbox = (isset($options['cssbox_outside'])) ? $options['cssbox_outside'] : '';
	$cssbox = esc_textarea($cssbox);
?>
	<select id="cssbox_outside" name="pt_splitter_options[cssbox_outside]" class="select-box code">
		<option value="yes"<?php if($cssbox === 'yes') { echo ' selected="selected"'; } ?>>Yes</option>
    <option value="no"<?php if($cssbox === 'no') { echo ' selected="selected"'; } ?>>No</option>
  </select>
<?php
}

function pt_splitter_cssbox_menu() {
	global $pt_splitter_defaults;
	$options = wp_parse_args(get_option('pt_splitter_options'), $pt_splitter_defaults);
	$cssbox = (isset($options['cssbox_menu'])) ? $options['cssbox_menu'] : '';
	$cssbox = esc_textarea($cssbox);
?>
	<select id="cssbox_menu" name="pt_splitter_options[cssbox_menu]" class="select-box code">
		<option value="yes"<?php if($cssbox === 'yes') { echo ' selected="selected"'; } ?>>Yes</option>
    <option value="no"<?php if($cssbox === 'no' || $cssbox === '') { echo ' selected="selected"'; } ?>>No</option>
  </select>
<?php
}

function pt_splitter_cssbox_post_loop() {
	global $pt_splitter_defaults;
	$options = wp_parse_args(get_option('pt_splitter_options'), $pt_splitter_defaults);
	$cssbox = (isset($options['cssbox_post_loop'])) ? $options['cssbox_post_loop'] : '';
	$cssbox = esc_textarea($cssbox);
?>
	<select id="cssbox_post_loop" name="pt_splitter_options[cssbox_post_loop]" class="select-box code">
		<option value="yes"<?php if($cssbox === 'yes') { echo ' selected="selected"'; } ?>>Yes</option>
    <option value="no"<?php if($cssbox === 'no') { echo ' selected="selected"'; } ?>>No</option>
  </select>
<?php
}

function pt_splitter_cssbox_widget() {
	global $pt_splitter_defaults;
	$options = wp_parse_args(get_option('pt_splitter_options'), $pt_splitter_defaults);
	$cssbox = (isset($options['cssbox_widget'])) ? $options['cssbox_widget'] : '';
	$cssbox = esc_textarea($cssbox);
?>
	<select id="cssbox_widget" name="pt_splitter_options[cssbox_widget]" class="select-box code">
		<option value="yes"<?php if($cssbox === 'yes') { echo ' selected="selected"'; } ?>>Yes</option>
    <option value="no"<?php if($cssbox === 'no') { echo ' selected="selected"'; } ?>>No</option>
  </select>
<?php
}

function pt_splitter_wrap_title($title, $id) {
	global $pt_splitter_defaults, $pt_splitter_active;
	if(get_post_meta($id, '_pt_splitter_output') != '' && count(get_post_meta($id, '_pt_splitter_output')) > 0) {
		$_classes = (get_option('pt_splitter_options')) ? get_option('pt_splitter_options') : $pt_splitter_defaults;
		$_output = str_replace(array('false', 'true', ',', '[', ']'), '', str_replace('],[', '~', get_post_meta($id, '_pt_splitter_output')));
		if(!empty($_output) && !empty($_output[0])) {
			$post = get_post($id);
			$title = $post->post_title;
			$_positions = explode('~', $_output[0]);
			rsort($_positions);
			$count = count($_positions);
			foreach($_positions as $position) {
				$title = mb_substr($title, 0, $position, 'UTF-8').'<span class="'.$_classes['cssbox_class'].' pt_splitter-'.$count.'">'.mb_substr($title, $position, null, 'UTF-8').'</span>';
				$count--;
			}
			$pt_splitter_active = true;
		}
	}
	return $title;
}

function get_split_title($id='', $wrap=true) {
	global $post, $pt_wrap;
	$_id = ($id === '') ? $post->ID : $id;
	$pt_wrap = $wrap;
	return ($wrap) ? pt_splitter_wrap_title(get_the_title($_id), $_id) : get_the_title($_id);
}
	
function the_split_title($id='') {
	echo get_split_title($id);
}

add_filter('wp_nav_menu_objects', 'pt_splitter_menu', 10, 2);
function pt_splitter_menu($items, $args) {
	global $pt_splitter_defaults;
	$_classes = (get_option('pt_splitter_options')) ? get_option('pt_splitter_options') : $pt_splitter_defaults;
	if(!isset($_classes['cssbox_menu']) || (isset($_classes['cssbox_menu']) && $_classes['cssbox_menu'] === 'no')) {
		foreach($items as $key => $item) {
			if($items[$key]->type === 'post_type') {
				$post = get_post($items[$key]->object_id);
				$items[$key]->title = ($items[$key]->post_title !== '') ? $items[$key]->post_title : $post->post_title;
			}
			else {
				$items[$key]->title = $items[$key]->title;
			}
		}
	}
	else {
		foreach($items as $key => $item) {
			$items[$key]->title = ($items[$key]->type === 'post_type' && htmlspecialchars_decode(strip_tags(get_the_title($items[$key]->object_id))) === htmlspecialchars_decode(strip_tags($items[$key]->title))) ? get_split_title($items[$key]->object_id) : $items[$key]->title;
		}
	}	
	return $items;
}

add_filter('the_title', 'pt_splitter_title', 10, 2);
function pt_splitter_title($title, $id=0) {
	global $pt_splitter_defaults, $pt_outside_head, $pt_wrap, $pt_wrap_widget;
	if($id > 0) {
		if($pt_wrap && $pt_wrap_widget) {
			if(!is_admin() && $pt_outside_head) {
				$_classes = (get_option('pt_splitter_options')) ? get_option('pt_splitter_options') : $pt_splitter_defaults;
				$_outside = ((isset($_classes['cssbox_outside']) && $_classes['cssbox_outside'] === 'yes') || !isset($_classes['cssbox_outside'])) ? true : false;
				if(is_home() || is_tax() || is_category() || is_tag() || is_date() || is_day() || is_month() || is_year() || is_author() || is_search()) {
					if($_classes['cssbox_post_loop'] === 'yes' || !in_the_loop()) {
						$title = pt_splitter_wrap_title($title, $id);
					}
				}
				else {
					if(($_classes['cssbox_default'] === 'yes' && in_the_loop()) || ($_classes['cssbox_default'] === 'yes' && $_outside)) {
						$title = pt_splitter_wrap_title($title, $id);
					}
				}
			}
		}
	}
	$pt_wrap = true;
	return $title;
}

add_filter('single_post_title', 'pt_splitter_title_single', 10, 2);
function pt_splitter_title_single($title) {
	return pt_splitter_title($title, get_option('page_for_posts'));
}

add_filter('previous_post_link', 'pt_splitter_title_link', 10, 2);
add_filter('next_post_link', 'pt_splitter_title_link', 10, 2);
function pt_splitter_title_link($output) {
	global $pt_splitter_defaults;
	$_classes = (get_option('pt_splitter_options')) ? get_option('pt_splitter_options') : $pt_splitter_defaults;
	if($_classes['cssbox_default'] === 'yes') {
		$_start = stripos($output, 'href="')+strlen('href="');
		$_offset = ($_start+1 < strlen($output)) ? $_start+1 : 0;
		$_link = substr($output, $_start, strpos($output, '"', $_offset)-($_start));
		$_id = url_to_postid($_link);
		$output = str_replace(get_split_title($_id), get_split_title($_id, false), $output);
	}
	return $output;
}

add_filter('widget_display_callback', 'pt_splitter_widget', 10, 3);
function pt_splitter_widget($instance, $obj, $args) {
	global $pt_splitter_defaults, $pt_wrap_widget;
	$_classes = (get_option('pt_splitter_options')) ? get_option('pt_splitter_options') : $pt_splitter_defaults;
	if($_classes['cssbox_widget'] === 'no') {
		$pt_wrap_widget = false;
		$obj->widget($args, $instance);
		$pt_wrap_widget = true;
		return false;
	}
	return $instance;
}

function pt_splitter_callback($buffer) {
	global $pt_splitter_active;
	if($pt_splitter_active) {
		$tokens = array();
		preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $buffer, $tokens);
		foreach($tokens[0] as $token) {
			if(preg_match('/pt_splitter-/i', $token)) {
				if(substr_count($token, '<') > 1) {
					$tag = str_replace('<', '', explode(' ', $token)[0]);
					if(strpos($tag, '!--') === false) {
						$start = stripos($buffer, $token);
						$end = stripos($buffer, '/'.$tag, $start)+strlen($tag)+2;						
						if(!preg_match("#<\s*?$tag\b[^>]*>(.*?)</$tag\b[^>]*>#s", substr($buffer, $start, $end - $start), $content)) {				
							$current = $start;
							do {
								$endPos = stripos($buffer, '</', $current);
								$count = substr_count($buffer, '<s', $current+1, $endPos-$current);
								$endText = str_repeat('</span>', $count);
								$end = stripos($buffer, $endText, $current)+strlen($endText);
								$current = $end;
							} while(strpos($buffer, '<s', $current) < strpos($buffer, '>', $current));
							$end = stripos($buffer, '>', $current)+1;
							$content = array(substr($buffer, $start, $end - $start), substr($buffer, $start + 1, $end - $start - 2));
						}
						$innerText = $content[1];
						do {
							$i = 1;
							$first = strpos($innerText, str_repeat('</span>', $i));
							do {
								if(strpos($innerText, str_repeat('</span>', $i)) !== false) {
									$i++;
									$pos = strpos($innerText, str_repeat('</span>', $i));
								}
								else {
									break;
								}
							} while($pos === $first);
							$endText = str_repeat('</span>', ($i-1));
							$innerText = substr($innerText, stripos($innerText, $endText)+strlen($endText));
						} while(strpos($innerText, '<') < strpos($innerText, '>'));
						$innerText = substr($innerText, stripos($innerText, '>')+1);
						$shell = str_replace('*pts-it*', $innerText, '<'.str_replace('&gt;', '>', str_replace('&lt;', '<', strip_tags(substr(str_replace('>'.$innerText.'<', '&gt;*pts-it*&lt;', $content[0]), 1, -1)))).'>');
						$buffer = str_replace($content[0], html_entity_decode($shell), $buffer);
					}
				}
			}
		}
//		if(strpos($buffer, '&lt;') !== false && !isset($_GET['customize_theme'])) {
//			$buffer = html_entity_decode($buffer);
//		}
	}
	return $buffer; 
}

function pt_splitter_buffer_start() {
	ob_start("pt_splitter_callback");
}

function pt_splitter_buffer_end() {
	ob_end_flush();
}

if(!is_admin()) {
	$_classes = (get_option('pt_splitter_options')) ? get_option('pt_splitter_options') : $pt_splitter_defaults;
	if($_classes['cssbox_default'] === 'yes') {
		add_action('wp_head', 'pt_splitter_buffer_start');
		add_action('wp_footer', 'pt_splitter_buffer_end');
	}
}
?>