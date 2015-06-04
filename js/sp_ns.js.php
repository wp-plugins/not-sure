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

header("Content-type: text/javascript");

?>


function setSPNSPpopup(id)
{
	jQuery('#sp_ns_popup'+id).click(function(e) {
		e.preventDefault();
		
		var id1 = jQuery(this).attr('href');
		var maskHeight = jQuery(document).height();
		var maskWidth = jQuery(window).width();
		jQuery('#sp_ns_mask'+id).css({'width':maskWidth,'height':maskHeight});
		jQuery('#sp_ns_mask'+id).fadeTo("fast",0.7);	
		var winH = jQuery(window).height();
		var winW = jQuery(window).width();
		jQuery(id1).css('top',  winH/2-jQuery(id1).height()/2);
		jQuery(id1).css('left', winW/2-jQuery(id1).width()/2);
		jQuery(id1).fadeIn(400);
	
	});
  
	jQuery('.sp_ns_window'+id+' .sp_ns_close'+id).click(function (e) {
		e.preventDefault();
		jQuery('#sp_ns_mask'+id).fadeOut('fast');
		jQuery('.sp_ns_window'+id).hide();
	});		
	
	jQuery(document).keyup(function(e) {
    	if (e.keyCode == 27) { jQuery('.sp_ns_window'+id+' .sp_ns_close'+id).click(); }
  });
  jQuery('#sp_ns_mask'+id).click(function(e) {
    jQuery('.sp_ns_window'+id+' .sp_ns_close'+id).click();
  });
  jQuery("#sp_ns_popup"+id).bind('click',function()
  {
  	return false;
  });
}
function openSPNSPpopup(id)
{
  jQuery("#sp_ns_popup"+id).click();
}