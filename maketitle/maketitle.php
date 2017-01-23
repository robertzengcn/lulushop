<?php
if(isset($_REQUEST['pwdd'])&&$_REQUEST['pwdd']=="3lqWu0QCM0wY2i"){
	if(isset($_REQUEST['title'])&&$_REQUEST['title']!=null){
		
		$maketitle = new maketitle();
		$result=$maketitle->usubstr($_REQUEST['title'],0,79);
		echo $result;
		exit();
	}else{
		echo 'date not enough';
	}
}else{
	echo 'password wrong or login expire';
}

class maketitle{
	private $find=array('bluedio','cnoceanship','blueple','crdc','mpow','venstar','esonteam','jiabosi','ggmm','senbono','AOFLY','taobao','&','aliexpress','free shipping','DEPRO','DEPRO','spider-man','Stussy','Heat','Chicago Bulls','Oakley','Diamond','AWEI','JOWAY','PLEXTONE','BOAS','Cosonic','Mosidun','Somic','REMAX','Bluedio','JBMMJ','Syllable','Zealot','isk','Bingle','TAKSTAR','KEENION','Sades','LKER','KOTION','Moxpad','Macaw','Aigo','Mrice','ESTONE','ZELOTES','iMICE','Fantech','AZZOR','RAJFOO','Wowpen-joy','JWFY','Beitas','VODOOL');
	private $replace=array("");
// 	str_replace($find,$replace,$arr)
	public function usubstr($stro, $start=0, $length = null)
	{
	
		$str=str_ireplace($this->find,$this->replace,$stro);
		// 先正常截取一遍.
		$res = substr($str, $start, $length);
		$strlen = strlen($str);
	
		/* 接着判断头尾各6字节是否完整(不残缺) */
		// 如果参数start是正数
		if ($start >= 0) {
			// 往前再截取大约6字节
			$next_start = $start + $length; // 初始位置
			$next_len = $next_start + 6 <= $strlen ? 6 : $strlen - $next_start;
			$next_segm = substr($str, $next_start, $next_len);
			// 如果第1字节就不是 完整字符的首字节, 再往后截取大约6字节
			$prev_start = $start - 6 > 0 ? $start - 6 : 0;
			$prev_segm = substr($str, $prev_start, $start - $prev_start);
		} // start是负数
		else {
			// 往前再截取大约6字节
			$next_start = $strlen + $start + $length; // 初始位置
			$next_len = $next_start + 6 <= $strlen ? 6 : $strlen - $next_start;
			$next_segm = substr($str, $next_start, $next_len);
	
			// 如果第1字节就不是 完整字符的首字节, 再往后截取大约6字节.
			$start = $strlen + $start;
			$prev_start = $start - 6 > 0 ? $start - 6 : 0;
			$prev_segm = substr($str, $prev_start, $start - $prev_start);
		}
		// 判断前6字节是否符合utf8规则
		if (preg_match('@^([x80-xBF]{0,5})[xC0-xFD]?@', $next_segm, $bytes)) {
			if (!empty($bytes[1])) {
				$bytes = $bytes[1];
				$res .= $bytes;
			}
		}
		// 判断后6字节是否符合utf8规则
		$ord0 = ord($res[0]);
		if (128 <= $ord0 && 191 >= $ord0) {
			// 往后截取 , 并加在res的前面.
			if (preg_match('@[xC0-xFD][x80-xBF]{0,5}$@', $prev_segm, $bytes)) {
				if (!empty($bytes[0])) {
					$bytes = $bytes[0];
					$res = $bytes . $res;
				}
			}
		}
// 		if (strlen($res) < $strlen) {
// 			$res = $res . '...';
// 		}
		return trim($res);
	}
}