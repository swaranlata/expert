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

if(empty($data['fullName'])){
  response(0,null,'Please enter client name.');   
}
if(empty($data['phoneNumber'])){
  response(0,null,'Please enter the phone number.');   
}
if(empty($data['location'])){
  response(0,null,'Please enter the location.');   
}
if(empty($data['email'])){
     response(0,null,'Please enter your email.'); 
}else{
    if(empty(CheckValidEmail($data['email']))){
        response(0,null,'Please enter valid email.'); 
    }
}
if(empty($data['userId'])){
  response(0,null,'Please enter inspector id.');   
}
if(empty($data['date'])){
  response(0,null,'Please enter the date.');
}
if(empty($data['inspectionDate'])){
  response(0,null,'Please enter the inspection date.');
}
if(empty($data['dateOfLoss'])){
  response(0,null,'Please enter the date of loss.');
}if(empty($data['inspectionTime'])){
  response(0,null,'Please enter the inspection time.');
}
$saveDetails=addClient($data);
if(!empty($saveDetails)){
    $date=$data['date'];
    if(!empty($date)){
      $date=date('Y-m-d',strtotime($data['date']));
    }
    $dateOfLoss=$data['dateOfLoss'];
    if(!empty($dateOfLoss)){
      $dateOfLoss=date('Y-m-d H:i:a',strtotime($data['dateOfLoss']));
    }  
    $inspectionDate=$data['inspectionDate'];
    if(!empty($inspectionDate)){
      $inspectionDate=date('Y-m-d H:i:a',strtotime($data['inspectionDate']));
      $finalInspectionDate=date('Y-m-d',strtotime($data['inspectionDate']));
      $finalInspectionTime=date('H:i:s',strtotime($finalInspectionDate.' '.$data['inspectionTime']));  
    }
    $newQuery='insert into  `im_new_inspections`(`jobNumber`,`time`,`date`,`inspectorId`,`clientId`,`rehabbedAfterYear`,`inspectionType`,`paymentType`,`inspectionDate`,`inspectionTime`,`isnNotes`,`insuaranceCompany`,`policyNumber`,`claim`,`insuaranceAdjuster`,`claimCount`,`dateOfLoss`,`typeOfLoss`,`remedeationCompany`,`publicAdjuster`,`referralSource`) values("'.$data['jobNumber'].'","'.$data['time'].'","'.$date.'","'.$data['userId'].'","'.$saveDetails.'","'.$data['rehabbedAfterYear'].'","'.$data['inspectionType'].'","'.$data['paymentType'].'","'.$inspectionDate.'","'.$data['inspectionTime'].'","'.$data['isnNotes'].'","'.$data['insuaranceCompany'].'","'.$data['policyNumber'].'","'.$data['claim'].'","'.$data['insuaranceAdjuster'].'","'.$data['claimCount'].'","'.$dateOfLoss.'","'.$data['typeOfLoss'].'","'.$data['remedeationCompany'].'","'.$data['publicAdjuster'].'","'.$data['referralSource'].'")';
    $wpdb->query($newQuery);
    $newiNspectionId=$wpdb->insert_id;
    if(!empty($newiNspectionId)){
        $newData = array(
            'datetime' =>$finalInspectionDate.' '.$finalInspectionTime,
            'inprogress' => '0',
            'scheduled' => $finalInspectionDate.' '.$finalInspectionTime,
            'address1' => $data['location'],
            'address2' =>'',
            'city' =>'',
            'state' =>'',
            'zip' => '',
            'latitude' => '',
            'longitude' => '',
            'duration' => '',
            'squarefeet' => '',
            'yearbuilt' => '',
            'reportnumber' => '',
            'salesprice' => '',
            'ordertype' => getInspectionTypeByOrdertypeName($data['inspectionType']),
            'clientuuid' => getClientId($saveDetails),
            'buyersagentuuid' => '',
            'sellersagentuuid' => '',
            'inspector1uuid' =>getInspectorId($data['userId']),
            'fees' => ''
        );
        $getOwnerDetails=getOwnerDetails();
        $url=ISN_API.'order?username='.$getOwnerDetails['username'].'&password='.$getOwnerDetails['password'];
        $response=useCurl($url,$newData);
        $final['newInspection']=$data;
        $final['newInspection']['newInspectionId']=(string) $newiNspectionId;
        $wpdb->query('update `im_new_inspections` set `isnInspectionId`="'.$response['id'].'" where `id`="'.$newiNspectionId.'"');
}
     $data['clientId']=(string) $saveDetails;
     response(1,$data,'No Error Found.');
}else{
    response(0,null,'Something wrong please try again later.'); 
}
?>