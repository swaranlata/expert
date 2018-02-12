<?php
require '../wp-config.php';
$data = $_GET;
if(empty($data['username'])){
  response(0,array(),'Please enter the username.');   
}
if(empty($data['password'])){
  response(0,array(),'Please enter the password.');   
}
if(empty($data['inspectionId'])){
  response(0,array(),'Please enter the inspectionId.');   
}
$scheduleList=getInspectionDetailsById($data['inspectionId'],$data);
if(!empty($scheduleList)){
   if($scheduleList['status']=='ok'){
       if(!empty($scheduleList['order'])){
            $orderDetails=$scheduleList['order'];
            $clientDetails=getClientDetailsById($orderDetails['client'],$data); 
            $name='';
            $mobile='';
            $email='';
            if($clientDetails['status']=='ok'){
                $name=$clientDetails['client']['display'];
                $mobile=$clientDetails['client']['mobilephone'];
                $email=$clientDetails['client']['email'];
            }
           $finalResponse['clientName']=$name;
           $finalResponse['clientId']=$clientDetails['client']['id'];
           $finalResponse['phoneNumber']=$mobile;
           $finalResponse['email']=$email;
           $finalResponse['address1']=$clientDetails['client']['address1'];
           $finalResponse['address2']=$clientDetails['client']['address2'];
           $finalResponse['city']=$clientDetails['client']['city'];
           $finalResponse['state']=$clientDetails['client']['state'];
           $finalResponse['zip']=$clientDetails['client']['zip'];
            $finalResponse['date']=date('d M, Y',strtotime($orderDetails['datetime'])); 
            $finalResponse['time']=date('h:i A',strtotime($orderDetails['datetime'])); 
            $finalResponse['inspectionId']=$orderDetails['id'];
            $finalResponse['inspectionType']=getInspectionTypeByOrdertype($data,$orderDetails['ordertype']);
            $finalResponse['fees']=$orderDetails['totalfee'];
            $finalResponse['payment_type']='';
            $finalResponse['type_of_loss']='';
            $finalResponse['gate_code']='';
            $finalResponse['lockbox_code']='';
            $finalResponse['occupied']='';
            $finalResponse['utilities_on']='';
            $finalResponse['policy_number']='';
            $finalResponse['date_of_loss']='';
            $finalResponse['claim_number']='';
            $finalResponse['mold_report_status']='';
            $finalResponse['insuaranceAdjuster']='';
            $finalResponse['insuaranceCompanyName']='';
            $finalResponse['rehabbedYears']='';
            $finalResponse['isnNotes']='';
            $finalResponse['referalSource']='';
            $finalResponse['publicAdjuster']='';
            $finalResponse['remediationCompany']='';           
            $finalResponse['claimCount']='';
            if(!empty($orderDetails['controls'])){
               foreach($orderDetails['controls'] as $k=>$v){
                   $keyName=strtolower(str_replace(' ','_',str_replace(':','',$v['name'])));
                   if($keyName=='mold_remediation_estimate_required?_(only_for_ref._partners)'){
                       $keyName='mold_remediation_estimate_required';
                   }
                   if($keyName=='rehabbed_after_1978?'){
                       $keyName='rehabbedYears';
                   }
                   if($keyName=='how_many_claims?'){
                       $keyName='claimCount';
                   }
                   if($keyName=='public_adjuster_(contact)'){
                       $keyName='publicAdjuster';
                   }if($keyName=='remediation_company_(contact)'){
                       $keyName='remediationCompany';
                   }
                   $finalResponse[$keyName]=$v['value'];
               }               
           }
          if(isset($orderDetails['contacts'])){
              $contactDetails=getContactDetailsById($orderDetails['contacts']['id'],$data);
              if($contactDetails['status']=='ok'){
                  $finalResponse['insuaranceAdjuster']=$contactDetails['contact']['display'];   
                  $finalResponse['insuaranceCompanyName']=$contactDetails['contact']['company_name'];   
             }
           }
           
           if(isset($orderDetails['buyersagent']) and !empty($orderDetails['buyersagent'])){
              $buyersDetails=getBuyerDetailsById($orderDetails['buyersagent'],$data);
              if($buyersDetails['status']=='ok'){
                  $finalResponse['isnNotes']=$buyersDetails['agent']['notes'];   
                 // $finalResponse['publicAdjuster']=$buyersDetails['agent']['display'];   
              }
         }
            
       }
        response(1,$finalResponse,'No Error Found');   
   }else{
        response(0,array(),$scheduleList['message']);  
   }
}
?>