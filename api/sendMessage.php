<?php
require '../wp-config.php';
/*$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data,true);*/
$data=$_POST;
$error=1;
global $wpdb;
if(empty($data['userId'])){
    $error=0;
}
if(empty($data['toUserId'])){
    $error=0;
}
if(empty($data['message']) and empty($_FILES['file']['name'])){
    $error=0;
}
if(!empty($error)){
    $loggedUser=AuthUser($data['userId'],'string');
    $otherloggedUser=AuthUser($data['toUserId'],'string');
    if($data['userId']==$data['toUserId']){
      response(0,null,'Please cant send message to yourself.');    
    }    
    $conversationId=getConversationId($data['userId'],$data['toUserId'],'inspector');
    if(empty($conversationId)){
       response(0,null,'You cant send message to the selected user.');     
    }
    $return='';
    if(!empty($_FILES['file']['name'])){
        $upload_dir = wp_upload_dir(); 
        $filename=time().'_'.$_FILES['file']['name'];
        $file = $upload_dir['path'].'/'.$filename;
        $return = $upload_dir['url'].'/'.$filename;
        move_uploaded_file($_FILES['file']['tmp_name'],$file);  
    }
    $wpdb->query('insert into `im_chats`(`senderId`,`receiverId`,`conversationId`,`message`,`created`,`file`) values("'.$data['userId'].'","'.$data['toUserId'].'","'.$conversationId.'","'.$data['message'].'","'.date('Y-m-d H:i:s').'","'.$return.'")');
    $lastInsertId=$wpdb->insert_id;
    $chat=$wpdb->get_row('select * from `im_chats` where `id`="'.$lastInsertId.'"',ARRAY_A);
    $chatMod['userId']=$chat['senderId'];
    $chatMod['toUserId']=$chat['receiverId'];
    $chatMod['messageId']=$chat['id'];
    $chatMod['message']=$chat['message'];     
    $chatMod['file']=$chat['file'];     
    $chatMod['dateTime']=$chat['created'];
    $chatMod['date']=date('Y-m-d',strtotime($chat['created']));
    $chatMod['time']=strtotime($chat['created']);
    $senderName=get_user_meta($data['userId'],'first_name',true);
    $finalContent='You have received new message from '.$senderName;
    insert_notification($data['userId'],$data['toUserId'],$lastInsertId,'1',$finalContent); 
    response(1,$chatMod,'No Error Found.');    
}else{
    response(0,null,'Please enter required fields.');
}
?>