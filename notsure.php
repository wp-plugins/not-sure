<?php
/* Plugin Name: Not Sure
Plugin URI: http://www.softpill.eu/
Description: Plugin to ask customers why are they unsure of purchasing, add buttons in posts with shortcodes
Version: 1.0
Author: Softpill.eu
Author URI: http://www.softpill.eu/
License: GPLv2 or later

Copyright 2015  Softpill.eu  (email : mail@softpill.eu)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define("SP_NS_DIR", WP_PLUGIN_DIR."/".basename( dirname( __FILE__ ) ) );
define("SP_NS_URL", plugins_url()."/".basename( dirname( __FILE__ ) ) );
if(is_admin()){
function sp_ns_activation() {
  global $wpdb;
  $table_name = $wpdb->prefix . "notsure";
  $sql="CREATE TABLE IF NOT EXISTS `$table_name` (
  `id`  int NULL AUTO_INCREMENT ,
  `title`  varchar(255) NULL ,
  `btn_text`  varchar(255) NULL ,
  `popup_description`  varchar(255) NULL ,
  `show_msg`  tinyint NULL DEFAULT 1 ,
  `msg_label`  varchar(255) NULL ,
  `show_email`  tinyint NULL DEFAULT 1 ,
  `email_label`  varchar(255) NULL ,
  `send_btn_text`  varchar(255) NULL ,
  `question1`  varchar(255) NULL ,
  `question2`  varchar(255) NULL ,
  `question3`  varchar(255) NULL ,
  `question4`  varchar(255) NULL ,
  `question5`  varchar(255) NULL ,
  `other_questions`  text NULL ,
  `send_to_admin`  tinyint NULL DEFAULT 1 ,
  `send_to`  varchar(255) NULL ,
  `mdate`  int NULL  ,
  PRIMARY KEY (`id`)
  )";
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
}
register_activation_hook(__FILE__, 'sp_ns_activation');
function sp_ns_deactivation() {
}
register_deactivation_hook(__FILE__, 'sp_ns_deactivation');

require_once(SP_NS_DIR.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."notsure_admin.php");
require_once(SP_NS_DIR.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."notsure_forms.php");
require_once(SP_NS_DIR.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."notsure_about.php");
require_once(SP_NS_DIR.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."notsure.records.php");
}
else{
//front-end
require_once(SP_NS_DIR.DIRECTORY_SEPARATOR."includes".DIRECTORY_SEPARATOR."notsure_frontend.php");
}


?>