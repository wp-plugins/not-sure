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
function sp_ns_register_shortcodes(){
   add_shortcode('sp_ns_display_button', 'sp_ns_display_button');
}

function sp_ns_getMoreOptions($str)
{
  $questions=array();
  if($str!="")
  {
    $questions=explode(",",$str);
  }
  return $questions;
}

function sp_ns_display_button($atts){
  global $wpdb;
  
  $table_name = $wpdb->prefix . "notsure";
  $html='';
  $id=0;
  
  if(is_array($atts))
  {
    extract(shortcode_atts(array(
      'id' => 0,
    ), $atts));
  }

  $id=$id+0;
  
  if($id>0)
  {
    $forms=$wpdb->get_results($wpdb->prepare(
      "SELECT * FROM $table_name WHERE id=%d",
      $id
    ));
    if(isset($forms[0]))
    {
      $form=$forms[0];
      $action=isset($_REQUEST['sp_ns_action'])?$_REQUEST['sp_ns_action']:"";
      if($action=='')
      {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_style( 'sp_ns_display_css', SP_NS_URL .'/css/sp_ns.css.php' );
        wp_enqueue_script( 'sp_ns_display_js', SP_NS_URL . '/js/sp_ns.js.php');
        sp_ns_button_form($form);
      }
      else if($action=='send')
      {
        sp_ns_send_mail();
      }
    }
  }
}
add_action( 'init', 'sp_ns_register_shortcodes');

