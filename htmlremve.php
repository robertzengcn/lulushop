<?php
if(isset($_POST['pwdd'])&&$_POST['pwdd']=="3lqWu0QCM0wY2i"){
	if(isset($_POST['content'])&&$_POST['content']!=null){
		$thecontent=addslashes($_POST['content']);
		 $str=preg_replace('/(\v|\s)+/', ' ', substr(str_replace(PHP_EOL, '',strip_tags($thecontent)),0,2000));
		 
		 echo $str;
		 exit();
	}	
}else{
	
echo 'no';
	
	
	exit();
}
