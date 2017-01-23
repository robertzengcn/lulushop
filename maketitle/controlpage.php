<?php
// if(!$_SESSION['wang']){
 if (!defined('Adminflag')) {
	die('Illegal Access');
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>截取标题控制台</title>

<meta name="robots" content="NOINDEX,NOFOLLOW">
<script type="text/javascript" src="../includes/templates/mars/jscript/jquery/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('body').on('click','#submitbutton',function(){		
		var thetitle=$('#title').val();
		if(thetitle==""){
			alert('请输入标题');
			return false;
			}
        $.ajax({url:"./maketitle.php",
    	    dataType:'text',
    	    data:{'pwdd':'3lqWu0QCM0wY2i','title':thetitle},
    	    type: "POST",
    	    success: function(data){
        	    
              if(data!="date not enough"&&data!="password wrong or login expire"){
    	    	$('#message').val(data);
                  }else{
                  alert(data);
                      }
    	    }
 	    
    	});
		});	

	$('body').on('click','#clear',function(){
		$('#title').val("");
		$('#message').val("");
		});
});
</script>
<style type="text/css">

    /* Basic Grey */
    .basic-grey {
    margin-left:auto;
    margin-right:auto;
    max-width: 500px;
    background: #F7F7F7;
    padding: 25px 15px 25px 10px;
    font: 12px Georgia, "Times New Roman", Times, serif;
    color: #888;
    text-shadow: 1px 1px 1px #FFF;
    border:1px solid #E4E4E4;
    }
    .basic-grey h1 {
    font-size: 25px;
    padding: 0px 0px 10px 40px;
    display: block;
    border-bottom:1px solid #E4E4E4;
    margin: -10px -15px 30px -10px;;
    color: #888;
    }
    .basic-grey h1>span {
    display: block;
    font-size: 11px;
    }
    .basic-grey label {
    display: block;
    margin: 0px;
    }
    .basic-grey label>span {
    float: left;
    width: 20%;
    text-align: right;
    padding-right: 10px;
    margin-top: 10px;
    color: #888;
    }
    .basic-grey input[type="text"], .basic-grey input[type="email"], .basic-grey textarea, .basic-grey select {
    border: 1px solid #DADADA;
    color: #888;
    height: 30px;
    margin-bottom: 16px;
    margin-right: 6px;
    margin-top: 2px;
    outline: 0 none;
    padding: 3px 3px 3px 5px;
    width: 70%;
    font-size: 12px;
    line-height:15px;
    box-shadow: inset 0px 1px 4px #ECECEC;
    -moz-box-shadow: inset 0px 1px 4px #ECECEC;
    -webkit-box-shadow: inset 0px 1px 4px #ECECEC;
    }
    .basic-grey textarea{
    padding: 5px 3px 3px 5px;
    }
    .basic-grey select {
    background: #FFF url('down-arrow.png') no-repeat right;
    background: #FFF url('down-arrow.png') no-repeat right);
    appearance:none;
    -webkit-appearance:none;
    -moz-appearance: none;
    text-indent: 0.01px;
    text-overflow: '';
    width: 70%;
    height: 35px;
    line-height: 25px;
    }
    .basic-grey textarea{
    height:100px;
    }
    .basic-grey .button {
    background: #E27575;
    border: none;
    padding: 10px 25px 10px 25px;
    color: #FFF;
    box-shadow: 1px 1px 5px #B6B6B6;
    border-radius: 3px;
    text-shadow: 1px 1px 1px #9E3F3F;
    cursor: pointer;
    }
    .basic-grey .button:hover {
    background: #CF7A7A
    }
</style>
</head>
<body>
<form id="postform" action="./tc.php" method="post">
<h1>截取字符串
<span>在标题栏里输入你要截取的字符串</span>
</h1>

<label>
<span>标题:</span>
<input id="title" type="text" name="title" placeholder="输入要截取标题" />
</label>

<label>
<span>结果：</span>
<textarea id="message" name="message" style="height:100px;"></textarea>
</label>

<label>
<span>&nbsp;</span>
<input type="button" class="button" id="submitbutton" value="提交" />
<input type="button" class="button" id="clear" value="清除" />
</label>
</form>

</body>
</html>