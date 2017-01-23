              <?php 
                  if ($flagAnyOutOfStock) {
              ?>
                  <?php
                      if (STOCK_ALLOW_CHECKOUT == 'true') {
                  ?>
                          <div class="messageStackError"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>
                  <?php }
                      else {
                  ?>
                          <div class="messageStackError"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>
                  <?php } //endif STOCK_ALLOW_CHECKOUT ?>
              <?php  } //endif flagAnyOutOfStock ?>
              <?php $caddress=zen_get_all_address($_SESSION['customer_id'],5);              
              $current=get_currencys(USD);

              ?>
     <input id="symbol" type="hidden" value="<?php echo $current->fields['symbol_left'];?>">     
        <div class="section">
            <div class="container">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">配送地址</h3>
                    </div>
                    <div class="panel-body">
                        <div id="addline" class="container">
                      <?php if($caddress->fields!=""){  	
                      while (!$caddress->EOF)
   	{
   		
  		//echo "<h1>".$caddress -> fields [firstname]."</h1>";
   		$format_id = zen_get_address_format_id($caddress->fields['country_id']);
   		$myaddress=zen_address_format($format_id, $caddress->fields, $html, $boln, $eoln);
   		$addressid=$caddress->fields['addressid'];
   		
  		?>

     
                            <div class="radio col-md-10">
                                <label class="col-md-6">
                                    <div class="col-md-12 col-xs-12"><div class="col-md-1 col-xs-1"><input id="radio<?php echo $addressid;?>" onclick="updateorder();" type="radio" name="address" value="<?php echo $addressid;?>"
                                    checked=""></div><span id="edit_<?php echo $addressid;?>" class="limitslab col-md-11 col-xs-11"><?php echo $myaddress;?></span></div></label>
                                     <div class="col-md-2">
                                    <a onclick="edi_address(<?php echo $addressid;?>)">编辑</a>
                                </div>
                            </div>
                          <?php  $caddress->MoveNext();
                            }
                      }
                            ?>
                           
                        </div>
                        <div class="row">
                            <div id="adshipform" class="<?php if($caddress->fields!=""){echo "hide";}?> col-md-10">
                                <div class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <div id="s_first_div" class="col-sm-10">
                                            <label for="inputPassword3" class="control-label">收货人</label>
                                            <input type="txt" class="form-control" id="s_first"
                                            placeholder="收货人">
                                            <input type="hidden" class="form-control" id="country_shipping"
                                            value="44">
                                        </div>
 
                                    </div>



                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label for="name">*省份:</label>
                                            <select id="povince_shipping_s" class="form-control">
