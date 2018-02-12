<?php
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );
define('ISN_API','https://goisn.net/moldexpert/rest/');
session_cache_limiter ('private, must-revalidate');    
$cache_limiter = session_cache_limiter();
session_cache_expire(60);
//date_default_timezone_set("Asia/Calcutta");
define('FROM_MAIL','swaran.lata@imarkinfotech.com');
define('FROM_NAME','Swaran Lata');
/*define('CUSTOM_ADMIN_URL',site_url().'/'.get_option('whl_page'));*/
define('CUSTOM_ADMIN_URL',admin_url());

    function my_theme_enqueue_styles() {

        $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

        wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
        wp_enqueue_style( 'child-style',
            get_stylesheet_directory_uri() . '/style.css',
            array( $parent_style ),
            wp_get_theme()->get('Version')
        );
    }
    add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

    add_action( 'admin_enqueue_scripts', 'load_custom_script' );
    function load_custom_script() {    
        if(is_admin()){
            wp_enqueue_script('custom_admin_script',get_stylesheet_directory_uri().'/js/admin_script.js','',true);
        }   
    }
    function getSampleType(){
        $posts = get_posts(
                    array(
                       'post_type' => 'sampletypes'
                    )
                );
        return $posts;
    }
  
    function pr($array = null) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
        die;
    }

    function response($success = null, $result = null, $error = null) {
        echo json_encode(array(
        'success' => $success,
        'result' => $result,
        'error' => $error),JSON_UNESCAPED_UNICODE);
        die;
    }

    function convert_array($array = null) {
        $finalArray = json_decode($array,true);
        return $finalArray;
    }

    function AuthUser($id = null, $error_type = null) {
        global $wpdb;
        $results = get_user_by('id',$id);
         if(empty($results)){
            if ($error_type == 'string') {
                response(0, null, 'You are not authorise to access this content.');
            } else {
                response(0, $error_type, 'You are not authorise to access this content.');
            }
        }else{
            return $results;
        }    
    }

    function checkPhoneValid($phone=null){
        if(!empty($phone)){
          if(!is_numeric($phone)){
            response(0, null, 'Please enter valid Phone number.');    
          }  
        }        
    }

    /* Valid Email Format Check*/
    function CheckValidEmail($email=null){
        $status=1;
        if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$email))
        { 
         $status=0; 
        }  
        return $status;
    }

    /* Send Email */
    function send_email($email=null,$subject=null,$content=null){
        $headers[] = 'From: '.FROM_NAME.' <'.FROM_MAIL.'>';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        wp_mail($email,$subject,$content,$headers); 
    }

        /* change Date format*/
    function inputChangeDate($inputDate=null){
      $date=str_replace('/','-',$inputDate);
      $date=date('m/d/Y',strtotime($date));
      return $date;
    }

    function getContentFromUrl($url=null){
       $response= file_get_contents($url);
       return $response=convert_array($response);
    }
    function getInspectionType($orderType=null,$data=null){
        $data=array('username'=>'swaran','password'=>'admin@123');
        return getInspectionTypeByOrdertype($data=null,$ordertype=null);
    }

    function getUserInformation($data=null){
       $url= ISN_API.'me?username='.$data['username'].'&password='.$data['password'];
       return $results=getContentFromUrl($url);  
    }

    /* Get Inspector Schedule */
    function getInspectorSchedule($data=null){
       $url= ISN_API.'availableslots?username='.$data['username'].'&password='.$data['password'].'&daysahead='.$data['daysahead'].'&inspector='.$data['inspector'];
       return $results=getContentFromUrl($url);  
    }

    /* Get All Clients*/
    function getAllClients($data=null){
       $url= ISN_API.'clients?username='.$data['username'].'&password='.$data['password'].'&after='.$data['selectedDate'];
       return $results=getContentFromUrl($url);  
    }

    /* Get Client details by Client ID */
    function getClientDetailsById($clientID=null,$data=null){
        $url= ISN_API.'client/'.$clientID.'?username='.$data['username'].'&password='.$data['password'];
        return $results=getContentFromUrl($url); 
    }

    /* Get All Inspections */
    function getAllInspections($data=null){
          $url= ISN_API.'orders/search?username='.$data['username'].'&password='.$data['password'].'&address1='.$data['address'].'&reportnumber='.$data['reportNumber'].'&datetime='.$data['dateTime'];
         return $results=getContentFromUrl($url);  
    }

    /* Get Inspection by Inspection ID */
    function getInspectionDetailsById($inspectionID=null,$data=null){
        $url= ISN_API.'order/'.$inspectionID.'?username='.$data['username'].'&password='.$data['password'].'&withallcontrols=1';
        return $results=getContentFromUrl($url); 
    }

    /* Get User Name */
    function getUserNameById($userID=null,$data=null){
        $url= ISN_API.'user/'.$userID.'?username='.$data['username'].'&password='.$data['password'];
        $results=getContentFromUrl($url); 
        $array=array();
        if(isset($results['status']) and $results['status']=='ok'){
          if($results['user']){
                $array['name']=$results['user']['displayname'];
                $mobile='';
                if(!empty($results['user']['phone'])){
                $mobile=$results['user']['phone'];
                } 
                $array['phoneNumber']=$mobile;
                $location='';
                if(!empty($results['user']['address1'])){
                  $location.=$results['user']['address1'].',';
                } 
                if(!empty($results['user']['city'])){
                  $location.=$results['user']['city'].',';
                } 
                if(!empty($results['user']['stateabbreviation'])){
                  $location.=$results['user']['stateabbreviation'].',';
                }
                if(!empty($results['user']['county'])){
                  $location.=$results['user']['county'];
                }
                $array['location']=$location;              
          }  
        }
        return $array;
    }
    /* Get Inspection Type by order type*/
    function getInspectionTypeByOrdertype($data=null,$ordertype=null){
        $url= ISN_API.'ordertypes?username='.$data['username'].'&password='.$data['password'];
        $results=getContentFromUrl($url);
        $inspectionName='';
        if(!empty($results['ordertypes'])){
            foreach($results['ordertypes'] as $k=>$v){
               if($v['id']==$ordertype){
                $inspectionName=str_replace(PHP_EOL, '', $v['name']);
                $inspectionName = preg_replace("/[\n\r]/","",$inspectionName); 
              }  
            }
        }
        $inspectionName=str_replace(' ','-',strtolower($inspectionName));
        $post=get_page_by_path( 'the_slug', $inspectionName, 'inspectiontypes');
        $id = $post->ID;
        $category_detail=get_terms($id);//$post->ID
        $catName='';
        if(!empty($category_detail)){
           foreach($category_detail as $cd){
                $catName=str_replace('-inspections','',$cd->slug);
            } 
        }
        return $catName;
    }

    /* Get My Inspection Schedule list */
    function getMyInspectionScheduleList($data=null){
       $url= ISN_API.'orders/footprints?username='.$data['username'].'&password='.$data['password'];
       $results=getContentFromUrl($url);
       return $results;
    }
    /* Get My Contact details by id*/
    function getContactDetailsById($contactId=null,$data=null){
       $url= ISN_API.'contact/'.$contactId.'?username='.$data['username'].'&password='.$data['password'];
       $results=getContentFromUrl($url);
       return $results;
    }
    /* Get My Contact details by id*/
    function getBuyerDetailsById($buyersId=null,$data=null){
        $url= ISN_API.'agent/'.$buyersId.'?username='.$data['username'].'&password='.$data['password'];
        $results=getContentFromUrl($url);
        return $results;
    }
    /* Save Inspecton Details */
    function saveInspectionDetails($data=null){
        global $wpdb;
        $getRow=$wpdb->get_row('select * from `im_inspection_details` where `inspectionId`="'.$data['inspectionId'].'"');
        if(!empty($getRow)){
          response(0,null,'Inspection already started.');
        }
        $wpdb->query('insert into `im_inspection_details`(`inspectionId`,`enviornmentType`,`hvacSystemValue`,`outdoorTemprature`,`hvacSystem`,`bullets`,`ductwork`,`outdoorRh`,`hvacSystemVisual`,`inspectionDate`,`inspectionTime`) values("'.$data['inspectionId'].'","'.$data['enviornmentType'].'","'.$data['hvacSystemValue'].'","'.$data['outdoorTemprature'].'","'.$data['hvacSystem'].'","'.$data['bullets'].'","'.$data['ductwork'].'","'.$data['outdoorRh'].'","'.$data['hvacSystemVisual'].'","'.$data['inspectionDate'].'","'.$data['inspectionTime'].'")');
        $lastid = $wpdb->insert_id;
        if(!empty($data['images'])){
            foreach($data['images'] as $imgKey=>$imgVal){
                $wpdb->query('insert into `im_images`(`areaId`,`imageKey`,`imageType`,`type`) values("'.$lastid.'","'.$imgVal['key'].'","0","3")');
            }
        }
        $getInspectionImages=getInspectionImages($lastid,'image');
        $allInspectionImages=array();
        if(!empty($getInspectionImages)){
          foreach($getInspectionImages as $k=>$v){
             $allInspectionImages['imageId']=$v['id'];  
             $allInspectionImages['key']=$v['imgKey'];  
             $allInspectionImages['imageUrl']=$v['images'];  
          }  
        }
        $data['images']=$allInspectionImages;        
        if(!empty($data['diagram'])){
            foreach($data['diagram'] as $imgKey=>$imgVal){
                $wpdb->query('insert into `im_images`(`areaId`,`imageKey`,`imageType`,`type`) values("'.$lastid.'","'.$imgVal['key'].'","1","3")');
            }
        }
        $getInspectionDiagram=getInspectionImages($lastid,'diagram');
        $allInspectionDiagramImages=array();
        if(!empty($getInspectionDiagram)){
          foreach($getInspectionDiagram as $k=>$v){
             $allInspectionDiagramImages['imageId']=$v['id'];  
             $allInspectionDiagramImages['key']=$v['imgKey'];  
             $allInspectionDiagramImages['imageUrl']=$v['images'];  
          }  
        }
        $wpdb->query('insert into `im_inspection_assignments`(`inspectionId`,`inspectorId`) values("'.$lastid.'","'.$data['userId'].'")'); 
        if(!empty($data['areaDetails'])){
            foreach($data['areaDetails'] as $k=>$v){
                $wpdb->query('insert into `im_areas`(`inspectionId`,`areaName`,`visualObservation`,`sampleType`,`serial`,`generalObservation`,`recommendations`,`temprature`,`rhRelativeHumidity`) values("'.$lastid.'","'.$v['areaName'].'","'.$v['visualObservation'].'","'.$v['sampleType'].'","'.$v['serial'].'","'.$v['generalObservation'].'","'.$v['recommendations'].'","'.$v['temprature'].'","'.$v['rhRelativeHumidity'].'")');
                $lastAreaid = $wpdb->insert_id;
                $data['areaDetails'][$k]['areaId']=$lastAreaid;
                if(!empty($data['areaDetails'][$k]['images'])){
                    foreach($data['areaDetails'][$k]['images'] as $imgKey=>$imgVal){
                        $wpdb->query('insert into `im_images`(`areaId`,`imageKey`,`imageType`,`type`) values("'.$lastAreaid.'","'.$imgVal['key'].'","0","0")');
                    }
                }
                $getAreaImages=getAreaImages($lastid,'image');
                $allAreaImages=array();
                if(!empty($getAreaImages)){
                    foreach($getAreaImages as $imgK=>$valK){
                        $allAreaImages[$imgK]['imageId']=$valK['id'];
                        $allAreaImages[$imgK]['key']=$valK['imageKey'];
                        $allAreaImages[$imgK]['imageUrl']=$valK['images'];
                    }
                }
                $data['areaDetails'][$k]['images']=$allAreaImages;
                if(!empty($data['areaDetails'][$k]['diagram'])){
                    foreach($data['areaDetails'][$k]['diagram'] as $imgKey=>$imgVal){
                        $wpdb->query('insert into `im_images`(`areaId`,`imageKey`,`imageType`,`type`) values("'.$lastAreaid.'","'.$imgVal['key'].'","1","0")');
                    }
                }
                $getDiagramImages=getAreaImages($lastid,'diagram');
                $allAreaDiaImages=array();
                if(!empty($getDiagramImages)){
                    foreach($getDiagramImages as $imgK=>$valK){
                        $allAreaDiaImages[$imgK]['diagramId']=$valK['id'];
                        $allAreaDiaImages[$imgK]['key']=$valK['imageKey'];
                        $allAreaDiaImages[$imgK]['diagram']=$valK['images'];
                    }
                }
                $data['areaDetails'][$k]['diagram']=$allAreaDiaImages;
                if(!empty($v['issueType'])){
                    foreach($v['issueType'] as $keys=>$values){
                        $wpdb->query('insert into `im_issues`(`type`,`selectionId`,`areaId`,`typeValue`,`measurements`,`location`) values("'.$values['type'].'","'.$values['typeId'].'","'.$lastAreaid.'","'.$values['typeValue'].'","'.$values['measurements'].'","'.$values['location'].'")');
                        $lastIssueId = $wpdb->insert_id;
                        $data['areaDetails'][$k]['issueType'][$keys]['issueId']=$lastIssueId;
                        if(!empty($values['images'])){
                            foreach($values['images'] as $imgKey=>$imgVal){
                                $wpdb->query('insert into `im_images`(`areaId`,`imageKey`,`imageType`,`type`) values("'.$lastIssueId.'","'.$imgVal['key'].'","0","1")');
                            }
                        }
                        $getIssueImages=getIssueImages($lastIssueId,'image');
                        $allIssueImg=array();
                        if(!empty($getIssueImages)){
                            foreach($getIssueImages as $imgK=>$valK){
                                $allIssueImages[$imgK]['imageId']=$valK['id'];
                                $allIssueImages[$imgK]['key']=$valK['imageKey'];
                                $allIssueImages[$imgK]['imageUrl']=$valK['images'];
                            }
                        }
                        $data['areaDetails'][$k]['issueType'][$keys]['images']=$allIssueImages;
                        if(!empty($values['diagram'])){
                            foreach($values['diagram'] as $imgKey=>$imgVal){
                                $wpdb->query('insert into `im_images`(`areaId`,`imageKey`,`imageType`,`type`) values("'.$lastIssueId.'","'.$imgVal['key'].'","1","1")');
                            }
                        }
                        $getIssueDiaImages=getIssueImages($lastIssueId,'diagram');
                        $allIssueDImg=array();
                        if(!empty($getIssueDiaImages)){
                            foreach($getIssueDiaImages as $imgK=>$valK){
                                $allIssueDImg[$imgK]['diagramId']=$valK['id'];
                                $allIssueDImg[$imgK]['key']=$valK['imageKey'];
                                $allIssueDImg[$imgK]['diagram']=$valK['images'];
                            }
                        }
                        $data['areaDetails'][$k]['issueType'][$keys]['diagram']=$allIssueDImg;
                    }
                }
                if(!empty($v['additionalSample'])){
                    foreach($v['additionalSample'] as $keysT=>$valuesT){
                        $wpdb->query('insert into `im_samples`(`sampleType`,`sampleSerialNo`,`sampleObservation`,`areaId`) values("'.$valuesT['sampleType'].'","'.$valuesT['sampleSerialNo'].'","'.$valuesT['sampleObservation'].'","'.$lastAreaid.'")');
                        $lastSampleId = $wpdb->insert_id;
                        $data['areaDetails'][$k]['additionalSample'][$keysT]['sampleId']=$lastSampleId;
                        if(!empty($valuesT['images'])){
                            foreach($valuesT['images'] as $imgKey=>$imgVal){
                                $wpdb->query('insert into `im_images`(`areaId`,`imageKey`,`imageType`,`type`) values("'.$lastSampleId.'","'.$imgVal['key'].'","0","2")');
                            }
                        }
                        $getSampleImages=getSampleImages($lastSampleId,'image');
                        $allSampleImg=array();
                        if(!empty($getSampleImages)){
                            foreach($getSampleImages as $imgK=>$valK){
                                $allSampleImg[$imgK]['imageId']=$valK['id'];
                                $allSampleImg[$imgK]['key']=$valK['imageKey'];
                                $allSampleImg[$imgK]['imageUrl']=$valK['images'];
                            }
                        }
                        $data['areaDetails'][$k]['additionalSample'][$keysT]['images']=$allSampleImg;
                        if(!empty($valuesT['diagram'])){
                            foreach($valuesT['diagram'] as $imgKey=>$imgVal){
                                $wpdb->query('insert into `im_images`(`areaId`,`imageKey`,`imageType`,`type`) values("'.$lastSampleId.'","'.$imgVal['key'].'","1","2")');
                            }
                        }
                        $getSampleDiaImages=getSampleImages($lastSampleId,'diagram');
                        $allSampleDiaImg=array();
                        if(!empty($getSampleDiaImages)){
                            foreach($getSampleDiaImages as $imgK=>$valK){
                                $allSampleDiaImg[$imgK]['diagramId']=$valK['id'];
                                $allSampleDiaImg[$imgK]['key']=$valK['imageKey'];
                                $allSampleDiaImg[$imgK]['diagram']=$valK['images'];
                            }
                        }
                        $data['areaDetails'][$k]['additionalSample'][$keysT]['diagram']=$allSampleDiaImg;
                    }
                }
            }            
        }
        $data['localInspectionId']=(string) $lastid;
        return $data;
    }
    function saveInspectionDetailsBKUP($data=null){
        global $wpdb;
        $getRow=$wpdb->get_row('select * from `im_inspection_details` where `inspectionId`="'.$data['inspectionId'].'"');
        if(!empty($getRow)){
          response(0,null,'Inspection already started.');
        }
        $wpdb->query('insert into `im_inspection_details`(`inspectionId`,`enviornmentType`,`hvacSystemValue`,`outdoorTemprature`,`hvacSystem`,`bullets`,`ductwork`) values("'.$data['inspectionId'].'","'.$data['enviornmentType'].'","'.$data['hvacSystemValue'].'","'.$data['outdoorTemprature'].'","'.$data['hvacSystem'].'","'.$data['bullets'].'","'.$data['ductwork'].'")');
        $lastid = $wpdb->insert_id;
        $wpdb->query('insert into `im_inspection_assignments`(`inspectionId`,`inspectorId`) values("'.$lastid.'","'.$data['userId'].'")'); 
        if(!empty($data['areaDetails'])){
            foreach($data['areaDetails'] as $k=>$v){
                $wpdb->query('insert into `im_areas`(`inspectionId`,`areaName`,`visualObservation`,`sampleType`,`serial`,`generalObservation`,`recommendations`,`temprature`,`rhRelativeHumidity`) values("'.$lastid.'","'.$v['areaName'].'","'.$v['visualObservation'].'","'.$v['sampleType'].'","'.$v['serial'].'","'.$v['generalObservation'].'","'.$v['recommendations'].'","'.$v['temprature'].'","'.$v['rhRelativeHumidity'].'")');
                $lastAreaid = $wpdb->insert_id;
                $data['areaDetails'][$k]['areaId']=$lastAreaid;
                $getAreaImages=getAreaImages($lastid,'image');
                $allAreaImages=array();
                if(!empty($getAreaImages)){
                    foreach($getAreaImages as $imgK=>$valK){
                        $allAreaImages[$imgK]['imageId']=$valK['id'];
                        $allAreaImages[$imgK]['imageUrl']=$valK['images'];
                    }
                }
                $data['areaDetails'][$k]['images']=$allAreaImages;
                $getDiagramImages=getAreaImages($lastid,'diagram');
                $allAreaDiaImages=array();
                if(!empty($getDiagramImages)){
                    foreach($getDiagramImages as $imgK=>$valK){
                        $allAreaDiaImages[$imgK]['diagramId']=$valK['id'];
                        $allAreaDiaImages[$imgK]['diagram']=$valK['images'];
                    }
                }
                $data['areaDetails'][$k]['diagram']=$allAreaDiaImages;
                if(!empty($v['issueType'])){
                    foreach($v['issueType'] as $keys=>$values){
                        $wpdb->query('insert into `im_issues`(`type`,`selectionId`,`areaId`,`typeValue`,`measurements`,`location`) values("'.$values['type'].'","'.$values['typeId'].'","'.$lastAreaid.'","'.$values['typeValue'].'","'.$values['measurements'].'","'.$values['location'].'")');
                        $lastIssueId = $wpdb->insert_id;
                        $data['areaDetails'][$k]['issueType'][$keys]['issueId']=$lastIssueId;
                        $getIssueImages=getIssueImages($lastIssueId,'image');
                        $allIssueImg=array();
                        if(!empty($getIssueImages)){
                            foreach($getIssueImages as $imgK=>$valK){
                                $allIssueImages[$imgK]['imageId']=$valK['id'];
                                $allIssueImages[$imgK]['imageUrl']=$valK['images'];
                            }
                        }
                        $data['areaDetails'][$k]['issueType'][$keys]['images']=$allIssueImages;
                        $getIssueDiaImages=getIssueImages($lastIssueId,'diagram');
                        $allIssueDImg=array();
                        if(!empty($getIssueDiaImages)){
                            foreach($getIssueDiaImages as $imgK=>$valK){
                                $allIssueDImg[$imgK]['diagramId']=$valK['id'];
                                $allIssueDImg[$imgK]['diagram']=$valK['images'];
                            }
                        }
                        $data['areaDetails'][$k]['issueType'][$keys]['diagram']=$allIssueDImg;
                    }
                }
                if(!empty($v['additionalSample'])){
                    foreach($v['additionalSample'] as $keysT=>$valuesT){
                        $wpdb->query('insert into `im_samples`(`sampleType`,`sampleSerialNo`,`sampleObservation`,`areaId`) values("'.$valuesT['sampleType'].'","'.$valuesT['sampleSerialNo'].'","'.$valuesT['sampleObservation'].'","'.$lastAreaid.'")');
                        $lastSampleId = $wpdb->insert_id;
                        $data['areaDetails'][$k]['additionalSample'][$keysT]['sampleId']=$lastSampleId;
                        $getSampleImages=getSampleImages($lastSampleId,'image');
                        $allSampleImg=array();
                        if(!empty($getSampleImages)){
                            foreach($getSampleImages as $imgK=>$valK){
                                $allSampleImg[$imgK]['imageId']=$valK['id'];
                                $allSampleImg[$imgK]['imageUrl']=$valK['images'];
                            }
                        }
                        $data['areaDetails'][$k]['additionalSample'][$keysT]['images']=$allSampleImg;
                        $getSampleDiaImages=getSampleImages($lastSampleId,'diagram');
                        $allSampleDiaImg=array();
                        if(!empty($getSampleDiaImages)){
                            foreach($getSampleDiaImages as $imgK=>$valK){
                                $allSampleDiaImg[$imgK]['diagramId']=$valK['id'];
                                $allSampleDiaImg[$imgK]['diagram']=$valK['images'];
                            }
                        }
                        $data['areaDetails'][$k]['additionalSample'][$keysT]['diagram']=$allSampleDiaImg;
                    }
                }
            }            
        }
        $data['localInspectionId']=(string) $lastid;
        return $data;
    }

    add_action('wp_ajax_delete_notification','delete_notification');
    add_action('wp_ajax_nopriv_delete_notification','delete_notification');

    function delete_notification(){
        $delete=delete_notify($_POST['notificationId']);
        if(!empty($delete)){
          echo json_encode(array('status'=>'true','message'=>'Notification deleted successfully.'));
        }else{
           echo json_encode(array('status'=>'false','message'=>'No Data found.'));         
        }
        die;
    }
    function delete_notify($id){
        global $wpdb;
        $wpdb->query('delete from `im_notifications` where `id`="'.$id.'"');
        return true;
    }


     /*check time ago */
    function getTiming($time){
       $time = time() - $time; // to get the time since that moment
       $time = ($time<1)? 1 : $time;
       $tokens = array (
           31536000 => 'year',
           2592000 => 'month',
           604800 => 'week',
           86400 => 'day',
           3600 => 'hour',
           60 => 'minute',
           1 => 'second'
       );
       foreach ($tokens as $unit => $text) {
           if ($time < $unit) continue;
           $numberOfUnits = floor($time / $unit);
           return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
       }

    }
    /* Admin panel functions*/
    add_action('admin_menu', 'admin_custom_menus');
    function admin_custom_menus(){
        $currentUserId=get_current_user_id();
        $user_meta=get_userdata($currentUserId);
        $user_roles=$user_meta->roles[0];
        add_menu_page('Inspections', 'All Inspections', 'manage_options', 'inspection', 'getAllInspectionsAdminPanel','dashicons-media-interactive',10); 
        add_submenu_page('inspection','View Inspection','View Inspection', 'manage_options','viewInspection','viewInspection');
        add_submenu_page('inspection','Edit Inspection','Edit Inspection', 'manage_options','editInspection','editInspection');
        add_submenu_page('inspection','Edit Area','Edit Area', 'manage_options','editArea','editArea');
        add_submenu_page('inspection','View Area','View Area', 'manage_options','viewArea','viewArea');
        add_submenu_page('inspection','Add sample','Add Sample', 'manage_options','add-sample','addSample');
        add_submenu_page('inspection','edit sample','edit Sample', 'manage_options','edit-sample','editSample');
        add_submenu_page('inspection','delete sample','delete Sample', 'manage_options','delete-sample','deleteSample');
        add_menu_page('reports', 'All Reports', 'manage_options', 'inspection-reports', 'getAllInspectionsReports','dashicons-admin-settings',10); 
        add_submenu_page('inspection-reports','All Reportsss','All Reports', 'manage_options','all-reports','getAllInspectionsReports');
        add_submenu_page('inspection-reports','View Pdf','View Pdf', 'manage_options','view-pdf','viewPdf');
        add_submenu_page('inspection-reports','Upload Pdf','Upload Pdf', 'manage_options','upload-pdf','uploadPdf');
        
        if($user_roles!='administrator'){
            add_menu_page('inbox', 'Inbox', 'manage_options', 'inbox-system', 'getInbox','dashicons-email',20); 
            add_menu_page('notifications', 'Notifications', 'manage_options', 'notifications', 'getNofications','dashicons-megaphone',20); 
            /*add_submenu_page('inbox-system','Send Message','Send Message', 'manage_options','send-message','sendMessage');*/
        }else{
            add_menu_page('upload_documents', 'Upload Documents', 'manage_options', 'documents', 'uploadDocuments','dashicons-media-text',20);     
            add_menu_page('All Clients', 'All Clients', 'manage_options', 'clients', 'allClients','dashicons-universal-access',20);     
            add_submenu_page('clients','Edit Client','Edit Client', 'manage_options','edit-client','editClient');
            add_submenu_page('clients','View Client','View Client', 'manage_options','view-client','viewClient');
            add_submenu_page('clients','Delete Client','Delete Client', 'manage_options','delete-client','deleteClient');
        }
        
    } 

    function deleteSample(){
        global $wpdb;
        $getRecords=$wpdb->get_row('select * from `im_samples` where `id`="'.$_GET['sampleId'].'"',ARRAY_A);
        if(!empty($getRecords)){
          $wpdb->query('delete from `im_samples` where `id`="'.$getRecords['id'].'"');  
         ?><script>

window.location.href='<?php echo admin_url().'admin.php?page=editArea&areaId='.$getRecords['areaId'];?>';
</script>
<?php
        }

    }
 
