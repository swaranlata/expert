<?php
/* Template Name: Pre Inspcetion PDF */

?><?php
include('../../../wp-config.php');
global $wpdb;
$success=0;

?>
<div class="wrap">
    <?php 
    global $wpdb;
    $dbInspection=$wpdb->get_row('select * from `im_inspection_details` where `id`="'.$_GET['inspectionId'].'"',ARRAY_A);
    $documents=$wpdb->get_row('select * from `im_documents` order by id desc',ARRAY_A);
    $getAreas=$wpdb->get_results('select * from `im_areas` where `inspectionId`="'.$_GET['inspectionId'].'"',ARRAY_A);
    $inspectionDetailsOrder=json_decode(file_get_contents('http://goisn.net/moldexpert/rest/order/6c8f8478-dc7e-490a-96db-eb731cb9174d?username=swaran&password=admin@123'),true);
 // echo '<pre>';print_r($inspectionDetailsOrder); 
    $inspectionDetails=json_decode(file_get_contents('http://clientstagingdev.com/expertreports/api/getInspectionDetails.php?inspectionId=6c8f8478-dc7e-490a-96db-eb731cb9174d&username=inspector&password=123456'),true);  
    //pr($inspectionDetails);
    
    $typeDetailsArea='';
    $typeDetails='';
     if(!empty($getAreas)){
            foreach($getAreas as $k=>$v){
                $areaImage=$v['image'];
                $typeDetailsArea .='<tr>
			<td>
				<table cellpadding="15" width="100%" style="border: 4px solid #5aaf24;margin-top: 100px; background: #fff">
					<tbody><tr>
						<td width="33.33%" valign="top">
							<div style="background-image: url('.$areaImage.');background-position: center;background-repeat: no-repeat;-webkit-background-size: cover;background-size: cover;padding-bottom: 50%;"></div>
						</td>
						<td width="33.33%" valign="top">
							<strong>'.$v['type'].'</strong>
							<p>
								'.$v['typeValue'].'
								<br>
								<small>'.$v['location'].'</small>
							</p>
						</td>
						<td width="33.33%" valign="top">
							<strong>'.$v['measurements'].'</strong>
						</td>
					</tr>
				</tbody></table>
			</td>
		</tr>';
            }
     }
    $prearea='<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-top: 30px;">
					<tr>
						<td>
							<p><strong>Type of Loss:</strong>'.$inspectionDetails['result']['type_of_loss'].'</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-bottom: 30px;margin-top: 30px;">
					<tr>
						<td>
							<p><strong>DISCLAIMER:</strong> Every effort to include a complete literature and peer review has been made to ensure the accuracy of the information provided within this document. However, MoldExpert.com or the inspector does not warrant or make any representations as to the quality, content, accuracy, or completeness of this information. Such materials have been compiled from a variety of sources and are subject to change without notice. We currently do not test for mycotoxins or low-level VOCs.</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td style="border: 4px solid #5aaf24; background: #fff;">
				<table cellspacing="0" style="width: 100%;" cellpadding="8">
					<tr>
						<td colspan="3">
							<p>'
								.$inspectionDetails['result']['clientName'].'<br>'
								.$inspectionDetails['result']['address1'].'<br>'
								.$inspectionDetails['result']['phoneNumber'].'<br>'
								.$inspectionDetails['result']['email'].'
							</p>
						</td>
					</tr>
					<tr>
						<th align="left" style="background: #a7d098;font-size: 18px;">Rehabbed After 1978</th>
						<th align="left" style="background: #a7d098;font-size: 18px;">Yes</th>
						<th align="left" style="background: #a7d098;font-size: 18px;">No</th>
					</tr>
					<tr>
						<th align="left">Type Of Inspection</th>
						<td colspan="2">'.$inspectionDetails['result']['inspectionType'].'</td>
					</tr>
					<tr>
						<th align="left" style="background: #dcf3d3;">Payment Type</th>
						<td colspan="2" style="background: #dcf3d3;">'.$inspectionDetails['result']['payment_type'].'</td>
					</tr>
					<tr>
						<th align="left">Fee</th>
						<td colspan="2">$'.$inspectionDetails['result']['fees'].'</td>
					</tr>
					<tr>
						<th align="left" style="background: #dcf3d3;">Insurance Company</th>
						<td colspan="2" style="background: #dcf3d3;">No data</td>
					</tr>
					<tr>
						<th align="left">Policy Number</th>
						<td colspan="2">'.$inspectionDetails['result']['policy_number'].'</td>
					</tr>
					<tr>
						<th align="left" style="background: #dcf3d3;">Claim #</th>
						<td colspan="2" style="background: #dcf3d3;">'.$inspectionDetails['result']['claim_number'].'</td>
					</tr>
					<tr>
						<th align="left">Insurance Adjuster</th>
						<td colspan="2">Lorem Ipsum</td>
					</tr>
					<tr>
						<th align="left" style="background: #dcf3d3;">Claim Count</th>
						<td colspan="2" style="background: #dcf3d3;">'.$inspectionDetails['result']['claim_number'].'</td>
					</tr>
					<tr>
						<th align="left">Date Of Loss</th>
						<td colspan="2">'.$inspectionDetails['result']['date_of_loss'].'</td>
					</tr>
					<tr>
						<th align="left" style="background: #dcf3d3;">Remediation Company</th>
						<td colspan="2" style="background: #dcf3d3;">'.$inspectionDetails['result']['remediationCompany'].'</td>
					</tr>
					<tr>
						<th align="left">Public Adjuster</th>
						<td colspan="2">Name</td>
					</tr>
				</table>
			</td>
		</tr>

		'.$typeDetailsArea.'
		

		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-top: 30px; background: #dcf3d3; padding: 15px;">
					<tr align="left">
						<th>HVAC System</th>
						<th>HVAC System Value</th>
						<th>Ductwork</th>
					</tr>
					<tr>
						<td style="padding-top: 15px;">'.$dbInspection['hvacSystem'].'</td>
						<td style="padding-top: 15px;">'. $dbInspection['hvacSystemValue'].'</td>
						<td style="padding-top: 15px;">'. $dbInspection['ductwork'].'</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style=" background: #fff; padding: 15px;">
					<tr>
						<td>
							<p>All remediation work will be performed in accordance IICRC S520 and Federal EPA Documents, Mold Remediation Schools, including latest revisions and the proposed Florida Mold Related Services Standards of Practice (SOP).</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
