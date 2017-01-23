/* javascript function to update form field
 *  field		form field that is being counted
 *  count		form field that will show characters left
 *  maxchars 	maximum number of characters
*/
//$(function() {
//
//var concode=$("#country_shipping  option:selected").val();
//var token=document.getElementsByName('securityToken');
//var tokenvalue=token[0].value;
//if(concode==""){return false;};
//$.ajax({
//	url      :'/ajaxcheckpay/',
//	data     : {'action':"check_country",'code':concode,'securityToken':tokenvalue},
//	type     : 'post',
//	dataType : 'json',
//	error    : function(data,message){
//	},
//	success  : function(data){
//		if(data.stute){
//			if(data.kind==1){
//				var html = '';
//				html = '<option value="0">please choose State/Province/Region</option>';
//				$('#povince_shipping_i').addClass('hide');
//				$('#povince_shipping_s').removeClass('hide');
//				$('#povince_shipping_s').empty().append(html);
//				html = '';
//				$.each(data.date,function(n,value){
//					html += '<option value="'+value.id+'">'+value.name+'</option>';
//				});
//				if(html != ''){
//					$('#povince_shipping_s').append(html);
//				}
//			}else{
//				$('#povince_shipping_i').removeClass('hide');
//				$('#povince_shipping_s').addClass('hide');				
//				$('#povince_shipping_s').empty();
//			}
//		}
//	}
//})
//
//
//
//});
//$(function() {
//	var hsel=document.getElementById('e_country_shipping');
//	hsel.addEventListener("change",function(){
//	var concode=$("#e_country_shipping  option:selected").val();
//	var token=document.getElementsByName('securityToken');
//	var tokenvalue=token[0].value;
//	if(concode==""){return false;};
//	$.ajax({
//		url      :'/ajaxcheckpay/',
//		data     : {'action':"check_country",'code':concode,'securityToken':tokenvalue},
//		type     : 'post',
//		dataType : 'json',
//		error    : function(data,message){
//		},
//		success  : function(data){
//			if(data.stute){
//				if(data.kind==1){
//					var html = '';
//					html = '<option value="0">please choose State/Province/Region</option>';
//					$('#e_povince_shipping_i').addClass('hide');
//					$('#e_povince_shipping_s').removeClass('hide');
//					$('#e_povince_shipping_s').empty().append(html);
//					html = '';
//					$.each(data.date,function(n,value){
//						html += '<option value="'+value.id+'">'+value.name+'</option>';
//					});
//					if(html != ''){
//						$('#e_povince_shipping_s').append(html);
//					}
//				}else{
//					$('#e_povince_shipping_i').removeClass('hide');
//					$('#e_povince_shipping_s').addClass('hide');				
//					$('#e_povince_shipping_s').empty();
//				}
//			}
//		}
//	})
//
//
//		});
//	});



function updateorder(){

	var temp = document.getElementsByName("address");
	var fump = document.getElementsByName("shipping");
	var token=document.getElementsByName('securityToken');
	var tokenvalue=token[0].value;
	//var dollnum=document.getElementsByName('securityToken');
	
var subcost=$('#subcostnum').html();
var symbol=$('#symbol').val();

	var nucode=subcost.substring(0,1);

	for(var i=0;i<fump.length;i++){
		  if(fump[i].checked){
			  var shipval = fump[i].value;
			  }	
	}
	
	  for(var i=0;i<temp.length;i++)
	  {
	  if(temp[i].checked){
	  var intHot = temp[i].value;
	  }	  
	  }
	  //console.log('id是',intHot);
	  //alert(intHot);
	  
	  	$.get("/index.php?main_page=checkout", {fecaction:"ajaxupdate",'id':intHot,'shipping':shipval,'securityToken':tokenvalue},function(data){
	  		if(data.stute){
	  			$('#shipway').html(data.detail.title+":");
	  			$('#shipprice').html(symbol+data.detail.cost);
	  			var num=$('#shipprice').html();
	  			var st=parseInt(num.replace(/[^0-9]/ig,""));
	  			var subnum=parseInt(subcost.replace(/[^0-9]/ig,""));
	  			var totcost=st+subnum;
	  			$('#totalcostnum').html(symbol+totcost);

	  		}
		},"JSON");
	  
}
$(function (){
	var rad = document.getElementsByName("address");
	var shi= document.getElementsByName("shipping");
	//rad.addEventListener("click",function(){alert('lala');}, false);

//	var prev = null;
//	for(var i = 0; i < rad.length; i++) {
//	    rad[i].onclick = function() {
//	    	 updateorder();
//	    };
//	}
	for(var i = 0; i < shi.length; i++){
		shi[i].onclick = function() {
			
	    	 updateorder();
	    	 
	    	 
	    };
	}
	
//	$('.limitslab').live('click',function(){
//		updateorder();
//	});
	$('input').live('ifChanged', function(event){
		updateorder();
		});
	
});

