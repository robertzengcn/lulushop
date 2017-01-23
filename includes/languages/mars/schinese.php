<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: english.php 19690 2011-10-04 16:41:45Z drbyte $
 */

// FOLLOWING WERE moved to meta_tags.php
//define('TITLE', 'Zen Cart!');
//define('SITE_TAGLINE', 'The Art of E-commerce');
//define('CUSTOM_KEYWORDS', 'ecommerce, open source, shop, online shopping');
// END: moved to meta_tags.php

  define('FOOTER_TEXT_BODY', '版权所有; ' . date('Y') . ' <a href="/"><strong>撸撸商城情趣用品</strong></a> <a href="/">充气娃娃</a></strong>');

// look in your $PATH_LOCALE/locale directory for available locales..
  @setlocale(LC_TIME, 'en_US');
  define('DATE_FORMAT_SHORT', '%m/%d/%Y');  // this is used for strftime()
  define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
  define('DATE_FORMAT', 'm/d/Y'); // this is used for date()
  define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
  if (!function_exists('zen_date_raw')) {
    function zen_date_raw($date, $reverse = false) {
      if ($reverse) {
        return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
      } else {
        return substr($date, 6, 4) . substr($date, 0, 2) . substr($date, 3, 2);
      }
    }
  }

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
  define('LANGUAGE_CURRENCY', 'USD');

// Global entries for the <html> tag
  define('HTML_PARAMS','dir="ltr" lang="zh"');

// charset for web pages and emails
  define('CHARSET', 'utf-8');

// footer text in includes/footer.php
  define('FOOTER_TEXT_REQUESTS_SINCE', 'requests since');

// Define the name of your Gift Certificate as Gift Voucher, Gift Certificate, Zen Cart Dollars, etc. here for use through out the shop
  define('TEXT_GV_NAME','Gift Certificate');
  define('TEXT_GV_NAMES','Gift Certificates');

// used for redeem code, redemption code, or redemption id
  define('TEXT_GV_REDEEM','优惠码');

// used for redeem code sidebox
  define('BOX_HEADING_GV_REDEEM', TEXT_GV_NAME);
  define('BOX_GV_REDEEM_INFO', '优惠码: ');

// text for gender
  define('MALE', '先生');
  define('FEMALE', '小姐');
  define('MALE_ADDRESS', '先生');
  define('FEMALE_ADDRESS', '小姐');

// text for date of birth example
  define('DOB_FORMAT_STRING', 'mm/dd/yyyy');

//text for sidebox heading links
  define('BOX_HEADING_LINKS', '&nbsp;&nbsp;[more]');

// categories box text in sideboxes/categories.php
  define('BOX_HEADING_CATEGORIES', '目录');

// manufacturers box text in sideboxes/manufacturers.php
  define('BOX_HEADING_MANUFACTURERS', '制造商');

// whats_new box text in sideboxes/whats_new.php
  define('BOX_HEADING_WHATS_NEW', '新商品');
  define('CATEGORIES_BOX_HEADING_WHATS_NEW', '新商品 ...');

  define('BOX_HEADING_FEATURED_PRODUCTS', '精选');
  define('CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS', '精选商品 ...');
  define('TEXT_NO_FEATURED_PRODUCTS', '更多精选商品将很快添加,请稍候察看.');

  define('TEXT_NO_ALL_PRODUCTS', '更多商品将很快添加,请稍候察看.');
  define('CATEGORIES_BOX_HEADING_PRODUCTS_ALL', '所有产品 ...');

// quick_find box text in sideboxes/quick_find.php
  define('BOX_HEADING_SEARCH', '搜索');
  define('BOX_SEARCH_ADVANCED_SEARCH', '高级 搜索');

// specials box text in sideboxes/specials.php
  define('BOX_HEADING_SPECIALS', '特价');
  define('CATEGORIES_BOX_HEADING_SPECIALS','特价 ...');

// reviews box text in sideboxes/reviews.php
  define('BOX_HEADING_REVIEWS', '评论');
  define('BOX_REVIEWS_WRITE_REVIEW', '撰写商品评价.');
  define('BOX_REVIEWS_NO_REVIEWS', '当前产品没有评价.');
  define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s 星!');

// shopping_cart box text in sideboxes/shopping_cart.php
  define('BOX_HEADING_SHOPPING_CART', '购物车');
  define('BOX_SHOPPING_CART_EMPTY', '你的购物车是空的.');
  define('BOX_SHOPPING_CART_DIVIDER', 'x');

// order_history box text in sideboxes/order_history.php
  define('BOX_HEADING_CUSTOMER_ORDERS', '快速重复下单');

// best_sellers box text in sideboxes/best_sellers.php
  define('BOX_HEADING_BESTSELLERS', '热卖商商品');
  define('BOX_HEADING_BESTSELLERS_IN', '热卖商商品在 <br />&nbsp;&nbsp;');

// notifications box text in sideboxes/products_notifications.php
  define('BOX_HEADING_NOTIFICATIONS', '通知');
  define('BOX_NOTIFICATIONS_NOTIFY', '通知我关于该<strong>%s</strong>产品的更新');
  define('BOX_NOTIFICATIONS_NOTIFY_REMOVE', '不要通知我关于 <strong>%s</strong>的更新');

