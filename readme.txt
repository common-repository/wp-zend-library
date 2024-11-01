=== WP Zend Library ===

Contributors: wildmice
Tags: web application framework, model-view-controller, MVC framework, MVC, framework, Zend Framework, Zend, theme development, plugin development
Requires at least: 3.2
Tested up to: 3.2.1
Stable tag: 1.0

Easy integration of Zend Framework library into Wordpress, making it available for themes and other plugins.

== Description ==

Use this plugin to integrate the Zend Framework library into Wordpress, making it available for both themes and 
other plugins. It does not include the ZendX extra library.

This plugin emulates the Zend Framework bootstrap file, without any application environment (because Wordpress does that), 
and includes a configuration file for setting database connection parameters.

Zend Framework is an open source, object-oriented web application framework implemented in PHP 5 and licensed under the 
New BSD License. It implements a popular application design pattern called model-view-controller (MVC). In this case, 
Wordpress becomes the 'view' instead of a Zend Framework application.

This plugin will probably work with versions of Wordpress earlier than 3.2, but if you are running such an earlier 
version check your version of PHP. Zend Framework requires PHP 5.2.4 or later.

Note: This is the first version of this plugin and it has not had extensive testing. Consider it experimental and use at 
your own risk.

== Installation ==

Requires PHP 5.2.4 or later. 

This plugin requires manual configuration. Do not use the plugin installer.

1. Download the plugin, and extract the files.
1. Download the Zend Framework Minimal from http://framework.zend.com/download/current/ and 
unpack the files.
1. Copy the contents of the folder library/Zend from the Zend Framework into the plugin's library/Zend folder.
1. Edit the plugin's configuration file, then upload the plugin to your plugins folder.
1. Activate the plugin through the Plugins menu in WordPress.

== Changelog ==

= 1.0 =
* This is the first version. Consider it a beta release, as it has not had much testing.

== Usage ==

You can use the Zend Framework in both themes and other plugins. 
Here are some simple examples of its use in a theme context.

Simple Example 1 - Database Query:

`<?php
  if(defined('WP_ZEND_LIBRARY')) {

    // display Zend version number
    echo Zend_Version::getLatest();

    if(defined('WP_ZEND_LIBRARY_DB')) {

      // list Wordpress usernames
      $results = $db->query('SELECT * FROM wp_users');
      while ($row = $results->fetch()) {
        echo '<p>'.$row['user_login'].'</p>';
      }

    }

  }
?>`

Simple Example 2 - Pagination:

`<?php
  if(defined('WP_ZEND_LIBRARY')) {

    // Create an array with numbers 1 to 100
    $data = range(1, 100);

    // Get a Paginator object using Zend_Paginator's built-in factory.
    $paginator = Zend_Paginator::factory($data);

    // Select the second page
    $paginator->setCurrentPageNumber(2);

    echo '<ul>';

    // Render each item for the current page in a list-item
    foreach ($paginator as $item) {
        echo '<li>' . $item . '</li>';
    }

    echo '</ul>';

  }
?>`

== Frequently Asked Questions ==

= Where can I find documentation on the Zend Framework? =

The online manual is at [Zend Framework Programmer's Reference Guide](http://framework.zend.com/manual/manual)

= Does this plugin include the ZendX library? =

No. However, if you are looking for jQuery and/or jQuery UI, these are both natively supported by Wordpress 
and many examples of usage are available through a large user community.
