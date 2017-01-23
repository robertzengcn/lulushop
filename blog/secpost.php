<?php
/*   Wordpress-Post-Interface-v2.9   (2010.05.11)

     WordPress免登录发布接口,支持Wordpress2.5+版本。
     适用于火车头采集器等任意采集器或脚本程序进行日志发布。
     
     Author: hamo2008@gmail.com
     Url   : http://www.satwe.com
     Ver   : 2.9.511
     
     ****最新版本或者意见建议请访问 http://www.hamo.cn/u/14***
     
     功能：
	  1. 随机时间安排与预约发布功能： 可以设定发布时间以及启用预约发布功能
	  2. 自动处理服务器时间与博客时间的时区差异
	  3. 永久链接的自动翻译设置。根据标题自动翻译为英文并进行seo处理
	  5. 多标签处理(多个标签可以用火车头默认的tag|||tag2|||tag3的形式)
	  6. 增加了发文后ping功能
	  7. 增加了“pending review”的设置     
     
     使用说明:（按照需求修改配置参数）
     $post_author    = 1;    	  //作者的id，默认为admin
     $post_status    = "publish"; //"future"：预约发布,"publish"：立即发布,"pending"：待审核
     $time_interval  = 60;        //发布时间间隔，单位为秒 。可是设置随机数值表达式，如如12345 * rand(0,17)
     $post_next      = "next"; //now:发布时间=当前时间+间隔时间值 
                               //next: 发布时间=最后一篇时间+间隔时间值
     $post_ping      = false;  //发布后是否执行ping
     $translate_slug = false;  //是否将中文标题翻译为英文做slug
     $secretWord     = 'abcd1234s';  //接口密码，如果不需要密码，则设为$secretWord=false ;
     
*/

//-------------------配置参数开始，根据需要修改-------------------------
$post_author    = 1;    	 
$post_status    = "publish"; 
$time_interval  = 60;        
$post_next      = "next"; 
$post_ping      = false;  	
$translate_slug = false;
$secretWord     = "W1T#AjVsZwe%1QT";
ini_set("display_errors", "On");

//-------------------配置参数结束，以下请勿修改-------------------------
if(isset($_POST['action'])){ 
    $hm_action=$_POST['action'];
}
else{
    die ("操作被禁止");
}

include "./wp-config.php"; 



if($post_ping) require_once("./wp-includes/comment.php");

if( !class_exists("Snoopy") )	require_once ("./wp-includes/class-snoopy.php");

function download_image($image)
{
	$ch = curl_init($image);
	if (!$ch) {
		//die("Could not init curl.");
	}
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	$response = curl_exec($ch);
	if (!$response) {
		//die("curl_exec error: ". curl_error($ch));
	}
	// Then, after your curl_exec call:
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	curl_close($ch);
	$header = substr($response, 0, $header_size);
	$body = substr($response, $header_size);
	if (!preg_match("/Content-Type: (.*)\r\n/i", $header, $match)) {
		//die("No content type for image: $image.");
	}
	$type = $match[1];
	switch (strtolower($type)) {
		case "image/gif":
			$ext = "gif";
			break;
		case "image/jpg":
		case "image/jpeg":
			$ext = "jpg";
			break;
		case "image/png":
			$ext = "png";
			break;
		case "image/bmp":
			$ext = "bmp";
			break;
		default:
			$ext = false;
			break;
	}
	if($ext!=false){
		$rand = mt_rand();
		$prodrwname = time(). $rand;

		
		$new = "/wp-content/uploads/" . $prodrwname . "." . $ext;
		$base = __DIR__ . $new;
		$fp = fopen($base, "wb");
		if ($fp) {
			//die("File: $base. Directory not writable.");
		
		fwrite($fp, $body);
		fclose($fp);
		}
		return $base;
	}else{
		return null;
	}
}

function insertintopostmeta($postid,$value){
	global $wpdb;
	$wpdb->insert(
			'wp_postmeta',
			array(
					'post_id' => $postid,
					'meta_key' => '_wp_attached_file',
					'meta_value'=>$value
			),
			array(
					'%d',
					'%s',
					'%s',
			)
	);
}

function hm_debug_info($msg)
{
    global $logDebugInfo;
    if($logDebugInfo) echo $msg."<br/>\n";
}

function hm_tranlate($text){
	$snoopy = new Snoopy;
	$url = "http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=".urlencode($text)."&langpair=zh-CN%7Cen";
	$submit_vars["text"] = $text;
	$submit_vars["ie"] = "UTF8"; 
	$submit_vars["hl"] = "zh-CN"; 
	$submit_vars["langpair"] = "zh|en"; 
	$snoopy->submit($url,$submit_vars);
	$htmlret = $snoopy->results;
	$htmlret = explode('translatedText',$htmlret);
	$htmlret = explode('}',$htmlret[1]);
	$htmlret = $htmlret[0];
	$htmlret = str_replace('"','',$htmlret);
	$htmlret = str_replace(':','',$htmlret);
	return $htmlret;
}

function hm_print_catogary_list()
{
    $cats = get_categories("hierarchical=0&hide_empty=0");
	foreach ((array) $cats as $cat) {
        echo '<<<'.$cat->cat_ID.'--'.$cat->cat_name.'>>>';	
	}
}

