<?php
/**
 * Common Template
 *
 * outputs the html header. i,e, everything that comes before the \</head\> tag <br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: DrByte  Tue Jul 17 16:02:00 2012 -0400 Modified in v1.5.1 $
 */
/**
 * load the module for generating page meta-tags
 */
require(DIR_WS_MODULES . zen_get_module_directory('meta_tags.php'));
/**
 * load the module which retrieves data from the database
 */
require(DIR_WS_MODULES . zen_get_module_directory('main_page.php'));
/**
 * output main page HEAD tag and related headers/meta-tags, etc
 */
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js gt-ie8"> <!--<![endif]-->
<head>
<title><?php echo META_TAG_TITLE; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="keywords" content="<?php echo META_TAG_KEYWORDS; ?>" />
<meta name="description" content="<?php echo META_TAG_DESCRIPTION; ?>" />
<meta http-equiv="imagetoolbar" content="no" />
    
<!-- ===================== Touch Icons ===================== -->
<link rel="shortcut icon" href="favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="includes/templates/mars/images/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="includes/templates/mars/images/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="includes/templates/mars/images/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="includes/templates/mars/images/apple-touch-icon-precomposed.png">

 <!-- ===================== Facebook "like" Meta Tags ===================== --> 
<meta property="og:title" content="<?php echo META_TAG_TITLE; ?>" />
<meta property="og:url" content="http://<?php echo $_SERVER["SERVER_NAME"]?><?php echo $_SERVER['REQUEST_URI'];?>" />
<?php if(META_TAG_PRODUCT_IMAGE=="META_TAG_PRODUCT_IMAGE"){?>
<meta property="og:image" content="<?php echo HTTP_SERVER . DIR_WS_CATALOG ?>includes/templates/mars/images/logo.png";  />
<?php }else{ ?>
<meta property="og:image" content="<?php echo HTTP_SERVER . DIR_WS_CATALOG ?>images/<?php echo META_TAG_PRODUCT_IMAGE;?>" />
<meta property="og:type" content="product" />
<?php } ?>

<meta property="og:site_name" content="<?php echo META_TAG_TITLE; ?>"/>
<meta property="og:description" content="<?php echo META_TAG_DESCRIPTION; ?>"/>
<meta property="og:locale" content="en_US" />  



<?php if (defined('ROBOTS_PAGES_TO_SKIP') && in_array($current_page_base,explode(",",constant('ROBOTS_PAGES_TO_SKIP'))) || $current_page_base=='down_for_maintenance' || $robotsNoIndex === true) { ?>
<meta name="robots" content="noindex, nofollow" />
<?php } ?>
<?php if (defined('FAVICON')) { ?>
<link rel="icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo FAVICON; ?>" type="image/x-icon" />
<?php } //endif FAVICON ?>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ); ?>" />
<?php if (isset($canonicalLink) && $canonicalLink != '') { ?>
<link rel="canonical" href="<?php echo $canonicalLink; ?>" />
<?php } ?>

<?php
/**
* load the loader files
*/

if($RI_CJLoader->get('status') && (!isset($Ajax) || !$Ajax->status())){
	$RI_CJLoader->autoloadLoaders();
	$RI_CJLoader->loadCssJsFiles();
	$files = $RI_CJLoader->header();	
	
	foreach($files['css'] as $file)
		if($file['include']) {
      include($file['src']);
    } else if (!$RI_CJLoader->get('minify_css') || $file['external']) {
      echo '<link rel="stylesheet" type="text/css" href="'.$file['src'].'" />'."\n";
    } else {
      echo '<link rel="stylesheet" type="text/css" href="min/?f='.$file['src'].'&amp;'.$RI_CJLoader->get('minify_time').'" />'."\n";
    }
    require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_JS_HEADER));
	foreach($files['jscript'] as $file)
		if($file['include']) {
      include($file['src']);
    } else if(!$RI_CJLoader->get('minify_js') || $file['external']) {
      echo '<script type="text/javascript" src="'.$file['src'].'"></script>'."\n";
    } else {
      echo '<script type="text/javascript" src="min/?f='.$file['src'].'&amp;'.$RI_CJLoader->get('minify_time').'"></script>'."\n";
    }
}
?>

<?php 
  /**
   * load the Mars custom css file, you can edit the content by going to Tools -> Define Pages Editor -> define_custom_css.php
   */    
    //require(zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_CUSTOM_CSS, 'false'));     
?>

<?php 
/**
 * load the necessary custom Mars theme script files
 */      
  
  if (in_array($current_page_base,explode(",",'checkout')) ) {
	$minibootstrap = true;
  }
  if($minibootstrap){
?>
<link href="/includes/templates/mars/css/bootstrap.min.css" rel="stylesheet">


  <?php }?>


<?php 
/**
 * load all site-wide jscript_*.js files from includes/templates/YOURTEMPLATE/jscript, alphabetically
 */
  // $directory_array = $template->get_template_part($template->get_template_dir('.js',DIR_WS_TEMPLATE, $current_page_base,'jscript'), '/^jscript_/', '.js');
  // while(list ($key, $value) = each($directory_array)) {
    // echo '<script type="text/javascript" src="' .  $template->get_template_dir('.js',DIR_WS_TEMPLATE, $current_page_base,'jscript') . '/' . $value . '"></script>'."\n";
  // }

/**
 * load all page-specific jscript_*.js files from includes/modules/pages/PAGENAME, alphabetically
 */
  // $directory_array = $template->get_template_part($page_directory, '/^jscript_/', '.js');
  // while(list ($key, $value) = each($directory_array)) {
    // echo '<script type="text/javascript" src="' . $page_directory . '/' . $value . '"></script>' . "\n";
  // }

/**
 * load all site-wide jscript_*.php files from includes/templates/YOURTEMPLATE/jscript, alphabetically
 */
  // $directory_array = $template->get_template_part($template->get_template_dir('.php',DIR_WS_TEMPLATE, $current_page_base,'jscript'), '/^jscript_/', '.php');
  // while(list ($key, $value) = each($directory_array)) {
/**
 * include content from all site-wide jscript_*.php files from includes/templates/YOURTEMPLATE/jscript, alphabetically.
 * These .PHP files can be manipulated by PHP when they're called, and are copied in-full to the browser page
 */
    // require($template->get_template_dir('.php',DIR_WS_TEMPLATE, $current_page_base,'jscript') . '/' . $value); echo "\n";
  // }
/**
 * include content from all page-specific jscript_*.php files from includes/modules/pages/PAGENAME, alphabetically.
 */
  // $directory_array = $template->get_template_part($page_directory, '/^jscript_/');
  // while(list ($key, $value) = each($directory_array)) {
/**
 * include content from all page-specific jscript_*.php files from includes/modules/pages/PAGENAME, alphabetically.
 * These .PHP files can be manipulated by PHP when they're called, and are copied in-full to the browser page
 */
    // require($page_directory . '/' . $value); echo "\n";
  // }

// DEBUG: echo '<!-- I SEE cat: ' . $current_category_id . ' || vs cpath: ' . $cPath . ' || page: ' . $current_page . ' || template: ' . $current_template . ' || main = ' . ($this_is_home_page ? 'YES' : 'NO') . ' -->';

?>


</head>
<?php // NOTE: Blank line following is intended: ?>

