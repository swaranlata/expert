<?php
require '../wp-config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
if(empty($data['email'])){
     response(0,null,'Please enter your email.'); 
}else{
    if(empty(CheckValidEmail($data['email']))){
        response(0,null,'Please enter valid email.'); 
    }
}
if(empty($data['userId'])){
  response(0,null,'Please enter inspector id.');   
}
if(empty($data['date'])){
  response(0,null,'Please enter the date.');
}
if(empty($data['inspectionDate'])){
  response(0,null,'Please enter the inspection date.');
}
if(empty($data['dateOfLoss'])){
  response(0,null,'Please enter the date of loss.');
}
AuthUser($data['userId'],'string');
$inspector=get_user_by('id',$data['userId']);
$roles=$inspector->roles[0];
if($roles!='inspector'){
    response(0,null,'You are not authorise to create client.'); 
}
$saveDetails=addClient($data);
if(!empty($saveDetails)){
    $data['clientId']=(string) $saveDetails;
    response(1,$data,'No Error Found.');
}else{
    response(0,null,'Something wrong please try again later.'); 
}
?>