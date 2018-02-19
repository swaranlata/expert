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
global $wpdb;
$getAllClients=$wpdb->get_results('select * from `im_clients` where `inspectorId`="'.$data['userId'].'" order by id desc',ARRAY_A);  
$allClient=array();
if(!empty($getAllClients)){
    foreach($getAllClients as $k=>$v){
        $getInsDetails=getClientInspectionDetails($v['clientId']);
        $allClient[$k]=$getInsDetails;
        $allClient[$k]['userId']=$v['inspectorId'];
        $allClient[$k]['date']=date('d M,Y',strtotime($getInsDetails['date']));
        $allClient[$k]['inspectionDate']=date('d M,Y',strtotime($getInsDetails['inspectionDate']));
        $allClient[$k]['dateOfLoss']=date('d M,Y',strtotime($getInsDetails['dateOfLoss']));  
        $allClient[$k]['clientId']=$v['id'];
        $allClient[$k]['fullName']=$v['fullName'];
        $allClient[$k]['location']=$v['location'];
        $allClient[$k]['phoneNumber']=$v['phoneNumber'];
        $allClient[$k]['email']=$v['email'];
        $allClient[$k]['clientId']=$v['id'];
        unset($allClient[$k]['id']);
        unset($getInsDetails['id']);
    }
    response(1,$allClient,'No Error Found.'); 
}else{
   response(0,array(),'No Clients Found.'); 
}


?>