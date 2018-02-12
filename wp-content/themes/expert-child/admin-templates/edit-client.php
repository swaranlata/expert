<?php
include 'includes/header.php';
global $wpdb;
$msg='';
if(isset($_POST['editClientDetails'])){
    $wpdb->query('update `im_clients` set `fullName`="'.$_POST['fullName'].'",`location`="'.$_POST['location'].'",`phoneNumber`="'.$_POST['phoneNumber'].'",`email`="'.$_POST['email'].'",`jobNumber`="'.$_POST['jobNumber'].'",`date`="'.$_POST['date'].'",`time`="'.$_POST['time'].'",`rehabbedAfterYear`="'.$_POST['rehabbedAfterYear'].'",`inspectionType`="'.$_POST['inspectionType'].'",`paymentType`="'.$_POST['paymentType'].'",`inspectionDate`="'.$_POST['inspectionDate'].'",`inspectionTime`="'.$_POST['inspectionTime'].'",`isnNotes`="'.$_POST['isnNotes'].'",`insuaranceCompany`="'.$_POST['insuaranceCompany'].'",`policyNumber`="'.$_POST['policyNumber'].'",`claim`="'.$_POST['claim'].'",`insuaranceAdjuster`="'.$_POST['insuaranceAdjuster'].'",`claimCount`="'.$_POST['claimCount'].'",`dateOfLoss`="'.$_POST['dateOfLoss'].'",`typeOfLoss`="'.$_POST['typeOfLoss'].'",`remedeationCompany`="'.$_POST['remedeationCompany'].'",`publicAdjuster`="'.$_POST['publicAdjuster'].'",`referralSource`="'.$_POST['referralSource'].'" where `id`="'.$_GET['clientId'].'"');
    $msg='1';
}
$getClientDetails=$wpdb->get_row('select * from `im_clients` where `id`="'.$_GET['clientId'].'"',ARRAY_A);

?>
<div class="wrap">
  <h1>Edit Inspection</h1>
    <?php
    if(!empty($msg)){
        ?>
    <div class="alert alert-success">
        <strong>Success!</strong> Client details updated successfully.
    </div>
    <?php
    }
    
    ?>
  <form method="post" name="edi-inspection" action="">
    <table class="form-table">
        <tr>
            <th scope="row"><label for="exampleInputEmail1">Full Name</label></th>
            <td><input type="text" name="fullName" value="<?php echo $getClientDetails['fullName']; ?>" class="form-control" placeholder="Full Name"></td>
        </tr>
        <tr>
            <th scope="row"><label for="exampleInputEmail1">Location</label></th>
            <td><input type="text" name="location" value="<?php echo $getClientDetails['location']; ?>" class="form-control" placeholder="Location"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Phone Number</label></th>
            <td><input type="text" name="phoneNumber" value="<?php echo $getClientDetails['phoneNumber']; ?>" class="form-control" placeholder="Phone Number"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Email</label></th>
            <td><input type="text" name="email" value="<?php echo $getClientDetails['email']; ?>" class="form-control" placeholder="Email"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Job Number</label></th>
            <td><input type="text" name="jobNumber" value="<?php echo $getClientDetails['jobNumber']; ?>" class="form-control" placeholder="Job Number"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Date</label></th>
            <td><input type="text" id="date" name="date" value="<?php echo date('d/m/Y',strtotime($getClientDetails['date'])); ?>" class="form-control" placeholder="Date"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Time</label></th>
            <td><input type="text" name="time" value="<?php echo $getClientDetails['time']; ?>" class="form-control timepickerclass" placeholder="Time"></td>
        </tr>
       <tr>
            <th scope="row">
                <label for="exampleInputEmail1">Rehabbed after years</label></th>
            <td>
                <input type="radio" <?php if(trim($getClientDetails['rehabbedAfterYear'])=='yes'){
    echo 'checked="checked"';
} ?> name="rehabbedAfterYear" value="yes"/>Yes
                <input <?php if(trim($getClientDetails['rehabbedAfterYear'])=='no'){
    echo 'checked="checked"';
} ?> type="radio" name="rehabbedAfterYear" value="no"/>No
           </td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Inspection Type</label></th>
            <td><input type="text" name="inspectionType" value="<?php echo $getClientDetails['inspectionType']; ?>" class="form-control" placeholder="Inspection Type"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Inspection Date</label></th>
            <td><input type="text" name="inspectionDate" value="<?php echo date('d/m/Y',strtotime($getClientDetails['inspectionDate'])); ?>" id="inspectionDate" class="form-control" placeholder="Inspection Date"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Inspection Time</label></th>
            <td><input type="text" name="inspectionTime" value="<?php echo $getClientDetails['inspectionTime']; ?>" class="form-control timepickerclass" placeholder="Inspection Time"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Isn Notes</label></th>
            <td><input type="text" name="isnNotes" value="<?php echo $getClientDetails['isnNotes']; ?>" class="form-control" placeholder="Isn Notes"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Insuarance Company</label></th>
            <td><input type="text" name="insuaranceCompany" value="<?php echo $getClientDetails['insuaranceCompany']; ?>" class="form-control" placeholder="Insuarance Company"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Policy Number</label></th>
            <td><input type="text" name="policyNumber" value="<?php echo $getClientDetails['policyNumber']; ?>" class="form-control" placeholder="Policy Number"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Claim</label></th>
            <td><input type="text" name="claim" value="<?php echo $getClientDetails['claim']; ?>" class="form-control" placeholder="Claim"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Insuarance Adjuster</label></th>
            <td><input type="text" name="insuaranceAdjuster" value="<?php echo $getClientDetails['insuaranceAdjuster']; ?>" class="form-control" placeholder="Insuarance Adjuster"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Claim Count</label></th>
            <td><input type="text" name="claimCount" value="<?php echo $getClientDetails['claimCount']; ?>" class="form-control" placeholder="Claim Count"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Date Of Loss</label></th>
            <td><input type="text" id="dateOfLoss" name="dateOfLoss" value="<?php echo date('d/m/Y',strtotime($getClientDetails['dateOfLoss'])); ?>" class="form-control" placeholder="Date Of Loss"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Type Of Loss</label></th>
            <td><input type="text" name="typeOfLoss" value="<?php echo $getClientDetails['typeOfLoss']; ?>" class="form-control" placeholder="Type Of Loss"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Remedeation Company</label></th>
            <td><input type="text" name="remedeationCompany" value="<?php echo $getClientDetails['remedeationCompany']; ?>" class="form-control" placeholder="Remedeation Company"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Public Adjuster</label></th>
            <td><input type="text" name="publicAdjuster" value="<?php echo $getClientDetails['publicAdjuster']; ?>" class="form-control" placeholder="Public Adjuster"></td>
        </tr>
       <tr>
            <th scope="row"><label for="exampleInputEmail1">Referral Source</label></th>
            <td><input type="text" name="referralSource" value="<?php echo $getClientDetails['referralSource']; ?>" class="form-control" placeholder="Referral Source"></td>
        </tr>
       
     
        
    </table>    
    <p class="submit">
      <button type="submit" name="editClientDetails" class="button button-primary">Submit</button>
    </p>
  </form>
</div>
<script>
jQuery(document).ready(function(){
    jQuery('.timepickerclass').timepicker();
    jQuery('#inspectionDate').datepicker({
		minDate: 0,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy"
        
	});
    jQuery('#dateOfLoss').datepicker({
		minDate: 0,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy"
        
	});
    jQuery('#date').datepicker({
		minDate: 0,
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1,
        dateFormat: "dd/mm/yy"
        
	});
});
</script>
<?php include 'includes/footer.php'; ?>