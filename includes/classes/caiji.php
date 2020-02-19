<?php
/**
 * File contains the order-processing class ("order")
 *
 * @package classes
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: Ian Wilson  Fri Jun 1 14:21:21 2012 +0000 Modified in v1.5.1 $
 */
/**
 * order class
 *
 * Handles all order-processing functions
 *
 * @package classes
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
class caiji extends base {
	/*
	 * 鑾峰彇鎼滅储鍏抽敭璇�
	 * 
	 * */
	public function getkeyword(){
		global $db;
		$keyword_query = "SELECT kl.keyword as keyword,cc.catelogue_name as catelogue_name FROM " . TABLE_CAI_KEYWORD_LIST . " as kl LEFT JOIN ".TABLE_CAI_CATELOGUE." as cc
                           ON kl.catalogue_id=cc.id WHERE kl.stute=1 order by rand() limit 1";
		$check_result = $db->Execute($keyword_query);
		if(!$check_result->RecordCount()){
			echo "no";
		}else{
			$result=$check_result->fields['keyword']."|".$check_result->fields['catelogue_name'];
		
			echo $result;
		}
		exit();
	}
	/*
	 * 妫�煡url鏄惁瀛樺湪
	 * 
	 * */
	public function checklist($url){
		global $db;
		$keyword_query = "SELECT * FROM " . TABLE_CAI_ARTICLE . " WHERE url=:url";
		$keyword_query  =$db->bindVars($keyword_query, ':url', $url, 'string');
		$check_result = $db->Execute($keyword_query);
		if(!$check_result->RecordCount()){
			echo 0;
		}else{					
			echo 1;
		}
		exit();
	}
	
	/*
	 * 淇濆瓨鏂囩珷
	 * */
	public function savearticle($title,$content,$catelogue,$url){
		$sql_data_array=array('title'=>$title,
				               'content'=>$content,
				              'keyword'=>$catelogue,
				               'time'=>date('Y-m-d H:i:s',time()),
				                'url'=>$url,
				                
				
		);
		
		zen_db_perform(TABLE_CAI_ARTICLE, $sql_data_array);
		exit();
	}
	
	/**
	 * 绉婚櫎html
	 * */
	public function removehtml($content,$length=800){
		$string=strip_tags($content,'<img>');
		echo mb_substr($string,0,$length);
		exit();
	}
	
	
	/**
	 * 鑾峰彇鏂囩珷
	 * */
	public function getarticle($keyword){
		global $db;
		$article_query = "SELECT * FROM " . TABLE_CAI_ARTICLE . " WHERE keyword=:keyword and statu=0";
		$article_query  =$db->bindVars($article_query, ':keyword', $keyword, 'string');
		$check_result = $db->Execute($article_query);
		
		if(!$check_result->RecordCount()){
			echo "n";
		}else{//濡傛灉鏈夋枃绔�
			$articleid=$check_result->fields['id'];
			
			$updatestute="update ". TABLE_CAI_ARTICLE ." SET statu=1 WHERE id={$articleid}";
			
			$db->Execute($updatestute);//璁剧疆鏂囩珷涓哄凡鍙戝竷
			echo json_encode(array('title'=>$check_result->fields['title'],'content'=>$check_result->fields['content']));
		}
		exit();
	}
	
	/**
	 * 鑾峰彇浜у搧閾炬帴
	 * */
	public function getlink(){
		global $db;
		$link_query = "SELECT url FROM " . TABLE_CAI_URL . " WHERE 1=1 ORDER BY rand()";		
		$link_result = $db->Execute($link_query);		
	}
	
	/**
	 * 妫�煡浜у搧閾炬帴鏄惁宸茬粡閲囬泦
	 * */
	public function checklink($link){
		global $db;
		$link_query = "SELECT link FROM " . TABLE_CAI_PRODUCTLINK . " WHERE link=:link";
		$link_query  =$db->bindVars($link_query, ':link', $link, 'string');
		$check_result = $db->Execute($link_query);
		if(!$check_result->RecordCount()){//濡傛灉涓嶅瓨鍦ㄦ敼浜у搧
			
			
			$array=array('link'=>$link,'time'=>date('Y-m-d H:i:s',time()));
			zen_db_perform(TABLE_CAI_PRODUCTLINK, $array);
			echo 0;exit();
		}else{//濡傛灉鏈夋敼浜у搧
			echo 1;exit();
		}
		
	}
	
	/**
	 * 删除字符串前后空格
	 * */
	public function trimcontent($content){
		echo trim($content);
		exit();
	}
	
	
  

}
