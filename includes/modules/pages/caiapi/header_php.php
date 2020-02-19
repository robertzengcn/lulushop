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
//  require(DIR_WS_CLASSES.'MicrosoftTranslator.class.php');
 
 if (!defined('IS_ADMIN_FLAG')) {
 	die('Illegal Access');
 }
 if(isset($_REQUEST['apikey'])&&$_REQUEST['apikey']=="9ewUASP685"){
 	$caiji=new caiji();
 	$type=isset($_REQUEST['type'])&&$_REQUEST['type']?$_REQUEST['type']:"";
 	$url=isset($_REQUEST['url'])&&$_REQUEST['url']?$_REQUEST['url']:"";
 	$title=isset($_REQUEST['title'])&&$_REQUEST['title']?$_REQUEST['title']:"";
 	$content=isset($_REQUEST['content'])&&$_REQUEST['content']?$_REQUEST['content']:"";
 	$catelogue=isset($_REQUEST['catelogue'])&&$_REQUEST['catelogue']?$_REQUEST['catelogue']:"";
 	$length=isset($_REQUEST['length'])&&$_REQUEST['length']?$_REQUEST['length']:"";
 
 	switch($type){
 		case 'getkeyword':
 			$caiji->getkeyword();
 			break;
 		case 'checklist':
 			$caiji->checklist($url);
 			break;	
 		case 'savearticle':
 			if($title==""||$content==""){
 				echo '1';//鏂囩珷缂哄皯鍏冪礌
 				exit();
 			}
 			$caiji->savearticle($title,$content,$catelogue,$url);
 			break;
 		case 'removehtml':
 			$caiji->removehtml($content,$length);
 			break;
 		case 'getarticle':	
 			$caiji->getarticle($catelogue);
 			break;
 		case 'checklink':
 			$caiji->checklink($url);			
 			break;
 		case 'trimcontent':
 			$caiji->trimcontent($content);
 		default:
 						
 	}

 }else{
 	echo "key wrong";
 }
 
exit();

?>