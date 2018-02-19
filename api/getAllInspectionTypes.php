<?php
require '../wp-config.php';
$data = $_GET;
global $wpdb;
if(empty($data['userId'])){
  response(0,array(),'Please enter the user id.');
}
$loggedUser=AuthUser($data['userId'],array());
$userDetails=get_user_by('id',$data['userId']);
$userRole=$userDetails->roles[0];
if($userRole!='inspector'){
  response(0,array(),'This api is authorise for the Inspector.');     
}
$getAllInspectionTypes=getAllInspectionTypes();
if(!empty($getAllInspectionTypes)){
    foreach($getAllInspectionTypes as $k=>$v){
        $category_detail=get_the_terms($v->ID,'inspectiontypes');
        if(!empty($category_detail)){
           $type=str_replace('-inspections','',$category_detail[0]->slug); 
        }else{
            $type='';
        }
        $finalArray[$k]['name']=$v->post_title;
        $finalArray[$k]['type']=$type;
    }
   response(1,$finalArray,'No Error Found.');
}else{
   response(0,array(),'No Data Found.');  
}
?>