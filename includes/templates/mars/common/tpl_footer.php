<?php
/**
 * Common Template - tpl_footer.php
 *
 * this file can be copied to /templates/your_template_dir/pagename<br />
 * example: to override the privacy page<br />
 * make a directory /templates/my_template/privacy<br />
 * copy /templates/templates_defaults/common/tpl_footer.php to /templates/my_template/privacy/tpl_footer.php<br />
 * to override the global settings and turn off the footer un-comment the following line:<br />
 * <br />
 * $flag_disable_footer = true;<br />
 *
 * @package templateSystem
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_footer.php 15511 2010-02-18 07:19:44Z drbyte $
 */
require(DIR_WS_MODULES . zen_get_module_directory('footer.php'));
?>

<?php
if (!isset($flag_disable_footer) || !$flag_disable_footer) {
?>

<!--bof-banner #5 display -->
<?php
  if (SHOW_BANNERS_GROUP_SET5 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET5)) {
    if ($banner->RecordCount() > 0) {
?>
<div id="bannerFive" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
<?php
    }
  }
?>
<!--eof-banner #5 display -->
<?php
  if($general_options->fields['smallinfo'] == 1){ 
		require($template->get_template_dir('/tpl_footer_info_small.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_footer_info_small.php'); 
	} 
	if($general_options->fields['biginfo'] == 1){ 
		require($template->get_template_dir('/tpl_footer_info_big.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_footer_info_big.php');
 	} 
 	if($general_options->fields['smallinfo'] == 2){ 
		require($template->get_template_dir('/tpl_footer_info_small.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_footer_info_small.php'); 
	} 
?>

<div class="container group">
	

	<!--bof-navigation display -->
<div class="container">	
	<nav class="nav">
    <ul>	
		<?php if (EZPAGES_STATUS_FOOTER == '1' or (EZPAGES_STATUS_FOOTER == '2' and (strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])))) { 
						require($template->get_template_dir('tpl_ezpages_bar_footer.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_ezpages_bar_footer.php'); 
		} ?>
	</ul>
	</nav>
</div>
	
	<!--eof-navigation display -->
	

	<!--bof- site copyright display -->
	<div id="siteinfoLegal" class="legalCopyright"><?php echo FOOTER_TEXT_BODY; ?>
	<script language="javascript" type="text/javascript" src="http://js.users.51.la/16890208.js"></script>
<noscript><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/16890208.asp" style="border:none" /></noscript>
	</div>
	<!--eof- site copyright display -->

	<!--bof-ip address display -->
	<?php
	if (SHOW_FOOTER_IP == '1') {
		?>
			<div id="siteinfoIP"><?php echo TEXT_YOUR_IP_ADDRESS . '  <strong>' . $_SERVER['REMOTE_ADDR'].' </strong>'; ?></div>
		<?php
		}
	?>
	<!--eof-ip address display -->	

	
		
</div>
<?php
} // flag_disable_footer
?>