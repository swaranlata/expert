<?php 
include('includes/header.php');
global $wpdb;
$getLabReports=$wpdb->get_results('select `inspectionId` from `im_labreports` where `report`!=""',ARRAY_A);
$inspectionArray=array();
$inspectionIds='';
if(!empty($getLabReports)){
	foreach($getLabReports as $k=>$v){
	   $inspectionArray[]=$v['inspectionId']; 
	}
	$inspectionIds=implode('","',$inspectionArray);
}
if(!empty($inspectionIds)){
 $query='select * from `im_inspection_details` where `status`="2" and `id` in ("'.$inspectionIds.'")';
 $getAllInspection=$wpdb->get_results($query,ARRAY_A);   
}else{
  $getAllInspection=array(); 
} 
?>
<div class="wrap">
	<div class="customAdmin">
		<h1 class="wp-heading-inline">All Reports</h1>
		<hr class="wp-header-end">
		<div class="reponseDiv" style="display:none;"></div>
		<table id="example" class="wp-list-table widefat striped">
			<thead>
				<tr>
					<th>Sr.No</th>
					<th>Inspection Id</th>
					<th>Outdoor Temprature</th>
					<th>Hvac System</th>
					<th>Bullets</th>
					<th>Ductwork</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$counter=1;
					if(!empty($getAllInspection)) {
						foreach($getAllInspection as $k=>$v) {
							$labReportStatus=getLabReportStatus($v['id']);
							?>
							<tr>
								<td><?php echo $counter; ?></td>
								<td><?php echo $v['inspectionId'];?></td>
								<td><?php echo $v['outdoorTemprature'];?></td>
								<td><?php echo $v['hvacSystem'];?></td>
								<td><?php echo $v['bullets'];?></td>
								<td><?php echo $v['ductwork'];?></td>
								<td>
									<?php if(empty($labReportStatus)) {
										?><a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-primary assignQA">Active</a><?php
									} elseif($labReportStatus=='1') { //active
										?>
										<a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-primary acceptReport">Accept</a>
										<a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-danger declineReport">Decline</a>
										<?php
									} elseif($labReportStatus=='2') { //accepted
										?><a href="javascript:void(0)" class="button button-primary">Accepted</a><?php
									} else { //decline
										?><a href="javascript:void(0)" class="button button-danger">Declined</a><?php
									} ?>
								</td>
							</tr>
							<?php
							$counter++;
						}
					} else {
						?>
						<tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>No Inspections found.</td><td></td>
                            <td></td>
                            <td></td></tr>
						<?php
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th>Sr.No</th>
					<th>Inspection Id</th>
					<th>Outdoor Temprature</th>
					<th>Hvac System</th>
					<th>Bullets</th>
					<th>Ductwork</th>
					<th>Status</th>  
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<!-- <div class="customAdmin">
	<h2>All Reports</h2>    
	<div class="reponseDiv" style="display:none;"></div>
	<table id="example" class="display " cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Sr.No</th>
				<th>Inspection Id</th>           
				<th>Outdoor Temprature</th>
				<th>Hvac System</th>
				<th>Bullets</th>
				<th>Ductwork</th>           
				<th>Status</th>           
					
			</tr>
		</thead>   
		<tbody>
			<?php 
			$counter=1;
			if(!empty($getAllInspection)){
				foreach($getAllInspection as $k=>$v){
					$labReportStatus=getLabReportStatus($v['id']);
			?>
			  <tr>
				<td><?php echo $counter; ?></td>
				<td><?php echo $v['inspectionId'];?></td>

				<td><?php echo $v['outdoorTemprature'];?></td>
				<td><?php echo $v['hvacSystem'];?></td>
				<td><?php echo $v['bullets'];?></td>
				<td><?php echo $v['ductwork'];?></td>
				<td>
					 <?php if(empty($labReportStatus)){
				?>
					 <a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-primary  assignQA">Active</a>
					<?php
			}elseif($labReportStatus=='1'){//active
				?>
					<a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-primary acceptReport">Accept</a>
					<a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-primary declineReport">Decline</a>  
					<?php
			}elseif($labReportStatus=='2'){//accepted
			   ?>   <a href="javascript:void(0)" class="button button-primary">Accepted</a>
				 
					<?php
			}else{//decline
				?> <a href="javascript:void(0)" class="button button-primary">Declined</a>                 
					<?php
				
			}?>
				</td>
			</tr>

			<?php
		$counter++;}
				?>
			<?php
			}else{
				?>
			<tr>
			<td colspan="6">No Inspections found.</td>
			</tr>
			<?php
			}?>


		</tbody>
		<tfoot>
		 <tr>
				<th>Sr.No</th>
				<th>Inspection Id</th>           
				<th>Outdoor Temprature</th>
				<th>Hvac System</th>
				<th>Bullets</th>
				<th>Ductwork</th>           
				<th>Status</th>           
	   
			</tr>
		</tfoot>
	</table>
</div> -->
<?php include 'includes/footer.php'; ?>