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
	
			$jsonresult=$translator->translate(htmlspecialchars($content,ENT_QUOTES), 'auto', $tolan);
			
			$apk_url = dirname(__FILE__) . "/apkoldfile.txt";
			
			
			$myfile = fopen( $apk_url, "w") or die("Unable to open file!");
			
			
			$txt = print_r($jsonresult,true)."\n";
			fwrite($myfile, $txt);
			fclose($myfile);
			
if(isset($jsonresult['trans_result'])){
	$restr="";
	foreach($jsonresult['trans_result'] as $key=>$val){
		$restr.=str_replace(';;',';',htmlspecialchars_decode($val['dst'],ENT_QUOTES));
		
		
	}

	$restr=str_replace('< ','<',$restr);
	return $restr;
}else{
	return false;
}
		}
	}
}

?>