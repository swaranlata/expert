<?php
require '../wp-config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
global $wpdb;
if(empty($data['userId'])){
 response(0,null,'Please enter the user id.');
}
if(empty($data['inspectionId'])){
 response(0,null,'Please enter the inspection id.');
}
$loggedInUser=AuthUser($data['userId'],'string');
$roles=$loggedInUser->roles[0];
if($roles!='inspector'){
    response(0,null,'You are not authorise to access this api.'); 
}
$query='select * from `im_inspection_details` where `id`="'.$data['inspectionId'].'"';
$res=$wpdb->get_row($query,ARRAY_A);
if(!empty($res)){
    $inspectionId=$res['inspectionId'];
    $getOwnerDetails=getOwnerDetails();
    echo$url=ISN_API.'order/'.$inspectionId.'?username='.$getOwnerDetails['username'].'&password='.$getOwnerDetails['password'];
    $response=deleteUsingCurl($url);
    $results=$wpdb->get_results('select * from `im_areas` where `inspectionId`="'.$inspectionId.'"');
    $wpdb->query('delete from `im_inspection_details` where `id`="'.$res['id'].'"'); 
    $wpdb->query('delete from `im_inspection_assignments` where `inspectionId`="'.$res['id'].'"'); 
    $wpdb->query('delete from `im_labreports` where `inspectionId`="'.$res['id'].'"'); 
    $wpdb->query('delete from `im_conversations` where `inspectionId`="'.$res['id'].'"'); 
    if(!empty($results)){
        foreach($results as $k=>$v){
           $query=$wpdb->query('delete from `im_areas` where `id`="'.$v['id'].'"'); 
           $wpdb->query('delete from `im_issues` where `areaId`="'.$v['id'].'"');
           $wpdb->query('delete from `im_samples` where `areaId`="'.$v['id'].'"');
        }
    }
    response(1,'Areas deleted successfully.','No Error Found.');   
}else{
    response(0,null,'No Area found to delete.'); 
}

?>