<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: orders.php 6214 2007-04-17 02:24:25Z ajeh $
 */

define('HEADING_TITLE', '订单');
define('HEADING_TITLE_SEARCH', '订单号:');
define('HEADING_TITLE_STATUS', '状态:');
define('HEADING_TITLE_SEARCH_DETAIL_ORDERS_PRODUCTS', '通过产品名称或者 <strong>ID:XX</strong> 或者型号 ');
define('TEXT_INFO_SEARCH_DETAIL_FILTER_ORDERS_PRODUCTS', '搜索过滤: ');
define('TABLE_HEADING_PAYMENT_METHOD', '付款<br />配送');
define('TABLE_HEADING_ORDERS_ID','ID');

define('TEXT_BILLING_SHIPPING_MISMATCH','帐单以及配送日期不确定');

define('TABLE_HEADING_COMMENTS', '评论留言');
define('TABLE_HEADING_CUSTOMERS', '客户');
define('TABLE_HEADING_ORDER_TOTAL', '订单总额');
define('TABLE_HEADING_DATE_PURCHASED', '购买日期');
define('TABLE_HEADING_STATUS', '状态');
define('TABLE_HEADING_TYPE', '订单类型');
define('TABLE_HEADING_ACTION', '动作');
define('TABLE_HEADING_QUANTITY', '数量.');
define('TABLE_HEADING_PRODUCTS_MODEL', '型号');
define('TABLE_HEADING_PRODUCTS', '产品');
define('TABLE_HEADING_TAX', '税');
define('TABLE_HEADING_TOTAL', '总额');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', '价格 (ex)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', '价格 (inc)');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', '总共 (ex)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', '总共 (inc)');

define('TABLE_HEADING_CUSTOMER_NOTIFIED', '客户通知');
define('TABLE_HEADING_DATE_ADDED', '添加日期');
//-bof-a-snap_affiliates-v2.5.0
define('TABLE_HEADING_UPDATED_BY', '更新被');
//-eof-a-snap_affiliates-v2.5.0

define('ENTRY_CUSTOMER', '客户:');
define('ENTRY_SOLD_TO', '卖给:');
define('ENTRY_DELIVERY_TO', '发货到:');
define('ENTRY_SHIP_TO', '配送到:');
define('ENTRY_SHIPPING_ADDRESS', '配送地址:');
define('ENTRY_BILLING_ADDRESS', '帐单地址:');
define('ENTRY_PAYMENT_METHOD', '付款方式:');
define('ENTRY_CREDIT_CARD_TYPE', '性用卡类型:');
define('ENTRY_CREDIT_CARD_OWNER', '信用卡所有人姓名:');
define('ENTRY_CREDIT_CARD_NUMBER', '信用卡号码:');
define('ENTRY_CREDIT_CARD_CVV', '信用卡安全码:');
define('ENTRY_CREDIT_CARD_EXPIRES', '信用卡到期日期:');
define('ENTRY_SUB_TOTAL', '总计:');
define('ENTRY_TAX', '税:');
define('ENTRY_SHIPPING', '配送:');
define('ENTRY_TOTAL', '总共:');
define('ENTRY_DATE_PURCHASED', '购买日期:');
define('ENTRY_STATUS', '状态:');
define('ENTRY_DATE_LAST_UPDATED', '上次更新日期:');
define('ENTRY_NOTIFY_CUSTOMER', '通知客户:');
define('ENTRY_NOTIFY_COMMENTS', '待处理通知:');
define('ENTRY_PRINTABLE', '打印发票');

define('TEXT_INFO_HEADING_DELETE_ORDER', '删除订单');
define('TEXT_INFO_DELETE_INTRO', '你确定要删除订单?');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', '恢复商品数量');
define('TEXT_DATE_ORDER_CREATED', '创建日期:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', '上次修改:');
define('TEXT_INFO_PAYMENT_METHOD', '付款方式:');
define('TEXT_PAID', '已付款');
define('TEXT_UNPAID', '未付款');

define('TEXT_ALL_ORDERS', '所有订单');
define('TEXT_NO_ORDER_HISTORY', '没有可行的订单历史');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', '订单更新');
define('EMAIL_TEXT_ORDER_NUMBER', '订单号码:');
define('EMAIL_TEXT_INVOICE_URL', '详细发票:');
define('EMAIL_TEXT_DATE_ORDERED', '订单日期:');
define('EMAIL_TEXT_COMMENTS_UPDATE', '<em>订单的相关留言: </em>');
define('EMAIL_TEXT_STATUS_UPDATED', '您的订单已经更新到以下状态:' . "\n");
define('EMAIL_TEXT_STATUS_LABEL', '<strong>新状态:</strong> %s' . "\n\n");
define('EMAIL_TEXT_STATUS_PLEASE_REPLY', '假如你有任何问题，请回复邮件.' . "\n");

define('ERROR_ORDER_DOES_NOT_EXIST', '错误: 订单不存在.');
define('SUCCESS_ORDER_UPDATED', 'Success: 订单已被成功更新.');
define('WARNING_ORDER_NOT_UPDATED', '警告: 没有任何数据改变. 订单没有被更新.');

define('ENTRY_ORDER_ID','发票 No. ');
define('TEXT_INFO_ATTRIBUTE_FREE', '&nbsp;-&nbsp;<span class="alert">免费</span>');

define('TEXT_DOWNLOAD_TITLE', '订单下载状态');
define('TEXT_DOWNLOAD_STATUS', '状态');
define('TEXT_DOWNLOAD_FILENAME', '文件名');
define('TEXT_DOWNLOAD_MAX_DAYS', '天');
define('TEXT_DOWNLOAD_MAX_COUNT', '计数');

define('TEXT_DOWNLOAD_AVAILABLE', '可行的');
define('TEXT_DOWNLOAD_EXPIRED', '到期');
define('TEXT_DOWNLOAD_MISSING', '不在服务器上');

define('IMAGE_ICON_STATUS_CURRENT', '状态 - 可行');
define('IMAGE_ICON_STATUS_EXPIRED', '状态 - 到期');
define('IMAGE_ICON_STATUS_MISSING', '状态 - 空缺');

define('SUCCESS_ORDER_UPDATED_DOWNLOAD_ON', '成功下载已打开');
define('SUCCESS_ORDER_UPDATED_DOWNLOAD_OFF', '成功下载已禁用');
define('TEXT_MORE', '... 更多');

define('TEXT_INFO_IP_ADDRESS', 'IP 地址: ');
define('TEXT_DELETE_CVV_FROM_DATABASE','从数据库中删除安全码');
define('TEXT_DELETE_CVV_REPLACEMENT','删除');
define('TEXT_MASK_CC_NUMBER','标记该号码');

define('TEXT_INFO_EXPIRED_DATE', '到期日期:<br />');
define('TEXT_INFO_EXPIRED_COUNT', '到期总计:<br />');

define('TABLE_HEADING_CUSTOMER_COMMENTS', '客户<br />留言');
define('TEXT_COMMENTS_YES', '客户留言 - 确定');
define('TEXT_COMMENTS_NO', '客户留言 - 取消');
?>