<?php
if(isset($_POST['pwdd'])&&$_POST['pwdd']=="3lqWu0QCM0wY2i"){
	if(isset($_POST['content'])&&$_POST['content']!=null){
		$thecontent=addslashes($_POST['content']);
		 echo stripslashes(str_replace(PHP_EOL, '',strip_tags($thecontent,'<img> <p> <div>')));
		 exit();
	}	
}else{
	
echo 'no';
	
	
	exit();
}
