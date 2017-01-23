<?php
/**
 * @package admin
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: reviews.php 19330 2011-08-07 06:32:56Z drbyte $
 */

  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $status_filter = (isset($_GET['status']) ? $_GET['status'] : '');
  $status_list[] = array('id' => 1, 'text' => TEXT_PENDING_APPROVAL);
  $status_list[] = array('id' => 2, 'text' => TEXT_APPROVED);

  if (zen_not_null($action)) {
    switch ($action) {
      case 'setflag':
        if (isset($_POST['flag']) && ($_POST['flag'] == 1 || $_POST['flag'] == 0))
        {
          zen_set_reviews_status($_GET['rID'], $_POST['flag']);
        }
        zen_redirect(zen_href_link(FILENAME_REVIEWS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . (isset($_GET['status']) ? 'status=' . $_GET['status'] . '&' : '') . 'rID=' . $_GET['rID'], 'NONSSL'));
        break;
      case 'update':
        $reviews_id = zen_db_prepare_input($_GET['rID']);
        $reviews_rating = zen_db_prepare_input($_POST['reviews_rating']);
        $reviews_text = zen_db_prepare_input($_POST['reviews_text']);

        $db->Execute("update " . TABLE_REVIEWS . "
                      set reviews_rating = '" . zen_db_input($reviews_rating) . "',
                      last_modified = now() where reviews_id = '" . (int)$reviews_id . "'");

        $db->Execute("update " . TABLE_REVIEWS_DESCRIPTION . "
                      set reviews_text = '" . zen_db_input($reviews_text) . "'
                      where reviews_id = '" . (int)$reviews_id . "'");

        zen_redirect(zen_href_link(FILENAME_REVIEWS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . (isset($_GET['status']) ? 'status=' . $_GET['status'] . '&' : '') . 'rID=' . $_GET['rID']));
        break;
      case 'deleteconfirm':
        // demo active test
        if (zen_admin_demo()) {
          $_GET['action']= '';
          $messageStack->add_session(ERROR_ADMIN_DEMO, 'caution');
          zen_redirect(zen_href_link(FILENAME_REVIEWS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . (isset($_GET['status']) ? 'status=' . $_GET['status'] : '')));
        }
        $reviews_id = zen_db_prepare_input($_POST['rID']);

        $db->Execute("delete from " . TABLE_REVIEWS . "
                      where reviews_id = '" . (int)$reviews_id . "'");

        $db->Execute("delete from " . TABLE_REVIEWS_DESCRIPTION . "
                      where reviews_id = '" . (int)$reviews_id . "'");


        zen_redirect(zen_href_link(FILENAME_REVIEWS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . (isset($_GET['status']) ? 'status=' . $_GET['status'] : '')));
        break;
    }
  }
?>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
