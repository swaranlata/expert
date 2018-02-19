<?php
require '../wp-config.php';
$data = $_GET;
if(empty($data['username'])){
  response(0,array(),'Please enter the username.');   
}
if(empty($data['password'])){
  response(0,array(),'Please enter the password.');   
}
if(!isset($data['offset']) || $data['offset']==''){
  response(0,array(),'Please enter the offset.');   
}
$offset=$data['offset']*10;
$limit=10;
$scheduleList=getMyInspectionScheduleList($data);
$orders=array();
if(!empty($scheduleList)){
   if($scheduleList['status']=='ok'){
        $orders=array_slice($scheduleList['footprints'],$offset,$limit);   
        $counter=0;
        if(!empty($orders)){         
         foreach($orders as $k=>$v){
             $inspectionInfo=getInspectionDetailsById($v['order'],$data);
             if(isset($inspectionInfo['status']) and $inspectionInfo['status']=='ok'){
                $clientDetails=getClientDetailsById($v['client'],$data);
                 $name='';
                 $mobile='';
                if($clientDetails['status']=='ok'){
                    $name=$clientDetails['client']['display'];
                    $mobile=$clientDetails['client']['mobilephone'];
                }
                $list[$counter]['inspectionId']=$v['order']; 
                $list[$counter]['clientName']=$name; 
                $list[$counter]['inspectionType']=ucfirst(getInspectionTypeByOrdertype($data,$inspectionInfo['order']['ordertype'])); 
                $list[$counter]['phoneNumber']=$mobile; 
                $list[$counter]['address1']=$v['address1']; 
                $list[$counter]['address2']=$v['address2']; 
                $list[$counter]['city']=$v['city']; 
                $list[$counter]['state']=$v['state']; 
                $list[$counter]['zip']=$v['zip']; 
                $dateAndTime=explode('T',$v['datetime']);
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
                $list[$counter]['date']=date('d M, Y',strtotime($date)); 
                $list[$counter]['time']=$time; 
                $list[$counter]['startTime']=$startTime; 
                $counter++;
             }                 
         }  
         response(1,$list,'No error found.');   
        }
        response(0,array(),'No data found.');
   }else{
     response(0,array(),$scheduleList['message']);  
   }
}else{
   response(0,array(),'No Data Found');     
}
?>