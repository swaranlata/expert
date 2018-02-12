<?php
include('includes/header.php');
global $wpdb;
if(isset($_POST['uploadFile'])){
    
}
?>
<div class="wrap">
    <h1>Upload Report to ISN SERVER</h1> 
    <i>This is the final step.</i>
    <br>
    <br>
    <form method="post">
        <input type="submit" value="Submit" name="uploadFile"/>
    </form>    
</div>
	<?php include 'includes/footer.php'; ?>