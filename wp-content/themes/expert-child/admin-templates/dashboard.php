<?php 
include('includes/header.php');
$totalInspection= totalInspection();
$approvedInspections= approvedInspections();
$declinedInspections= declinedInspections();
$pendingInspections= pendingInspections();
?>
<div class="container">
				<div class="boxContainer">
					<div class="box">
                        <a href="<?php echo site_url().'/wp-admin/admin.php?page=inspection';?>">
						<div class="boxInner">
							<h2>Total Inspections</h2>
							<div class="boxWrapper">
	                            <span><?php echo count($totalInspection); ?></span>
							</div>
						</div>
                            </a>
					</div>
					<div class="box">
                        <a href="<?php echo site_url().'/wp-admin/admin.php?page=inspection&inspectionType=approved';?>">
						<div class="boxInner">
							<h2>Approved Inspections</h2>
							<div class="boxWrapper">
	                            <span><?php echo count($approvedInspections); ?></span>
							</div>
						</div>
                        </a>
					</div>
					<div class="box">
                          <a href="<?php echo site_url().'/wp-admin/admin.php?page=inspection&inspectionType=declined';?>">
						<div class="boxInner">
							<h2>Declined Inspections</h2>
							<div class="boxWrapper">
	                            <span><?php echo count($declinedInspections); ?></span>
							</div>
						</div>
                              </a>
					</div>
					<div class="box">
                         <a href="<?php echo site_url().'/wp-admin/admin.php?page=inspection&inspectionType=pending';?>">
						<div class="boxInner">
							<h2>Pending Inspections</h2>
							<div class="boxWrapper">
	                            <span><?php echo count($pendingInspections); ?></span>
							</div>
						</div>
                        </a>
					</div>
					    
				</div>
			</div>