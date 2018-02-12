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
						<div class="boxInner">
							<h2>Total Inspections</h2>
                            <span><?php echo count($totalInspection); ?></span>
						</div>
					</div>
					<div class="box">
						<div class="boxInner">
							<h2>Approved Inspections</h2>
                            <span><?php echo count($approvedInspections); ?></span>
						</div>
					</div>
					<div class="box">
						<div class="boxInner">
							<h2>Declined Inspections</h2>
                            <span><?php echo count($declinedInspections); ?></span>
						</div>
					</div>
					<div class="box">
						<div class="boxInner">
							<h2>Pending Inspections</h2>
                            <span><?php echo count($pendingInspections); ?></span>
						</div>
					</div>
					    
				</div>
			</div>