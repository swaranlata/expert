<?php
require '../wp-config.php';
$data = $_GET;
if(empty($data['userId'])){
  response(0,array(),'Please enter the user id.');   
}
AuthUser($data['userId'],array());
$userDetails=get_user_by('id',$data['userId']);
$userRole=$userDetails->roles[0];
if($userRole!='inspector'){
  response(0,array(),'This api is authorise for the Inspector.');     
}
$records=getSampleType();
$array=array();
if(!empty($records)){
    foreach($records as $k=>$v){
     $array[$k]['sampleId']=$v->ID;   
     $array[$k]['sampleTitle']=$v->post_title;   
    }
    response(1,$array,'No Error Found.');  
}else{
    response(0,array(),'No Data Found.');     
}

?>