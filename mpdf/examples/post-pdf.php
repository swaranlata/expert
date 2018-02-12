<?php
require '../../wp-config.php';
include("../mpdf.php");
// $mpdf=new mPDF('c','A4','','',32,25,47,47,10,10); 
$mpdf=new mPDF('c','A4','','',0,0,42.4,8,0,0); 
$mpdf->mirrorMargins = 1;

$header='<tr>
	<td>
		<table border="0" cellspacing="0" cellpadding="0" width="100%"  style="@import url(\'https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900\');font-family: \'PT Sans\', sans-serif;">
			<tr style="background-image: url('.site_url().'/html/images/headerBg.jpg);">
				<td style="padding: 10px 15px;"><a href="#"><img src="'.site_url().'/html/images/logo.png" style="max-width: 160px;" alt="Expert Reports"></a></td>
				<td style="padding: 10px 15px;"><span style="background-color: #000;color: #fff;display: block;font-size: 28px;padding: 10px;"><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>Post-Remediation Report<span>&nbsp;&nbsp;&nbsp;&nbsp;</span></span></td>
				<td style="padding: 10px 15px;" align="right"><img src="'.site_url().'/html/images/rightLogo.png" alt="Full Licensed & Insured"></td>
			</tr>
			<tr>
				<td colspan="3" align="right" style="background-color: #fff;font-size: 18px;font-weight: 700;padding: 10px 30px;">Priscilla Kercado <span style="color: #58ae1d;font-size: 16px;">122 Chicago Woods Cir, Orlando, FL 32824</span></td>
			</tr>
		</table>
	</td>
</tr>';
$headerE=$header;
$footer='<tr>
	<td style="@import url(\'https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900\');font-family: \'PT Sans\', sans-serif;">
		<div style="border-bottom: 4px double #58ae1d;border-top: 4px double #58ae1d;color: #58ae1d;font-size: 16px;margin: 10px auto;/*max-width: 510px;*/padding: 10px 0px;text-align: center;">Phone:  1-844-344-MOLD | www.expertreports.com</div>
	</td>
</tr>';
$footerE=$footer;
$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($headerE,'E');
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footerE,'E');
$html='
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Expert Reports | PDF</title>

	<pnk rel="icon" type="image/png" href="'.site_url().'/html/images/favicon-32x32.png" sizes="32x32" />
</head>
<body style="margin: 0;padding: 0;/*background:#f1fded*/">
	<table border="0" cellspacing="0" cellpadding="0" style="@import url(\'https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900\');font-family: \'PT Sans\', sans-serif;margin: 0 auto;/*max-width: 820px;*/width: 100%; border: 1px solid #fff;" >
		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="background: #fff;padding: 15px;">
					<tr>
						<td>January 10, 2017</td>
					</tr>
					<tr>
						<td>
							<strong style="display: block;margin-top: 30px;">Sample Customer</strong><br>
							<span style="display: block;">123 Mocking Bird Lane</span><br>
							<span style="display: block;">Miami, Fl 33143</span>
						</td>
					</tr>

					<tr>
						<td style="padding-top: 30px;">Dear Jone,</td>
					</tr>

					<tr>
						<td>
							<p>Expert Inspections, LLC d.b.a. MoldExpert.com would like to present the findings of the mold testing done on the property listed above. This report covers the results of the testing as well as recommendations to correct any problems if necessary.</p>
							<p>Please review the entire report as many common questions are answered throughout.  If you have any questions please feel free to contact us at <a style="color: #58ae1d; text-decoration: none; font-weight: 600;" href="tel:844344-6653">(844) 344-MOLD (6653)</a>.</p>
							<p>You are welcome to also communicate with our office by email since this allows for faster customer service.  Requests for revisits or clarifications must be made by email, if possible. Our email address is <a  style="color: #58ae1d; text-decoration: none; font-weight: 600;" href="mailto:info@moldexpert.com">info@moldexpert.com</a>. Please visit <a  style="color: #58ae1d; text-decoration: none; font-weight: 600;"href="http://www.moldexpert.com" target="_blank">www.moldexpert.com</a> for more information and reference purposes.</p>
							<p>Thank you for giving us the opportunity to work with you.</p>
							<p>Sincerely,</p>
<p>
							<img style="max-width:80px;margin:10px 0;" src="'.site_url().'/html/images/sign.png" alt="">
