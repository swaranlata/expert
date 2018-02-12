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
$userLoginId=get_current_user_id();
$userData=get_user_by('id',$userLoginId);
$role=$userData->roles[0];
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
					<th>Report Id</th>
					<th>Reporter Name</th>
					<th>Outdoor Temprature</th>
					<th>Hvac System</th>
					<th>Bullets</th>
					<th>Ductwork</th>
					<?php if($role=='contributor'){
                                ?>
					<th>Status</th>
                    <?php } ?>
                    <th>Action</th>
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
								<td><?php echo getReporterName($v['id']);?></td>
								<td><?php echo $v['outdoorTemprature'];?></td>
								<td><?php echo $v['hvacSystem'];?></td>
								<td><?php echo $v['bullets'];?></td>
								<td><?php echo $v['ductwork'];?></td>
								  <?php if($role=='contributor'){
                                ?>
								<td>
									<?php if(empty($labReportStatus)) {
										?><a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-primary assignQA">Accept</a><?php
									} elseif($labReportStatus=='1') { //active
										?>
										<a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-primary acceptReport">Approve</a>
										<a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-danger declineReport">Reject</a>
										<?php
									} elseif($labReportStatus=='2') { //accepted
										?><a href="javascript:void(0)" class="button button-primary">Approved</a>
                                    <a href="<?php echo admin_url(); ?>admin.php?page=upload-pdf&inspectionId=<?php echo $v['id']; ?>" class="button button-primary">Submit to ISN</a>
                                    
                                    <?php
									} else { //decline
										?><a href="javascript:void(0)" class="button button-danger">Rejected</a><?php
									} ?>
								</td>
                                
                                
                                <?php } ?>
                                <td>
                                    <a href="javascript:void(0);" class="button button-primary">View Pdf</a>
                                    <!--<a href="<?php //echo admin_url().'admin.php?page=view-pdf&inspectionId='.$v['id']; ?>" class="button button-primary">View Pdf</a>-->
                                    
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
                            <td></td>
                            <td>No Reports found.</td>
                            <td></td><td></td>
                            <td></td>
                            <td></td></tr>
						<?php
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th>Sr.No</th>
					<th>Report Id</th>
                    <th>Reporter Name</th>
					<th>Outdoor Temprature</th>
					<th>Hvac System</th>
					<th>Bullets</th>
					<th>Ductwork</th>
                    <?php if($role=='contributor'){
                                ?>
					<th>Status</th>  
                    <?php } ?>
                    <th>Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php include 'includes/footer.php'; ?>