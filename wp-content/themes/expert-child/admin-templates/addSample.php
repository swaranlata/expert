<?php
include('includes/header.php');
global $wpdb;
$success=0;
$getSample=$wpdb->get_row('select * from `im_samples` where `id`="'.$_GET['sampleId'].'"',ARRAY_A);
if(isset($_POST['addSample'])) {
     if(!empty($getSample)){
      $wpdb->query('update `im_samples` set `sampleType`="'.$_POST['additionalSampleType'].'",`sampleSerialNo`="'.$_POST['additionalSerial'].'",`sampleObservation`="'.$_POST['additionalObservation'].'" where `id`="'.$getSample['id'].'"');  
      $message='Samples updated successfully.';
      $sampleId=$getSample['id'];
    }else{
      $wpdb->query('insert into `im_samples`(`sampleType`,`sampleSerialNo`,`sampleObservation`,`areaId`) values("'.$_POST['additionalSampleType'].'","'.$_POST['additionalSerial'].'","'.$_POST['additionalObservation'].'","'.$_GET['areaId'].'")');  
      $message='Samples added successfully.';
      $sampleId=$wpdb->insert_id;
    }    
    if(!empty($_FILES['image']['name'])){
       $count=count($_FILES['image']['name']);
       for($i=0;$i<$count;$i++){
           if(!empty($_FILES['image']['name'][$i])){
                $upload_dir = wp_upload_dir();     
                $upload_dir['path'];
                $file_name = uniqid() . '.png';
                $file = $upload_dir['path'].'/'.$file_name;
                $return = $upload_dir['url'].'/'.$file_name;
                move_uploaded_file($_FILES['image']['tmp_name'][$i],$upload_dir['path'].'/'.$_FILES['image']['name'][$i]);    
                $return=str_replace(site_url(),'',$upload_dir['url'].'/'.$_FILES['image']['name'][$i]);
                $query='insert into `im_images`(`areaId`,`images`,`imageType`,`type`) values("'.$sampleId.'","'.$return.'","0","2")';
                $wpdb->query($query);
           }
       }
    }
    if(!empty($_FILES['diagram']['name'])){
       $countDia=count($_FILES['diagram']['name']);
       for($i=0;$i<$countDia;$i++){
           if(!empty($_FILES['diagram']['name'][$i])){
                $upload_dir = wp_upload_dir();     
                $upload_dir['path'];
                $file_name = uniqid() . '.png';
                $file = $upload_dir['path'].'/'.$file_name;
                $return = str_replace(site_url(),'',$upload_dir['url'].'/'.$_FILES['diagram']['name'][$i]);
                move_uploaded_file($_FILES['diagram']['tmp_name'][$i],$upload_dir['path'].'/'.$_FILES['diagram']['name'][$i]);    
                $qry='insert into `im_images`(`areaId`,`images`,`imageType`,`type`) values("'.$sampleId.'","'.$return.'","1","2")';
                $wpdb->query($qry); 
           }
            
       }  
    } 
    
    
    
    
    
    
    $success=1;
}
?>
<div class="wrap newForm">
  <h1>Add Sample</h1> <?php
    if(!empty($success)){
        ?>
    <div class="alert alert-success">
        <strong>Success!</strong> <?php echo $message;  ?>
    </div>
    <?php
    }
    
    ?>
	<form name="" action="" method="post" enctype="multipart/form-data">
		<input type="hidden" id="areaId" value="<?php echo $_GET['areaId']; ?>" />
		<table class="form-table">			
           <tr>
            <th>Additional Samples:</th>
            </tr>
            <tr>
                <th scope="row"><label for="exampleInputEmail1">Sample Type</label></th>
                <td> 
                <?php $samples=getSampleType(); ?>
                <select name="additionalSampleType" class="selectpicker form-control">
                     <option value="">Select Sample Type</option>
                    <?php 
                    if(!empty($samples)){
                        foreach($samples as $k=>$v){
                            $selected='';
                            if($getSample['sampleType']==$v->post_title){
                                $selected="selected";
                            }
                            ?>
                     <option <?php echo $selected; ?> value="<?php echo $v->post_title; ?>"><?php echo $v->post_title?></option>
                    <?php
                            
                        }
                    }
                    
                    
                    ?>
                   
                   
                    
                    </select>
                
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="exampleInputEmail1">Serial</label></th>
                <td><input type="text" name="additionalSerial" value="<?php echo $getSample['sampleSerialNo'];?>" class="form-control" ></td>
            </tr>
            <tr>
                <th scope="row"><label for="exampleInputEmail1">Observation</label></th>
                <td><input type="text" name="additionalObservation" value="<?php echo $getSample['sampleObservation'];?>" class="form-control" ></td>
            </tr>
            <tr>
                <th scope="row"><label for="exampleInputEmail1">Image</label></th>
                <td>
               <div class="imgSample msgcon">
                <input type="text" name="mgs">
                <div class="fileCon">
                    <label for="fileUp"><i class="fa fa-paperclip" aria-hidden="true"></i></label>
                    <input type="file" style="display:none" multiple name="image[]"  class="form-control" >
                </div>
            </div>
                   <!--  <input type="file" multiple name="image[]"  class="form-control" > -->
                    <?php
                        if(isset($_GET['sampleId']) and !empty($_GET['sampleId'])){
                            $images=getSampleImages($_GET['sampleId'],'image');
                            if(!empty($images)){
                              ?>
                                      <div class="imageContainer">
                                      <?php
                                foreach($images as $k=>$v){
                                    ?>
                                    <div class="imageContainerWrapper"><div class="imageContainerInner" style="background-image: url(<?php echo site_url().$v['images']; ?>)">
                                        <span>&times;</span>
                                    </div>
                                    </div>
                               <!--  <img src="<?php //echo site_url().$v['images']; ?>" width="50px"/> -->
                            <?php

                                }
                                        ?>
                                      </div>
                                        <?php
                            } 
                        }                    
                    ?>
                    
                    
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="exampleInputEmail1">Diagram</label></th>
                <td>
            <div class="imgSample msgcon">
                <input type="text" name="mgs">
                <div class="fileCon">
                    <label for="fileUp"><i class="fa fa-paperclip" aria-hidden="true"></i></label>
                     <input type="file"  style="display:none" multiple name="diagram[]" class="form-control" >
                    
                </div>
            </div>


                   
                 <?php  
                        if(isset($_GET['sampleId']) and !empty($_GET['sampleId'])){
                            $images=getSampleImages($_GET['sampleId'],'diagram');
                            if(!empty($images)){
                                      ?>
                                      <div class="imageContainer">
                                      <?php
                                foreach($images as $k=>$v){
                                    ?>
                                     <div class="imageContainerWrapper"><div class="imageContainerInner" style="background-image: url(<?php echo site_url().$v['images']; ?>)">
                                        <span class="areaImage" data-attr-id="<?php echo $v['id'];?>">&times;</span>
                                    </div>
                                    </div>
                            <?php

                                }
                                        ?>
                                      </div>
                                        <?php

                            } 
                        }                                           
                    
                    ?>
                
                
                </td>
            </tr>
            
		</table>
		<button type="submit" name="addSample" class="button button-primary">Submit</button>
	</form>
</div>
	<?php include 'includes/footer.php'; ?>