<?php
	$db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '1.12.2' WHERE configuration_key = 'FAST_AND_EASY_CHECKOUT_VERSION' LIMIT 1;");
	$messageStack->add('Updated Fast and Easy Checkout to v1.12.2', 'success');
?>