<?php
/**
 * 翻译 api
 *
 * @package page
 * @copyright Copyright 2007-2008 Numinix http://www.numinix.com
 * @copyright Portions Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 3 2010-09-18 00:29:43Z numinix $
 */



 require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

 require(DIR_WS_CLASSES.'MicrosoftTranslator.class.php');
 require(DIR_WS_CLASSES.'translator.php'); 
 require(DIR_WS_CLASSES.'baidutrans.php');

 if (!defined('IS_ADMIN_FLAG')) {
 	die('Illegal Access');
 }
 if(isset($_REQUEST['apikey'])&&$_REQUEST['apikey']=="9ewUASP685"){
 	if(!isset($_REQUEST['content'])||strlen($_REQUEST['content'])<1){
 		die('0');
 	}else{
 		$content=$_REQUEST['content'];
 	}
 	
 	$type=isset($_REQUEST['type'])?$_REQUEST['type']:"bing";
 	
 	
 	$translator=new Translator();
 	switch($type){
 		case 'bing':
 			
 			$result=$translator->bing($content);
 			break;
 		case 'baidu':
 			$result=$translator->baidu($content);
 			break; 			
 		default:
 			die('0');	
 	}
 	echo $result;
 	exit();
 	

 	
 
	
 			
 			
 			
 				
 			
 	

 }else{
 	echo "key wrong";
 }
 
exit();

?>