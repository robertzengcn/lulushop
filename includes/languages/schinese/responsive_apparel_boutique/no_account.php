<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright Joseph Schilz
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: J_Schilz for Integrated COWOA - 14 April 2007
 */

define('NAVBAR_TITLE', '账单信息');

define('TABLE_HEADING_BILLING_ADDRESS', '账单地址');
define('TABLE_HEADING_SHIPPING_ADDRESS', '配送地址');

define('HEADING_TITLE', '结算 - 步骤 1 / 3');

define('TEXT_ORIGIN_LOGIN', '如果你已经有账户，你可以通过点击 <a href="%s"><em>登录</em>按钮登录</a>.');
define('TEXT_LEGEND_HEAD', '创建一个账户');
define('TEXT_MORE', 'For a limited time, new customers receive a coupon good for 10% off any order.  You will receive this coupon immediately after you have created your account, and it may be used on your first order.<br /><br />To begin creating a new account, please enter your account details below.');

// greeting salutation
define('EMAIL_SUBJECT', '欢迎来到 ' . STORE_NAME);
define('EMAIL_GREET_MR', '尊敬的  %s 先生,' . "\n\n");
define('EMAIL_GREET_MS', '尊敬的  %s 小姐,' . "\n\n");
define('EMAIL_GREET_NONE', '尊敬的 %s' . "\n\n");

// First line of the greeting
define('EMAIL_WELCOME', '欢迎你来到 <strong>' . STORE_NAME . '</strong>.');
define('EMAIL_SEPARATOR', '--------------------');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Congratulations! To make your next visit to our online shop a more rewarding experience, listed below are details for a Discount Coupon created just for you!' . "\n\n");
// your Discount Coupon Description will be inserted before this next define
define('EMAIL_COUPON_REDEEM', 'To use the Discount Coupon, enter the ' . TEXT_GV_REDEEM . ' code during checkout:  <strong>%s</strong>' . "\n\n");

define('EMAIL_GV_INCENTIVE_HEADER', 'Just for stopping by today, we have sent you a ' . TEXT_GV_NAME . ' for %s!' . "\n");
define('EMAIL_GV_REDEEM', 'The ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' is: %s ' . "\n\n" . 'You can enter the ' . TEXT_GV_REDEEM . ' during Checkout, after making your selections in the store. ');
define('EMAIL_GV_LINK', ' Or, you may redeem it now by following this link: ' . "\n");
// GV link will automatically be included before this line

define('EMAIL_GV_LINK_OTHER','Once you have added the ' . TEXT_GV_NAME . ' to your account, you may use the ' . TEXT_GV_NAME . ' for yourself, or send it to a friend!' . "\n\n");

define('EMAIL_TEXT', 'With your account, you can now take part in the <strong>various services</strong> we have to offer you. Some of these services include:' . "\n\n" . '<li><strong>Permanent Cart</strong> - Any products added to your online cart remain there until you remove them, or check them out.' . "\n\n" . '<li><strong>Address Book</strong> - We can deliver your products to another address other than your own. This is perfect to send birthday gifts directly to the birthday-person themselves.' . "\n\n" . '<li><strong>Order History</strong> - View your history of purchases that you have made with us.' . "\n\n" . '<li><strong>Products Reviews</strong> - Share your opinions on products with our other customers.' . "\n\n" . 'Your Discount Coupon - As a thank you for joining our community, we\'ve included a 10% discount coupon.  You may use this coupon once to get 10% off any order, large or small.  It is good through December of 2007.  The coupon code is \'08825bbc50\'.  To use this code, enter it during checkout in the coupon entry field.' . "\n\n");
define('EMAIL_CONTACT', 'For help with any of our online services, please email the store-owner: <a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS ." </a>\n\n");
define('EMAIL_GV_CLOSURE','Sincerely,' . "\n\n" . STORE_OWNER . "\nStore Owner\n\n". '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER . DIR_WS_CATALOG ."</a>\n\n");

// email disclaimer - this disclaimer is separate from all other email disclaimers
define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'This email address was given to us by you or by one of our customers. If you did not signup for an account, or feel that you have received this email in error, please send an email to %s ');

define('TABLE_HEADING_CONTACT_DETAILS', 'Contact Details');

define('ENTRY_COPYBILLING', 'Same Address for Shipping/Billing');
define('ENTRY_COPYBILLING_TEXT', '');
define('ENTRY_EMAIL_ADDRESS_CONFIRM', 'Confirm email:');
define('ENTRY_EMAIL_ADDRESS_CONFIRM_ERROR', 'Your email address confirmation does not match.');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Continue to checkout');
if ($_SESSION['cart']->get_content_type() == 'virtual') {
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- select payment method.'); 
} else {
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- select shipping/payment method.');
}
// eof