/* Add Client via App */
    function addClient($data=null){
        global $wpdb;
        $records=$wpdb->get_row('select * from `im_clients` where `email`="'.$data['email'].'"');
        if(!empty($records)){
           response(0,null,'Client already exists.'); 
        }else{
            $date=$data['date'];
            if(!empty($date)){
              $date=date('Y-m-d',strtotime($data['date']));
            }
            $dateOfLoss=$data['dateOfLoss'];
            if(!empty($dateOfLoss)){
              $dateOfLoss=date('Y-m-d h:i:a',strtotime($data['dateOfLoss']));
            }  
            $inspectionDate=$data['inspectionDate'];
            if(!empty($inspectionDate)){
              $inspectionDate=date('Y-m-d h:i:a',strtotime($data['inspectionDate']));
            }
            $query='insert into `im_clients`(`inspectorId`,`fullName`,`location`,`phoneNumber`,`email`,`jobNumber`,`date`,`time`,`rehabbedAfterYear`,`inspectionType`,`paymentType`,`inspectionDate`,`inspectionTime`,`isnNotes`,`insuaranceCompany`,`policyNumber`,`claim`,`insuaranceAdjuster`,`claimCount`,`dateOfLoss`,`typeOfLoss`,`remedeationCompany`,`publicAdjuster`,`referralSource`) values("'.$data['userId'].'","'.$data['fullName'].'","'.$data['location'].'","'.$data['phoneNumber'].'","'.$data['email'].'","'.$data['jobNumber'].'","'.$date.'","'.$data['time'].'","'.$data['rehabbedAfterYear'].'","'.$data['inspectionType'].'","'.$data['paymentType'].'","'.$inspectionDate.'","'.$data['inspectionTime'].'","'.$data['isnNotes'].'","'.$data['insuaranceCompany'].'","'.$data['policyNumber'].'","'.$data['claim'].'","'.$data['insuaranceAdjuster'].'","'.$data['claimCount'].'","'.$dateOfLoss.'","'.$data['typeOfLoss'].'","'.$data['remedeationCompany'].'","'.$data['publicAdjuster'].'","'.$data['referralSource'].'")';
            $wpdb->query($query);
            return $wpdb->insert_id;
      }
       
        
    }

    function getNofications(){
        include('admin-templates/notifications.php');     
    }
    function deleteClient(){
      include('admin-templates/delete-client.php');     
    }

    function viewClient(){
       include('admin-templates/view-client.php');   
    }
    function editClient(){
           include('admin-templates/edit-client.php');   
        }
    function allClients(){
       include('admin-templates/all-clients.php');   
    }

    function addSample(){
       include('admin-templates/addSample.php');  
        
    }
    function uploadPdf(){
       include('admin-templates/upload-pdf.php');   
    }

    function editSample(){
       include('admin-templates/addSample.php');   
    }
    function viewPdf(){
       include('admin-templates/view-pdf.php');   
    }
    function getAllInspectionsReports(){
      include('admin-templates/get-all-reports.php');   
    }

    function uploadDocuments(){
      include('admin-templates/upload_documents.php');   
    }

    function sendMessage(){
      include('admin-templates/sendMessage.php');      
    }

    function getInbox(){
       include('admin-templates/inbox.php');    
    }

    function editArea(){
      include('admin-templates/edit-area.php');   
    }
    function viewArea(){
          include('admin-templates/view-area.php');   
        } 
    function viewInspection(){
      include('admin-templates/view-inspection.php');   
    } 
    function editInspection(){
      include('admin-templates/edit-inspection.php');   
    }
    function getAllInspectionsAdminPanel(){
      include('admin-templates/all-inspections.php');   
    }

    add_action('wp_ajax_delete_image','delete_image');
    add_action('wp_ajax_nopriv_delete_image','delete_image');

    function delete_image(){
        global $wpdb;
        $wpdb->query('delete from `im_images` where `id`="'.$_POST['imgId'].'"');
        echo json_encode(array('status'=>'true'));
        die;
    }


    add_action('wp_ajax_changeStatusReport','changeStatusReport');
    add_action('wp_ajax_nopriv_changeStatusReport','changeStatusReport');
    function changeStatusReport(){
        global $wpdb;
        $row=$wpdb->get_row('select * from `im_labreports` where `inspectionId`="'.$_POST['inspectionId'].'"',ARRAY_A);
        $getInspectionAssignment=$wpdb->get_row('select * from `im_inspection_assignments` where `inspectionId`="'.$_POST['inspectionId'].'"',ARRAY_A);
        if(empty($row)){
            echo json_encode(array('status'=>'false','message'=>'No Inspection found.'));
            die;
        }
        $reporterId=$getInspectionAssignment['reporterId'];
        if($_POST['type']=='accept'){          
            $wpdb->query('update `im_labreports` set `status`="2" where `inspectionId`="'.$_POST['inspectionId'].'"'); 
            $userdata=get_user_by('id',$reporterId);
            send_email($userdata->data->user_email,'Report Accepted Notification','Report accepted successfully.');
            echo json_encode(array('status'=>'true','message'=>'Report accepted successfully.'));
        }else{
            $wpdb->query('update `im_labreports` set `status`="3" where `inspectionId`="'.$_POST['inspectionId'].'"');
            $wpdb->query('update `im_inspection_details` set `status`="1" where `id`="'.$_POST['inspectionId'].'"');            
            $userdata=get_user_by('id',$reporterId);
            send_email($userdata->data->user_email,'Report Rejected Notification','Report rejected successfully.');
            echo json_encode(array('status'=>'true','message'=>'Report rejected successfully.'));
        }        
        die;
    }

    function getLocalInspectionDetails($inspectionId=null){
        global $wpdb;
        $row=$wpdb->get_row('select * from `im_inspection_details` where `id`="'.$inspectionId.'"',ARRAY_A);   
        return $row;
    }

    add_action('wp_ajax_changeStatus','changeStatus');
    add_action('wp_ajax_nopriv_changeStatus','changeStatus');
    function changeStatus(){
        global $wpdb;
        $row=$wpdb->get_row('select * from `im_inspection_details` where `id`="'.$_POST['inspectionId'].'"',ARRAY_A);
        $getInspectionAssignment=$wpdb->get_row('select * from `im_inspection_assignments` where `inspectionId`="'.$_POST['inspectionId'].'"',ARRAY_A);
        if(empty($row)){
            echo json_encode(array('status'=>'false','message'=>'No Inspection found.'));
            die;
        }
        $inspectorId=$getInspectionAssignment['inspectorId'];
        $loginUserId=get_current_user_id();
        if($_POST['type']=='accept'){          
            $wpdb->query('update `im_inspection_details` set `status`="2" where `id`="'.$_POST['inspectionId'].'"'); 
            insert_notification($loginUserId,$inspectorId,$_POST['inspectionId'],'0','Inspection accepted successfully.');
            echo json_encode(array('status'=>'true','message'=>'Inspection accepted successfully.'));
        }else{
            $wpdb->query('update `im_inspection_details` set `status`="3" where `id`="'.$_POST['inspectionId'].'"');
            insert_notification($loginUserId,$inspectorId,$_POST['inspectionId'],'0','Inspection rejected successfully.');
            echo json_encode(array('status'=>'true','message'=>'Inspection rejected successfully.'));
        }        
        die;
    }

    add_action('wp_ajax_assignReporter','assignReporter');
    add_action('wp_ajax_nopriv_assignReporter','assignReporter');

    function assignReporter(){
        global $wpdb;
        $userId=get_current_user_id();
        $row=$wpdb->get_row('select * from `im_inspection_assignments` where `inspectionId`="'.$_POST['inspectionId'].'"',ARRAY_A);
        if($_POST['type']=='reporter'){  
            $wpdb->query('update `im_inspection_details` set `status`="1" where `id`="'.$_POST['inspectionId'].'"'); 
            if(empty($row)){
               $wpdb->query('insert into `im_inspection_assignments`(`inspectionId`,`reporterId`) values("'.$_POST['inspectionId'].'","'.$userId.'")'); 
            }else{
               $wpdb->query('update `im_inspection_assignments` set `reporterId`="'.$userId.'" where `inspectionId`="'.$_POST['inspectionId'].'"'); 
            }
             echo json_encode(array('status'=>'true','message'=>'Reporter assigned successfully.'));
            die;
            
        }else{
            $wpdb->query('update `im_labreports` set `status`="1" where `inspectionId`="'.$_POST['inspectionId'].'"'); 
            if(!empty($row)){
              $wpdb->query('update `im_inspection_assignments` set `qaId`="'.$userId.'" where `inspectionId`="'.$_POST['inspectionId'].'"'); 
            } 
            echo json_encode(array('status'=>'true','message'=>'QA assigned successfully.'));
            die;
        }
       
    }

    add_action('wp_ajax_getDetails','getDetails');
    add_action('wp_ajax_nopriv_getDetails','getDetails');

    function getDetails(){
        global $wpdb;
        $row=$wpdb->get_row('select * from `im_areas` where `id`="'.$_POST['areaId'].'" and `type`="'.$_POST['id'].'"',ARRAY_A);
        if(!empty($row)){
            echo json_encode(array('status'=>'true','data'=>$row));
            die;
        }else{
             echo json_encode(array('status'=>'false'));
            die;
            
        }
    }  
    function getAllSampleByArea($areaId=null){
        global $wpdb;
        $row=$wpdb->get_results('select * from `im_samples` where `areaId`="'.$areaId.'"',ARRAY_A);
        return $row;
    }

    function getFirstAreaImage($inspectionId=null){
        global $wpdb;
        return 'http://clientstagingdev.com/expertreports/wp-content/uploads/2018/01/5a6823443f4ab.png';
    }
    add_filter( 'screen_options_show_screen', '__return_false' ); 

    add_action('admin_head', 'mytheme_remove_help_tabs'); 
    function mytheme_remove_help_tabs() { 
        $screen = get_current_screen();
        $screen->remove_help_tabs();
    }

    
    add_action('wp_ajax_save_area_popup_details','save_area_popup_details');
    add_action('wp_ajax_nopriv_save_area_popup_details','save_area_popup_details');
    function save_area_popup_details(){
        global $wpdb;
        if(!empty($_POST['image'])){
            $upload_dir = wp_upload_dir();                
            $image=explode(',',$_POST['image']);
            $data['profileImage']=$image[1];
            $dataSource = base64_decode($data['profileImage']);
            $file_name = uniqid() . '.png';
            $file = $upload_dir['path'].'/'.$file_name;
            $return = $upload_dir['url'].'/'.$file_name;
            $success = file_put_contents($file, $dataSource);     
            $wpdb->query('update `im_areas` set `type`="'.$_POST['type'].'",`typeValue`="'.$_POST['typeValue'].'",`measurements`="'.$_POST['measurements'].'",`location`="'.$_POST['location'].'",`typeImage`="'.$return.'" where `id`="'.$_POST['areaId'].'"');
        }
        if(!empty($_POST['diagram'])){
            $upload_dir = wp_upload_dir();                
            $image=explode(',',$_POST['diagram']);
            $data['profileImage']=$image[1];
            $dataSource = base64_decode($data['profileImage']);
            $file_name = uniqid() . '.png';
            $file = $upload_dir['path'].'/'.$file_name;
            $return = $upload_dir['url'].'/'.$file_name;
            $success = file_put_contents($file, $dataSource);     
            $wpdb->query('update `im_areas` set `type`="'.$_POST['type'].'",`typeValue`="'.$_POST['typeValue'].'",`measurements`="'.$_POST['measurements'].'",`location`="'.$_POST['location'].'",`typeDiagram`="'.$return.'" where `id`="'.$_POST['areaId'].'"');
        } 
        $wpdb->query('update `im_areas` set `type`="'.$_POST['type'].'",`typeValue`="'.$_POST['typeValue'].'",`measurements`="'.$_POST['measurements'].'",`location`="'.$_POST['location'].'" where `id`="'.$_POST['areaId'].'"');
        echo json_encode(array('status'=>'true','message'=>'Details updated successfully.'));
        die;
    }

    add_action('wp_ajax_getMessages','getMessages');
    add_action('wp_ajax_nopriv_getMessages','getMessages');
    function getMessages(){
        session_start();
        $userDetails=get_user_by('id',get_current_user_id());
        $conversationID=getConversationId(get_current_user_id(),$_POST['usrId'],$userDetails->roles[0]);
        global $wpdb;
        $results=$wpdb->get_results('select * from `im_chats` where `conversationId`="'.$conversationID.'" order by id desc',ARRAY_A);
        $_SESSION['msgCount']=count($results);
        krsort($results);
        $html='';
        if(!empty($results)){
            foreach($results as $k=>$v){
               if(get_current_user_id()==$v['senderId']){
                 $class="me";
               }else{
                  $class="friend"; 
               }
                $message='';
                if(!empty($v['message'])){
                  $message=' <span>'.$v['message'].'</span><br>';  
                }
                $dateTime=date('d/m/Y h:i:s A',strtotime($v['created']));
                $image='';
                if(!empty($v['file'])){
                  $image='<img src="'.$v['file'].'" width="100px" alt="'.basename($v['file']).'"><br>';  
                }
               $html.='<li class="'.$class.'">
                        <div class="avatar">
                            <figure>'.ucfirst(substr(get_user_meta($v['senderId'],'first_name',true),0,1)).'</figure>
                            <span class="userName"><strong>'.get_user_meta($v['senderId'],'first_name',true).'</strong></span>
                        </div>
                        <div class="messageWrapper">
                           '.$message.$image.'<i>'.$dateTime.'</i>
                        </div>
              </li>'; 
            }
        }
        echo $html;
        die;
        
    }
    add_action('wp_ajax_getMessagesAjax','getMessagesAjax');
    add_action('wp_ajax_nopriv_getMessagesAjax','getMessagesAjax');
    function getMessagesAjax(){
        session_start();
        $userDetails=get_user_by('id',get_current_user_id());
        $conversationID=getConversationIdOnly(get_current_user_id(),$_POST['usrId']);
        global $wpdb;
        $results=$wpdb->get_results('select * from `im_chats` where `conversationId`="'.$conversationID.'" order by id desc',ARRAY_A);
        $html='';
        if($_SESSION['msgCount']<count($results)){
            $_SESSION['msgCount']=count($results);
            krsort($results);            
            if(!empty($results)){
                foreach($results as $k=>$v){
                   if(get_current_user_id()==$v['senderId']){
                     $class="me";
                   }else{
                      $class="friend"; 
                   }
                    $message='';
                    if(!empty($v['message'])){
                      $message=$v['message'];  
                    }
                    $image='';
                    if(!empty($v['file'])){
                      $image='<br><img src="'.$v['file'].'" width="100px" alt="'.basename($v['file']).'">';  
                    }
                   $html.='<li class="'.$class.'">
                            <div class="avatar">
                                <figure>'.ucfirst(substr(get_user_meta($v['senderId'],'first_name',true),0,1)).'</figure>
                                <span class="userName"><strong>'.get_user_meta($v['senderId'],'first_name',true).'</strong></span>
                            </div>
                            <div class="messageWrapper">
                                <span>'.$message.'</span>'.$image.'<i>'.$dateTime.'</i>
                            </div>
                  </li>';               


               
                }
            }            
        }
        echo $html;
        die; 
        
    }

    add_action('wp_ajax_send_message','send_message');
    add_action('wp_ajax_nopriv_send_message','send_message');
    function send_message(){
        global $wpdb;
        $userDetails=get_user_by('id',get_current_user_id());
        $conversationId=getConversationId(get_current_user_id(),$_POST['toUserId'],$userDetails->roles[0]);
        $return='';
        if(!empty($_FILES['file']['name'])){
            $upload_dir = wp_upload_dir(); 
            $file_name=time().'_'.$_FILES['file']['name'];
            $file = $upload_dir['path'].'/'.$file_name;
            $return = $upload_dir['url'].'/'.$file_name;
            move_uploaded_file($_FILES['file']['tmp_name'],$file);  
        }
        $wpdb->query('insert into `im_chats`(`senderId`,`receiverId`,`conversationId`,`message`,`created`,`file`) values("'.get_current_user_id().'","'.$_POST['toUserId'].'","'.$conversationId.'","'.$_POST['mgs'].'","'.date('Y-m-d H:i:s').'","'.$return.'")');
        $lastInsertId=$wpdb->insert_id;
        $senderName=get_user_meta(get_current_user_id(),'first_name',true);
        $finalContent='You have received new message from '.$senderName;
        $crntUserId=get_user_by('id',$_POST['toUserId']);
        $email_template=file_get_contents(get_stylesheet_directory_uri().'/email-template.php');
        $email_template=str_replace('[NAME]',ucwords($senderName),$email_template);
        $email_template=str_replace('[MESSAGE]',$finalContent,$email_template);
        send_email($crntUserId->data->user_email,'New Message Received',$email_template);
        insert_notification(get_current_user_id(),$_POST['toUserId'],$lastInsertId,'1',$finalContent); 
        echo json_encode(array('status'=>'true','message'=>'Your message has been sent.'));
        die;
    }


    function my_login_logo() { 
       $custom_logo_id = get_theme_mod( 'custom_logo' );
       $image = site_url().'/wp-content/uploads/2018/01/logo.png';             
    ?>
        <style type="text/css">
            #login h1 a,.login h1 a {
                background-image: url(<?php echo $image; ?>);
                height:65px;
                width:320px;
                background-size: contain;
                background-repeat: no-repeat;
                padding-bottom: 30px;
            }
            #backtoblog{
              display: none;  
            }
            body {
                background-color: #59524c !important;
            }
             .login #nav a { color: #fff !important; }
            .login #backtoblog a:focus, .login #nav a:focus, .login #backtoblog a:hover, .login #nav a:hover { color: #2cc0d9 !important; }
        </style>
    <?php }
    add_action( 'login_enqueue_scripts', 'my_login_logo' );
    
    add_action('in_admin_footer', 'foot_monger');  
    function foot_monger () { 
        $currentUser=get_current_user_id();
        if(!empty($currentUser)){
            $userData=get_user_by('id',$currentUser);
            if(!empty($userData)){
                $role=$userData->roles[0];
                if($role=='subscriber'){//Reporter
                    ?>
                <style>
                    #toplevel_page_inspection-reports,#menu-posts-inspectiontypes,#menu-posts-sampletypes{
                        display: none;
                    }
                    #toplevel_page_inspection{
                        display: block;
                    }
                     #menu-pages{
        display: none;
    }
                    
                </style>
                <?php

                }elseif($role=='contributor'){//QA
                    ?>
                <style>
                     #menu-pages,#menu-posts-inspectiontypes,#menu-posts-sampletypes{
        display: none;
    }
                    #toplevel_page_inspection{
                        display: block;
                    }
                    #toplevel_page_inspection-reports{
                        display: block;
                    }
                </style>
                <?php

                }else{//administrator  
                    ?>
<style>
    #menu-pages{
        display: block;
    }
    .error{
        border: 1px solid red !important;
    }
