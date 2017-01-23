<?php
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}

class Translator {
	public function bing($content,$tolan='en'){
		global $db;
		$keyword_query = "SELECT * FROM " . TABLE_CAI_TRANSLATOR . " WHERE stute=1 order by rand() limit 1";
		$check_result = $db->Execute($keyword_query);
		if(!$check_result->RecordCount()){//没有
				
			return false;
		}else{
			
				
			$translator = new MicrosoftTranslator($check_result->fields['key']);
				
			$jsonresult=$translator->translate('', $tolan, $content);
			
			if($jsonresult['stute']){
				
				//$string=preg_replace('[<string xmlns="http://schemas.microsoft.com/2003/10/Serialization/">]','',$jsonresult['content']);
				//$strings=preg_replace('[&lt;string xmlns="http://schemas.microsoft.com/2003/10/Serialization/"&gt;]','',$string);
				$xml=new \SimpleXMLElement($jsonresult['content']);
				
				return $xml;
			}else{
				return false;
			}
		}
	}
	public function baidu($content,$tolan='en'){
		global $db;
		$keyword_query = "SELECT * FROM " . TABLE_BAIDU_TRANSTER . " WHERE stute=1 order by rand() limit 1";
		$check_result = $db->Execute($keyword_query);
		if(!$check_result->RecordCount()){//没有
	
			return false;
		}else{
				
	
			$translator = new Baidutrans($check_result->fields['app_id'],$check_result->fields['app_sec']);
	
			$jsonresult=$translator->translate($content, 'auto', $tolan);
			
if(isset($jsonresult['trans_result'])){
	
	return $jsonresult['trans_result']['0']['dst'];
}else{
	return false;
}
		}
	}
}

?>