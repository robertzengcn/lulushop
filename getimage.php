<?php
//error_reporting(0);
ini_set("display_errors", "On");
require_once __DIR__ . '/autoload.php';

use Qiniu\Auth;

// 瀵洖鍙嗘稉濠佺炊缁拷
use Qiniu\Storage\UploadManager;

// $_REQUEST['pwdd']="3lqWu0QCM0wY2i";
// $_REQUEST['imageurl']='https://ae01.alicdn.com/kf/HTB1BWrBKXXXXXXeXFXXq6xXFXXXN/Seibertron-new-waterproof-Molle-Tactical-14-inch-Laptop-Sling-BAG-Backpack-laptop-bag-khaki-black.jpg';


if(isset($_REQUEST['pwdd'])&&$_REQUEST['pwdd']=="3lqWu0QCM0wY2i"){
	if(isset($_REQUEST['imageurl'])&&$_REQUEST['imageurl']!=null){
		$str=$_REQUEST['imageurl'];
		echo $str;exit();
$filename=basename($str);
$tempu=parse_url($_REQUEST['imageurl']);
$thehostname=$tempu['host'];
$qiniuhost='image.lulusc.com';

$savefile=str_replace($thehostname,$qiniuhost,$str);

$savefile=str_replace('https','http',$savefile);
$fulllink=parse_url($_REQUEST['imageurl']);
$thefiles=substr($fulllink['path'],1);




$makeimage = new makeimage();
//$imgfile=$makeimage->getImage($_POST['imageurl']);
$result=$makeimage->getImageInfo($_REQUEST['imageurl']);
if($result){

//$filepath=dirname(__FILE__).$filename;

// 闂囷拷顩︽繅顐㈠晸娴ｇ姷娈�Access Key 閸滐拷Secret Key
$accessKey = 'jMN6FOc_k_8TWSoMNfSs-KSDNKChPa59l5l-4ZFx';
$secretKey = 'ud5MW5efpiTEXo4TlBfClQ8AODWyCtilBNYhfRHu';

// 閺嬪嫬缂撻柎瀛樻綀鐎电钖�
$auth = new Auth($accessKey, $secretKey);

// 鐟曚椒绗傛导鐘垫畱缁屾椽妫�
$bucket = 'crunkmusicer';

// 閻㈢喐鍨氭稉濠佺炊 Token
$token = $auth->uploadToken($bucket);

// 鐟曚椒绗傛导鐘虫瀮娴犲墎娈戦張顒�勾鐠侯垰绶�
$filePath = $filename;

// 娑撳﹣绱堕崚棰佺閻楁稑鎮楁穱婵嗙摠閻ㄥ嫭鏋冩禒璺烘倳
$key = $thefiles;

// 閸掓繂顫愰崠锟経ploadManager 鐎电钖勯獮鎯扮箻鐞涘本鏋冩禒鍓佹畱娑撳﹣绱堕妴锟�$uploadMgr = new UploadManager();
$uploadMgr=new UploadManager;
// 鐠嬪啰鏁�UploadManager 閻拷putFile 閺傝纭舵潻娑滎攽閺傚洣娆㈤惃鍕瑐娴肩姰锟�
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
    //閺傚洣娆㈡穱婵嗙摠鐠侯垰绶�
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
    //閺傚洣娆㈡径褍鐨�
    $fp2=@fopen($filename,'a');
    fwrite($fp2,$img);
    fclose($fp2);
    return $filename;
}

function getImageInfo($img) { //$img娑撳搫娴樼挒鈩冩瀮娴犲墎绮风�纭呯熅瀵帮拷
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
//濠ф劕娴橀悧鍥╂畱鐎硅棄瀹抽崪宀勭彯鎼达拷
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