';
   
        $areaDetails=$prearea;
        
        if(!empty($getAreas)){
            foreach($getAreas as $k=>$v){
                $mold_spores='';
                $mold_spores_span='';
                $findMold=explode(',',$v['mold_spores']);
                if(!empty($findMold)){
                  foreach($findMold as $kes=>$ves){
                       $mold_spores.='<li style="margin-top: 3px;">'.$ves.'</li>';
                       $mold_spores_span.='<span style="display: block;font-size: 12px;font-weight: 500;margin-top: 15px;">'.$ves.'</span>';
                      }  
                }
                $data='<tr>
						<td colspan="2" style="border: 1px solid #c7c7c7;">
							<table border="0" cellspacing="15" cellpadding="0" width="100%">
                            
							</table>
						</td>
					</tr> ';
                $bedroomDetails='
								<tr>
									<td colspan="2" style="background-color: #c5e3b1;padding: 10px;">
										<span style="display: inline-block;vertical-align: middle;">
											<img src="'.site_url().'/html/images/error.png" alt="Error">
										</span>
										<span style="display: inline-block;margin-left: 10px;vertical-align: middle;">
											<span style="display: block;font-size: 18px;font-weight: bold;">'.$v['areaName'].'</span>
											<span style="display: block;font-size: 14px;font-weight: normal;">'.$v['labResults'].'</span>
											'.$mold_spores_span.'
										</span>
									</td>
									
								</tr>
								';
           
    
    $areaDetails .='<tr>
			<td style="padding: 0px 0px 20px;">
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-top: 30px;">
					<tr>
						<td>
							<p><strong>Area #1:</strong> '. $v['areaName'].'</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td style="background-color: #f9f9f9;padding: 15px 20px 20px;">
				<table border="0" cellspacing="0" cellpadding="0" width="50%" style="table-layout: fixed;width: 100%;">
					<tr>
						<td style="padding: 10px;padding-left: 0;">
							<span style="display: block;font-size: 16px;margin-bottom: 5px;">Temperature</span>
							<span style="border-bottom: 1px solid #b5b5b5;display: block;font-size: 16px;height: 34px;padding: 0px 12px;line-height: 34px;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);box-shadow: inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;">'. $v['temprature'].'</span>
						</td>
						<td style="padding: 10px;padding-right: 0;">
							<span style="display: block;font-size: 16px;margin-bottom: 5px;">RH Ralative Humidity</span>
							<span style="border-bottom: 1px solid #b5b5b5;display: block;font-size: 16px;height: 34px;padding: 0px 12px;line-height: 34px;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);box-shadow: inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;">'. $v['rhRelativeHumidity'].'</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td style="padding-top: 20px">
				<strong>Samples:</strong>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td>
							<div style="background-color: #c5e3b1;margin: 10px 0;padding: 10px;">
								<table border="0" cellspacing="0" cellpadding="0" width="100%">
									<tr>
										<td>
											<span style="display: inline-block;vertical-align: middle;">
												<img src="'.site_url().'/html/images/error.png" alt="Error">
											</span>
										</td>
										<td>
											<span style="display: inline-block;margin-left: 10px;vertical-align: middle;">
												<span style="display: block;font-size: 18px;font-weight: bold;">Foyer</span>
												<span style="display: block;font-size: 14px;font-weight: normal;">'.$v['labResults'].'</span>
												<span style="display: block;font-size: 12px;font-weight: 500;margin-top: 10px;">Sample Type: '.$v['sampleType'].'</span>
												<span style="display: block;font-size: 10px;font-weight: 500;margin-top: 0px;">Serial#: '.$v['serial'].'</span>
											</span>
										</td>
										<td>
											<table border="0" cellspacing="0" cellpadding="0" width="100%">
												<tr>
													<td style="font-size: 14px;font-weight: 600;"><strong>Visual: '.$v['visualObservation'].'</strong></td>
													<td style="font-size: 14px;font-weight: 600;"><strong>Sample '.$v['type'].'</strong></td>
												</tr>
												<tr>
													<td colspan="2">
														<ul style="font-size: 12px;list-style: none;padding: 0;">
															'.$mold_spores.'
														</ul>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					
								</table>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td>
				<table border="0" cellspacing="15" cellpadding="0" width="100%" style="border: 1px solid #c7c7c7;margin-top: 15px;">
					<tr>
						<td>
							<div style="background-image: url('.$v['typeImage'].');background-position: center;background-repeat: no-repeat;-webkit-background-size: cover;background-size: cover;padding-bottom: 50%;"></div>
						</td>
						<td>
							<div style="background-image: url('.$v['typeDiagram'].');background-position: center;background-repeat: no-repeat;-webkit-background-size: cover;background-size: cover;padding-bottom: 50%;"></div>
						</td>
					</tr>
					
				</table>
			</td>
		</tr>

		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="background-color: #f9f9f9;margin-top: 15px;padding: 15px 20px 20px;table-layout: fixed;">
					<tr>
						<td style="padding: 10px;padding-left: 0;">
							<span style="display: block;font-size: 16px;margin-bottom: 5px;">Temperature</span>
							<span style="border-bottom: 1px solid #b5b5b5;display: block;font-size: 16px;height: 34px;padding: 0px 12px;line-height: 34px;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);box-shadow: inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;">'. $v['temprature'].'</span>
						</td>
					<!--</tr>
					<tr>-->
						<td style="padding: 10px;padding-right: 0;">
							<span style="display: block;font-size: 16px;margin-bottom: 5px;">RH Ralative Humidity</span>
							<span style="border-bottom: 1px solid #b5b5b5;display: block;font-size: 16px;height: 34px;padding: 0px 12px;line-height: 34px;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);box-shadow: inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;">'. $v['rhRelativeHumidity'].'</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>';
                        
                
            }
        }
       
    echo '
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Expert Reports | PDF</title>

	<link rel="icon" type="image/png" href="'.site_url().'/html/images/favicon-32x32.png" sizes="32x32" />
