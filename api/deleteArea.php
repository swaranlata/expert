<?php
require '../wp-config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
global $wpdb;
if(empty($data['userId'])){
 response(0,null,'Please enter the user id.');
}
if(empty($data['areaId'])){
 response(0,null,'Please enter the area id.');
}
$loggedInUser=AuthUser($data['userId'],'string');
$roles=$loggedInUser->roles[0];
if($roles!='inspector'){
    response(0,null,'You are not authorise to access this api.'); 
}
$query='select * from `im_areas` where `id`="'.$data['areaId'].'" and `opponentId`="'.$data['userId'].'"';
$res=$wpdb->get_row($query,ARRAY_A);
if(!empty($res)){
    $query=$wpdb->query('delete from `im_notifications` where `id`="'.$res['id'].'"');
    response(1,'Notification deleted successfully.','No Error Found.');   
}else{
   response(0,null,'No Notification found to delete.'); 
}

?>