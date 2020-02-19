<?php
if(isset($_POST['pwdd'])&&$_POST['pwdd']=="3lqWu0QCM0wY2i"){
	if(isset($_POST['content'])&&$_POST['content']!=null){
		$thecontent=$_POST['content'];
		 $scontent=htmlspecialchars(str_replace(PHP_EOL, '',strip_tags($thecontent,'<img><p><div>')),ENT_QUOTES);
		 $str = str_replace(array("\t","http:www.aliexpress.com","https:www.aliexpress.com","www.aliexpress.com"), "", $scontent);		 
		 $str=preg_replace('/(\v|\s)+/', ' ', $str);
		 echo $str;
		 exit();
	}	
}else{
	
echo 'no';
	
	
	exit();
}