</head>
<body style="margin: 0;padding: 0;">
	<table border="0" cellspacing="0" cellpadding="0" style="@import url(\'https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900\');font-family: \'PT Sans\', sans-serif;margin: 0 auto;max-width: 820px;width: 100%;">
		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr style="background-image: url('.site_url().'/html/images/headerBg.jpg);">
						<td style="padding: 10px 15px;">
							<a href="#"><img src="'.site_url().'/html/images/logo.png" style="max-width: 180px;" alt="Expert Reports"></a>
						</td>
						<td style="padding: 10px 15px;">
							<span style="background-color: #000;color: #fff;display: block;font-size: 28px;padding: 10px;text-align: center;">Pre-Remediation Report</span>
						</td>
						<td style="padding: 10px 15px;" align="right">
							<img src="'.site_url().'/html/images/rightLogo.png" alt="Full Licensed & Insured">
						</td>
					</tr>
					<tr>
						<td colspan="3" align="center" style="background-color: #fff;font-size: 18px;font-weight: 700;padding: 10px 30px;">Priscilla Kercado <span style="color: #5aaf24;font-size: 16px;">122 Chicago Woods Cir, Orlando, FL 32824</span></td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-top: 30px;">
					<tr>
						<td>January 10, 2017</td>
					</tr>
					<tr>
						<td>
							<strong style="display: block;margin-top: 30px;">'.$inspectionDetails['result']['clientName'].'</strong>
							<span style="display: block;">'.$inspectionDetails['result']['address1'].'</span>
							<span style="display: block;">'.$inspectionDetails['result']['city'].','.$inspectionDetails['result']['state'].','.$inspectionDetails['result']['zip'].'</span>
						</td>
					</tr>

					<tr>
						<td style="padding-top: 30px;">Dear '.$inspectionDetails['result']['clientName'].',</td>
					</tr>

					<tr>
						<td>
							<p>Expert Inspections, LLC d.b.a. MoldExpert.com would like to present the findings of the mold testing done on the property listed above. This report covers the results of the testing as well as recommendations to correct any problems if necessary.</p>
							<p>Please review the entire report as many common questions are answered throughout.  If you have any questions please feel free to contact us at <a href="tel:844344-6653">(844) 344-MOLD (6653)</a>.</p>
							<p>You are welcome to also communicate with our office by email since this allows for faster customer service.  Requests for revisits or clarifications must be made by email, if possible. Our email address is <a href="mailto:info@moldexpert.com">info@moldexpert.com</a>. Please visit <a href="http://www.moldexpert.com" target="_blank">www.moldexpert.com</a> for more information and reference purposes.</p>
							<p>Thank you for giving us the opportunity to work with you.</p>
							<p>Sincerely,</p>

							<img src="'.site_url().'/html/images/sign.png" alt="">

							<p>
								Joe Puentes<br>
								Licensed Mold Assessor<br>
								1-844-344-MOLD
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td style="height: 257px;"></td>
		</tr>


		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td width="70%" style="position: relative;">
							<div class="imgWrapper" style="background-image: url(http://clientstagingdev.com/expertreports/html/images/image1.jpg);background-position: center;background-repeat: no-repeat;-webkit-background-size: cover;background-size: cover;bottom: 0;left: 0;position: absolute;right: 0;top: 0;"></div>
						</td>
						<td width="30%" align="right" style="background-color: #5aaf24;color: #fff;padding: 5px 30px;">
							<p><strong style="display: block;">Inspector:</strong><span>'.getInspectorName($_GET['inspectionId']).'</span></p>
							<p><strong style="display: block;">License:</strong><span></span></p>
							<p><strong style="display: block;">Date Tested:</strong><span>'.$inspectionDetailsOrder['order']['datetimeformatted'].'</span></p>
							<p><strong style="display: block;">Inspection Type:</strong><span>'.getInspectionType($inspectionDetailsOrder['order']['ordertype']).'</span></p>
						</td>
					</tr>
					<tr>
						<td width="70%" style="background-color: #231f20;color: #fff;padding: 5px 20px;">
							<span style="font-size: 18px;">Test Results</span>
						</td>
						<td width="30%" style="background-color: #231f20;color: #fff;padding: 5px 20px;">
							<span><img src="'.site_url().'/html/images/cloud.png" alt="weather" style="display: inline-block;vertical-align: middle;max-width: 40px;border-radius: 50%;"> <span style="display: inline-block;vertical-align: middle;">'.$dbInspection['hvacSystemValue'].'</span></span>
							<span style="margin-left: 30px;"><img src="'.site_url().'/html/images/temper.png" alt="Temperature" style="display: inline-block;vertical-align: middle;max-width: 40px;border-radius: 50%;"> <span style="display: inline-block;vertical-align: middle;">'.$dbInspection['outdoorTemprature'].' F</span></span>
						</td>
					</tr>
					'.$bedroomDetails.'
				</table>
			</td>
		</tr>

		'.$areaDetails.'
