<?php
if ($this_is_home_page) {
?>
 <?php
    if (RAP_SLIDES_STATUS == 'true') {
?>
      <?php require($template->get_template_dir('tpl_home_slider.php',DIR_WS_TEMPLATE, $current_page_base,'common')
		    . '/tpl_home_slider.php');?>
<?php
    } ?>
<?php
    } ?>

<div id="home-text">
<p>
艾美嘉情趣商城是经营充气娃娃，实体娃娃，硅胶娃娃等的零售、批发、代理、代发货等多样化的服务的成人用品销售平台。艾美嘉致力于以最低的价格为顾客提供最好的充气娃娃，实体娃娃。</p>
</div>		