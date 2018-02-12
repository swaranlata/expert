<?php
require '../wp-config.php';
$data = $_GET;
if(empty($data['username'])){
  response(0,null,'Please enter the username.');   
}
if(empty($data['password'])){
  response(0,null,'Please enter the password.');   
}
if(empty($data['selectedDate'])){
  response(0,null,'Please enter the date.');   
}
$limit=10;
if($data['offset']==''){
  response(0,null,'Please enter the offset.');   
}else{
  $offset=$data['offset']*10;  
}
$records=getAllClients($data);
$list=array();
if(isset($records['status']) and $records['status']=='ok'){
    $clients=array_slice($records['clients'],$offset,$limit);
    $counter=0;
    if(!empty($clients)){         
         foreach($clients as $k=>$v){
             if($v['show']=='yes'){
                 $clientInfo=getClientDetailsById($v['id'],$data);
                 if(isset($clientInfo['status']) and $clientInfo['status']=='ok'){
                   $list[$counter]['clientId']=$clientInfo['client']['id'];  
                   $list[$counter]['fullName']=$clientInfo['client']['display'];  
                   $list[$counter]['firstName']=$clientInfo['client']['first'];  
                   $list[$counter]['lastName']=$clientInfo['client']['last'];  
                   $list[$counter]['email']=$clientInfo['client']['email']; 
                   $mobile='';
                   if(!empty($clientInfo['client']['mobilephone'])){
                     $mobile=$clientInfo['client']['mobilephone'];
                   }
                   $list[$counter]['mobilePhoneNumber']=(string) $mobile;  
                   $home='';
                   if(!empty($clientInfo['client']['homephone'])){
                     $home=$clientInfo['client']['homephone'];
                   }
                   $list[$counter]['homePhoneNumber']=(string) $home;  
                   $list[$counter]['date']=date('d M, Y',strtotime($clientInfo['client']['modified']));  
                   $list[$counter]['time']=date('h:i A',strtotime($clientInfo['client']['modified']));  
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