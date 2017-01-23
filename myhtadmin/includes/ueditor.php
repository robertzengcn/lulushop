<?php
/**
 * @package admin
 * @copyright Copyright 2010 Kuroi Web Design
 * @copyright Portions Copyright 2009 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: ckeditor.php 277 2010-05-22 14:09:32Z kuroi $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

$var = zen_get_languages();
$jsLanguageLookupArray = "var lang = new Array;\n";
foreach ($var as $key)
{
  $jsLanguageLookupArray .= "  lang[" . $key['id'] . "] = '" . $key['code'] . "';\n";
}
?>

<script type="text/javascript" charset="utf-8" src="../<?php echo DIR_WS_EDITORS ?>ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="../<?php echo DIR_WS_EDITORS ?>ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="../<?php echo DIR_WS_EDITORS ?>ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">

var ue = UE.getEditor('products_description[2]');
</script>
