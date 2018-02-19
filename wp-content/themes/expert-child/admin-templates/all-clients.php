<?php 
include('includes/header.php');
global $wpdb;
$getAllClients=$wpdb->get_results('select * from `im_clients` order by id desc',ARRAY_A);  
?>
<div class="wrap">
	<div class="customAdmin">
        
		<h1 class="wp-heading-inline">All Clients</h1>
        
        
		<hr class="wp-header-end">
        <?php if(isset($_GET['status']) and $_GET['status']=='deleted'){
        ?>
        <div class="alert alert-success" role="alert">
            Client has been deleted successfully.
        </div>
        <script>
        setTimeout(function(){
            window.location.href='<?php echo admin_url().'admin.php?page=clients';?>';
        },2000);
        </script>
        <?php
    
        }?>
		<table id="tableId" class="wp-list-table widefat striped">
			<thead>
				<tr>
					<th>Sr.No</th>
					<th>Client Name</th>
					<th>Phone Number</th>
					<th>Email</th>
					<th>Inspection Type</th>
					<th>Payment Type</th>
					<th>Inspection DateTime</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
                  
					$counter=1;
					if(!empty($getAllClients)) {
						foreach($getAllClients as $k=>$v) {
                           $clientInspectionDetails=getClientInspectionDetails($v['clientId']);
                            
                           ?>
							<tr>
                                <td><?php echo $counter; ?></td>
                                <td><?php echo $v['fullName']; ?></td>
                                <td><?php echo $v['phoneNumber']; ?></td>
                                <td><?php echo $v['email']; ?></td>
                                <td><?php echo $clientInspectionDetails['inspectionType']; ?></td>
                                <td><?php echo $clientInspectionDetails['paymentType']; ?></td>
                                <td><?php echo date('d M,Y',strtotime($clientInspectionDetails['inspectionDate'])).'  '.$clientInspectionDetails['inspectionTime']; ?></td>
                                <td><a  class="button button-secondary"  href="<?php echo admin_url().'admin.php?page=edit-client&clientId='.$v['id']; ?>"><i class="fa fa-edit"></i></a>
                                    <a class="button button-secondary" href="<?php echo admin_url().'admin.php?page=view-client&clientId='.$v['id']; ?>"><i class="fa fa-eye"></i></a>
                                    <a  class="button button-secondary"  onclick="return confirm('Are you sure to delete the client.?')" href="<?php echo admin_url().'admin.php?page=delete-client&clientId='.$v['id']; ?>"><i class="fa fa-remove"></i></a></td>
                               
                
                                </tr>
							<?php
							$counter++;
						}
					} else {
						?>
						<tr>
                            <td></td>
                            <td></td>
                            <td></td><td></td>
                            <td class="text-center" >No Clients Found.</td>
                            
                            <td></td>
                            <td></td>
                            <td></td>
                            
                        </tr>
						<?php
					}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th>Sr.No</th>
					<th>Client Name</th>
					<th>Phone Number</th>
					<th>Email</th>
					<th>Inspection Type</th>
					<th>Payment Type</th>
                    <th>Inspection DateTime</th>
					<th>Action</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php include 'includes/footer.php'; ?>