function sp_ns_button_form($form)
{
  $button_text=$form->btn_text;
  $popup_description=$form->popup_description;
  $send_btn_text=$form->send_btn_text;
  $show_msg=$form->show_msg;
  $msg_label=$form->msg_label;
  $question1=$form->question1;
  $question2=$form->question2;
  $question3=$form->question3;
  $question4=$form->question4;
  $question5=$form->question5;
  $other_questions=$form->other_questions;
  $send_to_admin=$form->send_to_admin;
  $send_to=$form->send_to;
  $show_email=$form->show_email;
  $email_label=$form->email_label;
  
  $send_to_arr=sp_ns_getMoreOptions($send_to);
  $other_questions_arr=sp_ns_getMoreOptions($other_questions);
  
  $questions=array();
  if(trim($question1)!="")
  {
    $questions[]=$question1;
  }
  if(trim($question2)!="")
  {
    $questions[]=$question2;
  }
  if(trim($question3)!="")
  {
    $questions[]=$question3;
  }
  if(trim($question4)!="")
  {
    $questions[]=$question4;
  }
  if(trim($question5)!="")
  {
    $questions[]=$question5;
  }
  if(count($other_questions_arr)>0)
  {
    foreach($other_questions_arr as $q)
    {
      if(trim($q)!="")
      {
        $questions[]=$q;
      }
    }
  }
  $ns_id=uniqid('spns_');
  ?>
  <script type="text/javascript">
  <!--
  jQuery(document).ready(function() {
  setSPNSPpopup('<?php echo $ns_id;?>');
  });
  //-->
  </script>
  
  <div id="sp_ns_mask<?php echo $ns_id;?>" class="sp_ns_mask"></div>
  <a id="sp_ns_popup<?php echo $ns_id;?>" class="sp_ns_popup" name="sp_ns_popup<?php echo $ns_id;?>" href="#sp_ns_dlg<?php echo $ns_id;?>"></a>
  
  <div class="sp_ns_wrp">
    <input class="sp_ns_submit" style="float:none;" type="button" value="<?php echo esc_attr($button_text);?>" onClick="javascript:openSPNSPpopup('<?php echo $ns_id;?>');" />
  </div>
  
  <div id="sp_ns_box<?php echo $ns_id;?>" class="sp_ns_box">
    <div id="sp_ns_dlg<?php echo $ns_id;?>" class="sp_ns_window<?php echo $ns_id;?> sp_ns_dlg sp_ns_window">
      <a class="sp_ns_close<?php echo $ns_id;?> sp_ns_close" href="#" style="background-image: url(<?php echo SP_NS_URL;?>/images/close.png);"></a>
      
      
      <div class="sp_ns_popup_head">
        <?php echo $popup_description;?>
      </div>
      <div class="sp_ns_popup_content">
        <form action="" method="POST" name="NotSure<?php echo $ns_id;?>">
          <input type="hidden" name="working_plugin" value="<?php echo $ns_id?>" />
          <input type="hidden" name="form_id" value="<?php echo $form->id?>" />
          <input type="hidden" name="sp_ns_action" value="send" />
          <table width="100%" class="sp_ns_popup_tbl">
          <tbody>
          <?php
          if(count($questions)>0)
          {
            $nscnt=0;
            foreach($questions as $question)
            {
              $nscnt++;
              $id='ns_'.$nscnt.'_'.$ns_id;
              $question_str=esc_attr($question);
            ?>
            <tr class="sp_ns_popup_row">
              <td class="sp_ns_chk">
                <input type="checkbox" class="sp_ns_popup_input" name="sp_ns_questions[]" id="<?php echo $id;?>" value="<?php echo $question_str;?>" />
              </td>
              <td>
                <label for="<?php echo $id;?>" class="sp_ns_popup_lbl"><?php echo $question;?></label>
              </td>
            </tr>
            <?php
            }
          }
          if($show_msg==1)
          {
          ?>
            <tr class="sp_ns_popup_row">
              <td valign="top">
              &nbsp;
              </td>
              <td>
              </td>
            </tr>
            <tr class="sp_ns_popup_row">
              <td valign="top">
              </td>
              <td>
                <label for="sp_ns_msg_<?php echo $ns_id;?>" class="sp_ns_popup_lbl"><?php echo $msg_label;?></label>
              </td>
            </tr>
            <tr class="sp_ns_popup_row">
              <td valign="top">
                
              </td>
              <td>
                <textarea class="sp_ns_popup_msg" name="sp_ns_msg" id="sp_ns_msg_<?php echo $ns_id;?>"></textarea>
              </td>
            </tr>
          <?php
          }
          if($show_email==1)
          {
          ?>
            <tr class="sp_ns_popup_row">
              <td valign="top">
              &nbsp;
              </td>
              <td>
              </td>
            </tr>
            <tr class="sp_ns_popup_row">
              <td valign="top">
              </td>
              <td>
                <label for="sp_ns_email_<?php echo $ns_id;?>" class="sp_ns_popup_lbl"><?php echo $email_label;?></label>
              </td>
            </tr>
            <tr class="sp_ns_popup_row">
              <td valign="top">
                
              </td>
              <td>
                <input type="text" class="sp_ns_popup_payment_input" name="sp_ns_email" id="sp_ns_email_<?php echo $ns_id;?>" value="" />
              </td>
            </tr>
          <?php
          }
          ?>
            <tr class="sp_ns_popup_submit_row">
              <td colspan="2">
                <input class="sp_ns_submit" type="submit" value="<?php echo esc_attr($send_btn_text);?>" />
              </td>
            </tr>
            </tbody>
          </table>
        </form>
      </div>

      
      
      
    </div>
  </div>

  <?php
}
function sp_ns_send_mail()
{
  global $wpdb;
  $_POST1 = array_map('stripslashes_deep', $_POST);
  $form_id=isset($_POST1['form_id'])?intval($_POST1['form_id']):0;
  if($form_id>0)
  {
    $table_name = $wpdb->prefix . "notsure";
    $forms=$wpdb->get_results($wpdb->prepare(
      "SELECT * FROM $table_name WHERE id=%d",
      $form_id
    ));
    if(isset($forms[0]))
    {
      $form=$forms[0];
      add_filter( 'wp_mail_content_type', 'sp_ns_set_html_content_type' );
      $send_to="";
      $send_to_arr=array();
      $admin_mail=get_option( 'admin_email');
      if($admin_mail!="")
        $send_to_arr[]=$admin_mail;
      if($form->send_to!="")
      {
        $send_to_arr1=array();
        $send_to_arr1=explode(",",$form->send_to);//values alread checked in admin section
        if(count($send_to_arr1)>0)
        {
          foreach($send_to_arr1 as $st)
          {
            $send_to_arr[]=$st;
          }
        }
      }
      $send_to=implode(",",$send_to_arr);
      $subj="Customer Not Sure on ".$_SERVER['HTTP_HOST'];
      
      $notsure_questions=isset($_POST1['sp_ns_questions'])?$_POST1['sp_ns_questions']:array();//sanitize in interation
      $notsure_msg=isset($_POST1['sp_ns_msg'])?esc_textarea($_POST1['sp_ns_msg']):"";//sanitize the message
      $notsure_email=isset($_POST1['sp_ns_email'])?sanitize_email($_POST1['sp_ns_email']):"";//sanitize the email
      if($notsure_msg!="")
        $check_to_send=1;//something to send
      $actual_link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
      
      $check_to_send=0;
      
      $the_options="";
      if(count($notsure_questions)>0)
      {
        foreach($notsure_questions as $question)//sanitize the questions
        {
          $the_options.=sanitize_text_field($question).'
';
          $check_to_send=1;//something to send
        }
      }
      $notsure_email_chk="";
      if (!filter_var($notsure_email, FILTER_VALIDATE_EMAIL))//validate the email
      {
        $notsure_email_chk=" invalid";
      }
      else
      {
        $check_to_send=1;//something to send
      }
      
      $body   = 'Hi,

A customer is not sure about:
<a href="'.$actual_link.'">'.$actual_link.'</a>

He selected these options:
'.$the_options.'

And the following message:
'.$notsure_msg.'

Email:
'.$notsure_email.$notsure_email_chk.'

Not Sure Plugin
'.$_SERVER['HTTP_HOST'];
      $body=nl2br($body);
      if (!filter_var($notsure_email, FILTER_VALIDATE_EMAIL))//swap sender if invalid client email
      {
        $notsure_email=$admin_mail;
      }
      $headers[] = 'From: Customer Not Sure <'.$notsure_email.'>';
      if($check_to_send==1)
      {
        if(wp_mail( $send_to, $subj, $body, $headers ))
        {
          echo '<font color="green">Thank you</font>';
        }
        else
        {
          echo '<font color="red">An error occured in sending the email</font>';
        }
      }
      else
      {
        echo '<font color="red">Nothing to send</font>';
      }
      remove_filter( 'wp_mail_content_type', 'sp_ns_set_html_content_type' );
    }
    else
    {
      echo '<font color="red">An error occured</font>';
    }
  }
  else
  {
    echo '<font color="red">An error occured</font>';
  }
}
function sp_ns_set_html_content_type() {
	return 'text/html';
}
?>