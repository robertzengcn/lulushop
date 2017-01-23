-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 01 月 20 日 04:01
-- 服务器版本: 5.5.20
-- PHP 版本: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `lulu`
--

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orders_id` int(25) NOT NULL AUTO_INCREMENT,
  `customers_id` int(11) NOT NULL DEFAULT '0',
  `customers_name` varchar(64) NOT NULL DEFAULT '',
  `customers_company` varchar(64) DEFAULT NULL,
  `customers_street_address` varchar(64) NOT NULL DEFAULT '',
  `customers_suburb` varchar(32) DEFAULT NULL,
  `customers_city` varchar(32) NOT NULL DEFAULT '',
  `customers_postcode` varchar(10) NOT NULL DEFAULT '',
  `customers_state` varchar(32) DEFAULT NULL,
  `customers_country` varchar(32) NOT NULL DEFAULT '',
  `customers_telephone` varchar(32) NOT NULL DEFAULT '',
  `customers_email_address` varchar(96) NOT NULL DEFAULT '',
  `customers_address_format_id` int(5) NOT NULL DEFAULT '0',
  `delivery_name` varchar(64) NOT NULL DEFAULT '',
  `delivery_company` varchar(64) DEFAULT NULL,
  `delivery_street_address` varchar(64) NOT NULL DEFAULT '',
  `delivery_suburb` varchar(32) DEFAULT NULL,
  `delivery_city` varchar(32) NOT NULL DEFAULT '',
  `delivery_postcode` varchar(10) NOT NULL DEFAULT '',
  `delivery_state` varchar(32) DEFAULT NULL,
  `delivery_country` varchar(32) NOT NULL DEFAULT '',
  `delivery_address_format_id` int(5) NOT NULL DEFAULT '0',
  `billing_name` varchar(64) NOT NULL DEFAULT '',
  `billing_company` varchar(64) DEFAULT NULL,
  `billing_street_address` varchar(64) NOT NULL DEFAULT '',
  `billing_suburb` varchar(32) DEFAULT NULL,
  `billing_city` varchar(32) NOT NULL DEFAULT '',
  `billing_postcode` varchar(10) NOT NULL DEFAULT '',
  `billing_state` varchar(32) DEFAULT NULL,
  `billing_country` varchar(32) NOT NULL DEFAULT '',
  `billing_address_format_id` int(5) NOT NULL DEFAULT '0',
  `payment_method` varchar(128) NOT NULL DEFAULT '',
  `payment_module_code` varchar(32) NOT NULL DEFAULT '',
  `shipping_method` varchar(128) NOT NULL DEFAULT '',
  `shipping_module_code` varchar(32) NOT NULL DEFAULT '',
  `coupon_code` varchar(32) NOT NULL DEFAULT '',
  `cc_type` varchar(20) DEFAULT NULL,
  `cc_owner` varchar(64) DEFAULT NULL,
  `cc_number` varchar(32) DEFAULT NULL,
  `cc_expires` varchar(4) DEFAULT NULL,
  `cc_cvv` blob,
  `last_modified` datetime DEFAULT NULL,
  `date_purchased` datetime DEFAULT NULL,
  `orders_status` int(5) NOT NULL DEFAULT '0',
  `orders_date_finished` datetime DEFAULT NULL,
  `currency` char(3) DEFAULT NULL,
  `currency_value` decimal(14,6) DEFAULT NULL,
  `order_total` decimal(14,2) DEFAULT NULL,
  `order_tax` decimal(14,2) DEFAULT NULL,
  `paypal_ipn_id` int(11) NOT NULL DEFAULT '0',
  `ip_address` varchar(96) NOT NULL DEFAULT '',
  `shipping_telephone` varchar(50) DEFAULT NULL,
  `dropdown` varchar(50) DEFAULT NULL,
  `gift_message` varchar(100) DEFAULT NULL,
  `checkbox` int(1) DEFAULT NULL,
  `COWOA_order` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`orders_id`),
  KEY `idx_status_orders_cust_zen` (`orders_status`,`orders_id`,`customers_id`),
  KEY `idx_date_purchased_zen` (`date_purchased`),
  KEY `idx_cust_id_orders_id_zen` (`customers_id`,`orders_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=375 ;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`orders_id`, `customers_id`, `customers_name`, `customers_company`, `customers_street_address`, `customers_suburb`, `customers_city`, `customers_postcode`, `customers_state`, `customers_country`, `customers_telephone`, `customers_email_address`, `customers_address_format_id`, `delivery_name`, `delivery_company`, `delivery_street_address`, `delivery_suburb`, `delivery_city`, `delivery_postcode`, `delivery_state`, `delivery_country`, `delivery_address_format_id`, `billing_name`, `billing_company`, `billing_street_address`, `billing_suburb`, `billing_city`, `billing_postcode`, `billing_state`, `billing_country`, `billing_address_format_id`, `payment_method`, `payment_module_code`, `shipping_method`, `shipping_module_code`, `coupon_code`, `cc_type`, `cc_owner`, `cc_number`, `cc_expires`, `cc_cvv`, `last_modified`, `date_purchased`, `orders_status`, `orders_date_finished`, `currency`, `currency_value`, `order_total`, `order_tax`, `paypal_ipn_id`, `ip_address`, `shipping_telephone`, `dropdown`, `gift_message`, `checkbox`, `COWOA_order`) VALUES
