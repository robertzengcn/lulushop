<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: account.php 3595 2006-05-07 06:39:23Z drbyte $
 */

define('NAVBAR_TITLE', '佣金联盟首页');
define('HEADING_TITLE', '我的佣金统计');

define('TEXT_ORDERS_PAYMENTS', '订单以及付款');
define('TEXT_MARKETING_TOOLS', '市场营销工具');
define('TEXT_REFERRER_TERMS', '佣金条款');

define('TEXT_REFERRAL_SUBMITTED', '感谢您对佣金联盟的支持.  我们正在处理, 将在48小时内邮件通知结果.');
define('TEXT_REFERRAL_BANNED', '<em>您的佣金账户已被暂停.</em>  如果您有疑问, 请 <a href="%s">联系我们</a>.');

define('TEXT_PLEASE_LOGIN', '请 <a href="%s">登陆</a> 进入佣金统计.');
define('TEXT_REFERRER_SIGNUP', '假如你没有佣金账户, 请新建一个通过 <a href="%s">注册</a>页面.');

define('HEADING_REFERRER_INFO', '我的佣金联盟信息');
define('TEXT_REFERRER_ID', '我的佣金联盟账号:');
define('TEXT_MY_WEBSITE', '我的网站:'); /*v2.2.0a*/
define('TEXT_LAST_PAYMENT_MADE', '最近的付款日期在:');
define('TEXT_NO_PAYMENTS', '没有订单被付款');
define('TEXT_COMMISSION_RATE', '我的佣金比率:');
define('TEXT_MY_PAYMENT_TYPE', '我的付款方式:');

define('TEXT_SALES_SUMMARY', '销售统计');
define('TEXT_CURRENT_SALES', '当前销售额:');
define('TEXT_UNPAID_COMMISSION', '未支付佣金:');
define('TEXT_YTD_SALES', '近期销售额:');
define('TEXT_YTD_COMMISSION', '近期佣金:');

define('TEXT_ACTIVITY', '激活的佣金付款');  /*v2.5.1c*/
define('TEXT_TO', '到:');
define('TEXT_FROM', '从:');
define('TEXT_UNPAID', '未付款');
define('HEADING_PURCHASE_DATE', '购物日期');
define('HEADING_AMOUNT', '总量');
define('HEADING_COMMISSION_RATE', '佣金率');
define('HEADING_COMMISSION_CALCULATED', '计算出的佣金');
define('HEADING_COMMISSION_PAID', '<sup>*</sup>未付款佣金');
define('HEADING_COMMISSION_PAY_DATE', '佣金支付日期');
define('HEADING_COMMISSION_PAY_TYPE', '佣金支付通过');
  define ('TEXT_UNKNOWN', '未知');
define('HEADING_TOTALS', '总共');

define('TEXT_COMMISSION_PAID', '<strong><sup>*</sup>已支付佣金</strong> 包括退货以及退款， 关于佣金是如何支付的更多信息，
请访问 <a href="' . zen_href_link (FILENAME_REFERRER_SIGNUP, 'terms', 'SSL') . '">佣金条款页面</a>.');