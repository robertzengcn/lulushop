<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: account.php 3595 2006-05-07 06:39:23Z drbyte $
 */
define('NAVBAR_TITLE', '注册佣金联盟');
define('HEADING_TITLE', '佣金联盟注册');

define('TEXT_ORDERS_PAYMENTS', '订单和付款');
define('TEXT_MARKETING_TOOLS', '营销工具');
define('TEXT_REFERRER_TERMS', '佣金条款');

define('HEADING_REFERRER_TERMS', '我们的佣金条款');
define('TEXT_SIGN_UP', '您对佣金联盟感兴趣吗，请输入以下url了解详情');
define('TEXT_NOT_LOGGED_IN', '您对佣金联盟有兴趣吗？请<a href="%s">登陆您的账户</a>. 如果你还没有账户，你可以点击 <a href="%s">这里创建</a>.');

define('TEXT_HOMEPAGE_URL', '网站地址:');
define('ERROR_NO_URL', '请输入网站地址 (例如, www.mysite.com) 来注册佣金联盟.');

define('EMAIL_SUBJECT', STORE_NAME . ' 佣金联盟注册要求');
define('EMAIL_BODY', '客户姓名： %1$s %2$s (customer ID %3$u) 已经同意接受 ' . STORE_NAME . ' 佣金联盟项目. 您可以查看相关条款在您的账户下.');