<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-top: 30px; background: #fff; padding: 15px;">
					<tbody><tr>
						<td>
							<ul style="list-style: none;list-style-position: outside;margin: 0;padding: 0;">
								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> Remove all materials affected by mold and/or water damage in an effort to restore abnormal conditions to normal indoor fungal ecology</li>

								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> Abate the moisture source in an effort to help limit the reoccurrence of abnormal indoor fungal ecology</li>
				  

								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> HVAC system (i.e. coil, insulation, fan motor, enclosure, etc.) must be cleaned and treated using a corrective method.</li>

								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> HVAC duct work needs decontamination by applying anti-microbial agents, either directly or through the return.</li>

								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> Maintain HEPA filtered intake &amp; positive exhaust air containment during remediation activity until post remediation verification is cleared.</li>

								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> PPE for this remediation project is N-95 respirator with eye protection and Tyvek coveralls.</li>

								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> Sheetrock that shows signs of mold should first be HEPA vacuumed before removal, if it cannot be sanitized, then be removed carefully in large pieces.</li>

								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> Sheetrock should be removed at least 18 to 24 inches beyond contamination.</li>

								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> All contaminated material and debris that have been removed will be disposed as regular waste after it is bagged and removed from the containment.</li>

								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> Any other affected substrate materials must be cleaned and treated in accordance with IICRC S520 Standards. If the compromised material cannot be restored, it must be removed and replaced.</li>

								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> Completely HEPA-Vacuum and then wet-wipe all vertical and horizontal surfaces in their entirety.</li>

								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> Entire condo/house/commercial building must be fogged with anti-microbial agents.</li>

								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> Containment area will be scrubbed for 24 hours after remediation prior to Post Remediation Verification. Air Scrubbers shall be turned off hours prior to the Post Remediation Verification. All remediated surfaces must be completely free of dust and debris.</li>

								<li style="margin-bottom: 15px;padding-left: 20px;position: relative;"><span style="left: 0;position: absolute;top: 0px;color: #f00;">&#9745;</span> Post Remediation Verification will consist of a Visual, Olfactory, and duplicate samples that were part of the initial assessment by a Licensed Mold Assessor. If Post Remediation Verification is successful, the Licensed Mold Assessor will issue a Clearance Certificate to the client indicating no additional action is needed by remediator.</li>
							</ul>
						</td>
					</tr>
				</tbody></table>
			</td>
		</tr><tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-top: 30px;background: #fff; padding: 15px;">
					<tbody><tr>
						<td>
							<h2>1. Sampling, Observations &amp; Recommendations: The following areas were sampled and selected by the inspector and the client:</h2>

							<p>The U.S Environmental Protection Agency (EPA), The American Society of Heating, Refrigeration and Air Conditioning Engineers (ASHRA) and The America Conference of Governmental Hygienists (ACGIH) have published guidelines referencing maintaining relative humidity at levels below 60% as a mold preventive measure. While factors exist that can contribute to mold growth in areas with relative humidity below 60% it is generally accepted as the upper end of the range of desired levels.</p>
							<p><strong>Clearance Testing/Post Remediation Testing:</strong></p>
							<p>Clearance testing should be performed after any type of mold removal or remediation to verify that the remediation was successful in reducing indoor microbial levels of equal to or below ambient outdoors. Testing is to be done after the cleanup phase of the remediation is completed, but prior to any walls being closed or components such as cabinets/flooring being reinstalled. <strong>* This includes testing inside and outside the containment areas.</strong></p>
						</td>
					</tr>

					<tr>
						<td>
							<h2>2. Testing &amp; Other Recommendations:</h2>

							<p>A visual inspection is conducted to ascertain any visible signs of fungal growth or water intrusion.</p>
							<p>Air samples for airborne countable fungal agents are performed using Air-O-Cell Spore Trap Cassettes. Samples are taken indoors and outdoors to compare the genus and numbers of airborne spores.</p>
							<p>Potentially contaminated surface samples are performed using a Tape or Swab and analyzed via direct microscopy. Potentially contaminated interstitial wall spaces are performed using a wall cavity check adapter and connected to a Spore Trap Cassette.</p>
							<p>There are currently no government regulations or health standards defining the allowable number of airborne fungal spores in buildings. However, there are several accepted protocols and studies that are currently used as industry standards:</p>

							<ul>
								<li style="margin-bottom: 10px;">New York City Department of Health Guidelines on Assessment and Remediation of Fungi in Indoor Environments.</li>
								<li style="margin-bottom: 10px;">OSHA Respiratory Protection Standard, 29 CFR Parts 1910 and 1926.</li>
								<li style="margin-bottom: 10px;">29 CFR 1910.146 Permit Required Confined Space Entry Program.</li>
								<li style="margin-bottom: 10px;">OSHA General Industry Standard 29 CFR 1910.</li>
								<li style="margin-bottom: 10px;">Applicable Federal, State and Local Administrative Codes, Rules and Statutes.</li>
								<li style="margin-bottom: 10px;">
									The American Conference of Government Industrial Hygienists (ACGIH).
									<ul style="margin-top: 10px;">
										<li style="margin-bottom: 10px;">ACGIH sates that indoor spore levels are generally less than outdoor levels.</li>
									</ul>
								</li>
							</ul>

							<p>At high levels, most sensitive or immune-compromised individuals will experience symptoms. Acceptable levels for individual genus and species vary since their toxicity, spore size, weight and other features that affect the occupants vary.</p>
							<p><u>Other Recommendations for Microbial Remediation Protocol:</u></p>
							<p>The following areas must be remediated and/or taken into account:</p>

							<ul>
								<li style="margin-bottom: 10px;">Remove and discard all exposed insulation.</li>
								<li style="margin-bottom: 10px;">
									Enhanced cleaning of all interior surfaces throughout the specified areas/findings  and adjoining spaces as necessary to remove settled spores using a HEPA filter equipped vacuum cleaner including but not limited to:
									<ul style="margin-top: 10px;">
										<li style="margin-bottom: 10px;">Cabinets.</li>
										<li style="margin-bottom: 10px;">Shelves.</li>
										<li style="margin-bottom: 10px;">In and behind all drawers, appliances and closets.</li>
									</ul>
								</li>
								<li style="margin-bottom: 10px;">Wet wiping of surfaces should be performed on non-porous surfaces where applicable.</li>
								<li style="margin-bottom: 10px;">Engineering controls (i.e. Air Scrubbers5 equipped with HEPA filters) should be operated inside the building during all enhanced cleaning efforts and for a minimum of 48 hours following completion prior to retesting home.</li>
								<li style="margin-bottom: 10px;">Dehumidifiers must be used as necessary to keep the relative humidity below 60%.</li>
								<li style="margin-bottom: 10px;">Bedding, clothing, furniture and all porous surfaces should be cleaned or discarded as instructed by remediator.</li>
								<li style="margin-bottom: 10px;">Distribute and isolate all air filtration devices throughout the remediated areas. Ensure during the course of the project that no old, contaminated or incorrectly installed filters are used to minimize post remediation testing failures or potentially cross contaminating other areas of the residence.</li>
								<li style="margin-bottom: 10px;">Any affected materials that are not removed, due to structural concerns or materials adjacent to affected materials that have been removed should be sanded, scrubbed, and cleaned in detail with a detergent agent. If mold substances cannot be completely removed then they shall be encapsulated.</li>
								<li style="margin-bottom: 10px;">HVAC System to include blower wheel, coil, jacket and all components to remove all dust, debris and visible mold.</li>
								<li style="margin-bottom: 10px;">Clean surfaces of air handler unit including blower fan, evaporator coils and blower fan compartment with a detergent agent. Detail cleaning of the air handler unit and its closet after all remediation is complete is recommended.</li>
								<li style="margin-bottom: 10px;">Any affected materials that are not removed, due to structural concerns or materials adjacent to affected materials that have been removed, shall be sanded, scrubbed, and cleaned in detail with a detergent agent. If mold substances cannot be completely removed then they shall be encapsulated.</li>
								<li style="margin-bottom: 10px;">Continued monitoring of areas for moisture issues is recommended.</li>
								<li style="margin-bottom: 10px;">All remediation should be performed by a Florida Licensed Mold Remediator. We recommend obtaining price proposals from licensed Mold Remediators prior to completion of the due diligence period to determine actual costs. The costs of remediation can vary greatly.</li>
								<li style="margin-bottom: 10px;">Detail Cleaning of all areas where remediation occurs is recommended.</li>
								<li style="margin-bottom: 10px;">A mold clearance should be obtained upon completion of the remediation efforts to determine its success.</li>
							</ul>

							<p><u>Protocol for the containment:</u></p>

							<ul>
								<li>PVC or wood supporting frames shall be utilized to ensure that the containments remain intact during the entire remediation and post-remediation procedures.</li>
								<li>The containment must be built using polyethylene sheeting of 6-mil thickness that  is clear or opaque and moisture resistant duct tape and spray on glue capable of continuously sealing polyethylene through project’s remediation duration.</li>
								<li>Ground Fault Circuit Interrupters (GFCI) to be used on all electrical equipment within the containment.</li>
								<li>The designated onsite clean storage area must be outside.</li>
								<li>Polyethylene bags of 6-mil thickness such as those used for asbestos-containing waste.</li>
								<li>A wet-vacuum cleaner and HEPA-filtered vacuum cleaner. All areas should be cleaned and sanitized and new filters installed prior to beginning the project. All filters shall be disposed of as contaminated waste material at the end of this project.</li>
								<li>Remove all contents from the affected areas that will be contained. All applicable contents must be HEPA vacuumed and damp wiped with a mild detergent solution prior to removal. In the event some contents cannot be removed e.g. large furnishings ensure they have been cleaned properly and are sealed with polyethylene sheeting of 6-mil thickness. Electronic equipment should be HEPA vacuumed only.</li>
								<li>Once all the affected materials have been removed HEPA vacuum to remove remaining dust and debris from the containment. Additionally, wipe down the interior of the containment to remove any particular matter that may statically bind to the walls of the containment.</li>
								<li>Air Filtration devices with HEPA filtration and in a sufficient number to provide a negative pressure between the containment and outside areas shall be operated continuously from the time containment is established through the time all demolition is completed.</li>
							</ul>
						</td>
					</tr>

					<tr>
						<td>
							<h2>3. TIPS (for controlling mold growth):</h2>

							<ul>
								<li>Encourage active airflow throughout the building.  Open windows.</li>
								<li>Utilize bathroom and kitchen extractor fans/range hood.  Make sure they vent to outside.</li>
								<li>Ventilate clothes dryer exhaust to outside.</li>
								<li>Do not dry clothes indoors.</li>
								<li>Correct any condensation problems with proper ventilation.</li>
								<li>Maintain an air gap between furniture and the walls.</li>
								<li>Clean and dry windows often, especially single panes and aluminum frames.</li>
								<li>Periodically check plumbing fixtures for signs of water leaks.</li>
								<li>Maintain comfortable temperatures in all living quarters.</li>
								<li>Insulate the home including water pipes.</li>
								<li>Keep the relative humidity below 60%, running a dehumidifier if necessary.  </li>
								<li>Maintain caulking and grouting in kitchens and bathrooms.</li>
								<li>Keep houseplants to a minimum.  Do not use a live Christmas tree.</li>
								<li>Do not store firewood indoors.</li>
								<li>Frequently clean / change the heating / cooling filter.</li>
								<li>Use a vacuum cleaner that incorporates a Hepa-Filter frequently.</li>
								<li>Keep a log of health problems – date, time and room associated.  Look for patterns.</li>
							</ul>
						</td>
					</tr>

					<tr>
						<td>
							<h2>4. Important Information:</h2>

							<p><u>Post Remediation:</u></p>
							<ul>
								<li>Samples need to be taken after remediation but before reconstruction. Please call MoldExpert.com at 844-344-MOLD (6653) to schedule a post-remediation mold inspection.</li>
								<li>Additional samples should be taken 3 to 6 months following reconstruction to check the indoor air quality.</li>
							</ul>

							<p><u>Contractor Qualifications:</u></p>
							<ul>
								<li>Mold remediation must be performed by a qualified company that is a State Licensed MRSR with experience and training in microbial remediation. The companies employees must also be deemed free of any immunological diseases, have a proper fit-tested respirator and meet other state requirements.</li>
								<li>All remediation must be performed in accordance with the New York City Department of Health’s Guidelines on Assessment and Remediation of Fungi in Indoor Environments, IICRC’s S520 Standard &amp; Reference Guide for Professional Mold Remediation and the National Air Duct Cleaners Association’s (NADCA) standards.</li>
							</ul>

							<p><u>Disclosure:</u></p>
							<p>It is beyond the scope of our assessment to determine the sources of any past or currant water intrusions. The results of our observations represent conditions only at the time of inspection. Thus, this report should not be relied on to represent conditions at other locations, times or dates. Limitations: Our opinions are based on the findings and upon our professional expertise with no warranty or guarantee implied herein. This report is intended for the sole use of the client. Moldexpert.com accepts no responsibility for interpretation of this report by others. Its contents shall not be used or relied upon by other parties without prior written authorization of Moldexpert.com.</p>
							<p>It is agreed that Moldexpert.com will be compensated for any and all time and preparation in relationship to any and all third party litigation and or insurance settlement at the rate of $475.00 per hour.</p>

							<p><u>Testing Information:</u></p>

							<ul>
								<li>Selected interior walls and ceilings described were checked for moisture using a Digital Moisture Meter.</li>
								<li>WME- Wood Moisture Equivalent. In wood, the Survey Master measures the material’s actual percent moisture content (Percent H2O). When testing material other than wood, the meter measures the wood moisture equivalent (WME) value of the material. WME is the moisture level that would be attained by a piece of wood in equilibrium with the material being tested. As the critical moisture levels for wood are known, WME measurements enable the moisture meter user to establish if materials are in a safe air dry, borderline or damp condition. Less than 12% - The material is in a safe dry condition, moisture related problems of decay/deterioration will not occur. 12% to 20% - The material is in a borderline condition, decay/deterioration may occur under certain conditions. Over 20% - The material is in a wet condition, decay/deterioration is inevitable in time unless the moisture level of material is reduced.</li>
								<li>Minimum 6 mill plastic sealed air tight from wall to wall and ceiling to floor isolating the remediated areas from the occupied spaces. Air scrubbers must be operating.</li>
								<li>Air Scrubbers should be properly inspected (i.e. no by-pass, clean filters) prior to operation in building.</li>
							</ul>
						</td>
					</tr>

					<tr>
						<td>
							<h2>References and Links:</h2>

							<ul>
								<li>
									<p><strong>Environmental Protection Agency (EPA) -</strong></p>
									<p><a href="#">http://www.epa.gov/mold/</a></p>
								</li>
								<li>
									<p><strong>A Brief Guide to Mold, Moisture, and Your Home – </strong></p>
									<p><a href="#">www2.epa.gov/mold/brief-guide-mold-moisture-and-your-home</a></p>
								</li>
								<li>
									<p><strong>Should You Have the Air Ducts in Your Home Cleaned? – </strong></p>
									<p><a href="#">www2.epa.gov/indoor-air-quality-iaq/should-you-have-air-ducts-your-home-cleaned</a></p>
								</li>
								<li>
									<p><strong>Flood Cleanup - Avoiding Indoor Air Quality Problems – </strong></p>
									<p><a href="#">www2.epa.gov/indoor-air-quality-iaq/flood-cleanup-protect-indoor-air-quality</a></p>
								</li>
								<li>
									<p><strong>Center for Disease Control and Prevention (CDC) – </strong></p>
									<p><a href="#">http://www.cdc.gov/mold/</a></p>
								</li>
								<li>
									<p><strong>General Information – </strong></p>
									<p><a href="#">http://www.cdc.gov/mold/basics.htm</a></p>
								</li>
								<li>
									<p><strong>Cleanup and Remediation – </strong></p>
									<p><a href="#">http://www.cdc.gov/mold/cleanup.htm</a></p>
								</li>
								<li>
									<p><strong>Occupational Safety &amp; Health Administration (OSHA) – </strong></p>
									<p><a href="#">http://www.osha.gov/SLTC/molds</a></p>
								</li>
								<li>
									<p><strong>American Academy of Allergy, Asthma &amp; Immunology (AAAAI) – </strong></p>
									<p><a href="#">http://www.aaaai.org</a></p>
								</li>
								<li>
									<p><strong>Institute of Inspection, Cleaning and Restoration Certification (IICRC) – </strong></p>
									<p><a href="#">http://www.iicrc.org</a></p>
								</li>
							</ul>
						</td>
					</tr>
				</tbody></table>
			</td>
		</tr>
		<tr>
			<td>
				<table border="0" cellspacing="15" cellpadding="0" width="100%" style="border: 1px solid #c7c7c7;margin-top: 580px;">
					<tr>
						<td>
							<img src="'.$documents['license'].'" alt="">
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td>
				<table border="0" cellspacing="15" cellpadding="0" width="100%" style="border: 1px solid #c7c7c7;margin-top: 15px;">
					<tr>
						<td>
							<img src="'. $documents['certificate'].'" alt="">
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td>
				<div style="border-bottom: 4px double #5aaf24;border-top: 4px double #5aaf24;color: #5aaf24;font-size: 16px;margin: 10px auto;/*max-width: 510px;*/padding: 10px 0px;text-align: center;">Phone:  1-844-344-MOLD | www.expertreports.com</div>
			</td>
		</tr>
	</table>
</body>
</html>';?>
</div>
<?php die; ?>
<div class="wrap">
  <h1>View Pdf Report</h1> <!--<a class="button button-primary" href="<?php //echo site_url().'/tcpdf/examples/example_066.php';?>" style="margin-bottom: 30px;">Upload PDF to ISN</a>-->
    
  <iframe width="100%" height="800px" src="<?php echo site_url().'/tcpdf/examples/example_066.php';?>"></iframe>
</div>
	<?php include 'includes/footer.php'; ?>