</style>
<script>
      jQuery(document).ready(function(){
        jQuery('#toplevel_page_clients ul li').hide();
        jQuery('#toplevel_page_clients ul li:nth-child(2)').show();
        jQuery('#inspectiontypeschecklist li input').attr('type','radio');
        jQuery('#menu-users ul li:last-child').hide();
        jQuery('#menu-posts-sampletypes li:last').hide();
        jQuery('#tagsdiv-sampletypes').hide();
        jQuery('.row-actions .view').hide();
        jQuery('#publish').click(function(){
        var testervar = jQuery('[id^=\"titlediv\"]')
        .find('#title');
        if (testervar.val().length < 1){
            jQuery('[id^="titlediv"]').find('#title').css('border', '1px solid red');
            return false;
        }
    });
});
    </script>
<?php
                    
                }
                
            }
        }
      ?>
    <style>
        #dolly{
            display: none;
        }
        #wp-admin-bar-comments,#wp-admin-bar-new-content,#wp-admin-bar-wp-logo,#wpfooter,.user-nickname-wrap,.user-admin-color-wrap,.user-url-wrap,.user-description-wrap,.user-profile-picture,.user-display-name-wrap,.user-rich-editing-wrap,.user-syntax-highlighting-wrap,.user-admin-color-wrap,.user-admin-bar-front-wrap,.user-comment-shortcuts-wrap,.update-nag,#wp-admin-bar-updates{
            display: none;
        }
    </style>
    <script>
    var SITE_URL='<?php echo site_url();?>';   
    jQuery(document).ready(function(){  
        jQuery('#toplevel_page_inspection-reports ul li:nth-child(3)').hide();
        jQuery('#toplevel_page_inspection-reports ul li:nth-child(4)').hide();
        jQuery('.sideBarContainer ul li:first a').trigger('click');
        jQuery('#menu-dashboard ul li:last').hide();
        <?php
        if(isset($_GET['page'])){
            if($_GET['page']=='editInspection' || $_GET['page']=='viewInspection' || $_GET['page']=='editArea' || $_GET['page']=='viewArea'){
                ?>
             jQuery('#toplevel_page_inspection ul li').hide();
             jQuery('#toplevel_page_inspection ul li:nth-child(2)').show();
             jQuery('#toplevel_page_inspection ul li:nth-child(2)').addClass('current');
             jQuery('#toplevel_page_inspection ul li:nth-child(2)').parent().addClass('current');
            
            <?php
                
            }
            
        }
        ?>
        });
