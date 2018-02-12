<?php
require '../wp-config.php';
$data = $_GET;
$error=1;
global $wpdb;
if(empty($data['userId'])){
  response(0,array(),'Please enter the user id.');
}
$loggedUser=AuthUser($data['userId'],array());
$getRecords=$wpdb->get_results('SELECT * FROM `im_conversations` where (`senderId`="'.$data['userId'].'" or `receiverId`="'.$data['userId'].'")',ARRAY_A);
$con=array();
$strCon='';
if(!empty($getRecords)){
   foreach($getRecords as $k=>$v){
       $con[]=$v['id']; 
   } 
   $strCon=implode('","',$con);
}
if(!empty($strCon)){
     $query='select * from `im_chats` where `conversationId` in ("'.$strCon.'") group by `conversationId`';
    $chats=$wpdb->get_results($query,ARRAY_A);
}else{
   $chats=array(); 
}
$allChats=array();
if(!empty($chats)){
    $i=0;
    foreach($chats as $kk=>$vv){
        if($vv['senderId']==$_GET['userId']){
          $receiverId=$vv['receiverId'];
        }else{
          $receiverId=$vv['senderId'];
        }
        $allChats[$i]=getLastMessage($vv['conversationId']);
        $allChats[$i]['userId']=$receiverId;
        $allChats[$i]['username']=get_user_meta($receiverId,'first_name',true);
        $allChats[$i]['conversationId']=$vv['conversationId'];
         
        $i++;    
    } 
   response(1,$allChats,'No Error Found.'); 
}else{
   response(0,array(),'No Chat Found.'); 
}
?>
