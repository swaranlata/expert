<?php
include('includes/header.php');
global $wpdb;
$getInspection=$wpdb->get_row('select * from `im_inspection_details` where `id`="'.$_GET['inspectionId'].'"',ARRAY_A);
$getAreas=$wpdb->get_results('select * from `im_areas` where `inspectionId`="'.$_GET['inspectionId'].'"',ARRAY_A);
$success=0;
if(isset($_POST['uploadLabReport'])){
    $upload_dir = wp_upload_dir();                
    $file_name =time().'_'.str_replace(' ','_',$_FILES['labReport']['name']);
    $file = $upload_dir['path'].'/'.$file_name;
    $return = $upload_dir['url'].'/'.$file_name;
    $success = move_uploaded_file($_FILES['labReport']['tmp_name'],$upload_dir['path'].'/'.$file_name);  
    $getRow=$wpdb->get_row('select * from `im_labreports` where `inspectionId`="'.$_GET['inspectionId'].'"',ARRAY_A);
    if(!empty($getRow)){
       $query='update `im_labreports` set `report`="'.$return.'" where `id`="'.$getRow['id'].'"';
       $wpdb->query($query);  
    }else{
      $query='insert into `im_labreports`(`inspectionId`,`report`) values("'.$_GET['inspectionId'].'","'.$return.'")';
      $wpdb->query($query);  
    }
    $success=1;
}
$userLoginId=get_current_user_id();
$userData=get_user_by('id',$userLoginId);
$role=$userData->roles[0];
?>
<div class="wrap newForm">
    <h1></h1>
    <div id="MainView">
        <?php 
                            if($role=='contributor'){
                                $checkReportStatus=checkReportStatus($_GET['inspectionId']);
                                if($checkReportStatus['status']!='2'){
                                ?>
                                 <a class="editInspectionCladd button button-primary" href="<?php echo admin_url().'admin.php?page=editInspection&inspectionId='.$_GET['inspectionId']; ?>">Edit Inspection</a>
                                 <?php
                                } 
                                
                            }elseif($role=='subscriber'){
                                if($getInspection['status']!='2'){
                                ?>
                                <a class="editInspectionCladd button button-primary" href="<?php echo admin_url().'admin.php?page=editInspection&inspectionId='.$_GET['inspectionId']; ?>">Edit Inspection</a>
                                    <?php
                                } 
                                
                            }
                                
                                    ?>
       
        
        <table class="dataTable" cellpadding="10">
            <tbody>
                <tr>
                    <td>Inspection ID</td>
                    <td>
                        <?php echo $getInspection['inspectionId'];?>
                    </td>
                </tr> <tr>
                    <td>Inspector Name</td>
                    <td>
                        <?php echo getInspectorName($getInspection['id']);?>
                    </td>
                </tr>
                <tr>
                    <td>Outdoor Temprature</td>
                    <td>
                        <?php echo $getInspection['outdoorTemprature'];?>
                    </td>
                </tr> <tr>
                    <td>Type</td>
                    <td>
                        <?php echo $getInspection['enviornmentType'];?>
                    </td>
                </tr>
                <tr>
                    <td>Hvac System</td>
                    <td>
                        <?php echo $getInspection['hvacSystem'];?>
                    </td>
                </tr> <tr>
                    <td>Hvac System Value</td>
                    <td>
                        <?php echo $getInspection['hvacSystemValue'];?>
                    </td>
                </tr>
                <tr>
                    <td>Bullets</td>
                    <td>
                        <?php echo $getInspection['bullets'];?>
                    </td>
                </tr>
                <tr>
                    <td>Ductwork</td>
                    <td>
                        <?php echo $getInspection['ductwork'];?>
                    </td>
                </tr>
                <tr>
                    <td>Created On</td>
                    <td>
                        <?php echo date('d/m/Y h:i A',strtotime($getInspection['created'])); ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2>Inspection Areas</h2>
        <table class="wp-list-table widefat striped" cellpadding="10">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Area Name</th>
                    <th>Visual Observation</th>
                    <th>Sample Type</th>
                    <th>Serial</th>
                    <th>Temprature</th>
                    <th>RH Relative Humidity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count=1;
                if(!empty($getAreas)) {
                    foreach($getAreas as $k=>$v) {
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $v['areaName'];?></td>
                            <td><?php echo $v['visualObservation'];?></td>
                            <td><?php echo $v['sampleType'];?></td>
                            <td><?php echo $v['serial'];?></td>
                            <td><?php echo $v['temprature'];?></td>
                            <td><?php echo $v['rhRelativeHumidity'];?></td>
                            <td>
                                 <?php 
                            if($role=='contributor'){
                                $checkReportStatus=checkReportStatus($_GET['inspectionId']);
                                if($checkReportStatus['status']!='2'){
                                ?>
                                  <a href="<?php echo site_url().'/wp-admin/admin.php?page=editArea'; ?>&areaId=<?php echo $v['id'];?>" class="button button-warning"><i class="fa fa-pencil"></i></a>
                                 <?php
                                } 
                                
                            }elseif($role=='subscriber'){
                                if($getInspection['status']!='2'){
                                ?>
                                 <a href="<?php echo site_url().'/wp-admin/admin.php?page=editArea'; ?>&areaId=<?php echo $v['id'];?>" class="button button-warning"><i class="fa fa-pencil"></i></a>
                                    <?php
                                } 
                                
                            }
                                
                                    ?>
                              
                                
                                
                                <a href="<?php echo site_url().'/wp-admin/admin.php?page=viewArea'; ?>&areaId=<?php echo $v['id'];?>" class="button button-secondary"><i class="fa fa-eye"></i></a>
                                </td>
                        </tr>
                        <?php
                        $count++;
                    }
                }else{
                    ?>
                <tr>
                <td class="text-center" colspan="8">No Areas Found.</td>
                </tr>
                <?php
                }?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Sr.No</th>
                    <th>Area Name</th>
                    <th>Visual Observation</th>
                    <th>Sample Type</th>
                    <th>Serial</th>
                    <th>Temprature</th>
                    <th>RH Relative Humidity</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php
if(!empty($success)) {
    ?>
    <div class="alert alert-success" role="alert">
        <p>Lab Report uploaded successfully.</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <?php
}

if($getInspection['status']!='2' and $getInspection['status']!='3') {
    ?>
    <form method="post" action="" enctype="multipart/form-data">
        <label for="exampleInputEmail1">Upload Lab Report</label>
            <div class="msgcon">
                <input type="text" name="mgs">
                <div class="fileCon">
                    <label for="fileUp"><i class="fa fa-paperclip" aria-hidden="true"></i></label>
                     <input type="file" style="display:none" name="labReport" id="lab" required accept="application/pdf" class="form-control">
                </div>
            </div>
        <!-- <table class="dataTable" cellpadding="10">
            <tbody>
                <tr>
                    <td> <label for="exampleInputEmail1">Upload Lab Report</label></td>
                    <td>
                        <input type="file" name="labReport" required accept="application/pdf" class="form-control">
                    </td>
                </tr>
             </tbody>
        </table>-->
        <p class="submit">
            <button type="submit" name="uploadLabReport" class="button button-primary">Submit</button>
        </p>
    </form>
    <?php
} ?>
</div>



<?php
include 'includes/footer.php'; ?>