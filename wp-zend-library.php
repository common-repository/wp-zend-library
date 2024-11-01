<?php
/*
Plugin Name: WP Zend Library
Description: Integration of Zend Framework into Wordpress - this plugin makes the Zend Framework library available to Wordpress themes and plugins.
Author: Wild Mice Media
Version: 1.0

Copyright 2011  Wild Mice Media

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

//////////////////////////////////////////////////////////////////////

class WP_Zend_Library {

  public function using_database() {
    $opt = parse_ini_file(realpath(__DIR__.'/config/config.ini.php'), true);
    if($opt['main']['db.adapter'] &&
      $opt['main']['db.params.host'] &&
      $opt['main']['db.params.username'] &&
      $opt['main']['db.params.password'] &&
      $opt['main']['db.params.dbname']
    ) {
      define('WP_ZEND_LIBRARY_DB',TRUE);
      return TRUE;
    }
    else return FALSE;
  }
}

$wp_zend_library = new WP_Zend_Library;


//////////////////////////////////////////////////////////////////////

// This section emulates the Zend Framework bootstrap file, without any application environment

try {

  // Add /library directory to our include path
  set_include_path(implode(PATH_SEPARATOR, array(get_include_path(),realpath(__DIR__.'/library'))));

  // Turn on autoloading, so we do not include each Zend Framework class
  require_once realpath(__DIR__.'/library/Zend/Loader/Autoloader.php');
  $autoloader = Zend_Loader_Autoloader::getInstance();

  // Create registry object and setting it as the static instance in the Zend_Registry class
  $registry = new Zend_Registry();
  Zend_Registry::setInstance($registry);

  // Load configuration file and store the data in the registry
  $configuration = new Zend_Config_Ini(__DIR__.'/config/config.ini.php', 'main');
  Zend_Registry::set('configuration', $configuration);

  if($wp_zend_library->using_database()) {
    // Construct the database adapter class, connect to the database and store the db object in the registry
    $db = Zend_Db::factory($configuration->db);
    $db->query("SET NAMES 'utf8'");
    Zend_Registry::set('db', $db);
    // set this adapter as default for use with Zend_Db_Table
    Zend_Db_Table_Abstract::setDefaultAdapter($db);
  }

  /*
   * We want to set the encoding to UTF-8, so we won't rely on the ViewRenderer action helper by default,
   * but will construct view object and deliver it to the ViewRenderer after setting some options.
   */
  $view = new Zend_View(array('encoding'=>'UTF-8'));
  $viewRendered = new Zend_Controller_Action_Helper_ViewRenderer($view);
  Zend_Controller_Action_HelperBroker::addHelper($viewRendered);

  // if everything went well, set a status flag
  define('WP_ZEND_LIBRARY',TRUE);

} catch (Exception $e) {
  // try/catch works best in object mode (which we cannot use here), so not all errors will be caught
  echo '<span style="font-weight:bold;">WP Zend Library:</span> '.nl2br($e);
}

?>