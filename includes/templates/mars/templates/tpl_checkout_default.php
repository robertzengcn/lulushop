<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2007-2008 Numinix Technology http://www.numinix.com    |
// |                                                                      |
// | Portions Copyright (c) 2003-2006 Zen Cart Development Team           |
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
//  $Id: tpl_checkout_default.php 105 2010-02-09 04:45:40Z numinix $
//
?>
<?php echo $payment_modules->javascript_validation(); ?>


<?php  echo $_SESSION['new_billing_address'];?>
<?php echo zen_draw_form('checkout_payment', $form_action_url, 'post', 'id="checkout_payment"'); ?>

<?php if ($messageStack->size('redemptions') > 0) echo $messageStack->output('redemptions'); ?>
<?php if ($messageStack->size('checkout_shipping') > 0) echo $messageStack->output('checkout_shipping'); ?>
<?php if ($messageStack->size('checkout_payment') > 0) echo $messageStack->output('checkout_payment'); ?>

<span id="checkoutOrderHeading" class="fec-page-step">
	<?php echo HEADING_TITLE_ORDER_TOTAL; ?>
</span>

<?php include(DIR_WS_TEMPLATE . 'templates/tpl_checkout_stacked.php'); ?>
				
<?php if ($order->content_type != 'virtual') {
	$title_checkout = TITLE_CONTINUE_CHECKOUT_PROCEDURE;
} else {
	$title_checkout = TITLE_CONTINUE_CHECKOUT_PROCEDURE_VIRTUAL;
}
?>

</form>

