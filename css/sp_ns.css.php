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

header("Content-type: text/css");

$popup_box_floating='true';
$popup_box_rounded_corner='true';
$popup_box_border_width='0';
$popup_box_border_color='#ffffff';
?>
.sp_ns_err{
font-weight:bold;
color:red;
}

.sp_ns_mask {
  position:fixed;
  left:0;
  top:0;
  z-index:999999;
  background-color:#000;
  display:none;
}
  
.sp_ns_box .sp_ns_window {
  <?php if ($popup_box_floating == 'true')
      echo 'position:fixed;';
else
	  echo 'position:absolute;'; ?>
  left:0;
  top:0;
  width:auto;
  height:auto;
  display:none;
  z-index:999999;
  padding:20px;
  <?php if ( $popup_box_rounded_corner == 'true' )
  {?>
  	border-radius: 5px;
  	-moz-border-radius: 5px;
  	-webkit-border-radius: 5px;
  <?php } ?>
  box-shadow: 0 0 18px rgba(0, 0, 0, 0.4);
}

.sp_ns_box .sp_ns_dlg {
  max-width:800px; 
  height:auto;
  white-space:normal;
  overflow:visible;
  padding:10px;
  background-color:#ffffff;
  border:<?php echo $popup_box_border_width.'px'; ?> solid <?php echo $popup_box_border_color; ?>;
  font-family:Georgia !important;
  font-size:15px !important;
 
  
}

*html .sp_ns_box .sp_ns_window {
    position: absolute;
}

.sp_ns_box .sp_ns_window .sp_ns_close
{
	 
background-attachment: scroll;
background-clip: border-box;
background-color: transparent;
background-origin: padding-box;
background-position: 0% 0%;
background-repeat: no-repeat;
background-size: auto;
height: 36px;
right: -19px;
margin:0px 0px 0px 0px;
padding:0px 0px 0px 0px;
position: absolute;
top: -19px;
width: 36px;
border-bottom:0px;
}



.sp_ns_error{
color:red;
font-weight:bold;
}
.sp_ns_wrp{
padding:10px;
}
.sp_ns_description{

}
.sp_ns_button{

}
.sp_ns_submit{
background: #a9db80; /* Old browsers */
background: -moz-linear-gradient(top,  #a9db80 0%, #96c56f 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#a9db80), color-stop(100%,#96c56f)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #a9db80 0%,#96c56f 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #a9db80 0%,#96c56f 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #a9db80 0%,#96c56f 100%); /* IE10+ */
background: linear-gradient(to bottom,  #a9db80 0%,#96c56f 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a9db80', endColorstr='#96c56f',GradientType=0 ); /* IE6-9 */
 border: 1px solid #AAAAAA;
    border-radius: 5px 5px 5px 5px;
    color: #005700;
    float: right;
    /*margin-top: 10px;*/
    padding: 3px 10px;

}
.sp_ns_submit:hover{
background: #a9db80; /* Old browsers */
background: -moz-linear-gradient(top,  #a9db80 0%, #96c56f 43%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#a9db80), color-stop(43%,#96c56f)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #a9db80 0%,#96c56f 43%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #a9db80 0%,#96c56f 43%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #a9db80 0%,#96c56f 43%); /* IE10+ */
background: linear-gradient(to bottom,  #a9db80 0%,#96c56f 43%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a9db80', endColorstr='#96c56f',GradientType=0 ); /* IE6-9 */
cursor:pointer;

}



.sp_ns_popup_content{
width: 500px;
}
.sp_ns_popup_head{
margin-bottom: 25px;
}
.sp_ns_popup_content{

}
.sp_ns_popup_row{

}
.sp_ns_popup_submit_row{

}
.sp_ns_popup_lbl{
cursor:pointer;

}
.sp_ns_popup_input,.sp_ns_popup_payment_input {    border: 1px solid #AAAAAA;
    border-radius: 2px 2px 2px 2px;
    margin-bottom: 6px;
    padding: 3px 5px;
    }
	
.sp_ns_popup_input_co{  border: 1px solid #AAAAAA;
    border-radius: 2px 2px 2px 2px;
    margin-bottom: 6px;
    padding: 3px 5px;
    width: 97%;}	
	
.sp_ns_popup_tbl{
table-layout: auto;
}
.sp_ns_popup_submit_row, .sp_ns_popup_submit_row td, .sp_ns_popup_tbl, .sp_ns_popup_row td, .sp_ns_popup_row tr{
  border: medium none !important;
}
.sp_ns_popup_row{ width:100%; border:none;}
.sp_ns_popup_row td { }
.sp_ns_popup_payment_input{

}
.sp_ns_submit_error{

}
.sp_ns_popup_curr_sym{

}