function go_shoppingcart(){
	window.location.href="/index.php?main_page=shopping_cart";
}

function check_address(){
	var thefirst=$('#s_first').val();
	var thelast=$('#s_last').val();
	var addressliine=$('#addressline').val();
	//var addresssec=$('#addressline_sec').val();
	//var alladdress=addressliine+" "+addresssec;
	var city=$('#city').val();		
	var country=$('#country_shipping').val();
    var state=$('#povince_shipping_s option:selected').val();
	//var state=$('#povince_shipping_i').val();
    var country=$('#country_shipping').val();

	var zipcode=$('#zidval').val();
	var phonecoe=$('#phonenum').val();
	var token=document.getElementsByName('securityToken');
	var tokenvalue=token[0].value;

	if(thefirst==""){
		$('#shaddmsg').html('<p><strong>请输入收件人姓名</strong></p>');
		$("#s_first").addClass("focusedalert");
		$('#s_first').focus();		
		$('#shaddmsg').removeClass("hide");
		return false;
	}
	if(addressliine==""){
		$('#shaddmsg').html('<p><strong>请输入收件人详细地址</strong></p>');
		$("#addressline").addClass("focusedalert");
		$('#shaddmsg').removeClass("hide");
		$('#addressline').focus();		
		return false;
	}
	if(city==""){
		$('#shaddmsg').html('<p><strong>请输入城市</strong></p>');
		$("#city").addClass("focusedalert");
		$('#shaddmsg').removeClass("hide");
		$('#city').focus();
		return false;
	}
	if(zipcode==""){
		$('#shaddmsg').html('<p><strong>请输入邮编</strong></p>');
		$("#zidval").addClass("focusedalert");
		$('#shaddmsg').removeClass("hide");
		$('#zidval').focus();
		return false;
	}
	if(phonecoe==""){
		$('#shaddmsg').html('<p><strong>请输入电话号码</strong></p>');
		$("#phonenum").addClass("focusedalert");
		$('#shaddmsg').removeClass("hide");
		$('#phonenum').focus();
		return false;
	}

	$.ajax({
		url      :'/ajaxcheckpay/',
		data     : {'action':"set_address",'first_name':thefirst,'address':addressliine,'city':city,'zip':zipcode,'country':country,'state':state,'phone':phonecoe,'securityToken':tokenvalue},
		type     : 'post',
		dataType : 'json',
		error    : function(data,message){
			$('#shaddmsg').html('<p><strong>出错了，请稍候再试</strong></p>');
			$('#shaddmsg').removeClass("hide");
		},
		success  : function(data){
			var line="";
			if(data.stute){
				$("#adshipform").addClass("hide");
			line='<div class="radio col-md-10"><label class="col-md-6"><div class="col-md-12 col-xs-12"><div class="col-md-1 col-xs-1"><input id="radio'+data.id+'" onclick="updateorder()" type="radio" checked="" value="'+data.id+'" name="address"></div><span id="edit_'+data.id+'" class="limitslab col-md-11 col-xs-11">'+data.address+'</span></div></label><div class="col-md-2"><a onclick="edi_address('+data.id+')">编辑</a></div></div>';
				$("#addline").prepend(line);

				$('#addline input').iCheck({
						radioClass: 'iradio_minimal '});
				$('#radio'+data.id).iCheck('check');
				updateorder();
                  
			}else{
				$('#shaddmsg').html(data.msg);
				$('#shaddmsg').removeClass("hide");
			}
		}
	})
		
}

