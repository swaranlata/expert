<?php
include 'includes/header.php';
global $wpdb;
$msg='';
if(isset($_POST['editInspectionDetails'])){
    $wpdb->query('update `im_inspection_details` set `outdoorTemprature`="'.$_POST['outdoorTemprature'].'",`hvacSystem`="'.$_POST['hvacSystem'].'",`bullets`="'.$_POST['bullets'].'",`ductwork`="'.$_POST['ductwork'].'",`hvacSystemValue`="'.$_POST['hvacSystemValue'].'",`spoke_count`="'.$_POST['spoke_count'].'",`enviornmentType`="'.$_POST['enviornmentType'].'" where `id`="'.$_GET['inspectionId'].'"');
    $msg='1';
}
$getInspection=$wpdb->get_row('select * from `im_inspection_details` where `id`="'.$_GET['inspectionId'].'"',ARRAY_A);

?>
<div class="wrap">
  <h1>Edit Inspection</h1>
    <?php
    if(!empty($msg)){
        ?>
    <div class="alert alert-success">
        <strong>Success!</strong> Inspection details updated successfully.
    </div>
    <?php
    }
    
    ?>
  <form method="post" name="edi-inspection" action="">
    <table class="form-table">
        <tr>
        <th scope="row"><label for="exampleInputEmail1">Outdoor Temprature</label></th>
        <td><input type="text" name="outdoorTemprature" value="<?php echo $getInspection['outdoorTemprature']; ?>" class="form-control" placeholder="Outdoor Temprature"></td>
        </tr>
        <tr>
        <th scope="row"><label for="exampleInputEmail1">Hvac System</label></th>
        <td>

        <select  class="form-control" name="hvacSystem">
              <?php 
            if(empty($getInspection['hvacSystem'])){
               ?>
            <option value="">Select Hvac System </option>
            <?php
            }
            $finalArrayHvacSimp=array(
                'Central'=>'Central',
                'Window'=>'Window',
                'Other'=>'Other'            
            );
            foreach($finalArrayHvacSimp as $k=>$v){
                $selectHvacSim='';
                if($k==$getInspection['hvacSystem']){
                   $selectHvacSim='selected'; 
                }
               ?>
            <option <?php echo $selectHvacSim; ?> value="<?php echo $k;  ?>"><?php echo $v;  ?></option>
            <?php
            }
            ?>
        
        </select>
        </td>

        </tr>
        <tr>
        <th>Type</th>
            <td>
                <input type="radio" <?php if($getInspection['enviornmentType']=='Rainy'){
    echo 'checked';
} ?> name="enviornmentType" value="Rainy"/> Rainy  &nbsp;
                <input type="radio" <?php if($getInspection['enviornmentType']=='Clear'){
    echo 'checked';
} ?> name="enviornmentType" value="Clear"/> Clear
            </td>
        </tr>
        <tr>
        <th scope="row"><label for="exampleInputEmail1">Hvac System Value</label></th>
        <td>

        <select  class="form-control" name="hvacSystemValue">
        <?php 
            if(empty($getInspection['hvacSystemValue'])){
               ?>
            <option value="">Select Hvac System Value</option>
            <?php
            }
            $finalArrayHvac=array(
                'Clean'=>'Clean',
                'Dirty'=>'Dirty',
                'Visual Mold'=>'Visual Mold'            
            );
            foreach($finalArrayHvac as $k=>$v){
                $selectHvac='';
                if($k==$getInspection['hvacSystemValue']){
                   $selectHvac='selected'; 
                }
               ?>
            <option <?php echo $selectHvac; ?> value="<?php echo $k;  ?>"><?php echo $v;  ?></option>
            <?php
            }
            ?>

        </select>
        </td>

        </tr>
        <tr>
        <th scope="row"><label for="exampleInputEmail1">Bullets</label></th>
        <td><input type="text" name="bullets" value="<?php echo $getInspection['bullets']; ?>" class="form-control" placeholder="Bullets"></td>
        </tr>
        <tr>
        <th scope="row"><label for="exampleInputEmail1">Spoke Count</label></th>
        <td>
        <select  class="form-control" name="spoke_count">
         <?php 
            if(empty($getInspection['spoke_count'])){
               ?>
            <option value="">Select Spoke Count</option>
            <?php
            }
            $finalArraySpoke=array(
                'Elevated Spore Count'=>'Elevated Spore Count',
                'Acceptable Spore Count'=>'Acceptable Spore Count'                      
            );
            foreach($finalArraySpoke as $k=>$v){
                $selectSpoke='';
                if($k==$getInspection['spoke_count']){
                   $selectSpoke='selected'; 
                }
               ?>
            <option <?php echo $selectSpoke; ?> value="<?php echo $k;  ?>"><?php echo $v;  ?></option>
            <?php
            }
            ?>   
        </select>
        </td>
        </tr>
        <tr>
        <th scope="row"><label for="exampleInputEmail1">Ductwork</label></th>
        <td>
        <select  class="form-control" name="ductwork">
            <?php 
            if(empty($getInspection['ductwork'])){
               ?>
            <option value="">Select Ductwork</option>
            <?php
            }
            $finalArray=array(
                'Clean'=>'Clean',
                'Dirty'=>'Dirty',
                'Visual Mold'=>'Visual Mold'            
            );
            foreach($finalArray as $k=>$v){
                $select='';
                if($k==$getInspection['ductwork']){
                   $select='selected'; 
                }
               ?>
            <option <?php echo $select; ?> value="<?php echo $k;  ?>"><?php echo $v;  ?></option>
            <?php
            }
            ?>

        </select>
        </td>
        </tr>
        
    </table>    
    <p class="submit">
      <button type="submit" name="editInspectionDetails" class="button button-primary">Submit</button>
    </p>
  </form>
</div>
<?php include 'includes/footer.php'; ?>