</script>
<?php
    }
    function custom_menu_page_removing() {
        remove_menu_page('wpcf7');
        remove_menu_page('edit.php');
        remove_menu_page('themes.php');
        remove_menu_page('options-general.php');
        remove_menu_page('upload.php');
        remove_menu_page('tools.php');
        remove_menu_page('plugins.php');
        remove_menu_page('edit-comments.php');
    }
    add_action( 'admin_menu', 'custom_menu_page_removing' );

    function getLabReportStatus($Id=null){
        global $wpdb;
        $getRow=$wpdb->get_row('select * from `im_labreports` where `inspectionId`="'.$Id.'"',ARRAY_A);
        return $getRow['status'];
    }

    function customcode($username, $password ) {
      if (!empty($username) && !empty($password)) {
          $credentials=array('username'=>$username,'password'=>$password);
          $records=getUserInformation($credentials);
          if(isset($records['status']) and $records['status']=='ok'){
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
                    $u = new WP_User($user_id);
                    if($records['me']['officestaff']=='Yes'){//Reporter
                       $u->set_role('subscriber'); 
                    }elseif($records['me']['manager']=='Yes'){//QA
                       $u->remove_role('subscriber');
                       $u->set_role('contributor');  
                    }                   
                }else{
                    $user_id = wp_create_user($username,$password,$records['me']['emailaddress']);
                     wp_update_user(array(
                     'ID' => $user_id,
                     'display_name' => $records['me']['firstname'].' '.$records['me']['lastname']
                    )); 
                    update_user_meta($user_id,'first_name',$records['me']['firstname']);
                    update_user_meta($user_id,'last_name',$records['me']['lastname']);  
                    update_user_meta($user_id,'is_enable_notification',1);  
                    update_user_meta($user_id,'admin_color','coffee');  
                    $u = new WP_User($user_id);
                    if($records['me']['officestaff']=='Yes'){//Reporter
                       $u->set_role('subscriber'); 
                    }elseif($records['me']['manager']=='Yes'){//QA
                       $u->remove_role('subscriber');
                       $u->set_role('contributor');  
                    }  
                }
          }else{
            echo 'invalid';  
          }
      }
    }
    add_action('wp_authenticate', 'customcode', 30, 2);

    function se_154951_add_admin_body_class( $classes ) {
        return "$classes admin-color-coffee";

    }

    add_filter( 'admin_body_class', 'se_154951_add_admin_body_class' );

    function afterLogin( $user_login, $user ) {
        if($user->roles[0]=='inspector'){
            wp_logout();
            wp_redirect(home_url().'/portal');
            die;
        }
    }
    add_action('wp_login', 'afterLogin', 10, 2);

    function getPrivacyPolicy(){
        $page = get_posts(
                    array(
                        'name'      => 'privacy-policy',
                        'post_type' => 'page'
                    )
                );
        if(!empty($page)){
            return $page;
        }
        return false;
    }

    function getTermsConditions(){
            $page = get_posts(
                        array(
                            'name'      => 'terms-and-conditions',
                            'post_type' => 'page'
                        )
                    );
            if(!empty($page)){
                return $page;
            }
            return false;
    }

    /* Get Conversation ID */
    function getConversationId($sender=null,$receiver=null,$type=null){
      global $wpdb;
      $result=$wpdb->get_row('select * from `im_conversations` where (`senderId`="'.$sender.'" and `receiverId`="'.$receiver.'") or (`receiverId`="'.$sender.'" and `senderId`="'.$receiver.'")',ARRAY_A);
       if(!empty($result)){
         $id=$result['id'];  
       }else{
            if($type!='inspector'){
                $wpdb->query('insert into `im_conversations`(`senderId`,`receiverId`) values("'.$sender.'","'.$receiver.'")');
                $id=$wpdb->insert_id;  
            }else{
                $id='';
            }         
       }
       return $id;
   } 

   function getConversationIdOnly($sender=null,$receiver=null){
      global $wpdb;
      $result=$wpdb->get_row('select * from `im_conversations` where (`senderId`="'.$sender.'" and `receiverId`="'.$receiver.'") or (`receiverId`="'.$sender.'" and `senderId`="'.$receiver.'")',ARRAY_A);
       if(!empty($result)){
         $id=$result['id'];  
       }else{
         $id='';
       }
       return $id;
    }
    function getLastMessage($conversationId=null){
        global $wpdb;
        $row=$wpdb->get_row('select `message`,`file`,`created` from `im_chats` where `conversationId`="'.$conversationId.'" order by id desc',ARRAY_A);
        if(empty($row)){
          $row=array('message'=>'','file'=>'');            
        }
        $row['date']=date('d/m/Y',strtotime($row['created']));
        $row['dateTime']=$row['created'];
        unset($row['created']);
        return $row;
               
    }