function hm_get_post_time($post_next="normal")
{
    global $time_interval;
    global $wpdb;

    $time_difference = absint(get_option('gmt_offset')) * 3600;
    $tm_now = time()+$time_difference;
    
    if ($post_next=='now'){
        $tm=time()+$time_difference; 
    }
    else //if ($post_next=='next')
    {
        $tm = time()+$time_difference;
      	$posts = $wpdb->get_results( "SELECT post_date FROM $wpdb->posts ORDER BY post_date DESC limit 0,1" );
        foreach ( $posts as $post )
        {
            $tm=strtotime($post->post_date);
        }
    }
    return $tm+$time_interval;
}

function hm_publish_pending_post()
{
    global $wpdb;
    $tm_now = time()+absint(get_option('gmt_offset')) * 3600;
    $now_date=date("Y-m-d H:i:s",$tm_now);
    $wpdb->get_results( "UPDATE $wpdb->posts set `post_status`='publish' WHERE `post_status`='pending' and `post_date`<'$now_date'" );
}

function hm_add_category($post_category)
{
    if(!function_exists('wp_insert_category')) @include "./wp-admin/includes/taxonomy.php";
    global $wpdb;
    $post_category_new=array();
    $post_category_list= array_unique(explode(",",$post_category));
	foreach($post_category_list as $category)
	{
        $cat_ID =intval($category);
        if($cat_ID==0)
        {
            $category = $wpdb->escape($category);
			$cat_ID = wp_insert_category(array('cat_name' => $category));
        }
        array_push($post_category_new,$cat_ID);
    }
    return $post_category_new;
}

function hm_strip_slashes($str){
if (get_magic_quotes_gpc()) return stripslashes($str);
return $str;
}

function hm_do_save_post($post_detail)
{
    global $post_author,$post_ping,$post_status,$translate_slug,$autoAddCategory,$post_next;
	extract($post_detail);

    $post_title=trim(hm_strip_slashes($post_title));
	$post_name=$post_title;
	if($translate_slug) $post_name=hm_tranlate($post_name);
	$post_name=sanitize_title( $post_name);
	if( strlen($post_name) < 2 ) $post_name="";
    
    $post_content=hm_strip_slashes($post_content);
    
    $tags_input=str_replace("|||",",",$tags_input);
	
	if(isset($post_date) &&$post_date)
  {
	$post_date_gmt=$post_date;
	$post_status='publish';
  }
  else
  {
 	$tm=hm_get_post_time($post_next); 
    $time_difference = absint(get_option('gmt_offset')) * 3600;
	$post_date=date("Y-m-d H:i:s",$tm);
	$post_date_gmt = gmdate('Y-m-d H:i:s', $tm-$time_difference);
    if($post_status=='next') $post_status='publish';
  }
    
    $post_category=hm_add_category($post_category);
    
    $post_data = compact('post_author', 'post_date', 'post_date_gmt', 'post_content', 'post_title', 'post_category', 'post_status', 'post_excerpt', 'post_name','tags_input');
	$post_data = add_magic_quotes($post_data);
    $postID = wp_insert_post($post_data);

	if($post_ping)  generic_ping();
	return $postID;
}

if($hm_action== "list")
{
	hm_print_catogary_list();
}
elseif($hm_action== "update")
{
	hm_publish_pending_post();
}
elseif($hm_action == "save" /*&&isset($_POST['secret'])&&$_POST['secret'] == $secretWord*/)
{
    if (isset($secretWord)&&($secretWord!=false)){
        if(!isset($_POST['secret']) || $_POST['secret'] != $secretWord)
        {
            die('1');
        }
    }
    
    $post=$_POST;
	extract($post);
	if($post_title=='[标签:标题]'||$post_title=='') die('标题为空');
	if($post_content=='[标签:内容]'||$post_content=='') die('内容为空');
	if($post_category=='[分类id]'||$post_category=='') die('分类id为空');
	if($tag=='[标签:SY_tag]'){$tag='';}
	if(!isset($post_date) ||strlen($post_date)<8) $post_date=false;



    $postid=hm_do_save_post(array('post_title'=>$post_title,
  'post_content'=>$post_content,
  'post_category'=>$post_category,
  'tags_input'=>$tag,
  'post_date'=>$post_date));
    
    
    $content=htmlspecialchars_decode(stripslashes($post_content));
    
    $pattern="/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i";
    
    preg_match($pattern,$content,$match);
    //echo $match['2'];
    $search = '~^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?~i';
    $fileurl='';
    if(preg_match($search, $match['2'])){//如果匹配到图片
    	$fileurl=download_image($match['2']);    	
    	$filetype = wp_check_filetype( $fileurl, null );
    //insertintopostmeta($postid,$fileurl);
    $attachment=array('post_title'=>$post_title,
    		          'post_content'=>'',
    		          'post_status'=>'inherit',
    		          'post_mime_type'=>$filetype['type']    	
    );
    $attach_id = wp_insert_attachment( $attachment, $fileurl, 0 );
     require_once(ABSPATH . 'wp-admin/includes/image.php');
        $metadata = wp_generate_attachment_metadata( $attach_id, $fileurl );
        wp_update_attachment_metadata( $attach_id, $metadata );

        // Finally! set our post thumbnail
        update_post_meta( $postid, '_thumbnail_id', $attach_id );
    }
	echo '0';
}
else
{
    echo '2';
}
?>