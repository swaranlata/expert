<?php
require '../wp-config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data,true);
if(empty($data['userId'])){
  response(0,null,'Please enter the user id.');   
}
if(empty($data['imageId'])){
  response(0,null,'Please enter the image id.');   
}
$userDetails=AuthUser($data['userId'],'string');
$userRole=$userDetails->roles[0];
if($userRole!='inspector'){
  response(0,null,'This api is authorise for the Inspector.');     
}    
$getImage=$wpdb->get_row('select * from `im_images` where `id`="'.$data['imageId'].'"',ARRAY_A);
if(!empty($getImage)){
    $wpdb->query('delete from `im_images` where `id`="'.$getImage['id'].'"');    
    response(1,'Image deleted successfully.','No Error found.');   
}else{
    response(0,null,'No Image found.'); 
} 
?>