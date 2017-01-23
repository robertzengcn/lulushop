<?php
/**
 * shopping_cart header_php.php
 *
 * @package page
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 19098 2011-07-13 15:19:52Z wilt $
 */

// This should be first line of the script:
if (!$_SESSION['customer_id']) {
	$arraytar=array('stute'=>false,
                     'msg'=>"Login expire, please reflase to login",
		              );
echo json_encode($arraytar);
	exit();
}

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
//$breadcrumb->add(NAVBAR_TITLE);


if(isset($_POST['action']) && ($_POST['action'] == 'check_country')){
	global $db;

	$country=zen_db_prepare_input($_POST['code']);
	
	 $check_country_query = "SELECT zone_id,zone_name
                           FROM " . TABLE_ZONES . "
                           WHERE zone_country_id = :zone_code";

    $check_country_query  =$db->bindVars($check_country_query, ':zone_code', $country, 'integer');
    $check_country = $db->Execute($check_country_query);

	
	if (!$check_country->RecordCount()){
		$countarr=array('stute'=>true,
				        'kind'=>0,				 
		);
		echo json_encode($countarr);
	}else{
		$array_ids = array();
		$k=0;
		while (!$check_country->EOF)
		{
			
			$array_ids[$k]['id']=$check_country->fields['zone_id'];
			$array_ids[$k]['name']=$check_country->fields['zone_name'];
			$k=$k+1;
			$check_country->MoveNext();
		}
		$countarr=array('stute'=>true,
				'kind'=>1,
				'date'=>$array_ids
		);
		echo json_encode($countarr);
		
	} 
     

	
	exit();

}
if(isset($_POST['action']) && ($_POST['action'] == 'set_address')){
	$firstname=zen_db_prepare_input($_POST['first_name']);
	//$lastname=zen_db_prepare_input($_POST['last_name']);
	$street_address=zen_db_prepare_input($_POST['address']);
	$city=zen_db_prepare_input($_POST['city']);
	$postcode=zen_db_prepare_input($_POST['zip']);
	$country=(int)zen_db_prepare_input($_POST['country']);
	$state=zen_db_prepare_input($_POST['state']);
	$phone=zen_db_prepare_input($_POST['phone']);
	
	    $sql_data_array = array('customers_id' => $_SESSION['customer_id'],
	                            'entry_firstname' => $firstname,
	                            //'entry_lastname' => $lastname,
	                            'entry_street_address' => $street_address,
	                            'entry_postcode' => $postcode,
	                            'entry_city' => $city,
	    		                'entry_telephone'=>$phone,
	                            'entry_country_id' => $country);
	
	   //if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;

	   
	      if (is_numeric($state)) {
	        $sql_data_array['entry_zone_id'] = $state;
	        $sql_data_array['entry_state'] = '';
	      } else {
	        $sql_data_array['entry_zone_id'] = '0';
	        $sql_data_array['entry_state'] = $state;
	      }
	      
	    
	
	    zen_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
	    global $db;
	    
	
	    $address_id = $db->Insert_ID();
	
	    $zco_notifier->notify('NOTIFY_MODULE_CREATE_ACCOUNT_ADDED_ADDRESS_BOOK_RECORD', array_merge(array('address_id' => $address_id), $sql_data_array));
	
	    $sql = "update " . TABLE_CUSTOMERS . "
	              set customers_default_address_id = '" . (int)$address_id . "'
	              where customers_id = '" . (int)$_SESSION['customer_id'] . "'";
	
	    $db->Execute($sql);
	    

	    if($address_id){
	    	
	    	$myaddress=zen_address_label($_SESSION['customer_id'],$address_id,false, '',"\n");
	$arrresult=array('stute'=>true,
			          'id'=>$address_id,
			          'address'=>$myaddress
	 );
	    }else{
	    	$arrresult=array('stute'=>false,
            'msg'=>'some error happened'
	    	);
	}
   echo json_encode($arrresult);
   exit();
}
if(isset($_POST['action']) && ($_POST['action'] == 'get_address')){
	$addid=zen_db_prepare_input($_POST['id']);
	$addobj=zen_address_object($_SESSION['customer_id'],$addid);
	//print_r($addobj->fields);
	if($addobj->fields!=""){
		$arrresult=array('stute'=>true,
				'date'=>$addobj->fields
		);
	}else{
		$arrresult=array('stute'=>false,
				'date'=>NULL
		);
	}
	echo json_encode($arrresult);
	exit();
}
if(isset($_POST['action']) && ($_POST['action'] == 'update_address')){
	$firstname=zen_db_prepare_input($_POST['first_name']);
	//$lastname=zen_db_prepare_input($_POST['last_name']);
	$street_address=zen_db_prepare_input($_POST['address']);
	$city=zen_db_prepare_input($_POST['city']);
	$postcode=zen_db_prepare_input($_POST['zip']);
	$country=(int)zen_db_prepare_input($_POST['country']);
	$state=zen_db_prepare_input($_POST['state']);
	$phone=zen_db_prepare_input($_POST['phone']);
	$entid=zen_db_prepare_input($_POST['saveaddid']);
	
	
	      if (is_numeric($state)) {
	        $entry_zone_id = $state;
	        $entry_state= '';
	      } else {
	        $entry_zone_id= 0;
	        $entry_state = $state;
	      }
global $db;
	
	$sql = "UPDATE " . TABLE_ADDRESS_BOOK . " set entry_firstname =:firstname, entry_street_address=:address,entry_postcode=:postcode,
			entry_city=:city,entry_telephone=:telphone,entry_state=:state,entry_zone_id=:zoneid,entry_country_id=:countryid WHERE address_book_id = :entryid AND customers_id='" . (int)$_SESSION['customer_id'] . "'";
	$sql = $db->bindVars($sql, ':firstname', $firstname, 'string');
	$sql = $db->bindVars($sql, ':lastname', $lastname, 'string');
	$sql = $db->bindVars($sql, ':address', $street_address, 'string');
	$sql = $db->bindVars($sql, ':postcode', $postcode, 'string');
	$sql = $db->bindVars($sql, ':city', $city, 'string');
	$sql = $db->bindVars($sql, ':telphone', $phone, 'string');
	$sql = $db->bindVars($sql, ':countryid', $country, 'integer');
	$sql = $db->bindVars($sql, ':entryid', $entid, 'integer');
	$sql = $db->bindVars($sql, ':state', $entry_state, 'string');
	$sql = $db->bindVars($sql, ':zoneid', $entry_zone_id, 'integer');
	
	
	$sqlresult = $db->Execute($sql);
	if($sqlresult){
		$myaddress=zen_address_label($_SESSION['customer_id'],$entid,false, '',"");
		$arrresult=array('stute'=>true,
				'id'=>$entid,
				'address'=>$myaddress
		);
	}else{
		$arrresult=array('stute'=>false,
				'msg'=>'update address faild'
		);
	}
	
	echo json_encode($arrresult);
	exit();

	
	
}
exit();
?>