<?php
require '../wp-config.php';
$encoded_data = file_get_contents('php://input');
$data = json_decode($encoded_data, true);
if(empty($data['userId'])){
  response(0,null,'Please enter inspector id.');   
}
AuthUser($data['userId'],'string');
$inspector=get_user_by('id',$data['userId']);
$roles=$inspector->roles[0];
if($roles!='inspector'){
    response(0,null,'You are not authorise to create client.'); 
}
if(empty($data['inspectionDate'])){
  response(0,null,'Please enter the inspection date.');
}
if(empty($data['dateOfLoss'])){
  response(0,null,'Please enter the date of loss.');
}
if(empty($data['clientId'])){
  response(0,null,'Please enter the client id.');
}
if(empty($data['isnInspectorId'])){
  //response(0,null,'Please enter the client id.');
}
$dateOfLoss=$data['dateOfLoss'];
if(!empty($dateOfLoss)){
  $dateOfLoss=date('Y-m-d h:i:s',strtotime($data['dateOfLoss']));
}  
$inspectionDate=$data['inspectionDate'];
if(!empty($inspectionDate)){
  $inspectionDate=date('Y-m-d h:i:s',strtotime($data['inspectionDate']));
  $finalInspectionDate=date('Y-m-d',strtotime($data['inspectionDate']));
  $finalInspectionTime=date('H:i:s',strtotime($finalInspectionDate.' '.$data['inspectionTime']));
}
$query='insert into  `im_new_inspections`(`inspectorId`,`clientId`,`rehabbedAfterYear`,`inspectionType`,`paymentType`,`inspectionDate`,`inspectionTime`,`isnNotes`,`insuaranceCompany`,`policyNumber`,`claim`,`insuaranceAdjuster`,`claimCount`,`dateOfLoss`,`typeOfLoss`,`remedeationCompany`,`publicAdjuster`,`referralSource`) values("'.$data['userId'].'","'.$data['clientId'].'","'.$data['rehabbedAfterYear'].'","'.$data['inspectionType'].'","'.$data['paymentType'].'","'.$inspectionDate.'","'.$data['inspectionTime'].'","'.$data['isnNotes'].'","'.$data['insuaranceCompany'].'","'.$data['policyNumber'].'","'.$data['claim'].'","'.$data['insuaranceAdjuster'].'","'.$data['claimCount'].'","'.$dateOfLoss.'","'.$data['typeOfLoss'].'","'.$data['remedeationCompany'].'","'.$data['publicAdjuster'].'","'.$data['referralSource'].'")';
$wpdb->query($query);
$lastId= $wpdb->insert_id;  
if(!empty($lastId)){
    $newData = array(
        'datetime' =>$finalInspectionDate.' '.$finalInspectionTime,
        'inprogress' => '0',
        'scheduled' => $finalInspectionDate.' '.$finalInspectionTime,
        'address1' => $data['address1'],
        'address2' =>$data['address2'],
        'city' =>$data['city'],
        'state' => $data['state'],
        'zip' => $data['zip'],
        'latitude' => '',
        'longitude' => '',
        'duration' => '',
        'squarefeet' => '',
        'yearbuilt' => '',
        'reportnumber' => '',
        'salesprice' => '',
        'ordertype' => getInspectionTypeByOrdertypeName($data['inspectionType']),
        'clientuuid' => $data['clientId'],
        'buyersagentuuid' => '',
        'sellersagentuuid' => '',
        'inspector1uuid' =>  getInspectorId($data['userId']),
        'fees' => ''
    );  
    $getOwnerDetails=getOwnerDetails();
    $url=ISN_API.'order?username='.$getOwnerDetails['username'].'&password='.$getOwnerDetails['password'];
    $response=useCurl($url,$newData); 
    if($response['status']=='ok'){
        $wpdb->query('update `im_new_inspections` set `isnInspectionId`="'.$response['id'].'" where `id`="'.$lastId.'"');
        $final['newInspection']=$data;
        $final['newInspection']['newInspectionId']=(string) $lastId;  
        response(1,$final,'No Error Found.');
    }else{
    response(0,null,'Something wrong please try again later.'); 
    } 
}else{
    response(0,null,'Something wrong please try again later.'); 
}
?>