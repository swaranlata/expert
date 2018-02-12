<?php
require '../wp-config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data,true);
if(empty($data['userId'])){
  response(0,null,'Please enter the user id.');   
}
if(empty($data['conversationId'])){
  response(0,null,'Please enter the conversation id.');   
}
AuthUser($data['userId'],'string');
$userDetails=get_user_by('id',$data['userId']);
$userRole=$userDetails->roles[0];
if($userRole!='inspector'){
  response(0,null,'This api is authorise for the Inspector.');     
}
global $wpdb;
$getRow=$wpdb->get_row('select * from `im_conversations` where `id`="'.$data['conversationId'].'" and (`senderId`="'.$data['userId'].'" or `receiverId`="'.$data['userId'].'")');
if(!empty($getRow)){
  $deleteChat=$wpdb->query('delete from `im_chats where `conversationId`="'.$data['conversationId'].'"'); 
  response(1,'Conversation deleted successfully.','No Error found.');   
}else{
  response(0,null,'No Conversation found.');     
}

?>