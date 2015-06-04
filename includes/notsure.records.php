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
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class SP_NS_List_Table extends WP_List_Table {
	function get_columns(){
  $columns = array(
    'id' => 'ID',
    'title' => 'Title',
    'shortcode'      => 'Shortcode',
    'mdate'      => 'Edit Date'
  );
  return $columns;
}

function prepare_items() {
  global $wpdb;
  $per_page=10;
  $columns = $this->get_columns();
  $hidden = array();
  $sortable = array();
  $this->_column_headers = array($columns, $hidden, $sortable);
  $sql="
  select * from ".$wpdb->prefix."notsure
  where 1=1
  order by mdate desc
  ";
  $data=array();
  $results=$wpdb->get_results($sql);
  if(count($results)>0)
  {
    foreach($results as $r)
    {
      $data[]=array(
      'id'=>$r->id,
      'title'=>$r->title,
      'shortcode'=>"[sp_ns_display_button id=".$r->id."]",
      'mdate'=>date("d/m/y H:i",$r->mdate)
      );
    }
  }
  $current_page = $this->get_pagenum();
       
  $total_items = count($data);
  
  $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
  
  $this->items = $data;
  
  $this->set_pagination_args( array(
      'total_items' => $total_items,                  
      'per_page'    => $per_page,                     
      'total_pages' => ceil($total_items/$per_page)   
  ) );
}
function column_default( $item, $column_name ) {
  switch( $column_name ) {
    case 'id':
    case 'title':
    case 'shortcode':
    case 'mdate':
      return $item[ $column_name ];
    default:
      return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
  }
}
function column_title($item) {
  $actions = array(
            'edit'      => sprintf('<a href="javascript:void(0);" onClick="jQuery(\'#button_id\').val(\''.$item['id'].'\');document.edit_button.submit();">Edit</a>'),
            'delete'    => sprintf('<a href="javascript:void(0);" onClick="if(confirm(\'Are you sure you want to delete the button?\')){jQuery(\'#delbutton_id\').val(\''.$item['id'].'\');document.delete_button.submit();}">Delete</a>'),
        );

  return sprintf('%1$s %2$s', $item['title'], $this->row_actions($actions) );
}
}

?>