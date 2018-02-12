<?php 
require '../wp-config.php';
$pageDetails=getTermsConditions();
if(!empty($pageDetails)){
    $array['title']=$pageDetails[0]->post_title;
    $array['content']=strip_tags($pageDetails[0]->post_content);
    response(1,$array,'No Error Found.');
}else{
    response(0,null,'No Data Found.');  
}

?>