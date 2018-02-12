<?php
require '../wp-config.php';
$data = $_GET;
if(empty($data['username'])){
  response(0,null,'Please enter the username.');   
}
if(empty($data['password'])){
  response(0,null,'Please enter the password.');   
}
if(empty($data['daysahead'])){
  response(0,null,'Please enter the date.');   
}
if(empty($data['inspector'])){
  response(0,null,'Please enter the user id.');   
}
$records=getInspectorSchedule($data);
$list=array();
if(isset($records['status']) and $records['status']=='ok'){
    if(!empty($records['slots'])){
         foreach($records['slots'] as $k=>$v){
              $list[$k]['userId']=$v['userid']; 
              $list[$k]['startDate']=$v['start']; 
              $list[$k]['endDate']=$v['end']; 
              $list[$k]['firstName']=$v['userfirst']; 
              $list[$k]['lastName']=$v['userlast'];         
         }  
         response(1,$list,'No error found.');   
    }
    response(0,$list,'No data found.');    
}else{
   response(0,array(),'No data found.');    
}
?>