<?php
require '../wp-config.php';
$data = $_GET;
if(empty($data['username'])){
  response(0,null,'Please enter the username.');   
}
if(empty($data['password'])){
  response(0,null,'Please enter the password.');   
}
$username=$data['username'];
$password=$data['password'];
$records=getUserInformation($data);
if(isset($records['status']) and $records['status']=='ok'){
    if($records['me']['inspector']=='Yes'){
        $emailExists=email_exists($records['me']['emailaddress']);
        $usernameExists=username_exists($username);
        if(!empty($emailExists) or !empty($usernameExists)){
                    if(!empty($emailExists)){
                       $user_id= $emailExists;
                    }else{
                       $user_id= $usernameExists; 
                    }                    
                    wp_update_user(array(
                        'ID' => $user_id,
                        'display_name' => $records['me']['firstname'].' '.$records['me']['lastname']
                    )); 
                    update_user_meta($user_id,'first_name',$records['me']['firstname']);
                    update_user_meta($user_id,'last_name',$records['me']['lastname']);
                    update_user_meta($user_id,'deviceToken',$data['deviceToken']);  
                    update_user_meta($user_id,'deviceType',$data['deviceType']);  
                    $u = new WP_User($user_id);
                    $u->remove_role('subscriber');
                    $u->set_role('inspector');                   
                }
        else{
                     $user_id = wp_create_user($username,$password,$records['me']['emailaddress']);
                     wp_update_user(array(
                     'ID' => $user_id,
                     'display_name' => $records['me']['firstname'].' '.$records['me']['lastname']
                    )); 
                    update_user_meta($user_id,'first_name',$records['me']['firstname']);
                    update_user_meta($user_id,'last_name',$records['me']['lastname']);  
                    update_user_meta($user_id,'deviceToken',$data['deviceToken']);  
                    update_user_meta($user_id,'deviceType',$data['deviceType']);  
                    update_user_meta($user_id,'is_enable_notification',1);  
                    update_user_meta($user_id,'admin_color','coffee');
                }
        $finalArray=$records['me'];
        $finalArray['userId']=(string) $user_id;
        $finalArray['is_enable_notification']=(string) get_user_meta($user_id,'is_enable_notification',true);
        response(1,$finalArray,'No Error Found.');   
    }else{
       response(0,null,'Please check your usertype.');  
    }
}else{
   response(0,null,'Invalid Username and password combination.');    
}
?>