// manufacturer box text
  define('BOX_HEADING_MANUFACTURER_INFO', '制造商信息');
  define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s 的首页');
  define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', '其他产品');

// languages box text in sideboxes/languages.php
  define('BOX_HEADING_LANGUAGES', '语言');

// currencies box text in sideboxes/currencies.php
  define('BOX_HEADING_CURRENCIES', '货币');

// information box text in sideboxes/information.php
  define('BOX_HEADING_INFORMATION', '信息');
  define('BOX_INFORMATION_PRIVACY', '隐私通知');
  define('BOX_INFORMATION_CONDITIONS', '使用条件');
  define('BOX_INFORMATION_SHIPPING', '配送 &amp; 退回');
  define('BOX_INFORMATION_CONTACT', '联系我们');
  define('BOX_BBINDEX', 'Forum');
  define('BOX_INFORMATION_UNSUBSCRIBE', '退订产品更新');

  define('BOX_INFORMATION_SITE_MAP', '站点地图');

// information box text in sideboxes/more_information.php - were TUTORIAL_
  define('BOX_HEADING_MORE_INFORMATION', '更多信息');
  define('BOX_INFORMATION_PAGE_2', '页面 2');
  define('BOX_INFORMATION_PAGE_3', '页面 3');
  define('BOX_INFORMATION_PAGE_4', '页面 4');

//New billing address text
  define('SET_AS_PRIMARY' , '设为优先地址');
  define('NEW_ADDRESS_TITLE', '帐单地址');

