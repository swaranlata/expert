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
    $wpdb->query('update `im_clients` set `fullName`="'.$data['fullName'].'",`location`="'.$data['location'].'",`phoneNumber`="'.$data['phoneNumber'].'",`email`="'.$data['email'].'",`jobNumber`="'.$data['jobNumber'].'",`date`="'.$data['date'].'",`time`="'.$data['time'].'",`rehabbedAfterYear`="'.$data['rehabbedAfterYear'].'",`inspectionType`="'.$data['inspectionType'].'",`paymentType`="'.$data['paymentType'].'",`inspectionDate`="'.$data['inspectionDate'].'",`inspectionTime`="'.$data['inspectionTime'].'",`isnNotes`="'.$data['isnNotes'].'",`insuaranceCompany`="'.$data['insuaranceCompany'].'",`policyNumber`="'.$data['policyNumber'].'",`claim`="'.$data['claim'].'",`insuaranceAdjuster`="'.$data['insuaranceAdjuster'].'",`claimCount`="'.$data['claimCount'].'",`dateOfLoss`="'.$data['dateOfLoss'].'",`typeOfLoss`="'.$data['typeOfLoss'].'",`remedeationCompany`="'.$data['remedeationCompany'].'",`publicAdjuster`="'.$data['publicAdjuster'].'",`referralSource`="'.$data['referralSource'].'" where `id`="'.$checkClient['id'].'"');
    response(1,'Client updated successfully.','No Error found.');       
}else{
  response(0,null,'No Client found to update.');       
}
?>