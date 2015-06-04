<?php
/*
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
function sp_ns_admin_icon()
{
	echo '
		<style> 
      #toplevel_page_sp_ns_forms div.wp-menu-image:before { content: "\f328"; }
		</style>
	';
  //get other icons from http://melchoyce.github.io/dashicons/
}
add_action( 'admin_head', 'sp_ns_admin_icon' );
add_action('admin_menu', 'sp_ns_menus');

function sp_ns_menus() {
    add_menu_page('Not Sure', 'Not Sure Buttons', 'administrator', 'sp_ns_forms', 'sp_ns_forms',"","26.1345623");
    add_submenu_page('sp_ns_forms', 'About', 'About', 'administrator', 'sp_ns_about', 'sp_ns_about');
}
?>