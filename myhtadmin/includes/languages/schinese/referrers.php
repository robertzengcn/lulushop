<?php
// +----------------------------------------------------------------------+
// | Snap Affiliates for Zen Cart v1.5.0+                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 2013-2015, Vinos de Frutas Tropicales (lat9)           |
// |                                                                      |
// | Original: Copyright (c) 2009 Michael Burke                           |
// | http://www.filterswept.com                                           |
// |                                                                      |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license.       |
// +----------------------------------------------------------------------+

define('TEXT_REFERRERS', '佣金联盟'); /*v2.1.0a*/

define('ERROR_INVALID_PERCENTAGE', '该"当前佣金率" 的值必须是0到100之间的数字.'); /*v2.1.0a*/

// Language file for the Customers->Referrers Tool
define('HEADING_FIRST_NAME', '姓');
define('HEADING_LAST_NAME', '名');
define('HEADING_EMAIL_ADDRESS', '邮件地址');  //-v2.7.1a
define('HEADING_WEBSITE', '网站');
define('HEADING_APPROVED', '通过');
define('HEADING_BANNED', '禁止');
define('HEADING_UNPAID_TOTAL', '未付款总额');
define('HEADING_COMMISSION_RATE', '佣金率');
define('HEADING_EMAIL', '邮件地址');
define('HEADING_PAYMENT_TYPE', '付款方式');
  define('PAYMENT_TYPE_CHECK_MONEYORDER', 'Check/Money-order');
  define('PAYMENT_TYPE_PAYPAL', 'PayPal');
    define('PAYMENT_TYPE_PAYPAL_DETAILS', 'PayPal 邮件地址:');
  define('PAYMENT_TYPE_UNKNOWN', 'Unknown');

define('LABEL_REFERRER_ID', '佣金联盟 ID:');
define('LABEL_HOME_PAGE_LINK', '首页链接 Link:');  //-v2.7.3
define('LABEL_ORDERS_TOTAL', '订单总额:');
define('LABEL_WEBSITE', HEADING_WEBSITE . ':  <a href="http://%1$s" target="_blank" rel="noreferrer">%1$s</a>' . "\n"); /*v2.4.1c*, v2.7.0 added rel="noreferrer"*/
define('LABEL_EMAIL', HEADING_EMAIL . ': <a href="mailto:%1$s">%1$s</a>' . "\n");
define('LABEL_PHONE', '电话:');
define('LABEL_NAME_ADDRESS', '姓名和地址:');
define('LABEL_APPROVED', HEADING_APPROVED . ':');
define('LABEL_BANNED', HEADING_BANNED . ':');
define('TEXT_UNPAID', '未付款');
define('LABEL_UNPAID', TEXT_UNPAID . ':');
define('LABEL_ADDRESS', '地址:');
define('LABEL_PAYMENT_TYPE', HEADING_PAYMENT_TYPE . ':');
define('LABEL_UNPAID_COMMISSION', '未付款佣金:');
define('LABEL_CURRENT_COMMISSION_RATE', '当前佣金率:');

define('TEXT_REFERRER_INFO', '佣金联盟信息');
define('TEXT_STATUS', '状态');
define('TEXT_ORDER_HISTORY', '订单历史');
define('TEXT_TO', '到:');
define('TEXT_FROM', '从:');
define('TEXT_APPROVE', '通过'); /*v2.1.0a*/
define('TEXT_BAN', '禁止');
define('TEXT_UNBAN', '未禁止');
define('TEXT_PAY', '付款'); /*v2.1.0a*/
define('TEXT_UPDATE', '更新'); /*v2.1.0a*/
define('TEXT_UPDATE_PAYMENT_TYPE', '更新付款方式');
define('TEXT_DISPLAY_SPLIT', '显示 %1$u to %2$u (从 %3$u 中的佣金)');

//-bof-v2.7.0a
define('TEXT_PAY_SELECTED', '付款选择');
define('TEXT_CHOOSE_COMMISSIONS', '选择未付款佣金支付');
define('HEADING_CHOOSE', '选择');
define('HEADING_CALCULATED_COMMISSION', '计算佣金');
define('HEADING_COMMISSION_TO_PAY', '付款佣金');
define('ERROR_COMMISSION_CANT_BE_ZERO', '该付款佣金必须大于 0.');
define('ERROR_CHOOSE_COMMISSION_TO_PAY', '请选择最少一个佣金来付款.');
define('SUCCESS_PAYMENT_MADE', '你已付款的佣金 %1$s to %2$s %3$s 已被记录.');
//-eof-v2.7.0a
define('ERROR_PAYMENT_DETAILS_MISSING', '该域 <em>%s</em> 不能为空.  请重新输入.');

