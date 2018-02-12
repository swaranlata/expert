<?php 
include('includes/header.php');
global $wpdb;
$getAllInspection=$wpdb->get_results('select * from `im_inspection_details` order by id desc',ARRAY_A);
?>
<div class="wrap">
	<div class="customAdmin">
		<h1 class="wp-heading-inline">All Inspections</h1>
		<hr class="wp-header-end">
		<div class="reponseDiv" style="display:none;"></div>
		<table id="tableId" class="wp-list-table widefat striped">
			<thead>
				<tr>
					<th>Sr.No</th>
					<th>Inspection Id</th>
					<th>Inspector Name</th>
					<th>Outdoor Temprature</th>
					<th>Hvac System</th>
					<th>Bullets</th>
					<th>Ductwork</th>
					<th>Status</th>
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
								<td><?php echo $v['hvacSystem'];?></td>
								<td><?php echo $v['bullets'];?></td>
								<td><?php echo $v['ductwork'];?></td>
								<td>
									<?php if(empty($v['status'])) {
										?>
										<a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-primary  assignReporter">Active</a>
										<?php
									} elseif($v['status']=='1') { //active
										?>
										<a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-primary acceptInspection">Accept</a>
										<a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-danger declineInspection">Decline</a>
										<?php
									} elseif($v['status']=='2') { //accepted
										?><a href="javascript:void(0)" class="button button-primary customize">Accepted</a><?php
									} else { //decline
										?><a href="javascript:void(0)" class="button button-danger">Declined</a><?php
									} ?>
								</td>
								<td>
									<a href="<?php echo site_url().'/wp-admin/admin.php?page=viewInspection'; ?>&inspectionId=<?php echo $v['id'];?>" data-id="<?php echo $v['id'];?>" class="button button-secondary"><i class="fa fa-eye"></i></a>
									<a href="<?php echo site_url().'/wp-admin/admin.php?page=editInspection'; ?>&inspectionId=<?php echo $v['id'];?>" data-id="<?php echo $v['id'];?>" class="button button-warning"><i class="fa fa-pencil"></i></a>
								</td>
							</tr>
							<?php
							$counter++;
						}
					} else {
						?>
						<tr>
                            <td colspan="8" class="text-center">No Inspection Found.</td>
                            
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
					<th>Hvac System</th>
					<th>Bullets</th>
					<th>Ductwork</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php include 'includes/footer.php'; ?>