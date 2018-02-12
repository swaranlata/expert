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
$successCert=0;
if(isset($_POST['uploadDocuments'])){
    $queryDate='';
    if(!empty($_FILES['cerificate']['name'])){
        $upload_dir = wp_upload_dir();                
        $file_name =time().'_'.str_replace(' ','_',$_FILES['cerificate']['name']);
        $file = $upload_dir['path'].'/'.$file_name;
        $return = $upload_dir['url'].'/'.$file_name;
        $success = move_uploaded_file($_FILES['cerificate']['tmp_name'],$upload_dir['path'].'/'.$file_name);  
        $queryDate ='`certificate`="'.$file_name.'"';
        $query='update `im_inspection_details` set `report`="'.$return.'" where `id`="'.$getRow['id'].'"';
        $wpdb->query($query);
    }
    if(!empty($_FILES['license']['name'])){
        $upload_dir = wp_upload_dir();                
        $file_name =time().'_'.str_replace(' ','_',$_FILES['license']['name']);
        $file = $upload_dir['path'].'/'.$file_name;
        $return = $upload_dir['url'].'/'.$file_name;
        $success = move_uploaded_file($_FILES['license']['tmp_name'],$upload_dir['path'].'/'.$file_name);
        $queryDateLicen ='`license`="'.$file_name.'"';
        $query='update `im_inspection_details` set `report`="'.$return.'" where `id`="'.$getRow['id'].'"';
        $wpdb->query($query);
    }   
    $successCert=1;
}
?>
<div class="wrap">
    <h1></h1>
    <div id="MainView">
        <table class="dataTable" cellpadding="10">
            <tbody>
                <tr>
                    <td>Inspection ID</td>
                    <td>
                        <?php echo $getInspection['inspectionId'];?>
                    </td>
                </tr>
                <tr>
                    <td>Outdoor Temprature</td>
                    <td>
                        <?php echo $getInspection['outdoorTemprature'];?>
                    </td>
                </tr>
                <tr>
                    <td>Hvac System</td>
                    <td>
                        <?php echo $getInspection['hvacSystem'];?>
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
                    <td>creation Date</td>
                    <td>
                        <?php echo date('d/m/Y h:i A',strtotime($getInspection['created'])); ?>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2>Inspection View</h2>
        <table class="wp-list-table widefat striped" cellpadding="10">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Area Name</th>
                    <th>Visual Observation</th>
                    <th>Sample Type</th>
                    <th>Serial</th>
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
                            <td>
                                <a href="<?php echo site_url().'/wp-admin/admin.php?page=editArea'; ?>&areaId=<?php echo $v['id'];?>" class="button button-warning"><i class="fa fa-pencil"></i></a>
                                <!-- <a href="<?php echo site_url().'/wp-admin/admin.php?page=editArea'; ?>&areaId=<?php echo $v['id'];?>">Edit</a> -->


                                <a href="<?php echo site_url().'/wp-admin/admin.php?page=viewArea'; ?>&areaId=<?php echo $v['id'];?>" class="button button-secondary"><i class="fa fa-eye"></i></a>
                                <!-- <a href="<?php echo site_url().'/wp-admin/admin.php?page=viewArea'; ?>&areaId=<?php echo $v['id'];?>">View</a> -->

                            </td>
                        </tr>
                        <?php
                        $count++;
                    }
                }?>
            </tbody>
        </table>
    </div>
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
        <div class="form-group">
            <label for="exampleInputEmail1">Upload Lab Report</label>
            <input type="file" name="labReport" required accept="application/pdf" class="form-control">
        </div>
        <button type="submit" name="uploadLabReport" class="btn btn-primary">Submit</button>
    </form>
    <?php
}

$userId=get_current_user_id();
$userDetails=get_user_by('id',$userId);
if($userDetails->roles[0]=='administrator') {
    if(!empty($successCert)) {
        ?>
        <div class="alert alert-success" role="alert">
            <p>Documents uploaded successfully.</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <?php
    }
    ?>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleInputEmail1">Upload Certificate</label>
            <input type="file" name="certificate" required class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Upload License</label>
            <input type="file" name="license" required class="form-control">
        </div>
        <button type="submit" name="uploadDocuments" class="btn btn-primary">Submit</button>
    </form>
    <?php
}

include 'includes/footer.php'; ?>