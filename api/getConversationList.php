<?php
require '../wp-config.php';
$data = $_GET;
$error=1;
global $wpdb;
if(empty($data['userId'])){
  response(0,array(),'Please enter the user id.');
}
if(empty($data['conversationId'])){
  response(0,array(),'Please enter the conversation id.');
}
if($data['offset']==''){
  response(0,array(),'Please enter the offset.');
}
$offset=$data['offset']*20;
$allChats=array();

$loggedUser=AuthUser($data['userId'],array());
$query='select * from `im_chats` where `conversationId`="'.$data['conversationId'].'" order by id desc limit '.$offset.',20';
$chats=$wpdb->get_results($query,ARRAY_A); 
if(!empty($chats)){
    //krsort($chats); 
    $i=0;
    foreach($chats as $kk=>$vv){
        if($vv['senderId']==$data['userId']){
           $receiverId= $vv['receiverId'];
        }else{
            $receiverId= $vv['senderId']; 
        }
        $allChats[$i]['userId']=$vv['senderId'];
        $allChats[$i]['username']=get_user_meta($vv['senderId'],'first_name',true).' '.get_user_meta($vv['senderId'],'last_name',true);
        $allChats[$i]['messageId']=$vv['id'];
        $allChats[$i]['message']=$vv['message'];
        $allChats[$i]['file']=$vv['file'];
        $allChats[$i]['dateTime']=$vv['created'];
        $allChats[$i]['date']=date('d/m/y',strtotime($vv['created']));
        $allChats[$i]['time']=strtotime($vv['created']);
        $i++;   
    } 
}
if(!empty($allChats)){
  response(1,$allChats,'No Error Found.'); 
}else{
  response(0,array(),'No Chat Found.');  
}
?>