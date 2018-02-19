<?php
require '../wp-config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
global $wpdb;
if(empty($data['userId'])){
 response(0,null,'Please enter the user id.');
}
if(empty($data['sampleId'])){
 response(0,null,'Please enter the sample id.');
}
$loggedInUser=AuthUser($data['userId'],'string');
$roles=$loggedInUser->roles[0];
if($roles!='inspector'){
    response(0,null,'You are not authorise to access this api.'); 
}
$query='select * from `im_samples` where `id`="'.$data['sampleId'].'"';
$res=$wpdb->get_row($query,ARRAY_A);
if(!empty($res)){
    $query=$wpdb->query('delete from `im_samples` where `id`="'.$res['id'].'"');
    response(1,'Sample deleted successfully.','No Error Found.');   
}else{
    response(0,null,'No sample found to delete.'); 
}

?>