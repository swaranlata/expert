<?php 
include('includes/header.php');
global $wpdb;
$getAllReporter=getAllReporter();
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
    }elseif($_GET['inspectionType']=='pastdays'){
       $count=pastDaysDues(); 
        if(!empty($count)){
            $inspectionIds=implode('","',$count);
            $getAllInspection=$wpdb->get_results('select * from `im_inspection_details` where `id` in("'.$inspectionIds.'") order by id desc',ARRAY_A);             
        }else{
           $getAllInspection=array(); 
        }
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
$owner=getOwnerDetails();
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
					<th>Status</th>
					
					<th>Inspection Date</th>
					<th>Inspector Name</th>
					<th>Customer Name</th>
					<th>Reporter Name</th>
					<th>Address</th>
					<th>Phone Number</th>
					<th>Days Past</th>
					<!--<th>Outdoor Temprature</th>
					<th>Type</th>
					<th>Hvac System</th>
					<th>Bullets</th>
					<th>Ductwork</th>-->
                    <?php if($role=='contributor' || $role=='administrator'){ ?>
                    <th>Assign Reporter</th>
                    <?php }
                    if($role=='subscriber'){
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
                                <td><?php 
                                    if($v['status']=='0'){
                                        echo 'Pending';
                                    }elseif($v['status']=='1'){
                                        echo 'InProcess';
                                    }elseif($v['status']=='2'){
                                        echo 'Approved';
                                    }else{
                                        echo 'Rejected';
                                    }
                                    ?></td>
						
								
								<td><?php echo date('d M,Y',strtotime($v['inspectionDate']));?></td>
								<td><?php echo getInspectorName($v['id']);?></td>
                                <?php
                                    $insDetails= getInspectionDetailsById($v['inspectionId'],$owner); 
                                ?>
                                <td><?php $clientDetails= getClientDetailsById($insDetails['order']['client'],$owner);
                                    echo $clientDetails['client']['display'];
                                    ?></td>
                                 <td><?php echo getReporterName($v['id']); ?></td>
                                <td><?php  echo $clientDetails['client']['address1'].','.$clientDetails['client']['state'].','.$clientDetails['client']['zip']; ?></td>
                                <td><?php  echo $clientDetails['client']['mobilephone']; ?></td>
                                <td><?php 
                            $date1=date_create(date('Y-m-d',strtotime($v['inspectionDate'])));
                            $date2=date_create(date('Y-m-d',time()));
                            $diff=date_diff($date1,$date2);
                            echo $diff->days.' days';
                            ?></td>
                               
								<!--<td><?php /* echo $v['outdoorTemprature'];?></td>
								<td><?php echo ucfirst($v['enviornmentType']);?></td>
								<td><?php echo $v['hvacSystem'];?></td>
								<td><?php echo $v['bullets'];?></td>
								<td><?php echo $v['ductwork']; */?></td>-->
                                
                                 <?php if($role=='contributor' || $role=='administrator'){ ?>
                                <td>
                                    <input type="hidden" name="inspectionId" id="inspectionId" value="<?php  echo $v['id']; ?>"/>
                                    <select style="width:120px !important;" name="assignNewReporter" class="form=control assignNewReporter">
                                        <?php 
                                         $inspectionReporter=getReporterDetails($v['id']);                 if(empty($inspectionReporter)){
                                            ?>
                                          <option value="">Select Reporter</option>
                                        <?php
                                         }                              
                                                                                          
                                              $selectedClass="";                                            
                                       if(!empty($getAllReporter)){
                                            foreach($getAllReporter as $keyu=>$valu){
                                                if($valu->ID==$inspectionReporter){
                                                   $selectedClass="selected"; 
                                                }                                                
                                                ?>
                                                <option <?php echo $selectedClass; ?> value="<?php echo $valu->ID; ?>"><?php echo $valu->display_name; ?></option>
                                                <?php
                                                }
                                        }else{
                                            ?>
                                        <option value="">No Reporter found.</option>
                                        <?php
                                        }?>
                                    
                                    
                                    </select>
                                </td>
                                <?php } ?>
                                <?php if($role=='subscriber'){
                                ?>
								<td>
									<?php if(empty($v['status'])) {
										?>
										<a href="javascript:void(0);" data-id="<?php echo $v['id'];?>" class="button button-primary  assignReporter">Claim</a>
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
                                
                            }elseif($role=='administrator'){
                                ?>
                                   <!-- <a href="<?php //echo site_url().'/wp-admin/admin.php?page=deleteInspections'; ?>&inspectionId=<?php //echo $v['id'];?>" data-id="<?php //echo $v['id'];?>" class="button button-secondary"><i class="fa fa-remove"></i></a>-->
                                    <?php
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
                            
                            <td class="text-center">No Inspection Found.</td>
                            
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
                    <th>Status</th>
				
					<th>Inspection Date</th>
                    <th>Inspector Name</th>
                    <th>Customer Name</th>
                    <th>Reporter Name</th>
					<th>Address</th>
					<th>Phone Number</th>
					<th>Days Past</th>
					<!--<th>Outdoor Temprature</th>
                    <th>Type</th>
					<th>Hvac System</th>
					<th>Bullets</th>
					<th>Ductwork</th>-->
                     <?php if($role=='contributor' || $role=='administrator'){ ?>
                     <th>Assign Reporter</th>
                    <?php }
                    if($role=='subscriber'){
                                ?>
					<th>Status</th><?php } ?>
					<th>Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php include 'includes/footer.php'; ?>