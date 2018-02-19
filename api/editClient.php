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
if(empty($data['fullName'])){
  response(0,null,'Please enter client name.');   
}
if(empty($data['phoneNumber'])){
  response(0,null,'Please enter the phone number.');   
}
if(empty($data['location'])){
  response(0,null,'Please enter the location.');   
}
if(empty($data['date'])){
  response(0,null,'Please enter the date.');
}
if(empty($data['inspectionDate'])){
  response(0,null,'Please enter the inspection date.');
}
if(empty($data['dateOfLoss'])){
  response(0,null,'Please enter the date of loss.');
}
$userDetails=AuthUser($data['userId'],'string');
$userRole=$userDetails->roles[0];
if($userRole!='inspector'){
  response(0,null,'This api is authorise for the Inspector.');     
}
$date='';
if(!empty($data['date'])){
    $date=date('Y-m-d',strtotime($data['date']));  
}
$dateOfLoss='';
if(!empty($data['dateOfLoss'])){
    $dateOfLoss=date('Y-m-d h:i:a',strtotime($data['dateOfLoss']));  
}
$inspectionDate='';
if(!empty($data['inspectionDate'])){
      $inspectionDate=date('Y-m-d h:i:a',strtotime($data['inspectionDate']));  
}
$checkClient=$wpdb->get_row('select * from `im_clients` where `id`="'.$data['clientId'].'" and `inspectorId`="'.$data['userId'].'"',ARRAY_A);
if(!empty($checkClient)){
    $newInspection=getClientInspectionDetails($checkClient['clientId']);
    $wpdb->query('update `im_clients` set `fullName`="'.$data['fullName'].'",`location`="'.$data['location'].'",`phoneNumber`="'.$data['phoneNumber'].'",`email`="'.$data['email'].'" where `id`="'.$checkClient['id'].'"');
    $wpdb->query('update `im_new_inspections` set  `jobNumber`="'.$data['jobNumber'].'", `date`="'.$date.'",`time`="'.$data['time'].'", `rehabbedAfterYear`="'.$data['rehabbedAfterYear'].'",`inspectionType`="'.$data['inspectionType'].'",`paymentType`="'.$data['paymentType'].'",`inspectionDate`="'.$inspectionDate.'",`inspectionTime`="'.$data['inspectionTime'].'",`isnNotes`="'.$data['isnNotes'].'",`insuaranceCompany`="'.$data['insuaranceCompany'].'",`policyNumber`="'.$data['policyNumber'].'",`claim`="'.$data['claim'].'",`insuaranceAdjuster`="'.$data['insuaranceAdjuster'].'",`claimCount`="'.$data['claimCount'].'",`dateOfLoss`="'.$dateOfLoss.'",`typeOfLoss`="'.$data['typeOfLoss'].'",`remedeationCompany`="'.$data['remedeationCompany'].'",`publicAdjuster`="'.$data['publicAdjuster'].'",`referralSource`="'.$data['referralSource'].'" where `id`="'.$newInspection['id'].'"');    
    response(1,'Client updated successfully.','No Error found.');       
}else{
  response(0,null,'No Client found to update.');       
}
?>