<?php
require '../wp-config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data,true);
if(empty($data['userId'])){
  response(0,null,'Please enter the user id.');   
}
if(empty($data['clientId'])){
  response(0,null,'Please enter the client id.');   
}
$userDetails=AuthUser($data['userId'],'string');
$userRole=$userDetails->roles[0];
if($userRole!='inspector'){
  response(0,null,'This api is authorise for the Inspector.');     
}
$checkClient=$wpdb->get_row('select * from `im_clients` where `id`="'.$data['clientId'].'" and `inspectorId`="'.$data['userId'].'"',ARRAY_A);
if(!empty($checkClient)){
    $getOwnerDetails=getOwnerDetails();
    $url=ISN_API.'client/'.$checkClient['clientId'].'?username='.$getOwnerDetails['username'].'&password='.$getOwnerDetails['password'];
    $response=deleteUsingCurl($url);
    $wpdb->query('delete from `im_clients` where `id`="'.$checkClient['id'].'"');
    response(1,'Client deleted successfully.','No Error found.');       
}else{
  response(0,null,'No Client found to delete.');       
}
?>