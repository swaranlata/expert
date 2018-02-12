<?php
require '../wp-config.php';
$encoded_data = file_get_contents('php://input');
$data = $_POST;
if(empty($data['userId'])){
  response(0,null,'Please enter the user id.');   
}
if(empty($data['key'])){
  response(0,null,'Please enter the key.');   
}
if(empty($_FILES['file']['name'])){
  response(0,null,'Please enter the file.');   
}
$userDetails=AuthUser($data['userId'],'string');
$userRole=$userDetails->roles[0];
if($userRole!='inspector'){
  response(0,null,'This api is authorise for the Inspector.');     
}
$upload_dir = wp_upload_dir();     
$upload_dir['path'];
$file_name = uniqid() . '.png';
$file = $upload_dir['path'].'/'.$file_name;
$return = str_replace(site_url(),'',$upload_dir['url'].'/'.$_FILES['file']['name']);
move_uploaded_file($_FILES['file']['tmp_name'],$upload_dir['path'].'/'.$_FILES['file']['name']); 
$checkRecord=$wpdb->get_row('select * from `im_images` where `imageKey`="'.$data['key'].'"',ARRAY_A);
if(!empty($checkRecord)){
 $wpdb->query('update `im_images` set `images`="'.$return.'" where `id`="'.$checkRecord['id'].'"');
}
$last=$checkRecord['id'];  
$array['imageId']=$last;
$array['key']=$data['key'];
$array['imageUrl']=site_url().$return;    
response(1,$array,'No Error found.');     
?>