<?php
require '../wp-config.php';
$data = $_GET;
if(empty($data['username'])){
  response(0,array(),'Please enter the username.');   
}
if(empty($data['password'])){
  response(0,array(),'Please enter the password.');   
}
if(empty($data['address']) and  empty($data['reportNumber']) and empty($data['dateTime'])){
  response(0,array(),'Please enter the address/Report Number/Date and Time.');   
}
$limit=10;
if($data['offset']==''){
  response(0,array(),'Please enter the offset.');   
}else{
  $offset=$data['offset']*10;  
}
$records=getAllInspections($data);
$list=array();
if(isset($records['status']) and $records['status']=='ok'){
    $orders=array_slice($records['orders'],$offset,$limit);   
    $counter=0;
    if(!empty($orders)){         
         foreach($orders as $k=>$v){
             if($v['show']=='yes'){
                 $inspectionInfo=getInspectionDetailsById($v['id'],$data);
                 if(isset($inspectionInfo['status']) and $inspectionInfo['status']=='ok'){
                    $inspectorDetails=getUserNameById($inspectionInfo['order']['inspector1'],$data);
                    $list[$counter]['inspectionId']=$inspectionInfo['order']['id']; 
                    $list[$counter]['inspectorName']=$inspectorDetails['name']; 
                    $list[$counter]['inspectionType']=getInspectionTypeByOrdertype($data,$inspectionInfo['order']['ordertype']); 
                    $list[$counter]['phoneNumber']=$inspectorDetails['phoneNumber']; 
                    $list[$counter]['location']=$inspectorDetails['location']; 
                    $list[$counter]['date']=date('d M, Y',strtotime($inspectionInfo['order']['datetime'])); 
                    $list[$counter]['time']=date('h:i A',strtotime($inspectionInfo['order']['datetime'])); 
                    $counter++;
                 }                 
             }              
         }  
         response(1,$list,'No error found.');   
    }
    response(0,$list,'No data found.');    
}else{
   response(0,array(),'No data found.');    
}
?>