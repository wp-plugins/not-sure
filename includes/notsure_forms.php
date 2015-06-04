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
function sp_ns_forms(){
global $wpdb;
$action=isset($_POST['action'])?$_POST['action']:"";
$table_name = $wpdb->prefix . "notsure";

?>
<form method="post" name="edit_button" action="">
  <input type="hidden" name="action" value="edit_form" />
  <input type="hidden" name="button_id" id="button_id" value="" />
</form>
<form method="post" name="delete_button" action="">
  <input type="hidden" name="action" value="delete_form" />
  <input type="hidden" name="button_id" id="delbutton_id" value="" />
</form>
<?php


if($action=='save_new')
{
  $_POST1 = array_map('stripslashes_deep', $_POST);//why auto adding slashes??
  
  $title=isset($_POST1['sp_ns_title'])?sanitize_text_field($_POST1['sp_ns_title']):"";//text validation
  $btn_text=isset($_POST1['sp_ns_btn_text'])?sanitize_text_field($_POST1['sp_ns_btn_text']):"";//text validation
  $popup_description=isset($_POST1['sp_ns_popup_description'])?balanceTags(trim((string)$_POST1['sp_ns_popup_description'])):"";//textarea with allowed html tags
  $show_msg=isset($_POST1['sp_ns_show_msg'])?intval($_POST1['sp_ns_show_msg']):0;//int validation
  $msg_label=isset($_POST1['sp_ns_msg_label'])?sanitize_text_field($_POST1['sp_ns_msg_label']):"";//text validation
  $show_email=isset($_POST1['sp_ns_show_email'])?intval($_POST1['sp_ns_show_email']):0;//int validation
  $email_label=isset($_POST1['sp_ns_email_label'])?sanitize_text_field($_POST1['sp_ns_email_label']):"";//text validation
  $send_btn_text=isset($_POST1['sp_ns_send_btn_text'])?sanitize_text_field($_POST1['sp_ns_send_btn_text']):"";//text validation
  $question1=isset($_POST1['sp_ns_question1'])?sanitize_text_field($_POST1['sp_ns_question1']):"";//text validation
  $question2=isset($_POST1['sp_ns_question2'])?sanitize_text_field($_POST1['sp_ns_question2']):"";//text validation
  $question3=isset($_POST1['sp_ns_question3'])?sanitize_text_field($_POST1['sp_ns_question3']):"";//text validation
  $question4=isset($_POST1['sp_ns_question4'])?sanitize_text_field($_POST1['sp_ns_question4']):"";//text validation
  $question5=isset($_POST1['sp_ns_question5'])?sanitize_text_field($_POST1['sp_ns_question5']):"";//text validation
  $other_questions=isset($_POST1['sp_ns_other_questions'])?esc_textarea($_POST1['sp_ns_other_questions']):"";//textarea validation
  $send_to_admin=isset($_POST1['sp_ns_send_to_admin'])?intval($_POST1['sp_ns_send_to_admin']):0;//int validation
  $send_to=isset($_POST1['sp_ns_send_to'])?sanitize_text_field($_POST1['sp_ns_send_to']):"";//text validation
  
  //check lengths
  //sp_ns_check_string_length($string,$length=255)
  $title=sp_ns_check_string_length($title);
  $btn_text=sp_ns_check_string_length($btn_text);
  $popup_description=sp_ns_check_string_length($popup_description,1000);//1000 chars is enough
  $show_msg=sp_ns_check_string_length($show_msg,1);
  $msg_label=sp_ns_check_string_length($msg_label);
  $show_email=sp_ns_check_string_length($show_email,1);
  $email_label=sp_ns_check_string_length($email_label);
  $send_btn_text=sp_ns_check_string_length($send_btn_text);
  $question1=sp_ns_check_string_length($question1);
  $question2=sp_ns_check_string_length($question2);
  $question3=sp_ns_check_string_length($question3);
  $question4=sp_ns_check_string_length($question4);
  $question5=sp_ns_check_string_length($question5);
  $other_questions=sp_ns_check_string_length($other_questions,1000);//1000 chars is enough
  $send_to_admin=sp_ns_check_string_length($send_to_admin,1);
  $send_to=sp_ns_check_string_length($send_to);
  
  //remove new lines from other questions
  $other_questions = trim(preg_replace('/\s\s+/', '', $other_questions));
  
  //check for valid email addresses before save
  $send_to_arr=array();
  $send_to_arr=explode(",",$send_to);
  $send_to="";
  if(count($send_to_arr)>0)
  {
    $send_to_new_arr=array();
    foreach($send_to_arr as $st)
    {
      if(is_email($st))
      {
        $send_to_new_arr[]=$st;
      }
    }
    $send_to=implode(",",$send_to_new_arr);
  }
  
  //save in database
  $wpdb->insert( 
  	$table_name, 
  	array(
  		'title'=>$title,
      'btn_text'=>$btn_text,
      'popup_description'=>$popup_description,
      'show_msg'=>$show_msg,
      'msg_label'=>$msg_label,
      'show_email'=>$show_email,
      'email_label'=>$email_label,
      'send_btn_text'=>$send_btn_text,
      'question1'=>$question1,
      'question2'=>$question2,
      'question3'=>$question3,
      'question4'=>$question4,
      'question5'=>$question5,
      'other_questions'=>$other_questions,
      'send_to_admin'=>$send_to_admin,
      'send_to'=>$send_to,
      'mdate'=>time()
  	), 
  	array( 
  		'%s','%s','%s','%d','%s','%d','%s','%s','%s','%s','%s','%s','%s','%s','%d','%s','%d'
  	)
  );

  if(isset($wpdb->last_error) && $wpdb->last_error!="")
  {
    add_settings_error(
      'sp_ns_opperation_messages',
      esc_attr( 'settings_updated' ),
      "DB ERROR: ".$wpdb->last_error,
      'error'
    );
    $action="";
  }
  else
  {
    add_settings_error(
      'sp_ns_opperation_messages',
      esc_attr( 'settings_updated' ),
      "Added Not Sure Button",
      'updated'
    );
    $action="";
  }
  $action="";
}

if($action=='add_new')
{
  ?>
  <div class="wrap">
  <form method="post" action="">
    <input type="hidden" name="action" value="save_new" />
    <h2>Add New Not Sure Button</h2>
    <table class="form-table">
      <tr>
        <th scope="row"><a href="" class="button button-secondary">Cancel</a></th>
        <td colspan="2"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Not Sure Button" /></td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_title">Title</th>
        <td><input type="text" name="sp_ns_title" id="sp_ns_title" value="" /></td>
        <td>Not Sure Button Title, not used in front-end</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_btn_text">Button Text</th>
        <td><input type="text" name="sp_ns_btn_text" id="sp_ns_btn_text" value="I'm interested but..." /></td>
        <td>The Not Sure button text, i.e.: I'm not sure</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_popup_description">Pop-up Description</th>
        <td><textarea name="sp_ns_popup_description" id="sp_ns_popup_description">Please let us know why are you unsure</textarea></td>
        <td>Add text in the pop-up before the options, can be HTML</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_show_msg">Show Message box?</th>
        <td>
        <select name="sp_ns_show_msg" id="sp_ns_show_msg">
          <option value="0">No</option>
	        <option value="1" selected="selected">Yes</option>
        </select>
        </td>
        <td>Show or hide the message box</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_msg_label">Label for Message</th>
        <td><input type="text" name="sp_ns_msg_label" id="sp_ns_msg_label" value="Message" /></td>
        <td>The label of the Message box</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_show_email">Show Email?</th>
        <td>
        <select name="sp_ns_show_email" id="sp_ns_show_email">
          <option value="0">No</option>
	        <option value="1" selected="selected">Yes</option>
        </select>
        </td>
        <td>Show the email field or not</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_email_label">Label for Email</th>
        <td><input type="text" name="sp_ns_email_label" id="sp_ns_email_label" value="Email(if you want us to get back to you)" /></td>
        <td>The label of the email box</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_send_btn_text">Send Button Text</th>
        <td><input type="text" name="sp_ns_send_btn_text" id="sp_ns_send_btn_text" value="Send" /></td>
        <td>Pop-up send button text</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_question1">Question 1</th>
        <td><input type="text" name="sp_ns_question1" id="sp_ns_question1" value="The price is too high" /></td>
        <td>Question 1 text</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_question2">Question 2</th>
        <td><input type="text" name="sp_ns_question2" id="sp_ns_question2" value="It's not what I'm looking for" /></td>
        <td>Question 2 text</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_question3">Question 3</th>
        <td><input type="text" name="sp_ns_question3" id="sp_ns_question3" value="I'm looking for something with more functions" /></td>
        <td>Question 3 text</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_question4">Question 4</th>
        <td><input type="text" name="sp_ns_question4" id="sp_ns_question4" value="I don't know if it's what I need" /></td>
        <td>Question 4 text</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_question5">Question 5</th>
        <td><input type="text" name="sp_ns_question5" id="sp_ns_question5" value="The price is too low, I don't trust it" /></td>
        <td>Question 5 text</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_other_questions">More Questions</th>
        <td><textarea name="sp_ns_other_questions" id="sp_ns_other_questions"></textarea></td>
        <td>Add more questions separated by , (comma)</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_send_to_admin">Send feedback to website admin?</th>
        <td>
        <select name="sp_ns_send_to_admin" id="sp_ns_send_to_admin">
          <option value="0">No</option>
	        <option value="1" selected="selected">Yes</option>
        </select>
        </td>
        <td>Send feedback to website admin</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_send_to">Send feedback to:</th>
        <td><input type="text" name="sp_ns_send_to" id="sp_ns_send_to" value="" /></td>
        <td>Add email addresses separated by , (comma)</td>
      </tr>
      <tr>
        <th scope="row"><a href="" class="button button-secondary">Cancel</a></th>
        <td colspan="2"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Not Sure Button" /></td>
      </tr>
    </table>
  </form>
  </div>
  <?php
}

if($action=='save_edit')
{
  $form_id=isset($_POST['button_id'])?intval($_POST['button_id']):0;//working form id
  if($form_id>0)
  {
  $_POST1 = array_map('stripslashes_deep', $_POST);//why auto adding slashes??
  
  $title=isset($_POST1['sp_ns_title'])?sanitize_text_field($_POST1['sp_ns_title']):"";//text validation
  $btn_text=isset($_POST1['sp_ns_btn_text'])?sanitize_text_field($_POST1['sp_ns_btn_text']):"";//text validation
  $popup_description=isset($_POST1['sp_ns_popup_description'])?balanceTags(trim((string)$_POST1['sp_ns_popup_description'])):"";//textarea with allowed html tags
  $show_msg=isset($_POST1['sp_ns_show_msg'])?intval($_POST1['sp_ns_show_msg']):0;//int validation
  $msg_label=isset($_POST1['sp_ns_msg_label'])?sanitize_text_field($_POST1['sp_ns_msg_label']):"";//text validation
  $show_email=isset($_POST1['sp_ns_show_email'])?intval($_POST1['sp_ns_show_email']):0;//int validation
  $email_label=isset($_POST1['sp_ns_email_label'])?sanitize_text_field($_POST1['sp_ns_email_label']):"";//text validation
  $send_btn_text=isset($_POST1['sp_ns_send_btn_text'])?sanitize_text_field($_POST1['sp_ns_send_btn_text']):"";//text validation
  $question1=isset($_POST1['sp_ns_question1'])?sanitize_text_field($_POST1['sp_ns_question1']):"";//text validation
  $question2=isset($_POST1['sp_ns_question2'])?sanitize_text_field($_POST1['sp_ns_question2']):"";//text validation
  $question3=isset($_POST1['sp_ns_question3'])?sanitize_text_field($_POST1['sp_ns_question3']):"";//text validation
  $question4=isset($_POST1['sp_ns_question4'])?sanitize_text_field($_POST1['sp_ns_question4']):"";//text validation
  $question5=isset($_POST1['sp_ns_question5'])?sanitize_text_field($_POST1['sp_ns_question5']):"";//text validation
  $other_questions=isset($_POST1['sp_ns_other_questions'])?esc_textarea($_POST1['sp_ns_other_questions']):"";//textarea validation
  $send_to_admin=isset($_POST1['sp_ns_send_to_admin'])?intval($_POST1['sp_ns_send_to_admin']):0;//int validation
  $send_to=isset($_POST1['sp_ns_send_to'])?sanitize_text_field($_POST1['sp_ns_send_to']):"";//text validation
  
  //check lengths
  //sp_ns_check_string_length($string,$length=255)
  $title=sp_ns_check_string_length($title);
  $btn_text=sp_ns_check_string_length($btn_text);
  $popup_description=sp_ns_check_string_length($popup_description,1000);//1000 chars is enough
  $show_msg=sp_ns_check_string_length($show_msg,1);
  $msg_label=sp_ns_check_string_length($msg_label);
  $show_email=sp_ns_check_string_length($show_email,1);
  $email_label=sp_ns_check_string_length($email_label);
  $send_btn_text=sp_ns_check_string_length($send_btn_text);
  $question1=sp_ns_check_string_length($question1);
  $question2=sp_ns_check_string_length($question2);
  $question3=sp_ns_check_string_length($question3);
  $question4=sp_ns_check_string_length($question4);
  $question5=sp_ns_check_string_length($question5);
  $other_questions=sp_ns_check_string_length($other_questions,1000);//1000 chars is enough
  $send_to_admin=sp_ns_check_string_length($send_to_admin,1);
  $send_to=sp_ns_check_string_length($send_to);
  
  //remove new lines from other questions
  $other_questions = trim(preg_replace('/\s\s+/', '', $other_questions));
  
  //check for valid email addresses before save
  $send_to_arr=array();
  $send_to_arr=explode(",",$send_to);
  $send_to="";
  if(count($send_to_arr)>0)
  {
    $send_to_new_arr=array();
    foreach($send_to_arr as $st)
    {
      if(is_email($st))
      {
        $send_to_new_arr[]=$st;
      }
    }
    $send_to=implode(",",$send_to_new_arr);
  }
  
  //save in database
  $wpdb->update(
    $table_name,
    array(
      'title'=>$title,
      'btn_text'=>$btn_text,
      'popup_description'=>$popup_description,
      'show_msg'=>$show_msg,
      'msg_label'=>$msg_label,
      'show_email'=>$show_email,
      'email_label'=>$email_label,
      'send_btn_text'=>$send_btn_text,
      'question1'=>$question1,
      'question2'=>$question2,
      'question3'=>$question3,
      'question4'=>$question4,
      'question5'=>$question5,
      'other_questions'=>$other_questions,
      'send_to_admin'=>$send_to_admin,
      'send_to'=>$send_to,
      'mdate'=>time()
    ),
    array('id' => $form_id),
    array(
  		'%s','%s','%s','%d','%s','%d','%s','%s','%s','%s','%s','%s','%s','%s','%d','%s','%d'
  	),
    array('%d')
  );

  //check for errors
  if(isset($wpdb->last_error) && $wpdb->last_error!="")
  {
    add_settings_error(
      'sp_ns_opperation_messages',
      esc_attr( 'settings_updated' ),
      "DB ERROR: ".$wpdb->last_error,
      'error'
    );
    $action="edit_form";
  }
  else
  {
    add_settings_error(
      'sp_ns_opperation_messages',
      esc_attr( 'settings_updated' ),
      "Updated Not Sure Button",
      'updated'
    );
    $action="edit_form";
  }
  }
  else
  {
    $action="";
  }
}
if($action=='edit_form')
{
  $form_id=isset($_POST['button_id'])?$_POST['button_id']+0:0;
  if($form_id>0)
  {
    $sql="select * from $table_name where id='".$form_id."'";
    $form = $wpdb->get_results($sql);
    if(isset($form[0]))
    {
      $form=$form[0];
      $errors = get_settings_errors('sp_ns_opperation_messages');
      if(is_array($errors))
      {
        foreach($errors as $err)
        {
        ?>
        <div class="<?php echo $err['type'];?>">
            <p><?php echo $err['message'];?></p>
        </div>
        <?php
        }
      }
  ?>
  <div class="wrap">
  <form method="post" action="">
    <input type="hidden" name="button_id" value="<?php echo $form->id;?>" />
    <input type="hidden" name="action" value="save_edit" />
    <h2>Edit Not Sure Button</h2>
    <table class="form-table">
      <tr>
        <th scope="row"><a href="" class="button button-secondary">Cancel</a></th>
        <td colspan="2"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Not Sure Button" /></td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_title">Title</th>
        <td><input type="text" name="sp_ns_title" id="sp_ns_title" value="<?php echo esc_attr($form->title);?>" /></td>
        <td>Not Sure Button Title, not used in front-end</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_btn_text">Button Text</th>
        <td><input type="text" name="sp_ns_btn_text" id="sp_ns_btn_text" value="<?php echo esc_attr($form->btn_text);?>" /></td>
        <td>The Not Sure button text, i.e.: I'm not sure</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_popup_description">Pop-up Description</th>
        <td><textarea name="sp_ns_popup_description" id="sp_ns_popup_description"><?php echo esc_attr($form->popup_description);?></textarea></td>
        <td>Add text in the pop-up before the options, can be HTML</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_show_msg">Show Message box?</th>
        <td>
        <select name="sp_ns_show_msg" id="sp_ns_show_msg">
          <option value="0"<?php echo (($form->show_msg==0)?' selected="selected"':"");?>>No</option>
	        <option value="1"<?php echo (($form->show_msg==1)?' selected="selected"':"");?>>Yes</option>
        </select>
        </td>
        <td>Show or hide the message box</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_msg_label">Label for Message</th>
        <td><input type="text" name="sp_ns_msg_label" id="sp_ns_msg_label" value="<?php echo esc_attr($form->msg_label);?>" /></td>
        <td>The label of the Message box</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_show_email">Show Email?</th>
        <td>
        <select name="sp_ns_show_email" id="sp_ns_show_email">
          <option value="0"<?php echo (($form->show_email==0)?' selected="selected"':"");?>>No</option>
	        <option value="1"<?php echo (($form->show_email==1)?' selected="selected"':"");?>>Yes</option>
        </select>
        </td>
        <td>Show the email field or not</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_email_label">Label for Email</th>
        <td><input type="text" name="sp_ns_email_label" id="sp_ns_email_label" value="<?php echo esc_attr($form->email_label);?>" /></td>
        <td>The label of the email box</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_send_btn_text">Send Button Text</th>
        <td><input type="text" name="sp_ns_send_btn_text" id="sp_ns_send_btn_text" value="<?php echo esc_attr($form->send_btn_text);?>" /></td>
        <td>Pop-up send button text</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_question1">Question 1</th>
        <td><input type="text" name="sp_ns_question1" id="sp_ns_question1" value="<?php echo esc_attr($form->question1);?>" /></td>
        <td>Question 1 text</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_question2">Question 2</th>
        <td><input type="text" name="sp_ns_question2" id="sp_ns_question2" value="<?php echo esc_attr($form->question2);?>" /></td>
        <td>Question 2 text</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_question3">Question 3</th>
        <td><input type="text" name="sp_ns_question3" id="sp_ns_question3" value="<?php echo esc_attr($form->question3);?>" /></td>
        <td>Question 3 text</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_question4">Question 4</th>
        <td><input type="text" name="sp_ns_question4" id="sp_ns_question4" value="<?php echo esc_attr($form->question4);?>" /></td>
        <td>Question 4 text</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_question5">Question 5</th>
        <td><input type="text" name="sp_ns_question5" id="sp_ns_question5" value="<?php echo esc_attr($form->question5);?>" /></td>
        <td>Question 5 text</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_other_questions">More Questions</th>
        <td><textarea name="sp_ns_other_questions" id="sp_ns_other_questions"><?php echo esc_attr($form->other_questions);?></textarea></td>
        <td>Add more questions separated by , (comma)</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_send_to_admin">Send feedback to website admin?</th>
        <td>
        <select name="sp_ns_send_to_admin" id="sp_ns_send_to_admin">
          <option value="0"<?php echo (($form->send_to_admin==0)?' selected="selected"':"");?>>No</option>
	        <option value="1"<?php echo (($form->send_to_admin==1)?' selected="selected"':"");?>>Yes</option>
        </select>
        </td>
        <td>Send feedback to website admin</td>
      </tr>
      <tr>
        <th scope="row"><label for="sp_ns_send_to">Send feedback to:</th>
        <td><input type="text" name="sp_ns_send_to" id="sp_ns_send_to" value="<?php echo esc_attr($form->send_to);?>" /></td>
        <td>Add email addresses separated by , (comma)</td>
      </tr>
      <tr>
        <th scope="row"><a href="" class="button button-secondary">Cancel</a></th>
        <td colspan="2"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Not Sure Button" /></td>
      </tr>
    </table>
  </form>
  </div>
  <?php
  }
  else
  {
    $action="";
  }
  }
  else
  {
    $action="";
  }
}


if($action=='delete_form')
{
  $form_id=isset($_POST['button_id'])?intval($_POST['button_id']):0;
  if($form_id>0)
  {
    $wpdb->delete($table_name,array('id'=>$form_id));
    if(isset($wpdb->last_error) && $wpdb->last_error!="")
    {
      add_settings_error(
        'sp_ns_opperation_messages',
        esc_attr( 'settings_updated' ),
        "DB ERROR: ".$wpdb->last_error,
        'error'
      );
      $action="";
    }
    else
    {
      add_settings_error(
        'sp_ns_opperation_messages',
        esc_attr( 'settings_updated' ),
        "Deleted Not Sure Button",
        'updated'
      );
      $action="";
    }
  }
  $action="";
}

if($action=="")
{
$myListTable = new SP_NS_List_Table();
$myListTable->prepare_items(); 
?>
<div class="wrap">
<h2>Not Sure Buttons</h2>
<form method="post" action="">
  <input type="hidden" name="action" value="add_new" />
  <input type="submit" name="submit" id="submit" class="button button-primary" value="Add New" />
</form>

<?php
$errors = get_settings_errors('sp_ns_opperation_messages');
if(is_array($errors))
{
  foreach($errors as $err)
  {
  ?>
  <div class="<?php echo $err['type'];?>">
      <p><?php echo $err['message'];?></p>
  </div>
  <?php
  }
}
$myListTable->display(); 
?>
</div>
<?php
}

}
function sp_ns_check_string_length($string,$length=255)
{
  $string=(string)$string;
  if($string!="")
  {
    $length=intval($length);
    if($length>0)
    {
      if(strlen($string)>$length)
        $string=substr($string,0,255);
      return $string;
    }
  }
  return $string;
}
?>