define('TEXT_NONCOMMISSIONABLE', ' (Non-Commissionable)');  /*v2.5.0a*/

define('HEADING_ORDER_ID', '订单 ID'); /*v2.3.0a*/
define('HEADING_ORDER_DATE', '订单日期');
define('HEADING_ORDER_TOTAL', '订单总额');
define('HEADING_COMMISSION_TOTAL', '总共佣金');
define('HEADING_COMMISSION_PAY_DATE', '已付款佣金到');
define('HEADING_COMMISSION_PAID_VIA', '佣金付款通过');
define('HEADING_TOTALS', '总共');

/* ----
** The email subject and message when an affiliate account is approved.  The message is created by passing three parameters:
** 1) The link to the store's login page
** 2) The link to the store's referrer_tools page
** 3) The link to the store's contact_us page
*/
define('EMAIL_SUBJECT_APPROVED', '通过: ' . STORE_NAME . ' 佣金联盟账户');
define('EMAIL_MESSAGE_APPROVED_HTML', '恭喜!  您在 <strong>' . STORE_NAME . '</strong> 的佣金账户已被通过.  您可以通过登录账户点击 <a href="%1$s">这里</a>.  在你登录后，您可以进入佣金统计和其他工具通过 <a href="%2$s">这里</a>.<br /><br />接下来您需要花几分钟完善你的佣金联盟账户.  假如您有任何疑问, 请 <a href="%3$s">联系我们</a>.<br /><br />此致,<br /><br />' . STORE_OWNER); /*v2.1.0c*/
define('EMAIL_MESSAGE_APPROVED_TEXT', '恭喜!  您在 ' . STORE_NAME . ' 的佣金账户已被通过. 您可以通过登录账户通过使用以下链接: %1$s.  在您登录后, 可以进入佣金统计和其他工具使用以下链接: %2$s.' . "\n\n" . '接下来您需要花几分钟完善你的佣金联盟账户.  假如您有任何疑问, 请联系我们使用以下链接: %3$s.' . "\n\n此致,\n\n" . STORE_OWNER);

/* ----
** The email subject and message when an affiliate account is banned/suspended.
*/
define('EMAIL_SUBJECT_BANNED', '暂停: ' . STORE_NAME . ' 佣金账户');
define('EMAIL_MESSAGE_BANNED_HTML', '您在 <strong>' . STORE_NAME . '</strong> 的佣金账户已被暂停. 假如您认为其中有错误, 请联系我们. 我们将为您处理并且重启您的账户.<br /><br />此致,<br /><br />' . STORE_OWNER);
define('EMAIL_MESSAGE_BANNED_TEXT', '您在 ' . STORE_NAME . ' 的佣金账户已被暂停.  假如您认为其中有错误, 请联系我们. 我们将为您处理并且重启您的账户.' . "\n\n此致,\n\n" . STORE_OWNER);

/* ----
** The email subject and message when a payment is made to an affiliate.  The message is created by passing four parameters:
** 1) The formatted payment amount
** 2) The link to the store's login page
** 3) The link to the store's referrer_tools page
** 4) The link to the store's contact_us page
*/
define('EMAIL_SUBJECT_PAID', '付款: ' . STORE_NAME . ' 佣金账户');  //-v2.7.0c (added leading space)
define('EMAIL_MESSAGE_PAID_HTML', '您在 ' . STORE_NAME . '的佣金联盟账户的佣金刚刚被支付， 您这期总共赚到的佣金为 <strong>%1$s</strong>.<br /><br />如果您想查看详情请 <a href="%2$s">登录</a> 并且查看您的佣金 <a href="%3$s">统计</a>. 假如您有任何问题, 请 <a href="%4$s">联系我们</a>.<br /><br />此致,<br /><br />' . STORE_OWNER); /*v2.1.0c, v2.7.0c*/
define('EMAIL_MESSAGE_PAID_TEXT', '您在 ' . STORE_NAME . ' 的佣金联盟账户的佣金刚刚被支付. 您这期总共赚到的佣金为 %1$s.' . "\n\n" . '如果您想查看详情请 (%2$s) 并且查看您的佣金统计 (%3$s).  假如您有任何疑问, 请联系我们通过以下链接: %4$s.' . "\n\n此致,\n\n" . STORE_OWNER); /*v2.1.0c*/

/* ----
** The orders_status_history comment created when an affiliate is paid.
**
** %1$s - The commission payment amount
** %2$s - The referrer's first name
** %3$s - The referrer's last name
** %4$s - The commission payment type information
*/
//-bof-a-v2.5.0
define('TEXT_ORDERS_STATUS_PAID', '已支付佣金 %1$s 付款到 %2$s %3$s via %4$s.');
//-eof-a-v2.5.0