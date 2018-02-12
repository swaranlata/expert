<?php
/* Template Name: View PDF */

?>
	<?php
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

	//pr($inspectionDetailsOrder);

	$areaDetails='';

	if(!empty($getAreas)) {
		foreach($getAreas as $k=>$v) {
			$mold_spores='';
			$mold_spores_span='';
			$findMold=explode(',',$v['mold_spores']);
			if(!empty($findMold)) {
				foreach($findMold as $kes=>$ves) {
					$mold_spores.='<li style="margin-top: 3px;">'.$ves.'</li>';
					$mold_spores_span.='<span style="display: block;font-size: 12px;font-weight: 500;margin-top: 15px;">'.$ves.'</span>';
				}
			}

			$data='<tr>
				<td colspan="2" style="border: 4px solid #5aaf24;">
					<table border="0" cellspacing="15" cellpadding="0" width="100%"></table>
				</td>
			</tr> ';

			$bedroomDetails='<tr>
				<td colspan="2" style="background-color: #c5e3b1;padding: 10px;">
					<span style="display: inline-block;vertical-align: middle;"><img src="'.site_url().'/html/images/error.png" alt="Error"></span>
					<span style="display: inline-block;margin-left: 10px;vertical-align: middle;">
						<span style="display: block;font-size: 18px;font-weight: bold;">'.$v['areaName'].'</span>
						<span style="display: block;font-size: 14px;font-weight: normal;">'.$v['labResults'].'</span>
						'.$mold_spores_span.'
					</span>
				</td>
			</tr>';

			$areaDetails .='<tr>
				<td style="padding: 0px 0px 20px;">
					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin-top: 30px;">
						<tr>
							<td><p><strong>Area #1:</strong> '. $v['areaName'].'</p></td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td style="background-color: #f9f9f9;padding: 15px 20px 20px;">
					<table border="0" cellspacing="0" cellpadding="0" width="50%" style="table-layout: fixed;">
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
										<tr valign="top">
											<td>
												<span style="display: inline-block;vertical-align: middle;"><img src="'.site_url().'/html/images/error.png" alt="Error"></span>
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
															<ul style="font-size: 12px;list-style: none;padding: 0;">'.$mold_spores.'</ul>
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
					<!--</div>-->
				</td>
			</tr>
	<!--</table>
</td>
</tr>-->

		<tr>
			<td style="padding-bottom: 30px;">
				<table border="0" cellspacing="15" cellpadding="0" width="100%" style="border: 4px solid #5aaf24;margin-top: 15px;">
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
			<td style="background-color: #f9f9f9;padding: 15px 20px 20px;">
				<table border="0" cellspacing="0" cellpadding="0" width="50%" style="table-layout: fixed;">
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
	<table border="0" cellspacing="0" cellpadding="0" style="@import url(\'https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900\');font-family: \'PT Sans\', sans-serif;margin: 0 auto;/*max-width: 820px;width: 100%;*/">
		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr style="background-image: url('.site_url().'/html/images/headerBg.jpg);">
						<td style="padding: 10px 15px;">
							<a href="#"><img src="'.site_url().'/html/images/logo.png" style="max-width: 180px;" alt="Expert Reports"></a>
						</td>
						<td style="padding: 10px 15px;">
							<span style="background-color: #000;color: #fff;display: block;font-size: 28px;padding: 10px;text-align: center;">Post-Remediation Report</span>
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
							<strong style="display: block;margin-top: 30px;">Sample Customer</strong>
							<span style="display: block;">123 Mocking Bird Lane</span>
							<span style="display: block;">Miami, Fl 33143</span>
						</td>
					</tr>

					<tr>
						<td style="padding-top: 30px;">Dear Jone,</td>
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
			<td style="height: 260px;"></td>
		</tr>

		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td width="70%" style="position: relative;">
							<div class="imgWrapper" style="background-image: url('.site_url().'/html/images/image1.jpg);background-position: center;background-repeat: no-repeat;-webkit-background-size: cover;background-size: cover;bottom: 0;left: 0;position: absolute;right: 0;top: 0;"></div>
						</td>
						<td width="30%" align="right" style="background-color: #5aaf24;color: #fff;padding: 15px 30px;">
							<p><strong style="display: block;">Inspector:</strong><span>'.getInspectorName($_GET['inspectionId']).'</span></p>
							<p><strong style="display: block;">License:</strong><span>'.$inspectionDetailsOrder['order']['reportnumber'].'</span></p>
							<p><strong style="display: block;">Date Tested:</strong><span>'.$inspectionDetailsOrder['order']['datetimeformatted'].'</span></p>
							<p><strong style="display: block;">Inspection Type:</strong><span>'.getInspectionType($inspectionDetailsOrder['order']['ordertype']).'</span></p>
						</td>
					</tr>
					<tr>
						<td width="70%" style="background-color: #231f20;color: #fff;padding: 15px 20px;">
							<span style="font-size: 18px;">Test Results</span>
						</td>
						<td width="30%" style="background-color: #231f20;color: #fff;padding: 15px 20px;">
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
			<td style="padding-top: 0px;"></td>
		</tr>

		<tr>
			<td align="center" style="padding-top: 0px;">
				<table border="0" cellspacing="15" cellpadding="0" width="100%" style="border: 4px solid #5aaf24;margin-top: 15px;">
					<tr>
						<td align="center">
							<img src="'.$documents['license'].'" alt="">
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td style="padding-top: 220px;"></td>
		</tr>

		<tr>
			<td align="center">
				<table border="0" cellspacing="15" cellpadding="0" width="100%" style="border: 4px solid #5aaf24;margin-top: 15px;">
					<tr>
						<td align="center">
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
		<?php  include 'includes/footer.php'; ?>