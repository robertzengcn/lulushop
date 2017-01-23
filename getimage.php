<?php
error_reporting(0);
require_once __DIR__ . '/autoload.php';

use Qiniu\Auth;

// 引入上传类
use Qiniu\Storage\UploadManager;

// $_REQUEST['pwdd']="3lqWu0QCM0wY2i";
// $_REQUEST['imageurl']='https://ae01.alicdn.com/kf/HTB1BWrBKXXXXXXeXFXXq6xXFXXXN/Seibertron-new-waterproof-Molle-Tactical-14-inch-Laptop-Sling-BAG-Backpack-laptop-bag-khaki-black.jpg';


if(isset($_REQUEST['pwdd'])&&$_REQUEST['pwdd']=="3lqWu0QCM0wY2i"){
	if(isset($_REQUEST['imageurl'])&&$_REQUEST['imageurl']!=null){
		$str=$_REQUEST['imageurl'];
$filename=basename($str);
$tempu=parse_url($_REQUEST['imageurl']);
$thehostname=$tempu['host'];
$qiniuhost='image.lulusc.com';
$savefile=str_replace($thehostname,$qiniuhost,$str);

$fulllink=parse_url($_REQUEST['imageurl']);
$thefiles=substr($fulllink['path'],1);




$makeimage = new makeimage();
//$imgfile=$makeimage->getImage($_POST['imageurl']);
$result=$makeimage->getImageInfo($_REQUEST['imageurl']);
if($result){

//$filepath=dirname(__FILE__).$filename;

// 需要填写你的 Access Key 和 Secret Key
$accessKey = 'jMN6FOc_k_8TWSoMNfSs-KSDNKChPa59l5l-4ZFx';
$secretKey = 'ud5MW5efpiTEXo4TlBfClQ8AODWyCtilBNYhfRHu';

// 构建鉴权对象
$auth = new Auth($accessKey, $secretKey);

// 要上传的空间
$bucket = 'crunkmusicer';

// 生成上传 Token
$token = $auth->uploadToken($bucket);

// 要上传文件的本地路径
$filePath = $filename;

// 上传到七牛后保存的文件名
$key = $thefiles;

// 初始化 UploadManager 对象并进行文件的上传。
$uploadMgr = new UploadManager();

// 调用 UploadManager 的 putFile 方法进行文件的上传。
list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
//echo "\n====> putFile result: \n";
$qiniuurl=$savefile;
unlink($filename);
if ($err !== null) {
//     print_r($err);
// 	print_r($err->body);
// 	exit();
	//echo $_REQUEST['imageurl'];
	
$ch = curl_init(); 
$timeout = 10; 
curl_setopt ($ch, CURLOPT_URL, $qiniuurl); 
curl_setopt($ch, CURLOPT_HEADER, 1); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
$contents = curl_exec($ch); 

if(false == $contents) 
{ 
echo $_REQUEST['imageurl'];
} 
else 
{ 
echo $savefile;
}
	
} else {
    //var_dump($ret);
	echo $savefile;
}

}else{
	echo $_REQUEST['imageurl'];
}


	}	
}
class makeimage{
	
function getImage($url,$filename='',$type=0){
    if($url==''){return false;}
    if($filename==''){
        $ext=strrchr($url,'.');
        
        $filename=basename($url);
    }
    //文件保存路径
    if($type){
  $ch=curl_init();
  $timeout=5;
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  $img=curl_exec($ch);
  curl_close($ch);
    }else{
     ob_start();
     @readfile($url);
     $img=ob_get_contents();
     ob_end_clean();
    }
    $size=strlen($img);
    //文件大小
    $fp2=@fopen($filename,'a');
    fwrite($fp2,$img);
    fclose($fp2);
    return $filename;
}

function getImageInfo($img) { //$img为图象文件绝对路径 
$needupload=false;
$img_info = getimagesize($img); 


$new_img_info = array ( 
"width"=>$img_info[0], 
"height"=>$img_info[1], 
); 

if(($img_info[0]<1000)&&($img_info[1]<1000)){
	$needupload=true;
	
switch($img_info[2]){
case 1:
$image=imagecreatefromgif($img);
break;
case 2:
$image=imagecreatefromjpeg($img);
break;
case 3:
$image=imagecreatefrompng($img);
break;
}
	
	//$image = imagecreatefromjpeg($img);
	if($img_info[0]<1000&&$img_info[0]>=500){
	$newwidth=$img_info[0]*2.5;
	$newheight=$img_info[1]*2.5;
	}else{
	$newwidth=$img_info[0]*5.5;
	$newheight=$img_info[1]*5.5;
	}

  if(function_exists("imagecopyresampled"))
        {
            $newim = imagecreatetruecolor($newwidth,$newheight);
           imagecopyresampled($newim,$image,0,0,0,0,$newwidth,$newheight,$img_info[0],$img_info[1]);
        }
        else
        {
            $newim = imagecreate($newwidth,$newheight);
           imagecopyresized($newim,$image,0,0,0,0,$newwidth,$newheight,$img_info[0],$img_info[1]);
        }
		$filename=basename($img);
		
switch($img_info[2]){
case 1:
imagegif($newim,$filename);
break;
case 2:
imagejpeg($newim,$filename);
break;
case 3:
imagepng($newim,$filename);
break;
}
		imagedestroy($newim);
	
}

return $needupload;

      

}

function resizeimage($srcfile,$mySize){
$size=getimagesize($srcfile);
switch($size[2]){
case 1:
$img=imagecreatefromgif($srcfile);
break;
case 2:
$img=imagecreatefromjpeg($srcfile);
break;
case 3:
$img=imagecreatefrompng($srcfile);
break;
}
//源图片的宽度和高度
$oldImg['w']=imagesx($img);
$oldImg['h']=imagesy($img);
if ($oldImg['w']<=$mySize['w']){
$rate=1.5;
}
$newImg['w']=$oldImg['w']*$rate;
$newImg['h']=$oldImg['h']*$rate;
//return "width=".$newImg['w']." height=".$newImg['h'];

} 

}