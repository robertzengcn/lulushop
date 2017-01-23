<?php
/**
 * caiji api
 *
 * @package page
 * @copyright Copyright 2007-2008 Numinix http://www.numinix.com
 * @copyright Portions Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 3 2010-09-18 00:29:43Z numinix $
 */


 require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
 require(DIR_WS_CLASSES.'caiji.php');
 require(DIR_WS_CLASSES.'MicrosoftTranslator.class.php');
 
 if (!defined('IS_ADMIN_FLAG')) {
 	die('Illegal Access');
 }
 if(isset($_REQUEST['apikey'])&&$_REQUEST['apikey']=="9ewUASP685"){
 	$caiji=new caiji();
 	$type=isset($_REQUEST['type'])&&$_REQUEST['type']?$_REQUEST['type']:"";
 	$url=isset($_REQUEST['url'])&&$_REQUEST['url']?$_REQUEST['url']:"";
 	switch($type){
 		case 'getkeyword':
 			$caiji->getkeyword();
 			break;
 		case 'checklist':
 			$caiji->checklist($url);
 			break;		
 			
 			
 			
 				
 			
 	}

 }else{
 	echo "key wrong";
 }
 
exit();

?>