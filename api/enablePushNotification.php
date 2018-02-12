<?php
require '../wp-config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
global $wpdb;
AuthUser($data['userId'],'string');
if(empty($data['userId'])){
   response(0,null,'Please enter the inspector id.');  
}
$inspector=get_user_by('id',$data['userId']);
$roles=$inspector->roles[0];
if($roles!='inspector'){
    response(0,null,'You are not authorise to use this api.'); 
}
$statusArray=array(0,1);
if($data['status']!=''){
   if(!in_array($data['status'],$statusArray)){
     response(0,null,'Please enter the valid status.');  
   } 
}else{
    response(0,null,'Please enter the status.');  
}
$loggedInUser=AuthUser($data['userId'],'string');
update_user_meta($data['userId'],'is_enable_notification',$data['status']);
response(1,"Pushnotification status changed successfully.",'No Error Found.'); 
?>