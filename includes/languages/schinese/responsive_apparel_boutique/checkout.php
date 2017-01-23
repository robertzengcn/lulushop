<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2007 Numinix Technology http://www.numinix.com         |
// |                                                                      |
// | Portions Copyright (c) The Zen Cart Development Team                 |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+

//BREADCRUMB
define('NAVBAR_TITLE', '结算');

//SECTION HEADINGS
define('HEADING_TITLE_ORDER_TOTAL', '结算 - 步骤 2 / 3:');
define('HEADING_TITLE_SHIPPING', '步骤 1 - 配送信息'); 
define('HEADING_TITLE_PAYMENT', '步骤 2 - 支付信息'); 
define('HEADING_TITLE_PAYMENT_VIRTUAL', 'Step 1 - 支付信息');

//TABLE HEADINGS
define('TABLE_HEADING_PAYMENT_METHOD', '账单详情');
define('TABLE_SUBHEADING_PAYMENT_METHOD', '账单信息');
define('TABLE_HEADING_SHIPPING_METHOD', '配送信息'); 
define('TABLE_SUBHEADING_SHIPPING_METHOD', '配送方式'); 
define('TABLE_HEADING_COMMENTS', '订单特殊要求/订单留言'); 
define('TABLE_HEADING_SHIPPING_ADDRESS', '配送地址');
define('TABLE_HEADING_SHOPPING_CART', '购物车内商品');
define('TABLE_HEADING_BILLING_ADDRESS', '账单地址');
define('TABLE_HEADING_DROPDOWN', 'Drop Down Heading');
define('TABLE_HEADING_GIFT_MESSAGE', 'Gift Message');
define('TABLE_HEADING_FEC_CHECKBOX', 'Optional Checkbox');

//TITLES
define('TITLE_BILLING_ADDRESS', '账单地址:'); 
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', '<strong>继续到步骤 3</strong>'); 
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE_VIRTUAL', '<strong>继续到步骤 2</strong>'); 
define('TITLE_CONFIRM_CHECKOUT', '<strong>确认订单</strong>');
define('TITLE_SHIPPING_ADDRESS', '配送信息:'); 

//TEXT
define('TEXT_CHOOSE_SHIPPING_DESTINATION', '你订购的商品将会被发送到左边的地址，你可以通过<em>修改地址</em>按钮来修改收货地址。'); 
define('TEXT_SELECTED_BILLING_DESTINATION', '你的账单地址显示在右侧，你可以通过<em>修改地址</em>按钮来修改账单地址。'); 
define('TEXT_YOUR_TOTAL','总共'); 
define('TEXT_SELECT_PAYMENT_METHOD', '请为你的订单选择付款方式'); 
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', "- 请点击 '继续结算'"); 
define('TEXT_ENTER_SHIPPING_INFORMATION', '当前订单可行的配送方式'); 
define('TEXT_CONFIRM_CHECKOUT', '正在处理');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* 必填</span>');
define('TEXT_DROP_DOWN', '请选择: ');
define('TEXT_FEC_CHECKBOX', 'Signature Option?');      

//ERROR MESSAGES DISPLAYED
define('ERROR_CONDITIONS_NOT_ACCEPTED', '请勾选按钮确认遵守条款'); 
define('ERROR_NO_PAYMENT_MODULE_SELECTED', '请为你的订单选择付款方式');
// eof