$(document).ready(function(){
	$("#s_first").blur(function(){
		 $("#s_first").removeClass("focusedalert");
	});	
	$("#s_last").blur(function(){
		 $("#s_last").removeClass("focusedalert");
	});	
	$("#addressline").blur(function(){
		 $("#addressline").removeClass("focusedalert");
	});	
	$("#city").blur(function(){
		 $("#city").removeClass("focusedalert");
	});	
	$("#zidval").blur(function(){
		 $("#zidval").removeClass("focusedalert");
	});	
	$("#phonenum").blur(function(){
		 $("#phonenum").removeClass("focusedalert");
	});	

	});
function setSelectChecked(selectId, checkValue){  
    var select = document.getElementById(selectId);  
    for(var i=0; i<select.options.length; i++){  
        if(select.options[i].value == checkValue){  
            select.options[i].selected = true;  
            break;  
        }  
    }  
};  
function edi_address(id){
	var token=document.getElementsByName('securityToken');
	var tokenvalue=token[0].value;
	//var country=$('#country_shipping').val();
	
	$.ajax({
		url      :'/ajaxcheckpay/',
		data     : {'action':"get_address",'id':id,'securityToken':tokenvalue},
		type     : 'post',
		dataType : 'json',
		error    : function(data,message){
		},
		success  : function(data){
			if(data.stute){
				$("#e_first").val(data.date.firstname);	
				//$("#e_last").val(data.date.lastname);
				$("#e_addressline").val(data.date.street_address);
				$("#e_city").val(data.date.city);
				$("#e_zidval").val(data.date.postcode);				
				$("#e_phonenum").val(data.date.phonenum);
				$("#e_saveaddid").val(id);
				
				//setSelectChecked("e_country_shipping",data.date.country_id);
				var diqucode=data.date.zone_id;
				//start change another select
				$.ajax({
					url      :'/ajaxcheckpay/',
					data     : {'action':"check_country",'code':data.date.country_id,'securityToken':tokenvalue},
					type     : 'post',
					dataType : 'json',
					error    : function(data,message){
					},
					success  : function(data){
						if(data.stute){
							if(data.kind==1){
								var html = '';
								html = '<option value="0">请选择省份</option>';
								$('#e_povince_shipping_i').addClass('hide');
								$('#e_povince_shipping_s').removeClass('hide');
								$('#e_povince_shipping_s').empty().append(html);
								html = '';
								$.each(data.date,function(n,value){
									html += '<option value="'+value.id+'">'+value.name+'</option>';
								});
								if(html != ''){
									$('#e_povince_shipping_s').append(html);
									if((diqucode!=0)&&(diqucode!="")){
									setSelectChecked("e_povince_shipping_s",diqucode);
									}
								}
							}else{
								$('#e_povince_shipping_i').removeClass('hide');
								$('#e_povince_shipping_s').addClass('hide');				
								$('#e_povince_shipping_s').empty();
							}
						}
					}
				})
				
				if((data.date.zone_id!=0)&&!isNaN(data.date.zone_id)){
						
				}
				
				
				$('#editaddress').modal('show');
				
			}
		}
	})	
	
}
function add_address(){
	$("#s_first").val("");
	$("#s_last").val("");
	$("#addressline").val("");
	$("#povince_shipping_i").val("");
	$("#city").val("");
	$("#zidval").val("");
	$("#phonenum").val("");
	$("#addressline_sec").val("");
	$("#adshipform").removeClass("hide");
}
function cancel_address(){
	$("#adshipform").addClass("hide");
}
function cancel_update(){
	$('#editaddress').modal('hide');
}
function show_coupon(){
	$('#coupon').modal('show');
}
function update_address(){
	var efirst=$("#e_first").val();
	//var elast=$("#e_last").val();
	var eaddress=$("#e_addressline").val();
	var ecity=$("#e_city").val();
	var ephone=$("#e_phonenum").val();
	var ezip=$("#e_zidval").val();
	var addid=$("#e_saveaddid").val();
	var ecountry=$('#country_shipping').val();
	//var ecountry=$('#e_country_shipping option:selected').val();
	var token=document.getElementsByName('securityToken');
	var tokenvalue=token[0].value;
	
   var estate=$('#e_povince_shipping_s option:selected').val();

	
	if(efirst==""){
		$('#eadd_msg').html('<p><strong>请输入您的姓名</strong></p>');
		$("#e_first").addClass("focusedalert");
		$('#e_first').focus();		
		$('#eadd_msg').removeClass("hide");
		return false;
	}

	if(eaddress==""){
		$('#eadd_msg').html('<p><strong>请输入您的地址</strong></p>');
		$("#e_last").addClass("focusedalert");
		$('#eadd_msg').removeClass("hide");
		$('#e_last').focus();		
		return false;
	}
	if(ecity==""){
		$('#eadd_msg').html('<p><strong>请输入您的城市</strong></p>');
		$("#e_city").addClass("focusedalert");
		$('#eadd_msg').removeClass("hide");
		$('#e_city').focus();
		return false;
	}
	if(ezip==""){
		$('#eadd_msg').html('<p><strong>请输入您的邮编</strong></p>');
		$("#e_zidval").addClass("focusedalert");
		$('#eadd_msg').removeClass("hide");
		$('#e_zidval').focus();
		return false;
	}
	if(ephone==""){
		$('#eadd_msg').html('<p><strong>请输入您的电话</strong></p>');
		$("#e_phonenum").addClass("focusedalert");
		$('#eadd_msg').removeClass("hide");
		$('#e_phonenum').focus();
		return false;
	}

	$.ajax({
		url      :'/ajaxcheckpay/',
		data     : {'action':"update_address",'first_name':efirst,'address':eaddress,'city':ecity,'zip':ezip,'country':ecountry,'state':estate,'saveaddid':addid,'phone':ephone,'securityToken':tokenvalue},
		type     : 'post',
		dataType : 'json',
		error    : function(data,message){
		},
		success  : function(data){
			if(data.stute){
				$('#editaddress').modal('hide');
				$('#edit_'+data.id).html(data.address);				
				$('#radio'+data.id).iCheck('check');
				
				
				
			}
		}
	})
	
	
}
function get_couponval(){
	var coupons=$('#coupontxt').val();
	if(coupons==""){return false}
	var token=document.getElementsByName('securityToken');
	var tokenvalue=token[0].value;
	
	$.ajax({
		url      :'/index.php?main_page=checkout',
		data     : {'dc_redeem_code':coupons,'securityToken':tokenvalue},
		type     : 'post',
		dataType : 'json',
		error    : function(data,message){
		},
		
		success  : function(data){
			

					if(data.stute){
						
			var html='<div class="product_price total textalri"><strong><span id="totalcost">优惠券:'+data.code+':</span></strong><div style="display: inline-block"><span class="total_price" id="discounamount">-'+data.discount+'</span></div></div>'
			$('#couerrs').toggleClass('hide');
			$('#shippricediv').append(html);
			$('#totalcostnum').html(data.total);
			$('#coupon').modal('hide');			
						
					}else{
						$('#couerrs').toggleClass('hide');
						$('#couerrs').html(data.msg);
					}

		}
	});
	
	
}