// javascript messages
  define('JS_ERROR', '处理你的表单时发生错误.\n\n请检查以下信息:\n\n');

  define('JS_REVIEW_TEXT', '* 商品评价字数不足. 商品评价最少需要 ' . REVIEW_TEXT_MIN_LENGTH . ' 个字符.');
  define('JS_REVIEW_RATING', '* 请为商品评级.');

  define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* 请为你的订单选择付款方式.');

  define('JS_ERROR_SUBMITTED', '表单已经提交. 请点击确定等待处理.');

  define('ERROR_NO_PAYMENT_MODULE_SELECTED', '请为你的订单选择付款方式.');
  define('ERROR_CONDITIONS_NOT_ACCEPTED', '情确认条款.');
  define('ERROR_PRIVACY_STATEMENT_NOT_ACCEPTED', '请确认隐私声明.');

  define('CATEGORY_COMPANY', '公司信息');
  define('CATEGORY_PERSONAL', '你的个人信息');
  define('CATEGORY_ADDRESS', '你的地址');
  define('CATEGORY_CONTACT', '你的联系信息');
  define('CATEGORY_OPTIONS', '选项');
  define('CATEGORY_PASSWORD', '你的密码');
  define('CATEGORY_LOGIN', '登陆');
  define('PULL_DOWN_DEFAULT', '请选择你的国家');
  define('PLEASE_SELECT', '请选择 ...');
  define('TYPE_BELOW', '请在以下输入 ...');

  define('ENTRY_COMPANY', '公司名:');
  define('ENTRY_COMPANY_ERROR', '请输入公司名.');
  define('ENTRY_COMPANY_TEXT', '');
  define('ENTRY_GENDER', '性别:');
  define('ENTRY_GENDER_ERROR', '请选择你的性别.');
  define('ENTRY_GENDER_TEXT', '*');
  define('ENTRY_FIRST_NAME', '姓名:');
  define('ENTRY_FIRST_NAME_ERROR', '你的名字有错误,系统要求最少 ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' 个字符.');
  define('ENTRY_FIRST_NAME_TEXT', '*');
  define('ENTRY_LAST_NAME', '姓:');
  define('ENTRY_LAST_NAME_ERROR', '你的姓有错误,系统要求最少 ' . ENTRY_LAST_NAME_MIN_LENGTH . ' 个字符.');
  define('ENTRY_LAST_NAME_TEXT', '*');
  define('ENTRY_DATE_OF_BIRTH', '出生日期:');
  define('ENTRY_DATE_OF_BIRTH_ERROR', '你的姓有错误,系统要求的格式为: MM/DD/YYYY (例如 05/21/1970)');
  define('ENTRY_DATE_OF_BIRTH_TEXT', '* (eg. 05/21/1970)');
  define('ENTRY_EMAIL_ADDRESS', '邮件地址:');
  define('ENTRY_EMAIL_ADDRESS_ERROR', '你的邮件地址有错误? 系统要求最少 ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' 个字符,请重试.');
  define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', '对不起,我们的系统无法识别你的邮件地址.');
  define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', '该邮件地址已经注册 - 请尝试用该邮件登陆. 如果你已经不使用该邮件地址,你可以在账户里修改');
  define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
  define('ENTRY_NICK', '昵称:');
  define('ENTRY_NICK_TEXT', '*'); // note to display beside nickname input field
  define('ENTRY_NICK_DUPLICATE_ERROR', '该昵称已经使用,请尝试其他昵称');
  define('ENTRY_NICK_LENGTH_ERROR', 'Please try again. Your Nick Name must contain at least ' . ENTRY_NICK_MIN_LENGTH . ' characters.');
  define('ENTRY_STREET_ADDRESS', '街道地址:');
  define('ENTRY_STREET_ADDRESS_ERROR', '街道地址最少要有 ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' 个字符.');
  define('ENTRY_STREET_ADDRESS_TEXT', '*');
  define('ENTRY_SUBURB', '街道地址 2:');
  define('ENTRY_SUBURB_ERROR', '');
  define('ENTRY_SUBURB_TEXT', '');
  define('ENTRY_POST_CODE', '邮编:');
  define('ENTRY_POST_CODE_ERROR', '你的邮编必须包含最少 ' . ENTRY_POSTCODE_MIN_LENGTH . ' 个字符.');
  define('ENTRY_POST_CODE_TEXT', '*');
  define('ENTRY_CITY', '城市:');
  define('ENTRY_CUSTOMERS_REFERRAL', 'Referral Code:');
  define('CART', 'Cart');

  define('ENTRY_CITY_ERROR', '你的城市必须包含 ' . ENTRY_CITY_MIN_LENGTH . ' 个字符.');
  define('ENTRY_CITY_TEXT', '*');
  define('ENTRY_STATE', '州/省/市:');
  define('ENTRY_STATE_ERROR', '省市必须包含 ' . ENTRY_STATE_MIN_LENGTH . ' 个字符.');
  define('ENTRY_STATE_ERROR_SELECT', '请从下拉菜单中选择.');
  define('ENTRY_STATE_TEXT', '*');
  define('JS_STATE_SELECT', '-- 请选择 --');
  define('ENTRY_COUNTRY', '国家:');
  define('ENTRY_COUNTRY_ERROR', '请从下拉菜单中选择国家.');
  define('ENTRY_COUNTRY_TEXT', '*');
  define('ENTRY_TELEPHONE_NUMBER', '电话:');
  define('ENTRY_TELEPHONE_NUMBER_ERROR', '你的电话号码最少要有 ' . ENTRY_TELEPHONE_MIN_LENGTH . ' 个字符.');
  define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
  define('ENTRY_FAX_NUMBER', 'Fax Number:');
  define('ENTRY_FAX_NUMBER_ERROR', '');
  define('ENTRY_FAX_NUMBER_TEXT', '');
  define('ENTRY_NEWSLETTER', 'Subscribe to Our Newsletter.');
  define('ENTRY_NEWSLETTER_TEXT', '');
  define('ENTRY_NEWSLETTER_YES', 'Subscribed');
  define('ENTRY_NEWSLETTER_NO', 'Unsubscribed');
  define('ENTRY_NEWSLETTER_ERROR', '');
  define('ENTRY_PASSWORD', '密码:');
  define('ENTRY_PASSWORD_ERROR', '你的密码必须包含最少 ' . ENTRY_PASSWORD_MIN_LENGTH . ' 个字符.');
  define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', '两次密码不相同.');
  define('ENTRY_PASSWORD_TEXT', '* (最少 ' . ENTRY_PASSWORD_MIN_LENGTH . ' 个字符)');
  define('ENTRY_PASSWORD_CONFIRMATION', '确认密码:');
  define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
  define('ENTRY_PASSWORD_CURRENT', '当前密码:');
  define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
  define('ENTRY_PASSWORD_CURRENT_ERROR', '你的密码必须最少 ' . ENTRY_PASSWORD_MIN_LENGTH . ' 个字符.');
  define('ENTRY_PASSWORD_NEW', '新密码:');
  define('ENTRY_PASSWORD_NEW_TEXT', '*');
  define('ENTRY_PASSWORD_NEW_ERROR', '你的新密码必须包含最少 ' . ENTRY_PASSWORD_MIN_LENGTH . ' 个字符.');
  define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', '两次输入的密码不同.');
  define('PASSWORD_HIDDEN', '--HIDDEN--');

  define('FORM_REQUIRED_INFORMATION', '* 必填信息');
  define('ENTRY_REQUIRED_SYMBOL', '*');

  // constants for use in zen_prev_next_display function
  define('TEXT_RESULT_PAGE', '');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> products)');
  define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> orders)');
  define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> reviews)');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> new products)');
  define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> specials)');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_FEATURED_PRODUCTS', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> featured products)');
  define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_ALL', 'Displaying <strong>%d</strong> to <strong>%d</strong> (of <strong>%d</strong> products)');

  define('PREVNEXT_TITLE_FIRST_PAGE', '第一页');
  define('PREVNEXT_TITLE_PREVIOUS_PAGE', '下一页');
  define('PREVNEXT_TITLE_NEXT_PAGE', '上一页');
  define('PREVNEXT_TITLE_LAST_PAGE', '下一页');
  define('PREVNEXT_TITLE_PAGE_NO', '%d 页');
  define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Previous Set of %d Pages');
  define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Next Set of %d Pages');
  define('PREVNEXT_BUTTON_FIRST', '&lt;&lt;FIRST');
  define('PREVNEXT_BUTTON_PREV', '&lt;&lt;&nbsp;Prev');
  define('PREVNEXT_BUTTON_NEXT', 'Next&nbsp;&gt;&gt;');
  define('PREVNEXT_BUTTON_LAST', 'LAST&gt;&gt;');

  define('TEXT_BASE_PRICE','开始从: ');

  define('TEXT_CLICK_TO_ENLARGE', '商品大图');

  define('TEXT_SORT_PRODUCTS', '排列商品 ');
  define('TEXT_DESCENDINGLY', '降序');
  define('TEXT_ASCENDINGLY', '升序');
  define('TEXT_BY', ' 用 ');

  define('TEXT_REVIEW_BY', '从 %s');
  define('TEXT_REVIEW_WORD_COUNT', '%s 单词');
  define('TEXT_REVIEW_RATING', '星级: %s [%s]');
  define('TEXT_REVIEW_DATE_ADDED', '增加日期: %s');
  define('TEXT_NO_REVIEWS', '当前没有商品评价.');

  define('TEXT_NO_NEW_PRODUCTS', '更多商品将很快添加,请稍候察看.');

  define('TEXT_UNKNOWN_TAX_RATE', 'Sales Tax');

  define('TEXT_REQUIRED', '<span class="errorText">Required</span>');

  define('WARNING_INSTALL_DIRECTORY_EXISTS', 'SECURITY WARNING: Installation directory exists at: %s. Please remove this directory for security reasons.');
  define('WARNING_CONFIG_FILE_WRITEABLE', 'Warning: I am able to write to the configuration file: %s. This is a potential security risk - please set the right user permissions on this file (read-only, CHMOD 644 or 444 are typical). You may need to use your webhost control panel/file-manager to change the permissions effectively. Contact your webhost for assistance. <a href="http://tutorials.zen-cart.com/index.php?article=90" target="_blank">See this FAQ</a>');
  define('ERROR_FILE_NOT_REMOVEABLE', 'Error: Could not remove the file specified. You may have to use FTP to remove the file, due to a server-permissions configuration limitation.');
  define('WARNING_SESSION_AUTO_START', 'Warning: session.auto_start is enabled - please disable this PHP feature in php.ini and restart the web server.');
  define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warning: The downloadable products directory does not exist: ' . DIR_FS_DOWNLOAD . '. Downloadable products will not work until this directory is valid.');
  define('WARNING_SQL_CACHE_DIRECTORY_NON_EXISTENT', 'Warning: The SQL cache directory does not exist: ' . DIR_FS_SQL_CACHE . '. SQL caching will not work until this directory is created.');
  define('WARNING_SQL_CACHE_DIRECTORY_NOT_WRITEABLE', 'Warning: I am not able to write to the SQL cache directory: ' . DIR_FS_SQL_CACHE . '. SQL caching will not work until the right user permissions are set.');
  define('WARNING_DATABASE_VERSION_OUT_OF_DATE', 'Your database appears to need patching to a higher level. See Admin->Tools->Server Information to review patch levels.');
  define('WARNING_COULD_NOT_LOCATE_LANG_FILE', 'WARNING: Could not locate language file: ');

  define('TEXT_CCVAL_ERROR_INVALID_DATE', 'The expiration date entered for the credit card is invalid. Please check the date and try again.');
  define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'The credit card number entered is invalid. Please check the number and try again.');
  define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'The credit card number starting with %s was not entered correctly, or we do not accept that kind of card. Please try again or use another credit card.');

  define('BOX_INFORMATION_DISCOUNT_COUPONS', '折扣');
  define('BOX_INFORMATION_GV', TEXT_GV_NAME . ' 常见问题');
  define('VOUCHER_BALANCE', TEXT_GV_NAME . ' 余额 ');
  define('BOX_HEADING_GIFT_VOUCHER', TEXT_GV_NAME . ' Account');
  define('GV_FAQ', TEXT_GV_NAME . ' FAQ');
  define('ERROR_REDEEMED_AMOUNT', 'Congratulations, you have redeemed ');
  define('ERROR_NO_REDEEM_CODE', 'You did not enter a ' . TEXT_GV_REDEEM . '.');
  define('ERROR_NO_INVALID_REDEEM_GV', 'Invalid ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM);
  define('TABLE_HEADING_CREDIT', 'Credits Available');
  define('GV_HAS_VOUCHERA', 'You have funds in your ' . TEXT_GV_NAME . ' Account. If you want <br />
                           you can send those funds by <a class="pageResults" href="');

  define('GV_HAS_VOUCHERB', '"><strong>email</strong></a> to someone');
  define('ENTRY_AMOUNT_CHECK_ERROR', 'You do not have enough funds to send this amount.');
  define('BOX_SEND_TO_FRIEND', 'Send ' . TEXT_GV_NAME . ' ');

  define('VOUCHER_REDEEMED',  TEXT_GV_NAME . ' Redeemed');
  define('CART_COUPON', 'Coupon :');
  define('CART_COUPON_INFO', '更多信息');
  define('TEXT_SEND_OR_SPEND','You have a balance available in your ' . TEXT_GV_NAME . ' account. You may spend it or send it to someone else. To send click the button below.');
  define('TEXT_BALANCE_IS', 'Your ' . TEXT_GV_NAME . ' balance is: ');
  define('TEXT_AVAILABLE_BALANCE', 'Your ' . TEXT_GV_NAME . ' Account');

// payment method is GV/Discount
  define('PAYMENT_METHOD_GV', 'Gift Certificate/Coupon');
  define('PAYMENT_MODULE_GV', 'GV/DC');

  define('TABLE_HEADING_CREDIT_PAYMENT', 'Credits Available');

  define('TEXT_INVALID_REDEEM_COUPON', '优惠券无效');
  define('TEXT_INVALID_REDEEM_COUPON_MINIMUM', '您的消费额不足 %s');
  define('TEXT_INVALID_STARTDATE_COUPON', '此优惠券还不能使用');
  define('TEXT_INVALID_FINISHDATE_COUPON', '此优惠券已到期');
  define('TEXT_INVALID_USES_COUPON', '此优惠券只能被使用一次 ');
  define('TIMES', ' 次数.');
  define('TIME', ' 次数.');
  define('TEXT_INVALID_USES_USER_COUPON', '您已使用此优惠码: 此优惠码最多能被使用 %s 次. ');
  define('REDEEMED_COUPON', '优惠券价值 ');
  define('REDEEMED_MIN_ORDER', '在订单超过 ');
  define('REDEEMED_RESTRICTIONS', ' [产品类别限制]');
  define('TEXT_ERROR', '错误发生');
  define('TEXT_INVALID_COUPON_PRODUCT', '此优惠码对您购物车里的商品不起作用');
  define('TEXT_VALID_COUPON', '恭喜，您已成功使用优惠券');
  define('TEXT_REMOVE_REDEEM_COUPON_ZONE', '此优惠码对于您所选择的地址无效.');

// more info in place of buy now
  define('MORE_INFO_TEXT','... 更多信息');

// IP Address
  define('TEXT_YOUR_IP_ADDRESS','Your IP Address is: ');

//Generic Address Heading
  define('HEADING_ADDRESS_INFORMATION','地址信息');

// cart contents
  define('PRODUCTS_ORDER_QTY_TEXT_IN_CART','购物车中的商品数量: ');
  define('PRODUCTS_ORDER_QTY_TEXT','数量: ');

// success messages for added to cart when display cart is off
// set to blank for no messages
// for all pages except where multiple add to cart is used:
  define('SUCCESS_ADDED_TO_CART_PRODUCT', '成功添加产品到购物车 ...');
// only for where multiple add to cart is used:
  define('SUCCESS_ADDED_TO_CART_PRODUCTS', '成功添加所选商品到购物车 ...');

  define('TEXT_PRODUCT_WEIGHT_UNIT','lbs');

// Shipping
  define('TEXT_SHIPPING_WEIGHT','lbs');
  define('TEXT_SHIPPING_BOXES', 'Boxes');

// Discount Savings
  define('PRODUCT_PRICE_DISCOUNT_PREFIX','节省:&nbsp;');
  define('PRODUCT_PRICE_DISCOUNT_PERCENTAGE','% 折扣');
  define('PRODUCT_PRICE_DISCOUNT_AMOUNT','&nbsp;折扣');

// Sale Maker Sale Price
  define('PRODUCT_PRICE_SALE','售价:&nbsp;');

//universal symbols
  define('TEXT_NUMBER_SYMBOL', '# ');

// banner_box
  define('BOX_HEADING_BANNER_BOX','赞助商');
  define('TEXT_BANNER_BOX','请访问我们的赞助商 ...');

// banner box 2
  define('BOX_HEADING_BANNER_BOX2','您能遇见的史上最惠 ...');
  define('TEXT_BANNER_BOX2','现在就去购买!');

// banner_box - all
  define('BOX_HEADING_BANNER_BOX_ALL','赞助商');
  define('TEXT_BANNER_BOX_ALL','请访问我们的赞助商 ...');

// boxes defines
  define('PULL_DOWN_ALL','请选择');
  define('PULL_DOWN_MANUFACTURERS','- Reset -');
// shipping estimator
  define('PULL_DOWN_SHIPPING_ESTIMATOR_SELECT', '请选择');

// general Sort By
  define('TEXT_INFO_SORT_BY','排序: ');

// close window image popups
  define('TEXT_CLOSE_WINDOW',' - 点击图片关闭');
// close popups
  define('TEXT_CURRENT_CLOSE_WINDOW','[ 关闭窗口 ]');

// iii 031104 added:  File upload error strings
  define('ERROR_FILETYPE_NOT_ALLOWED', 'Error:  File type not allowed.');
  define('WARNING_NO_FILE_UPLOADED', 'Warning:  no file uploaded.');
  define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Success:  file saved successfully.');
  define('ERROR_FILE_NOT_SAVED', 'Error:  File not saved.');
  define('ERROR_DESTINATION_NOT_WRITEABLE', 'Error:  destination not writeable.');
  define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Error: destination does not exist.');
  define('ERROR_FILE_TOO_BIG', 'Warning: File was too large to upload!<br />Order can be placed but please contact the site for help with upload');
// End iii added

  define('TEXT_BEFORE_DOWN_FOR_MAINTENANCE', 'NOTICE: This website is scheduled to be down for maintenance on: ');
  define('TEXT_ADMIN_DOWN_FOR_MAINTENANCE', 'NOTICE: The website is currently Down For Maintenance to the public');

  define('PRODUCTS_PRICE_IS_FREE_TEXT','It\'s Free!');
  define('PRODUCTS_PRICE_IS_CALL_FOR_PRICE_TEXT','Call for Price');
  define('TEXT_CALL_FOR_PRICE','Call for price');

  define('TEXT_INVALID_SELECTION',' You picked an Invalid Selection: ');
  define('TEXT_ERROR_OPTION_FOR',' On the Option for: ');
  define('TEXT_INVALID_USER_INPUT', 'User Input Required<br />');

// product_listing
  define('PRODUCTS_QUANTITY_MIN_TEXT_LISTING','最少: ');
  define('PRODUCTS_QUANTITY_UNIT_TEXT_LISTING','单位: ');
  define('PRODUCTS_QUANTITY_IN_CART_LISTING','在购物车中:');
  define('PRODUCTS_QUANTITY_ADD_ADDITIONAL_LISTING','额外增加:');

  define('PRODUCTS_QUANTITY_MAX_TEXT_LISTING','最大:');

  define('TEXT_PRODUCTS_MIX_OFF','*Mixed OFF');
  define('TEXT_PRODUCTS_MIX_ON','*Mixed ON');

  define('TEXT_PRODUCTS_MIX_OFF_SHOPPING_CART','<br />*You can not mix the options on this item to meet the minimum quantity requirement.*<br />');
  define('TEXT_PRODUCTS_MIX_ON_SHOPPING_CART','*Mixed Option Values is ON<br />');

  define('ERROR_MAXIMUM_QTY','The quantity added to your cart has been adjusted because of a restriction on maximum you are allowed. See this item:<br />');
  define('ERROR_CORRECTIONS_HEADING','Please correct the following: <br />');
  define('ERROR_QUANTITY_ADJUSTED', 'The quantity added to your cart has been adjusted. The item you wanted is not available in fractional quantities. The quantity of item:<br />');
  define('ERROR_QUANTITY_CHANGED_FROM', ', has been changed from: ');
  define('ERROR_QUANTITY_CHANGED_TO', ' to ');

// Downloads Controller
  define('DOWNLOADS_CONTROLLER_ON_HOLD_MSG','NOTE: Downloads are not available until payment has been confirmed');
  define('TEXT_FILESIZE_BYTES', ' bytes');
  define('TEXT_FILESIZE_MEGS', ' MB');

// shopping cart errors
  define('ERROR_PRODUCT','<br />以下商品: ');
  define('ERROR_PRODUCT_STATUS_SHOPPING_CART','<br />我们很抱歉该商品从我们的库存中移除<br />该商品已移出你的购物车.');
  define('ERROR_PRODUCT_ATTRIBUTES','<br />以下商品: ');
  define('ERROR_PRODUCT_STATUS_SHOPPING_CART_ATTRIBUTES','我们很抱歉该商品从我们的库存中移除<br />该商品已移出你的购物车.');
  define('ERROR_PRODUCT_QUANTITY_MIN',',  ... 最小数量错误 - ');
  define('ERROR_PRODUCT_QUANTITY_UNITS',' ... 数量单位错误 - ');
  define('ERROR_PRODUCT_OPTION_SELECTION','<br /> ... 无效的选项 ');
  define('ERROR_PRODUCT_QUANTITY_ORDERED','<br /> 你的订单总共: ');
  define('ERROR_PRODUCT_QUANTITY_MAX',' ... 最大数量错误 - ');
  define('ERROR_PRODUCT_QUANTITY_MIN_SHOPPING_CART',', 最小数量限制. ');
  define('ERROR_PRODUCT_QUANTITY_UNITS_SHOPPING_CART',' ... 数量单位错误 - ');
  define('ERROR_PRODUCT_QUANTITY_MAX_SHOPPING_CART',' ... 最大数量错误 - ');

  define('WARNING_SHOPPING_CART_COMBINED', '注意: 为了您的方便,您当前的购物车已和上次购物车中未结算的商品合并,请您察看购物车');

// error on checkout when $_SESSION['customers_id' does not exist in customers table
  define('ERROR_CUSTOMERS_ID_INVALID', '客户信息无效!<br />请登陆或者重新创建你的账户 ...');

  define('TABLE_HEADING_FEATURED_PRODUCTS','精选商品');

  define('TABLE_HEADING_NEW_PRODUCTS', '%s 新商品');
  define('TABLE_HEADING_UPCOMING_PRODUCTS', '新到商品');
  define('TABLE_HEADING_DATE_EXPECTED', '期望日期');
  define('TABLE_HEADING_SPECIALS_INDEX', '%s 特价');

  define('CAPTION_UPCOMING_PRODUCTS','商品将会很快到货');
  define('SUMMARY_TABLE_UPCOMING_PRODUCTS','table contains a list of products that are due to be in stock soon and the dates the items are expected');

// meta tags special defines
  define('META_TAG_PRODUCTS_PRICE_IS_FREE_TEXT','It\'s Free!');

// customer login
  define('TEXT_SHOWCASE_ONLY','联系我们');
// set for login for prices
  define('TEXT_LOGIN_FOR_PRICE_PRICE','Price Unavailable');
  define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE','Login for price');
// set for show room only
  define('TEXT_LOGIN_FOR_PRICE_PRICE_SHOWROOM', ''); // blank for prices or enter your own text
  define('TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM','Show Room Only');

// authorization pending
  define('TEXT_AUTHORIZATION_PENDING_PRICE', 'Price Unavailable');
  define('TEXT_AUTHORIZATION_PENDING_BUTTON_REPLACE', 'APPROVAL PENDING');
  define('TEXT_LOGIN_TO_SHOP_BUTTON_REPLACE','Login to Shop');

// text pricing
  define('TEXT_CHARGES_WORD','Calculated Charge:');
  define('TEXT_PER_WORD','<br />Price per word: ');
  define('TEXT_WORDS_FREE',' Word(s) free ');
  define('TEXT_CHARGES_LETTERS','Calculated Charge:');
  define('TEXT_PER_LETTER','<br />Price per letter: ');
  define('TEXT_LETTERS_FREE',' Letter(s) free ');
  define('TEXT_ONETIME_CHARGES','*onetime charges = ');
  define('TEXT_ONETIME_CHARGES_EMAIL',"\t" . '*onetime charges = ');
  define('TEXT_ATTRIBUTES_QTY_PRICES_HELP', 'Option Quantity Discounts');
  define('TABLE_ATTRIBUTES_QTY_PRICE_QTY','QTY');
  define('TABLE_ATTRIBUTES_QTY_PRICE_PRICE','PRICE');
  define('TEXT_ATTRIBUTES_QTY_PRICES_ONETIME_HELP', 'Option Quantity Discounts Onetime Charges');

// textarea attribute input fields
  define('TEXT_MAXIMUM_CHARACTERS_ALLOWED',' 最大允许字符数');
  define('TEXT_REMAINING','剩下');

// Shipping Estimator
  define('CART_SHIPPING_OPTIONS', '估计运费');
  define('CART_SHIPPING_OPTIONS_LOGIN', '请 <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">登陆</span></a>, 显示你的运费.');
  define('CART_SHIPPING_METHOD_TEXT', '可行的配送模式');
  define('CART_SHIPPING_METHOD_RATES', '星级');
  define('CART_SHIPPING_METHOD_TO','配送到: ');
  define('CART_SHIPPING_METHOD_TO_NOLOGIN', '请登陆: <a href="' . zen_href_link(FILENAME_LOGIN, '', 'SSL') . '"><span class="pseudolink">登陆</span></a>');
  define('CART_SHIPPING_METHOD_FREE_TEXT','面运费');
  define('CART_SHIPPING_METHOD_ALL_DOWNLOADS','- Downloads');
  define('CART_SHIPPING_METHOD_RECALCULATE','Recalculate');
  define('CART_SHIPPING_METHOD_ZIP_REQUIRED','true');
  define('CART_SHIPPING_METHOD_ADDRESS','Address:');
  define('CART_OT','Total Cost Estimate:');
  define('CART_OT_SHOW','true'); // set to false if you don't want order totals
  define('CART_ITEMS','Items in Cart: ');
  define('CART_SELECT','Select');
  define('ERROR_CART_UPDATE', '<strong>请更新你的订单.</strong> ');
  define('IMAGE_BUTTON_UPDATE_CART', 'Update');
  define('EMPTY_CART_TEXT_NO_QUOTE', 'Whoops! Your session has expired ... Please update your shopping cart for Shipping Quote ...');
  define('CART_SHIPPING_QUOTE_CRITERIA', 'Shipping quotes are based on the address information you selected:');

// multiple product add to cart
  define('TEXT_PRODUCT_LISTING_MULTIPLE_ADD_TO_CART', 'Add: ');
  define('TEXT_PRODUCT_ALL_LISTING_MULTIPLE_ADD_TO_CART', 'Add: ');
  define('TEXT_PRODUCT_FEATURED_LISTING_MULTIPLE_ADD_TO_CART', 'Add: ');
  define('TEXT_PRODUCT_NEW_LISTING_MULTIPLE_ADD_TO_CART', 'Add: ');
  //moved SUBMIT_BUTTON_ADD_PRODUCTS_TO_CART to button_names.php as BUTTON_ADD_PRODUCTS_TO_CART_ALT

// discount qty table
  define('TEXT_HEADER_DISCOUNT_PRICES_PERCENTAGE', 'Qty Discounts Off Price');
  define('TEXT_HEADER_DISCOUNT_PRICES_ACTUAL_PRICE', 'Qty Discounts New Price');
  define('TEXT_HEADER_DISCOUNT_PRICES_AMOUNT_OFF', 'Qty Discounts Off Price');
  define('TEXT_FOOTER_DISCOUNT_QUANTITIES', '* Discounts may vary based on options above');
  define('TEXT_HEADER_DISCOUNTS_OFF', 'Qty Discounts Unavailable ...');

// sort order titles for dropdowns
  define('PULL_DOWN_ALL_RESET','- RESET - ');
  define('TEXT_INFO_SORT_BY_PRODUCTS_NAME', '商品名');
  define('TEXT_INFO_SORT_BY_PRODUCTS_NAME_DESC', '商品名 - 降序');
  define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE', '价格 - 从低到高');
  define('TEXT_INFO_SORT_BY_PRODUCTS_PRICE_DESC', '价格 - 从高到低');
  define('TEXT_INFO_SORT_BY_PRODUCTS_MODEL', '型号');
  define('TEXT_INFO_SORT_BY_PRODUCTS_DATE_DESC', '添加日期 - 从新到旧');
  define('TEXT_INFO_SORT_BY_PRODUCTS_DATE', '添加日期 - 从旧到新');
  define('TEXT_INFO_SORT_BY_PRODUCTS_SORT_ORDER', '默认显示');

// downloads module defines
  define('TABLE_HEADING_DOWNLOAD_DATE', 'Link Expires');
  define('TABLE_HEADING_DOWNLOAD_COUNT', 'Remaining');
  define('HEADING_DOWNLOAD', 'To download your files click the download button and choose "Save to Disk" from the popup menu.');
  define('TABLE_HEADING_DOWNLOAD_FILENAME','Filename');
  define('TABLE_HEADING_PRODUCT_NAME','Item Name');
  define('TABLE_HEADING_BYTE_SIZE','File Size');
  define('TEXT_DOWNLOADS_UNLIMITED', 'Unlimited');
  define('TEXT_DOWNLOADS_UNLIMITED_COUNT', '--- *** ---');

// misc
  define('COLON_SPACER', ':&nbsp;&nbsp;');

// table headings for cart display and upcoming products
  define('TABLE_HEADING_QUANTITY', '数量.');
  define('TABLE_HEADING_PRODUCTS', '商品名');
  define('TABLE_HEADING_TOTAL', '总共');

// create account - login shared
  define('TABLE_HEADING_PRIVACY_CONDITIONS', '隐私声明');
  define('TEXT_PRIVACY_CONDITIONS_DESCRIPTION', '请确认你已阅读隐私条款. <a href="' . zen_href_link(FILENAME_PRIVACY, '', 'SSL') . '"><span class="pseudolink">隐私条款</span></a>.');
  define('TEXT_PRIVACY_CONDITIONS_CONFIRM', '我已阅读并且同意隐私条款.');
  define('TABLE_HEADING_ADDRESS_DETAILS', '地址信息');
  define('TABLE_HEADING_PHONE_FAX_DETAILS', '其他联系信息');
  define('TABLE_HEADING_DATE_OF_BIRTH', 'Verify Your Age');
  define('TABLE_HEADING_LOGIN_DETAILS', '登陆信息');
  define('TABLE_HEADING_REFERRAL_DETAILS', 'Were You Referred to Us?');

  define('ENTRY_EMAIL_PREFERENCE','Newsletter and Email Details');
  define('ENTRY_EMAIL_HTML_DISPLAY','HTML');
  define('ENTRY_EMAIL_TEXT_DISPLAY','TEXT-Only');
  define('EMAIL_SEND_FAILED','ERROR: Failed sending email to: "%s" <%s> with subject: "%s"');

  define('DB_ERROR_NOT_CONNECTED', 'Error - Could not connect to Database');

  // EZ-PAGES Alerts
  define('TEXT_EZPAGES_STATUS_HEADER_ADMIN', 'WARNING: EZ-PAGES HEADER - On for Admin IP Only');
  define('TEXT_EZPAGES_STATUS_FOOTER_ADMIN', 'WARNING: EZ-PAGES FOOTER - On for Admin IP Only');
  define('TEXT_EZPAGES_STATUS_SIDEBOX_ADMIN', 'WARNING: EZ-PAGES SIDEBOX - On for Admin IP Only');

// extra product listing sorter
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER', '');
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES', 'Items starting with ...');
  define('TEXT_PRODUCTS_LISTING_ALPHA_SORTER_NAMES_RESET', '-- Reset --');

///////////////////////////////////////////////////////////
// include email extras
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_EMAIL_EXTRAS)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_EMAIL_EXTRAS);

// include template specific header defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_HEADER)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_HEADER);

// include template specific button name defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_BUTTON_NAMES)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_BUTTON_NAMES);

// include template specific icon name defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_ICON_NAMES)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_ICON_NAMES);

// include template specific other image name defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_OTHER_IMAGES_NAMES)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_OTHER_IMAGES_NAMES);

// credit cards
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_CREDIT_CARDS)) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select. FILENAME_CREDIT_CARDS);

// include template specific whos_online sidebox defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/' . FILENAME_WHOS_ONLINE . '.php')) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . FILENAME_WHOS_ONLINE . '.php');

// include template specific meta tags defines
  if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/meta_tags.php')) {
    $template_dir_select = $template_dir . '/';
  } else {
    $template_dir_select = '';
  }
  require_once(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir_select . 'meta_tags.php');

// END OF EXTERNAL LANGUAGE LINKS