<?php  
if (!$check_province->RecordCount()){
?>
<option value="">请选择身份</option>
<?php  
}else{                                           
while (!$check_province->EOF)
		{
			?>
			<option value="<?php echo $check_province->fields['zone_id'];?>"><?php echo $check_province->fields['zone_name'];?></option>
			

<?php 
$check_province->MoveNext();
		}
		}
		?>
                                            </select>
                                            <input type="hidden" id="country_shipping" value="44">

                                        </div>
                                    </div>
                                                                        <div class="form-group">
                                        <div class="col-sm-10">
                                            <label for="inputPassword3" class="control-label">*城市:</label>
                                            <input type="text" class="form-control" id="city" placeholder="城市">
                                        </div>
                                    </div>
                                                                        <div id="addressline_div" class="form-group">
                                        <div class="col-sm-10">
                                            <label for="inputPassword3" class="control-label">*详细地址:</label>
                                            <input type="text" class="form-control" id="addressline"
                                            placeholder="详细地址">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label for="inputPassword3" class="control-label">*邮编:</label>
                                            <input type="text" class="form-control" id="zidval"
                                            placeholder="邮编">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                            <label for="inputPassword3" class="control-label">*电话号码:</label>
                                            <input type="text" class="form-control" id="phonenum"
                                            placeholder="电话号码">
                                        </div>
                                    </div>
                                                                        <div class="form-group">
                                        <div class="col-sm-10">
                                            <div id="shaddmsg" class="alert alert-danger hide"></div>

                                        </div>
                                    </div>
                                    
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xs-9 col-sm-6 col-md-6">
                                                <button id="checkaddres" type="button" class="btn btn-warning" onclick="check_address();">使用此地址</button>
                                            </div>
                                                                                        <div class="col-xs-4 col-sm-5 col-md-4">
                                                <button id="chanceladd" type="button" class="btn btn-warning" onclick="cancel_address();">取消</button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 col-xs-8">
                            <div class="row">
                                                <button type="button" onclick="add_address();" class="btn btn-warning col-xs-offset-6">添加新的地址</button>
                           </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">商品详情</h3>
                    </div>
                    <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="textcent">型号</th>
                                    <th class="textcent"><?php echo TABLE_HEADING_PRODUCTS; ?></th>
                                    <th class="textcent"><?php echo TABLE_HEADING_QUANTITY; ?></th>
                                    <th class="textcent"><?php echo TABLE_HEADING_TOTAL; ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php for ($i=0, $n=sizeof($order->products); $i<$n; $i++) { ?>
                            <?php $thumbnail = zen_get_products_image($order->products[$i]['id'], 80, 80); ?>
                                <tr>
                                    <td class="col-md-2 textcent"><?php echo $order->products[$i]['model']; ?></td>
                                    <td class="col-md-8 textcent">
                                        <dl>
                                            <dt class="col-md-2 imgmagin">
                                                <?php echo $thumbnail; ?>
                                            </dt>
                                            <dd class="col-md-10"><?php echo $order->products[$i]['name']; ?><?php  echo $stock_check[$i]; ?></dd>
                                             <?php // if there are attributes, loop thru them and display one per line
                                    if (isset($order->products[$i]['attributes']) && sizeof($order->products[$i]['attributes']) > 0 ) {
                                    
                                      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
                                ?>
                                            <dd class="col-md-10"><?php echo $order->products[$i]['attributes'][$j]['option'] . ': ' . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])); ?></dd>
                                   <?php
                                      } // end loop
                                     
                                    } // endif attribute-info
                                ?>         
                                        </dl>
                                    </td>
                                    <td class="col-md-1 textcent"><?php echo $order->products[$i]['qty']; ?>&nbsp;x</td>
                                    <td class="col-md-1 textcent"><?php echo $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']);
                                    if ($order->products[$i]['onetime_charges'] != 0 ) echo '<br /> ' . $currencies->display_price($order->products[$i]['onetime_charges'], $order->products[$i]['tax'], 1);
                                ?></td>
                                </tr>
                                <tr>
                                
                                <?php  }  // end for loopthru all products 
                    ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                       <button type="button" onclick="go_shoppingcart();" class="btn btn-warning textright">修改购物车</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     <?php
          if (zen_count_shipping_modules() > 0) {
      ?>        

        <div class="section">
            <div class="container">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo TABLE_SUBHEADING_SHIPPING_METHOD; ?></h3>
                    </div>
                    <div class="panel-body">
                        <table class="textcent">
                            <thead>
                                <tr>
                                    <th class="textcent col-md-5"><?php echo TABLE_SUBHEADING_SHIPPING_METHOD; ?></th>
                                    <th class="textcent col-md-4">价格</th>
                                    <th class="textcent col-md-3">选择</th>
                                </tr>
                            </thead>
                            <tbody>

                    <?php
                  if ($free_shipping == true) {

              ?>
              
              <?php }
                  else {
                      $radio_buttons = 0;
                      for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
                  ?>
                            
                                <tr>
                                    <td>
                                        <dl>
                                            <dt><?php echo $quotes[$i]['module']; ?></dt>
                                            <!--  <dd>
                                                <?php if (isset($quotes[$i]['icon']) && zen_not_null($quotes[$i]['icon'])) { echo $quotes[$i]['icon']; } ?>
                                            </dd>-->
                                        </dl>
                                    </td>
                                     <?php
                                  if (isset($quotes[$i]['error'])) {
                              
                                     echo $quotes[$i]['error'];
                              }else {
                                      for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
                                       $checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $_SESSION['shipping']['id']) ? true : false);
                                       
                                       
                                       if ( ($n > 1) || ($n2 > 1) ) {
                                       
                                       	?>
                                                             <td><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))); ?></td>
                                             <?php
                                                         } else {
                                             ?>
                                                             <td><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])) . zen_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); ?></td>
                                             <?php
                                                         }
                                             ?>
                                              <td><?php echo zen_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked, 'onclick="updateForm();" id="ship-'.$quotes[$i]['id'] . '-' . $quotes[$i]['methods'][$j]['id'].'"'); ?></td>
                                             
 <?php   
 $radio_buttons++;
      }
      }
      }
      }
      ?>

                              
                 
                                        
                                    </td>
                                </tr>
                               
                             

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<?php } ?>
          <?php
            if (SHOW_ACCEPTED_CREDIT_CARDS != '0') {
          ?>
          
          <?php
              if (SHOW_ACCEPTED_CREDIT_CARDS == '1') {
                echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled();
              }
              if (SHOW_ACCEPTED_CREDIT_CARDS == '2') {
                echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled('IMAGE_');
              }
          ?>
      
          <?php } ?>
          
          <?php
            foreach($payment_modules->modules as $pm_code => $pm) {
              if(substr($pm, 0, strrpos($pm, '.')) == 'googlecheckout') {
                unset($payment_modules->modules[$pm_code]);
              }
            }
            $selection = $payment_modules->selection();
          
            if (sizeof($selection) > 1) {
          ?>
              <!-- <span class="fec-information"><?php echo TEXT_SELECT_PAYMENT_METHOD; ?></span> -->
          <?php
            } elseif (sizeof($selection) == 0) {
          ?>
              <!-- <span class="fec-information"><?php echo TEXT_NO_PAYMENT_OPTIONS_AVAILABLE; ?></span> -->
          
          <?php
            }
          ?>
          
          
          <!-- comment box start -->
          
          <div class="section">
            <div class="container">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">订单留言</h3>
                    </div>
                    <div class="panel-body">
                        
            <div class="control-group">

            <div class="controls">
              <textarea name="comments" class="input-xlarge" id="textarea" rows="3" placeholder="请留下您对订单的其他要求"></textarea>
            </div>
          </div>
                               
                            
                       

                    </div>
                </div>
            </div>
        </div>
          
          <!-- comment box end -->
          

        
        <div class="section">
            <div class="container">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo TABLE_HEADING_PAYMENT_METHOD; ?></h3>
                    </div>
                    <div class="panel-body">
                        <div class="container">
                        
                        <?php
                        
            $radio_buttons = 0;
            for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
          ?>
          
          <?php
              if (sizeof($selection) > 1) {

            ?>
            
             <?php      
                      if (empty($selection[$i]['noradio'])) {
                  ?>
            
                        
                            <div class="radio">
                                <label>
                                    <?php echo zen_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 'id="pmt-'.$selection[$i]['id'].'"'); ?></label>
                            </div>
                            <?php } ?>
                            
                 <?php } 
                      else { 
                  ?>
                 
                  <?php echo zen_draw_hidden_field('payment', $selection[$i]['id']); ?>
                  <label for="pmt-<?php echo $selection[$i]['id']; ?>" class="radioButtonLabel"><?php echo $selection[$i]['module']; ?></label>
                  
                  <?php }
                  ?>
                  
               <!-- credit card start -->
                <?php
              if (defined('MODULE_ORDER_TOTAL_COD_STATUS') && MODULE_ORDER_TOTAL_COD_STATUS == 'true' and $selection[$i]['id'] == 'cod') {
          ?>
            <div class="alert"><?php echo TEXT_INFO_COD_FEES; ?></div>
          <?php
              } else {
                // echo 'WRONG ' . $selection[$i]['id'];
          ?>
          <?php
              }
          ?>
          
          <?php
              if (isset($selection[$i]['error'])) {
          ?>
              <div><?php echo $selection[$i]['error']; ?></div>
          
          <?php
              } elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) {
          ?>
          
          <div class="fec-credit-card-info">
          <?php
                for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
          ?>
                    <div class="fec-field">
                        <label <?php echo (isset($selection[$i]['fields'][$j]['tag']) ? 'for="'.$selection[$i]['fields'][$j]['tag'] . '" ' : ''); ?> class="inputLabel"><?php echo $selection[$i]['fields'][$j]['title']; ?></label>
                        <?php echo $selection[$i]['fields'][$j]['field']; ?>
                    </div>
                    
          <?php
                }
          ?>
          </div>
          <?php
              }?>
               
               
                 <!-- credit card end --> 
                  <?php
                  $radio_buttons++;
                  }
                   ?>             
                            
                        </div>
                        <div class="container">
                            <a onclick="show_coupon();">使用优惠券</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="container">
            <div class="row">
                          <?php
                  if (MODULE_ORDER_TOTAL_INSTALLED) {
                      $order_totals = $order_total_modules->process();
              ?>
                <?php $order_total_modules->output(); ?>
                <?php } ?>

        </div>
        <hr class="lines">
        <div class="section">
            <div class="container">
                <button type="submit" class="btn btn-warning col-xs-offset-6 textright butm">提交订单</button>
            </div>
        </div>
        
  <div class="modal fade" id="editaddress" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               修改地址
            </h4>
         </div>
         <div class="modal-body">

  
 <div class="container">
    	<div class="row">
			<div class="col-md-4">
				<div class="panel panel-login">

					<div class="panel-body">
					 <div class="container">
					<div class="row">
                            <div id="editshipform" class="col-md-12">
                                <div class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <div id="s_first_div" class="col-md-4">
                                            <label for="inputPassword3" class="control-label">姓名</label>
                                            <input type="txt" class="form-control" id="e_first"
                                            placeholder="First name">
                                        </div>

                                    </div>
                                    <div id="addressline_div" class="form-group">
                                        <div class="col-md-4">
                                            <label for="inputPassword3" class="control-label">*详细地址:</label>
                                            <input type="text" class="form-control" id="e_addressline"
                                            placeholder="Address Line 1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="inputPassword3" class="control-label">*城市:</label>
                                            <input type="text" class="form-control" id="e_city" placeholder="city">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="name">*省份:</label>
                                            <select id="e_povince_shipping_s" class="form-control hide">

                                            </select>
                                             <input type="text" class="form-control" id="e_povince_shipping_i"
                                            placeholder="State/Province/Region">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="inputPassword3" class="control-label">*邮编:</label>
                                            <input type="text" class="form-control" id="e_zidval"
                                            placeholder="ZIP / Postal Code">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label for="inputPassword3" class="control-label">*电话:</label>
                                            <input type="text" class="form-control" id="e_phonenum"
                                            placeholder="Phone Number">
                                        </div>
                                    </div>
                                                                        <div class="form-group">
                                        <div class="col-md-4">
                                        <input type="hidden" id="e_saveaddid" value="">
                                            <div id="eadd_msg" class="alert alert-danger hide"></div>

                                        </div>
                                    </div>
                                    
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xs-9 col-sm-6 col-md-3">
                                                <button type="button" class="btn btn-warning" onclick="update_address();">保存</button>
                                            </div>
                                                                                        <div class="col-xs-3 col-sm-5 col-md2">
                                                <button type="button" class="btn btn-warning" onclick="cancel_update();">取消</button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>    
     <!-- 鍐呭缁撴潫 -->
</div><!-- /.modal -->   

<!-- 模态框（Modal） -->
<div class="modal fade" id="coupon" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" 
               data-dismiss="modal" aria-hidden="true">
                  &times;
            </button>
            <h4 class="modal-title" id="myModalLabel">
               优惠券
            </h4>
         </div>
         <div class="modal-body">
   <div>
   <div class="form-inline" role="form">
   <input type="text" class="form-control" id="coupontxt" 
         placeholder="请输入优惠码">
         <div id="couerrs" class="alert alert-danger hide"></div>

         
         </div>
         </div>
         </div>
         <div class="modal-footer">
           <button type="button" onclick="get_couponval();" class="btn btn-primary">
              提交
            </button>
            <button type="button" class="btn btn-default" 
               data-dismiss="modal">关闭
            </button>

         </div>
      </div><!-- /.modal-content -->
</div><!-- /.modal -->
</div>
 
        
      