</p>
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
	</table>';
	$mpdf->WriteHTML($html);
	$mpdf->AddPage();
	$html1= '<table  style="@import url(\'https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900\');font-family: \'PT Sans\', sans-serif;" >
		<!-- Inspector Section -->
		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<!-- Inspector Content -->
					<tr>
						<td width="65%" style="background-image: url('.site_url().'/html/images/image1.jpg);background-position: center;background-repeat: no-repeat;-webkit-background-size: cover;background-size: cover;position: relative;">
							 <!--img src="'.site_url().'/html/images/image1.jpg" -->
						</td>
						<td width="35%" align="right" style="background-color: #58ae1d;color: #fff;padding: 20px 30px;">
							<p><strong style="display: block;">Inspector:</strong><br><span>Enrique Villamar</span></p><br>
							<p><strong style="display: block;">License:</strong><br><span>MRSA2320</span></p><br>
							<p><strong style="display: block;">Date Tested:</strong><br><span>2017-12-28</span></p><br>
							<p><strong style="display: block;">Inspection Type:</strong><br><span>Pre Inspection</span></p>
						</td>
					</tr>
					<!-- /Inspector Content -->

					<!-- Inspector Weather Section -->
					<tr>
						<td width="65%" style="background-color: #231f20;color: #fff;padding: 5px 20px;">
							<span style="font-size: 18px;">Test Results</span>
						</td>
						<td width="35%" style="background-color: #231f20;color: #fff;padding: 5px 20px;">
							<span><img src="'.site_url().'/html/images/cloud.png" alt="weather" style="display: inline-block;vertical-align: middle;max-width: 40px;"> <span style="display: inline-block;vertical-align: middle;">Clear</span></span>
							<span>&nbsp;&nbsp;&nbsp;</span>
							<span><img src="'.site_url().'/html/images/temper.png" alt="Temperature" style="display: inline-block;vertical-align: middle;max-width: 40px;"> <span style="display: inline-block;vertical-align: middle;">64° F</span></span>
						</td>
					</tr>
					<!-- /Inspector Weather Section -->

					<!-- Inspector Results -->
					<tr>
						<td colspan="2" style="border: 1px solid #c7c7c7;">
							<table border="0" cellspacing="15" cellpadding="0" width="100%">
								<tr>
									<td style="background-color: #c5e3b1;">
										<table border="0" cellspacing="0" cellpadding="0" width="100%">
											<tr>
												<td style="background-color: #c5e3b1;padding: 10px;">
													<span style="display: inline-block;vertical-align: middle;">
														<img src="'.site_url().'/html/images/error.png" alt="Error">
													</span>
												</td>
												<td>
													<span style="display: inline-block;margin-left: 10px;vertical-align: middle;">
														<span style="display: block;font-size: 18px;font-weight: bold;">Foyer</span>
														<span style="display: block;font-size: 14px;font-weight: normal;">Elevated Spore Counts</span>
														<span style="display: block;font-size: 12px;font-weight: 500;margin-top: 15px;">Penicillium/Aspergillus</span>
													</span>
												</td>
											</tr>
										</table>
									</td>
									<td style="background-color: #c5e3b1;">
										<table border="0" cellspacing="0" cellpadding="0" width="100%">
											<tr>
												<td style="background-color: #c5e3b1;padding: 10px;">
													<span style="display: inline-block;vertical-align: middle;">
														<img src="'.site_url().'/html/images/ok.png" alt="Ok">
													</span>
												</td>
												<td>
													<span style="display: inline-block;margin-left: 10px;vertical-align: middle;">
														<span style="display: block;font-size: 18px;font-weight: bold;">Master Bedroom</span>
														<span style="display: block;font-size: 14px;font-weight: normal;">Accepable Spore Counts</span>
														<span style="display: block;font-size: 12px;font-weight: 500;margin-top: 15px;">No Elevated Moods</span>
													</span>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td style="background-color: #c5e3b1;">
										<table border="0" cellspacing="0" cellpadding="0" width="100%">
											<tr>
												<td style="background-color: #c5e3b1;padding: 10px;">
													<span style="display: inline-block;vertical-align: middle;">
														<img src="'.site_url().'/html/images/error.png" alt="Error">
													</span>
												</td>
												<td>
													<span style="display: inline-block;margin-left: 10px;vertical-align: middle;">
														<span style="display: block;font-size: 18px;font-weight: bold;">Bedroom #3</span>
														<span style="font-size: 14px;font-weight: normal;">Elevated Spore Counts</span>
														<span style="display: block;font-size: 12px;font-weight: 500;margin-top: 15px;">Penicillium/Aspergillus</span>
													</span>
												</td>
											</tr>
										</table>
									</td>
									<td style="background-color: #c5e3b1;">
										<table border="0" cellspacing="0" cellpadding="0" width="100%">
											<tr>
												<td style="background-color: #c5e3b1;padding: 10px;">
													<span style="display: inline-block;vertical-align: middle;">
														<img src="'.site_url().'/html/images/warning.png" alt="Error">
													</span>
												</td>
												<td>
													<span style="display: inline-block;margin-left: 10px;vertical-align: middle;">
														<span style="display: block;font-size: 18px;font-weight: bold;">Hallway Bathroom</span>
														<span style="display: block;font-size: 14px;font-weight: normal;">See Observations</span>
														<span style="display: block;font-size: 12px;font-weight: 500;margin-top: 15px;">No Elevated Moods</span>
													</span>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<!-- /Inspector Results -->
				</table>
			</td>
		</tr>
		<!-- /Inspector Section -->

		<!-- /Type of Loss Disclaimer Section -->
	</table>';
	$mpdf->WriteHTML($html1);
	$mpdf->AddPage();
	$html2='<table  style="@import url(\'https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900\');font-family: \'PT Sans\', sans-serif;">
		<!-- Type of Loss Details Table Section -->
		<!-- Area Loop -->
		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="15" width="100%" style="margin-top: 20px;">
					<tr>
						<td>
							<p><strong>Area #1:</strong> NAME</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<!-- /Area Loop -->

		<!-- Area Details -->
		<tr>
			<td style="background-color: #f9f9f9;padding: 15px 20px 20px;">
				<table border="0" cellspacing="0" cellpadding="0" width="50%" style="table-layout: fixed;width: 100%;">
					<tr>
						<td style="padding: 10px;padding-left: 0;">
							<span style="display: block;font-size: 16px;margin-bottom: 5px;width: 100%;">Temperature</span>
							<span style="border-bottom: 1px solid #b5b5b5;display: block;font-size: 16px;height: 34px;padding: 0px 12px;line-height: 34px;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;width: 100%;">Dummy Text</span>
						</td>
						<td style="padding: 10px;padding-right: 0;">
							<span style="display: block;font-size: 16px;margin-bottom: 5px;width: 100%;">RH Ralative Humidity</span>
							<span style="border-bottom: 1px solid #b5b5b5;display: block;font-size: 16px;height: 34px;padding: 0px 12px;line-height: 34px;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;width: 100%;">Dummy Text</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<!-- /Area Details -->

		<!-- Area Samples -->
		<tr>
			<td style="padding-top: 20px">
				<strong>Samples:</strong>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td>
							<div style="background-color: #c5e3b1;margin: 10px 0;padding: 10px;">
								<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin: 10px 0;">
									<tr>
										<td style="background-color: #c5e3b1;margin: 10px 0;padding: 10px;">
											<span style="display: inline-block;vertical-align: middle;">
												<img src="'.site_url().'/html/images/error.png" alt="Error">
											</span>
										</td>
										<td style="background-color: #c5e3b1;margin: 10px 0;padding: 10px;">
											<span style="display: inline-block;margin-left: 10px;vertical-align: middle;">
												<span style="display: block;font-size: 18px;font-weight: bold;">Foyer</span>
												<span style="display: block;font-size: 14px;font-weight: normal;">Elevated Spore Counts</span>
												<span style="display: block;font-size: 12px;font-weight: 500;margin-top: 10px;">Sample Type: AOC</span>
												<span style="display: block;font-size: 10px;font-weight: 500;margin-top: 0px;">Serial#: 343434</span>
											</span>
										</td>
										<td style="background-color: #c5e3b1;margin: 10px 0;padding: 10px;">
											<table border="0" cellspacing="0" cellpadding="0" width="100%">
												<tr>
													<td style="font-size: 14px;font-weight: 600;"><strong>Visual: Abormal</strong></td>
													<td style="font-size: 14px;font-weight: 600;"><strong>Sample 1</strong></td>
												</tr>
												<tr>
													<td colspan="2">
														
															<p style="margin-top: 3px;">-Perecillium/Aspergilud (sample value entered by report writer as lab results)</p>
															<p style="margin-top: 3px;">-Stachybotrys (sample value entered by report writer as lab results)</p>
															<p style="margin-top: 3px;">-Nigro (sample value entered by report writer as lab results)</p>
														
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div style="background-color: #c5e3b1;margin: 10px 0;padding: 10px;">
								<table border="0" cellspacing="0" cellpadding="0" width="100%" style="margin: 10px 0;">
									<tr>
										<td style="background-color: #c5e3b1;margin: 10px 0;padding: 10px;">
											<span style="display: inline-block;vertical-align: middle;">
												<img src="'.site_url().'/html/images/error.png" alt="Error">
											</span>
										</td>
										<td style="background-color: #c5e3b1;margin: 10px 0;padding: 10px;">
											<span style="display: inline-block;margin-left: 10px;vertical-align: middle;">
												<span style="display: block;font-size: 18px;font-weight: bold;">Foyer</span>
												<span style="display: block;font-size: 14px;font-weight: normal;">Elevated Spore Counts</span>
												<span style="display: block;font-size: 12px;font-weight: 500;margin-top: 10px;">Sample Type: AOC</span>
												<span style="display: block;font-size: 10px;font-weight: 500;margin-top: 0px;">Serial#: 343435</span>
											</span>
										</td>
										<td style="background-color: #c5e3b1;margin: 10px 0;padding: 10px;">
											<table border="0" cellspacing="0" cellpadding="0" width="100%">
												<tr>
													<td style="font-size: 14px;font-weight: 600;"><strong>Visual: Abormal</strong></td>
													<td style="font-size: 14px;font-weight: 600;"><strong>Sample 2</strong></td>
												</tr>
												<tr>
													<td colspan="2">
														
															<p style="margin-top: 3px;">-Perecillium/Aspergilud (sample value entered by report writer as lab results)</p>
															<p style="margin-top: 3px;">-Stachybotrys (sample value entered by report writer as lab results)</p>
															<p style="margin-top: 3px;">-Nigro (sample value entered by report writer as lab results)</p>
														
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
			</td>
		</tr></table>
		<!-- /Area Samples -->

		<!-- Area Samples Images -->
    <table width="100%" style="@import url(\'https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900\');font-family: \'PT Sans\', sans-serif;">
		<!-- Type of Loss Details Table Section -->
		<tr>
			<td>
				<table border="0" cellspacing="15" cellpadding="0" width="100%" style="border: 1px solid #dcf3d3;margin-top: 15px; background: #fff;">
					<tr>
						<td>
                         <img width="100%" src="'.site_url().'/html/images/image3.jpg">
							<!--div style="background-image: url('.site_url().'/html/images/image3.jpg);background-position: center;background-repeat: no-repeat;-webkit-background-size: cover;background-size: cover;padding-bottom: 50%;"></div-->
						</td>
						<td>
                          <img width="100%" src="'.site_url().'/html/images/image5.jpg">
							<!--div style="background-image: url('.site_url().'/html/images/image4.jpg);background-position: center;background-repeat: no-repeat;-webkit-background-size: cover;background-size: cover;padding-bottom: 50%;"></div-->
						</td>
					</tr>
					<tr>
						<td>
                        <img width="100%" src="'.site_url().'/html/images/image5.jpg">
							<!--div style="background-image: url('.site_url().'/html/images/image5.jpg);background-position: center;background-repeat: no-repeat;-webkit-background-size: cover;background-size: cover;padding-bottom: 50%;"></div-->
						</td>
						<td>
                         <img width="100%" src="'.site_url().'/html/images/image3.jpg">
							<!--div style="background-image: url('.site_url().'/html/images/image6.jpg);background-position: center;background-repeat: no-repeat;-webkit-background-size: cover;background-size: cover;padding-bottom: 50%;"></div-->
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<!-- /Area Samples Images -->
        </table>
       <table width="100%" style="@import url(\'https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900\');font-family: \'PT Sans\', sans-serif;">
		<!-- Area Details -->
		<tr>
			<td style="background-color: #f9f9f9;padding: 15px 20px 20px;">
				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout: fixed;width: 100%;">
					<tr>
						<td style="padding: 10px;padding-left: 0;">
							<span style="display: block;font-size: 16px;margin-bottom: 5px;width: 100%;">Temperature</span>
							<span style="border-bottom: 1px solid #b5b5b5;display: block;font-size: 16px;height: 34px;padding: 0px 12px;line-height: 34px;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;width: 100%;">Dummy Text</span>
						</td>
						<td style="padding: 10px;padding-right: 0;">
							<span style="display: block;font-size: 16px;margin-bottom: 5px;width: 100%;">RH Ralative Humidity</span>
							<span style="border-bottom: 1px solid #b5b5b5;display: block;font-size: 16px;height: 34px;padding: 0px 12px;line-height: 34px;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;width: 100%;">Dummy Text</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<!-- Area Details -->

	<!-- Content -->
	
	
	<!-- /Content -->';

	$mpdf->WriteHTML($html2);
	$mpdf->AddPage();
	$html3='<table  style="@import url(\'https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900\');font-family: \'PT Sans\', sans-serif;">

		<!-- Certificate 1 -->
		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td align="center">
							<img src="'.site_url().'/html/images/dbpr.jpg" alt="" style="width: 100%;">
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<!-- /Certificate 1 -->

		<!-- Certificate 2 -->
		<tr>
			<td>
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td align="center">
							<img src="'.site_url().'/html/images/cli.jpg" alt="" style="width: 100%;">
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<!-- /Certificate 2 -->

		<!-- Footer -->
		
		<!-- Footer -->
	</table>';
	$mpdf->WriteHTML($html3);
	$html='
</body>
</html>';


$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

?>