<?php
/**
 * html_output.php
 * HTML-generating functions used throughout the core
 *
 * @package functions
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: html_output.php 19355 2011-08-21 21:12:09Z drbyte $
 */

/*
 *  Output a form
 */
  function alipay_draw_form($name, $action, $method = 'post', $parameters = '',$securityToken=true) {
    $form = '<form name="' . zen_output_string($name) . '" action="' . zen_output_string($action) . '" method="' . zen_output_string($method) . '"';

    if (zen_not_null($parameters)) $form .= ' ' . $parameters;

    $form .= '>';
    if (strtolower($method) == 'post' && $securityToken) 
	{
		$form .= '<input type="hidden" name="securityToken" value="' . $_SESSION['securityToken'] . '" />';
	}
    return $form;
  }
?>