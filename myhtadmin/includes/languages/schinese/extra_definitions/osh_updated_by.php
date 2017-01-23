<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: orders.php 6214 2007-04-17 02:24:25Z ajeh $
 */
define('OSH_EMAIL_SEPARATOR', '------------------------------------------------------');
define('OSH_EMAIL_TEXT_SUBJECT', '订单更新');
define('OSH_EMAIL_TEXT_ORDER_NUMBER', '订单数量:');
define('OSH_EMAIL_TEXT_INVOICE_URL', '发票详情:');
define('OSH_EMAIL_TEXT_DATE_ORDERED', '订单日期:');
define('OSH_EMAIL_TEXT_COMMENTS_UPDATE', '<em>您的订单相关备注: </em>' . "\n\n");
define('OSH_EMAIL_TEXT_STATUS_UPDATED', '您的订单状态已被更新:' . "\n");  /*v1.0.0c*/
define('OSH_EMAIL_TEXT_STATUS_NO_CHANGE', '您的订单状态没有改变:' . "\n");  /*v1.0.0a*/
define('OSH_EMAIL_TEXT_STATUS_LABEL', '<strong>当前状态: </strong> %s' . "\n\n");  /*v1.0.0c*/
define('OSH_EMAIL_TEXT_STATUS_CHANGE', '<strong>原来状态:</strong> %1$s, <strong>新状态:</strong> %2$s' . "\n\n");  /*v1.0.0c*/
define('OSH_EMAIL_TEXT_STATUS_PLEASE_REPLY', '假如您有任何问题,请回复邮件.' . "\n");

// -----
// Used by orders.php, so that the orders.php language file doesn't require change!
//
define('TABLE_HEADING_UPDATED_BY', '更新被');  /*v1.0.2a*/