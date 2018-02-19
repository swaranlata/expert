<?php
require '../wp-config.php';
$data = $_GET;
if(empty($data['userId'])){
  response(0,null,'Please enter the user id.');   
}
if(empty($data['inspectionId'])){
  response(0,null,'Please enter the inspection id.');   
}
$inspector=AuthUser($data['userId'],'string');
$roles=$inspector->roles[0];
if($roles!='inspector'){
    response(0,null,'You are not authorise to access the content.'); 
}
global $wpdb;
$row=$wpdb->get_row('select * from `im_inspection_details` where `id`="'.$data['inspectionId'].'"',ARRAY_A);
if(!empty($row)){
   $finalArray['localInspectionId']= $row['id'];
   $finalArray['inspectionId']= $row['inspectionId'];
   $finalArray['outdoorTemprature']= $row['outdoorTemprature'];
   $finalArray['enviormentType']= $row['hvacSystem'];
   $finalArray['hvacSystem']= $row['hvacSystem'];
   $finalArray['hvacSystemValue']= $row['hvacSystemValue'];
   $finalArray['bullets']= $row['bullets'];
   $finalArray['ductwork']= $row['ductwork'];
   $finalArray['hvacSystemVisual']= $row['hvacSystemVisual'];
   $finalArray['outdoorRh']= $row['outdoorRh'];
   $finalArray['inspectionDate']= date('d M,Y',strtotime($row['inspectionDate']));
   $finalArray['inspectionTime']= $row['inspectionTime'];
   $getInspectionImages=getInspectionImages($row['id'],'image');
   $allInspectionImages=array();
   if(!empty($getInspectionImages)){
      foreach($getInspectionImages as $k=>$v){
         $allInspectionImages[$k]['imageId']=$v['id'];  
         $allInspectionImages[$k]['key']=$v['imageKey'];  
         $allInspectionImages[$k]['imageUrl']=site_url().$v['images'];  
      }  
    }
   $finalArray['images']=$allInspectionImages; 
   $getInspectionDiagram=getInspectionImages($row['id'],'diagram');
    $allInspectionDiagramImages=array();
    if(!empty($getInspectionDiagram)){
      foreach($getInspectionDiagram as $k=>$v){
         $allInspectionDiagramImages[$k]['imageId']=$v['id'];  
         $allInspectionDiagramImages[$k]['key']=$v['imageKey'];  
         $allInspectionDiagramImages[$k]['imageUrl']=site_url().$v['images'];  
      }  
    }    
   $finalArray['diagram']=$allInspectionDiagramImages; 
   $areas=array();
   $getAllAreas=$wpdb->get_results('select * from `im_areas` where `inspectionId`="'.$row['id'].'"',ARRAY_A);
    if(!empty($getAllAreas)){
        foreach($getAllAreas as $ka=>$va){
           $areas[$ka]['areaId']=(int) $va['id']; 
           $areas[$ka]['areaName']=$va['areaName']; 
           $areas[$ka]['visualObservation']=$va['visualObservation']; 
           $areas[$ka]['sampleType']=$va['sampleType']; 
           $areas[$ka]['serial']=$va['serial']; 
           $areas[$ka]['generalObservation']=$va['generalObservation']; 
           $areas[$ka]['recommendations']=$va['recommendations']; 
           $areas[$ka]['temprature']=$va['temprature']; 
           $areas[$ka]['rhRelativeHumidity']=$va['rhRelativeHumidity']; 
           $areas[$ka]['generalObservation']=$va['generalObservation'];
           $areas[$ka]['images']=array();
           $areas[$ka]['diagram']=array();
           $getAreaImages=getAreaImages($va['id'],'image');
           $allAreaImages=array();
            if(!empty($getAreaImages)){
                foreach($getAreaImages as $imgK=>$valK){
                    $allAreaImages[$imgK]['imageId']=$valK['id'];
                    $allAreaImages[$imgK]['key']=$valK['imageKey'];
                    $allAreaImages[$imgK]['imageUrl']=site_url().$valK['images'];
                }
            }
            $areas[$ka]['images']=$allAreaImages;
            $getDiagramImages=getAreaImages($va['id'],'diagram');
            $allAreaDiaImages=array();
            if(!empty($getDiagramImages)){
                foreach($getDiagramImages as $imgK=>$valK){
                    $allAreaDiaImages[$imgK]['diagramId']=$valK['id'];
                    $allAreaDiaImages[$imgK]['key']=$valK['imageKey'];
                    $allAreaDiaImages[$imgK]['diagram']=site_url().$valK['images'];
                }
            }
           $areas[$ka]['diagram']=$allAreaDiaImages;
           $areas[$ka]['issueType']=array();
           $areas[$ka]['additionalSample']=array();
           $issueArea=array();
           $issuesOfAReas=$wpdb->get_results('select * from `im_issues` where `areaId`="'.$va['id'].'"',ARRAY_A); 
            if(!empty($issuesOfAReas)){
                foreach($issuesOfAReas as $ki=>$vi){
                    $issueArea[$ki]['typeId']=$vi['selectionId'];
                    $issueArea[$ki]['type']=$vi['type'];
                    $issueArea[$ki]['typeValue']=$vi['typeValue'];
                    $issueArea[$ki]['measurements']=$vi['measurements'];
                    $issueArea[$ki]['location']=$vi['location'];
                    $issueArea[$ki]['issueId']=(int) $vi['id'];
                    $issueArea[$ki]['images']=array();
                    $issueArea[$ki]['diagram']=array();
                    $getIssueImages=getIssueImages($vi['id'],'image');
                    $allIssueImg=array();
                    if(!empty($getIssueImages)){
                        foreach($getIssueImages as $imgK=>$valK){
                            $allIssueImg[$imgK]['imageId']=$valK['id'];
                            $allIssueImg[$imgK]['key']=$valK['imageKey'];
                            $allIssueImg[$imgK]['imageUrl']=site_url().$valK['images'];
                        }
                    }
                    $issueArea[$ki]['images']=$allIssueImg;
                    $getIssueDiaImages=getIssueImages($vi['id'],'diagram');
                    $allIssueDImg=array();
                    if(!empty($getIssueDiaImages)){
                        foreach($getIssueDiaImages as $imgK=>$valK){
                            $allIssueDImg[$imgK]['diagramId']=$valK['id'];
                            $allIssueDImg[$imgK]['key']=$valK['imageKey'];
                            $allIssueDImg[$imgK]['diagram']=site_url().$valK['images'];
                        }
                    }
                    $issueArea[$ki]['diagram']=$allIssueDImg;
                    
                }
            }
           $areas[$ka]['issueType']=$issueArea;
           $additionalSamples=$wpdb->get_results('select * from `im_samples` where `areaId`="'.$va['id'].'"',ARRAY_A);
            $areaSample=array();
            if(!empty($additionalSamples)){
                foreach($additionalSamples as $ks=>$vs){
                   $areaSample[$ks]['sampleType']=$vs['sampleType']; 
                   $areaSample[$ks]['sampleSerialNo']=$vs['sampleSerialNo']; 
                   $areaSample[$ks]['sampleObservation']=$vs['sampleObservation']; 
                   $areaSample[$ks]['sampleId']=(int) $vs['id']; 
                   $areaSample[$ks]['images']=array(); 
                   $areaSample[$ks]['diagram']=array(); 
                   $getSampleImages=getSampleImages($vs['id'],'image');
                    $allSampleImg=array();
                    if(!empty($getSampleImages)){
                        foreach($getSampleImages as $imgK=>$valK){
                            $allSampleImg[$imgK]['imageId']=$valK['id'];
                            $allSampleImg[$imgK]['key']=$valK['imageKey'];
                            $allSampleImg[$imgK]['imageUrl']=site_url().$valK['images'];
                        }
                    } 
                    $areaSample[$ks]['images']=$allSampleImg; 
                    $getSampleDiaImages=getSampleImages($vs['id'],'diagram');
                    $allSampleDiaImg=array();
                    if(!empty($getSampleDiaImages)){
                        foreach($getSampleDiaImages as $imgK=>$valK){
                            $allSampleDiaImg[$imgK]['diagramId']=$valK['id'];
                            $allSampleDiaImg[$imgK]['key']=$valK['imageKey'];
                            $allSampleDiaImg[$imgK]['diagram']=site_url().$valK['images'];
                        }
                    }
                    $areaSample[$ks]['diagram']=$allSampleDiaImg;
                }
            }
            $areas[$ka]['additionalSample']=$areaSample;
        }
    }
   $finalArray['areaDetails']= $areas;
   response(1,$finalArray,'No Error found.');    
}else{
  response(0,null,'No inspection found.');    
}
?>