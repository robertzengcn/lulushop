1 	<?php
2 	  require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));
3 	  $define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_HOMEINTRO, 'false');
4 	  $breadcrumb->add(NAVBAR_TITLE);
5 	?>