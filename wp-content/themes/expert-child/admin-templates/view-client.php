<?php
include('includes/header.php');
global $wpdb;
$getClient=$wpdb->get_row('select * from `im_clients` where `id`="'.$_GET['clientId'].'"',ARRAY_A);
if(isset($_GET['clientId'])){
  if(empty($getClient)){
       ?>
<script>
window.location.href='<?php echo admin_url().'admin.php?page=clients'; ?>';
</script>
<?php
  }  
}else{
    
    ?>
<script>
window.location.href='<?php echo admin_url().'admin.php?page=clients'; ?>';
</script>
<?php
}
$clientInspectionDetails=getClientInspectionDetails($getClient['clientId']);
?>
<div class="wrap">
    <h1>View Client Details</h1>
    <div id="MainView">
        <a style="float:right;" class="editInspectionCladd button button-primary" href="<?php echo admin_url().'/admin.php?page=editInspection&inspectionId='.$_GET['inspectionId']; ?>">Edit Client</a>
        <table class="dataTable" cellpadding="10">
            <tbody>
                <tr>
                    <td>Client Name :</td>
                    <td>
                        <?php echo $getClient['fullName'];?>
                    </td>
                </tr><tr>
                    <td>Location :</td>
                    <td>
                        <?php echo $getClient['location'];?>
                    </td>
                </tr><tr>
                    <td>Phone Number :</td>
                    <td>
                        <?php echo $getClient['phoneNumber'];?>
                    </td>
                </tr><tr>
                    <td>Email :</td>
                    <td>
                        <?php echo $getClient['email'];?>
                    </td>
                </tr><tr>
                    <td>Client Name :</td>
                    <td>
                        <?php echo $clientInspectionDetails['jobNumber'];?>
                    </td>
                </tr><tr>
                    <td>Date :</td>
                    <td>
                        <?php echo date('d M,Y',strtotime($clientInspectionDetails['date']));?>
                    </td>
                </tr><tr>
                    <td>Time :</td>
                    <td>
                        <?php echo $clientInspectionDetails['time'];?>
                    </td>
                </tr><tr>
                    <td>Rehabbed After Years? :</td>
                    <td>
                        <?php echo $clientInspectionDetails['rehabbedAfterYear'];?>
                    </td>
                </tr>
                <tr>
                    <td>Inspection Type :</td>
                    <td>
                        <?php echo $clientInspectionDetails['inspectionType'];?>
                    </td>
                </tr> 
                <tr>
                    <td>Payment Type :</td>
                    <td>
                        <?php echo $clientInspectionDetails['paymentType'];?>
                    </td>
                </tr>
                <tr>
                    <td>Inspection Date :</td>
                    <td>
                        <?php echo date('d M,Y',strtotime($clientInspectionDetails['inspectionDate']));?>
                    </td>
                </tr><tr>
                    <td>Inspection Time :</td>
                    <td>
                        <?php echo $clientInspectionDetails['inspectionTime'];?>
                    </td>
                </tr><tr>
                    <td>Isn Notes :</td>
                    <td>
                        <?php echo $clientInspectionDetails['isnNotes'];?>
                    </td>
                </tr><tr>
                    <td>Insuarance Company :</td>
                    <td>
                        <?php echo $clientInspectionDetails['insuaranceCompany'];?>
                    </td>
                </tr><tr>
                    <td>Policy Number :</td>
                    <td>
                        <?php echo $clientInspectionDetails['policyNumber'];?>
                    </td>
                </tr><tr>
                    <td>Claim :</td>
                    <td>
                        <?php echo $clientInspectionDetails['claim'];?>
                    </td>
                </tr>
              <tr>
                    <td>Insurance Adjuster :</td>
                    <td>
                        <?php echo $clientInspectionDetails['insuaranceAdjuster'];?>
                    </td>
                </tr><tr>
                    <td>Claim Count :</td>
                    <td>
                        <?php echo $clientInspectionDetails['claimCount'];?>
                    </td>
                </tr><tr>
                    <td>Date of Loss :</td>
                    <td>
                        <?php echo date('d M,Y',strtotime($clientInspectionDetails['dateOfLoss']));?>
                    </td>
                </tr><tr>
                    <td>Type of Loss :</td>
                    <td>
                        <?php echo $clientInspectionDetails['typeOfLoss'];?>
                    </td>
                </tr><tr>
                    <td>Remedetiation Company :</td>
                    <td>
                        <?php echo $clientInspectionDetails['remedeationCompany'];?>
                    </td>
                </tr>
                <tr>
                    <td>Public Adjuster :</td>
                    <td>
                        <?php echo $clientInspectionDetails['publicAdjuster'];?>
                    </td>
                </tr>
                <tr>
                    <td>Referal Source :</td>
                    <td>
                        <?php echo $clientInspectionDetails['referralSource'];?>
                    </td>
                </tr>
                <tr>
                    <td>Created Date :</td>
                    <td>
                        <?php echo date('d/m/Y h:i:s A',strtotime($getClient['created']));?>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </div>

</div>



<?php
include 'includes/footer.php'; ?>