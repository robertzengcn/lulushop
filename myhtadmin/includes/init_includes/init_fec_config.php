<?php
if (!defined('IS_ADMIN_FLAG'))
  {
    die('Illegal Access');
  }
// add upgrade script
$fec_version     = (defined('FAST_AND_EASY_CHECKOUT_VERSION') ? FAST_AND_EASY_CHECKOUT_VERSION : 'new');
$current_version = '1.14.6'; // change this each time a new version is ready to release
while ($fec_version != $current_version)
  {
    switch ($fec_version)
    {
        // add case for each previous version
        case 'new':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/new.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/new.php');
                $fec_version = '1.12.0';
                break;
              }
            else
              {
                break 2;
              }
        case '1.11.2':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_12_0.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_12_0.php');
                $fec_version = '1.12.0';
                break;
              }
            else
              {
                break 2;
              }
        case '1.12.0':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_12_1.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_12_1.php');
                $fec_version = '1.12.1';
                break;
              }
            else
              {
                break 2;
              }
        case '1.12.1':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_12_2.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_12_2.php');
                $fec_version = '1.12.2';
                break;
              }
            else
              {
                break 2;
              }
        case '1.12.2':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_12_3.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_12_3.php');
                $fec_version = '1.12.3';
                break;
              }
            else
              {
                break 2;
              }
        case '1.12.3':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_13_0.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_13_0.php');
                $fec_version = '1.13.0';
                break;
              }
            else
              {
                break 2;
              }
        case '1.13.0':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_13_1.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_13_1.php');
                $fec_version = '1.13.1';
                break;
              }
            else
              {
                break 2;
              }
        case '1.13.1':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_13_2.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_13_2.php');
                $fec_version = '1.13.2';
                break;
              }
            else
              {
                break 2;
              }
        case '1.13.2':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_14_0.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_14_0.php');
                $fec_version = '1.14.0';
                break;
              }
            else
              {
                break 2;
              }
        case '1.14.0':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_14_1.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_14_1.php');
                $fec_version = '1.14.1';
                break;
              }
            else
              {
                break 2;
              }
        case '1.14.1':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_14_2.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_14_2.php');
                $fec_version = '1.14.2';
                break;
              }
            else
              {
                break 2;
              }
        case '1.14.2':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_14_3.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_14_3.php');
                $fec_version = '1.14.3';
                break;
              }
            else
              {
                break 2;
              }
        case '1.14.3':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_14_4.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_14_4.php');
                $fec_version = '1.14.4';
                break;
              }
            else
              {
                break 2;
              }
        case '1.14.4':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_14_5.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_14_5.php');
                $fec_version = '1.14.5';
                break;
              }
            else
              {
                break 2;
              }
        case '1.14.5':
            // perform upgrade
            if (file_exists(DIR_WS_INCLUDES . 'installers/fec/1_14_6.php'))
              {
                include_once(DIR_WS_INCLUDES . 'installers/fec/1_14_6.php');
                $fec_version = '1.14.6';
                break;
              }
            else
              {
                break 2;
              }                                           
        default:
            $fec_version = $current_version;
            // break all the loops
            break 2;
    }
  }