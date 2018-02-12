<?php
require '../wp-config.php';
$data = $_GET;
AuthUser($data['userId'],array());
$inspector=get_user_by('id',$data['userId']);
$roles=$inspector->roles[0];
if($roles!='inspector'){
    response(0,array(),'You are not authorise to access the apis.'); 
}
global $wpdb;
$rows=$wpdb->get_results('select * from `im_notifications` where `opponentId`="'.$data['userId'].'" order by id desc',ARRAY_A);
$finalArray=array();
if(!empty($rows)){
   foreach($rows as $k=>$v){
     $finalArray[$k]['title']=$v['title'];  
     $finalArray[$k]['date']=date('d/m/Y',strtotime($v['created']));  
     $finalArray[$k]['time']=date('h:i:s A',strtotime($v['created']));    
   } 
    response(1,$finalArray,'No notificatiosn found.');
}else{
    response(0,array(),'No notificatiosn found.');
}

?>