(369, 430, 'JianZe Zeng', 'Zeng JianZe', 'å†¯å®…æ‘28å·(No.28 Fengzhai Village)Cell No:15705910133', '', 'ç¦å·žå¸‚ä»“å±±åŒºå»ºæ–°é•‡(Jian', '350000', 'Fujian', 'China', '+86 18059949858', 'amigatoy@gmail.com', 1, 'JianZe Zeng', 'Zeng JianZe', 'å†¯å®…æ‘28å·(No.28 Fengzhai Village)Cell No:15705910133', '', 'ç¦å·žå¸‚ä»“å±±åŒºå»ºæ–°é•‡(Jian', '350000', 'Fujian', 'China', 1, 'JianZe Zeng', 'Zeng JianZe', 'å†¯å®…æ‘28å·(No.28 Fengzhai Village)Cell No:15705910133', '', 'ç¦å·žå¸‚ä»“å±±åŒºå»ºæ–°é•‡(Jian', '350000', 'Fujian', 'China', 1, 'PayPal', 'paypalwpp', 'Free Shipping Options (Free Shipping)', 'freeoptions', '', '', '', '', '', NULL, NULL, '2014-04-30 23:03:12', 1, NULL, 'GBP', '1.000000', '59.51', '0.00', 0, '27.156.119.130 - 27.156.119.130', NULL, NULL, NULL, NULL, 0),
(370, 0, ' ', '', '', '', '', '', '', '', '', '', 0, ' ', '', '', '', '', '', '', '', 0, ' ', '', '', '', '', '', '', '', 0, 'Gift Certificate/Coupon', 'GV/DC', '', '', '', '', '', '', '', NULL, NULL, '2014-04-30 23:03:20', 2, NULL, 'GBP', '1.000000', '0.00', '0.00', 0, '108.162.215.196 - 108.162.215.196', NULL, NULL, NULL, NULL, 0),
(372, 0, ' ', '', '', '', '', '', '', '', '', '', 0, ' ', '', '', '', '', '', '', '', 0, ' ', '', '', '', '', '', '', '', 0, 'Gift Certificate/Coupon', 'GV/DC', '', '', '', '', '', '', '', NULL, NULL, '2014-05-04 21:10:55', 2, NULL, 'GBP', '1.000000', '0.00', '0.00', 0, '108.162.215.196 - 108.162.215.196', NULL, NULL, NULL, NULL, 0),
(373, 0, '???', '??', '????', '????', '??', '3591062', NULL, 'fdad', '', '', 0, '', NULL, '', NULL, '', '', NULL, '', 0, '', NULL, '', NULL, '', '', NULL, '', 0, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, NULL, NULL, NULL, 0),
(374, 0, '测试', '测试', '', NULL, '', '', NULL, '', '', '', 0, '', NULL, '', NULL, '', '', NULL, '', 0, '', NULL, '', NULL, '', '', NULL, '', 0, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, '', NULL, NULL, NULL, NULL, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
