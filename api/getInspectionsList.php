<?php
require '../wp-config.php';
global $wpdb;
$data = $_GET;
if(empty($data['userId'])){
  response(0,array(),'Please enter the user id.');   
}if(empty($data['username'])){
  response(0,array(),'Please enter the user name.');   
}if(empty($data['password'])){
  response(0,array(),'Please enter the password.');   
}
if($data['type']==''){//0-submitted,1-approved,2-rejected
  response(0,array(),'Please select the inspection type.');   
}
$authorizeUser=AuthUser($data['userId'],array());
$role=$authorizeUser->roles[0];
if($role=='inspector'){
    $rows=$wpdb->get_results('select `inspectionId` from `im_inspection_assignments` where `inspectorId`="'.$data['userId'].'"',ARRAY_A);
    $allInspections=array();
    if(!empty($rows)){
        foreach($rows as $k=>$v){
           $allInspections[]=$v['inspectionId']; 
        }
        $inspections=implode('","',$allInspections);
        if(empty($data['type'])){//0-submitted
           $query='select * from  `im_inspection_details` where id in("'.$inspections.'") and `status`="0"';
        }elseif($data['type']=='1'){//1-approved
           $query='select * from  `im_inspection_details` where id in("'.$inspections.'") and `status`="2"';
        }else{//2-rejected
           $query='select * from  `im_inspection_details` where id in("'.$inspections.'") and `status`="3"'; 
        } 
        $records=$wpdb->get_results($query,ARRAY_A);
        $finalArray=array();
        if(!empty($records)){
            foreach($records as $k=>$v){
                $details=array('username'=>$data['username'],'password'=>$data['password']);
                $inspectionInfo=getInspectionDetailsById($v['inspectionId'],$details);
                 $name='';
                 $mobile='';
                 $city='';
                 $state='';
                 $address1='';
                 $address2='';
                 $zip='';
                if(isset($inspectionInfo['status']) and $inspectionInfo['status']=='ok'){
                    $clientDetails=getClientDetailsById($inspectionInfo['order']['client'],$details);
                    
                    if($clientDetails['status']=='ok'){
                        $name=$clientDetails['client']['display'];
                        $mobile=$clientDetails['client']['mobilephone'];
                         $city=$clientDetails['client']['city'];
                         $state=$clientDetails['client']['state'];
                         $address1=$clientDetails['client']['address1'];
                         $address2=$clientDetails['client']['address2'];
                         $zip=$clientDetails['client']['zip'];
                         $email=$clientDetails['client']['email'];
                    }
                }
                $finalArray[$k]=$v;
                $finalArray[$k]['localInspectionId']=$v['id'];                
                $finalArray[$k]['inspectionType']=getInspectionTypeByOrdertype($details,$inspectionInfo['order']['ordertype']); ;    
                $finalArray[$k]['clientName']=$name;    
                $finalArray[$k]['phoneNumber']=$mobile;    
                $finalArray[$k]['address1']=$address1;    
                $finalArray[$k]['address2']=$address2;    
                $finalArray[$k]['city']=$city;    
                $finalArray[$k]['state']=$state;    
                $finalArray[$k]['email']=$email;    
                $finalArray[$k]['zip']=$zip; 
                $dateAndTime=explode(' ',$inspectionInfo['order']['datetimeformatted']);
                $date='';
                $time='';
                if(!empty($dateAndTime)){
                    $date=$dateAndTime[0];
                    $time=$dateAndTime[1];  
                }
                 $startTime='';
                if(!empty($time)){
                  $start=explode('-',$time);   
                  $startTime=$start[0];
                }
                $finalArray[$k]['date']=date('d M, Y',strtotime($date)); 
                $finalArray[$k]['time']=$time; 
                $finalArray[$k]['startTime']=$startTime; 
                unset($finalArray[$k]['id']);
            }
          response(1,$finalArray,'No inspection found.');
        }else{
         response(0,array(),'No inspection found.');       
        }
    }else{
        response(0,array(),'No inspection found.');    
    }
}else{
  response(0,array(),'Only inspector can view the inspections.');     
}



?>