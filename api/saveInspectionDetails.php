<?php
require '../wp-config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
if(empty($data['userId'])){
   response(0,null,'Please enter the inspection id.'); 
}  
AuthUser($data['userId'],'string');
$inspector=get_user_by('id',$data['userId']);
$roles=$inspector->roles[0];
if($roles!='inspector'){
    response(0,null,'You are not authorise to use this api.'); 
}
$saveDetails=saveInspectionDetails($data);
if(!empty($saveDetails)){
    response(1,$saveDetails,'No Error Found.');
}else{
    response(0,null,'Something wrong please try again later.'); 
}
?>