/* Add Notifications*/
    function insert_notification($userId=null,$opponentId=null,$moduleId=null,$type=null,$finalContent=null){
        global $wpdb;
        $query='insert into `im_notifications`(`userId`,`opponentId`,`moduleId`,`created`,`title`,`type`) values("'.$userId.'","'.$opponentId.'","'.$moduleId.'","'.date('Y-m-d H:i:s').'","'.$finalContent.'","'.$type.'")';
        $wpdb->query($query);
        if(!empty($opponentId)){
            pushMessageNotification($opponentId,$finalContent);   
        }      
    } 


  /* start Push Notifications */
    function pushMessageNotification($user_id,$message){
        global $wpdb;
        $tokens = trim(get_user_meta($user_id,'deviceToken',true));
        $deviceName = get_user_meta($user_id,'deviceType',true);
        $pushNotification = get_user_meta($user_id,'is_enable_notification',true);
        $userDetails=get_user_by('id',$user_id);
        $userRole=$userDetails->roles[0];
        if($userRole!='inspector'){
             
        }else{
            if(!empty($tokens) and !empty($pushNotification))
            {
                if($deviceName=='android')
                {
                    $res=sendMessageAndroid($tokens,$message);
                    return $res;
                }else{
                    $res=sendMessageIos($tokens,$message);
                    return $res;
                }
            }  
        }
        
    } 

    function sendMessageIos($token_id,$checkNotification){
        $title = "Expert Testing";
        $description = strip_tags($checkNotification);
        //FCM api URL	
        $url = 'https://fcm.googleapis.com/fcm/send';
      $server_key='AAAACClfaBU:APA91bEn8H2fxI8BKas4dpu9XjEOqBT3CQzXf2u9rW_UjTR84qtsxm5p3rjSP7cPsmpBHILjOIcnGIXyRFxm_Ka-G-tZ5UefEUnoEEs_dz4TWwfgjIBjCeRdLROEkf5g5YZRKIiiwjRt';
        //header with content_type api key
        $fields = array (
            'to' => $token_id,
            "content_available"  => true,
            "priority" =>  "high",
            'notification' => array( 
            "sound"=>  "default",
            "badge"=>  "12",
            'title' => "$title",
            'body' => "$description",
        )
        );
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$server_key
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    function sendMessageAndroid($token_id,$checkNotification){
     $title = "Expert Testing";
    $description = $checkNotification;

    //FCM api URL	
    $url = 'https://android.googleapis.com/gcm/send';
    //api_key available in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
    $server_key = 'AAAACClfaBU:APA91bEn8H2fxI8BKas4dpu9XjEOqBT3CQzXf2u9rW_UjTR84qtsxm5p3rjSP7cPsmpBHILjOIcnGIXyRFxm_Ka-G-tZ5UefEUnoEEs_dz4TWwfgjIBjCeRdLROEkf5g5YZRKIiiwjRt';

    //header with content_type api key
    $fields = array (
    'to' => $token_id,
    "content_available"  => true,
    "priority" =>  "high",
    'notification' => array( 
    "sound"=>  "default",
    "badge"=>  "12",
    'title' => "$title",
    'body' => "$description",
    )
    );
    //header with content_type api key
    $headers = array(
    'Content-Type:application/json',
    'Authorization:key='.$server_key
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === FALSE) {
    die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
    }

    add_action('init', 'inspectiontypes');
    function inspectiontypes() {
        register_post_type('inspectiontypes', array(
            'labels' => array(
                'name' => __("Inspection Type"),
                'singular_name' => __("inspectiontypes"),
                'all_items' => __("All Inspections"),
                'edit_item' => __("Edit Inspections"),
                'add_new' => __("Add New")
            ),
            'rewrite' => array('slug' => 'inspectiontypes', 'with_front' => true),
            'capability_type' => 'post',
            'public' => true,
            'hierarchical' => true,
            'supports' => array(
                'title',
                'editor',
               /* 'thumbnail',
                'author',*/
            ),
            'menu_position' =>60

                )
        );
        register_taxonomy('inspectiontypes', 'inspectiontypes', array('label' => __("Inspection Categories"), 'show_ui' => true, 'show_admin_column' => true, 'rewrite' => false, 'hierarchical' => true,));
    }

    add_action('wp_dashboard_setup', 'remove_dashboard_widgets');
    function remove_dashboard_widgets () {         
          remove_meta_box( 'dashboard_quick_press',   'dashboard', 'side' );      //Quick Press widget
          remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );      //Recent Drafts
          remove_meta_box( 'dashboard_primary',       'dashboard', 'side' );      //WordPress.com Blog
          remove_meta_box( 'dashboard_secondary',     'dashboard', 'side' );      //Other WordPress News
          remove_meta_box( 'dashboard_incoming_links','dashboard', 'normal' );    //Incoming Links
          remove_meta_box( 'dashboard_plugins',       'dashboard', 'normal' );    //Plugins
          remove_meta_box( 'dashboard_activity',   'dashboard', 'normal' );      //Quick Press widget
          remove_meta_box( 'dashboard_right_now',   'dashboard', 'normal' );      //Quick Press widget
    }

    function getInspectorName($inspectionId=null){
        global $wpdb;
        $query='select * from `im_inspection_assignments` where `inspectionId`="'.$inspectionId.'"';
        $row=$wpdb->get_row($query,ARRAY_A);
        if(!empty($row['inspectorId'])){
            $username= get_user_by('id',$row['inspectorId']); 
            return ucfirst($username->data->display_name);
        }else
        {
            return 'No Inspector is Active on this inspection.';
        }
        
    }

    function getReporterName($inspectionId=null){
        global $wpdb;
        $query='select * from `im_inspection_assignments` where `inspectionId`="'.$inspectionId.'"';
        $row=$wpdb->get_row($query,ARRAY_A);
        if(!empty($row['reporterId'])){
            $username= get_user_by('id',$row['reporterId']); 
            return ucfirst($username->data->display_name);
        }else
        {
            return 'No Reporter is Active on this inspection.';
        }
        
    }

    
    function convertPDF(){
        
    }
    
    function example_add_dashboard_widgets() {
        wp_add_dashboard_widget(
                 'example_dashboard_widget',         // Widget slug.
                 'Inspections Overview',         // Title.
                 'example_dashboard_widget_function' // Display function.
        );	
    }
    add_action( 'wp_dashboard_setup', 'example_add_dashboard_widgets' );

    /**
    * Create the function to output the contents of our Dashboard Widget.
    */
    function example_dashboard_widget_function() {
       require 'admin-templates/dashboard.php'; 

    }

    /* Total number of inspections */
    function totalInspection(){
        global $wpdb;
        $records=$wpdb->get_results('select * from `im_inspection_details`');
        return $records;
    }

    /* Total number of approved inspections */
    function approvedInspections(){
        global $wpdb;
        $records=$wpdb->get_results('select * from `im_inspection_details` where `status`="2" order by id desc');
        return $records;
    }

    /* Total number of declined inspections */
    function declinedInspections(){
        global $wpdb;
        $records=$wpdb->get_results('select * from `im_inspection_details` where `status`="3" order by id desc');
        return $records;
    }

    /* Total number of pending inspections */
    function pendingInspections(){
        global $wpdb;
        $records=$wpdb->get_results('select * from `im_inspection_details` where `status`="1" order by id desc');
        return $records;
    }
    add_action('init', 'sampleType');
    function sampleType() {
        register_post_type('sampletypes', array(
            'labels' => array(
                'name' => __("Sample Type"),
                'singular_name' => __("sampletype"),
                'all_items' => __("All Sample Types"),
                'edit_item' => __("Edit Sample"),
                'add_new' => __("Add New")
            ),
            'rewrite' => array('slug' => 'sampletype', 'with_front' => true),
            'capability_type' => 'post',
            'public' => true,
            'hierarchical' => true,
            'supports' => array(
                'title',
                /*'editor',
                'thumbnail',
                'author',*/
            ),
            'menu_position' =>60

                )
        );
        register_taxonomy('sampletypes', 'sampletypes'
                         /* array('label' => __("Inspection Categories"), 'show_ui' => true, 'show_admin_column' => true, 'rewrite' => false, 'hierarchical' => true,)*/
                         );
    }

 function getIssueId($selectionId,$areaId){
        global $wpdb;
        $records=$wpdb->get_row('select `id` from `im_issues` where `selectionId`="'.$selectionId.'" and `areaId`="'.$areaId.'"');
        if(!empty($records)){
            return $records->id;
        }
        return false;        
    }

    function getAreaImages($areaId,$type){
        global $wpdb;
        if($type=='image'){
          $records=$wpdb->get_results('select * from `im_images` where `imageType`="0" and `type`="0" and `areaId`="'.$areaId.'"',ARRAY_A);  
        }else{
          $records=$wpdb->get_results('select * from `im_images` where `imageType`="1" and `type`="0" and `areaId`="'.$areaId.'"',ARRAY_A);  
        }        
        return $records;  
    }
    function getInspectionImages($areaId,$type){
        global $wpdb;
        if($type=='image'){
          $records=$wpdb->get_results('select * from `im_images` where `imageType`="0" and `type`="3" and `areaId`="'.$areaId.'"',ARRAY_A);  
        }else{
          $records=$wpdb->get_results('select * from `im_images` where `imageType`="1" and `type`="3" and `areaId`="'.$areaId.'"',ARRAY_A);  
        }        
        return $records;  
    }

    function getSampleImages($sampleId,$type){
        global $wpdb;
        if($type=='image'){
          $records=$wpdb->get_results('select * from `im_images` where `imageType`="0" and `type`="2" and `areaId`="'.$sampleId.'"',ARRAY_A);  
        }else{
          $records=$wpdb->get_results('select * from `im_images` where `imageType`="1" and `type`="2" and `areaId`="'.$sampleId.'"',ARRAY_A);  
        }        
        return $records;  
    }
    function getIssueImages($issueId,$type){
        global $wpdb;
        if($type=='image'){
          $records=$wpdb->get_results('select * from `im_images` where `imageType`="0" and `type`="1" and `areaId`="'.$issueId.'"',ARRAY_A);  
        }else{
          $records=$wpdb->get_results('select * from `im_images` where `imageType`="1" and `type`="1" and `areaId`="'.$issueId.'"',ARRAY_A);  
        }        
        return $records;  
    }
    function getSelectedIssues($areaId){
        global $wpdb;
        $records=$wpdb->get_results('select * from `im_issues` where `areaId`="'.$areaId.'"',ARRAY_A);  
        $array=array();
        if(!empty($records)){
            foreach($records as $k=>$v){
                $array[]=$v['selectionId'];
            }
        }
        return $array;  
    }
    function getIssueDetails($issueId){
        global $wpdb;
        $records=$wpdb->get_row('select * from `im_issues` where `id`="'.$issueId.'"',ARRAY_A);  
        return $records;  
    }
    function checkReportStatus($inspectionId=null){
        global $wpdb;
        $records=$wpdb->get_row('select * from `im_labreports` where `inspectionId`="'.$inspectionId.'"',ARRAY_A);  
        return $records;  
    }

?>