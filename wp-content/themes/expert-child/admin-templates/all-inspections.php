<?php 
include('includes/header.php');
global $wpdb;
if(isset($_GET['inspectionType'])){
    if($_GET['inspectionType']=='pending'){
          $inspectionTitle='Pending';
          $getAllInspection=$wpdb->get_results('select * from `im_inspection_details` where `status`="1" order by id desc',ARRAY_A); 
    }elseif($_GET['inspectionType']=='declined'){
         $inspectionTitle='Rejected';
          $getAllInspection=$wpdb->get_results('select * from `im_inspection_details` where `status`="3" order by id desc',ARRAY_A); 
    }elseif($_GET['inspectionType']=='approved'){
        $inspectionTitle='Approved';
       $getAllInspection=$wpdb->get_results('select * from `im_inspection_details` where `status`="2" order by id desc',ARRAY_A); 
    }else{
        $inspectionTitle='All';
     $getAllInspection=$wpdb->get_results('select * from `im_inspection_details` order by id desc',ARRAY_A);   
    }
}else{
    $inspectionTitle='All';
   $getAllInspection=$wpdb->get_results('select * from `im_inspection_details` order by id desc',ARRAY_A); 
}
$userLoginId=get_current_user_id();
$userData=get_user_by('id',$userLoginId);
$role=$userData->roles[0];
?>
<div class="wrap newForm">
	<div class="customAdmin">
        
		<h1 class="wp-heading-inline"><?php echo $inspectionTitle; ?> Inspections</h1>
        
        
		<hr class="wp-header-end">
		<div class="reponseDiv" style="display:none;"></div>
		<table id="tableId" class="wp-list-table widefat striped">
			<thead>
				<tr>
					<th>Sr.No</th>
					<th>Inspection Id</th>
					<th>Inspector Name</th>
					<th>Outdoor Temprature</th>
					<th>Type</th>
					<th>Hvac System</th>
					<th>Bullets</th>
					<th>Ductwork</th>
                    <?php if($role=='subscriber'){
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
                           ?>
							<tr>
								<td><?php echo $counter; ?></td>
								<td><?php echo $v['inspectionId'];?></td>
								<td><?php echo getInspectorName($v['id']);?></td>
								<td><?php echo $v['outdoorTemprature'];?></td>
								<td><?php echo ucfirst($v['enviornmentType']);?></td>
								<td><?php echo $v['hvacSystem'];?></td>
								<td><?php echo $v['bullets'];?></td>
								<td><?php echo $v['ductwork'];?></td>
                                <?php if($role=='subscriber'){
                                ?>
								<td>
									<?php if(empty($v['status'])) {
										?>
										<a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-primary  assignReporter">Accept</a>
										<?php
									} elseif($v['status']=='1') { //active
										?>
										<a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-primary acceptInspection">Submit to QA</a>
										<a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-danger declineInspection">Reject</a>
										<?php
									} elseif($v['status']=='2') { //accepted
										?><a href="javascript:void(0)" class="button button-primary customize">Approved</a><?php
									} else { //decline
										?><a href="javascript:void(0)" class="button button-danger">Rejected</a><?php
									} ?>
								</td>
                                <?php } ?>
								<td>
                              
									<a href="<?php echo site_url().'/wp-admin/admin.php?page=viewInspection'; ?>&inspectionId=<?php echo $v['id'];?>" data-id="<?php echo $v['id'];?>" class="button button-secondary"><i class="fa fa-eye"></i></a>
                                      <?php 
                            if($role=='contributor'){
                                $checkReportStatus=checkReportStatus($v['id']);
                                if($checkReportStatus['status']!='2'){
                                ?>
                                <a href="<?php echo site_url().'/wp-admin/admin.php?page=editInspection'; ?>&inspectionId=<?php echo $v['id'];?>" data-id="<?php echo $v['id'];?>" class="button button-warning"><i class="fa fa-pencil"></i></a>
                                 <?php
                                } 
                                
                            }elseif($role=='subscriber'){
                                if($v['status']!='2'){
                                ?>
                                <a href="<?php echo site_url().'/wp-admin/admin.php?page=editInspection'; ?>&inspectionId=<?php echo $v['id'];?>" data-id="<?php echo $v['id'];?>" class="button button-warning"><i class="fa fa-pencil"></i></a>
                                    <?php
                                } 
                                
                            }
                                
                                    ?>
									
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
                            <td class="text-center">No Inspection Found.</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            
                             <?php if($role=='subscriber'){
                                ?>
                            <td></td>
                            <?php } ?>
                            
                            
                            
                </tr>
						<?php
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th>Sr.No</th>
					<th>Inspection Id</th>
                    <th>Inspector Name</th>
					<th>Outdoor Temprature</th>
                    <th>Type</th>
					<th>Hvac System</th>
					<th>Bullets</th>
					<th>Ductwork</th>
                    <?php if($role=='subscriber'){
                                ?>
					<th>Status</th><?php } ?>
					<th>Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php include 'includes/footer.php'; ?>