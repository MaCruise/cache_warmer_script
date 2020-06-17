<?php

defined('DS') ? null:define('DS',DIRECTORY_SEPARATOR);
define('SITE_ROOT', DS.'wamp64'.DS.'www'.DS.'Cache_Warmer_script');
defined('APP_PATH') ? null:define('APP_PATH',SITE_ROOT.DS.'app');
defined('DATABASE_PATH') ? null:define('DATABASE_PATH',SITE_ROOT.DS.'database');
defined('CONTROLLER_PATH') ? null:define('CONTROLLER_PATH',SITE_ROOT.DS.'controller');
ob_start();

require_once(APP_PATH.DS.'functions.php');
require_once(APP_PATH.DS.'Session.php');
require_once(DATABASE_PATH.DS.'Database.php');


require_once(DATABASE_PATH.DS.'config.php');
require_once(APP_PATH.DS.'Table.php');
require_once(APP_PATH.DS.'Queries.php');
require_once(APP_PATH.DS.'Dbobject.php');
require_once(APP_PATH.DS.'User.php');
require_once(APP_PATH.DS.'Website.php');
require_once(APP_PATH.DS.'Framework.php');
require_once(APP_PATH.DS.'Sitemap.php');
require_once(APP_PATH.DS.'ErrorMessage.php');
require_once(CONTROLLER_PATH.DS.'FrameworksController.php');
require_once(CONTROLLER_PATH.DS.'UsersController.php');
require_once(CONTROLLER_PATH.DS.'WebsitesController.php');





?>