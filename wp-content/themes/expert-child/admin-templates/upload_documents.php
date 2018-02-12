<?php
include('includes/header.php');
global $wpdb;
$successCert=0;
$selectDocuments=$wpdb->get_row('select * from `im_documents`',ARRAY_A);
if(isset($_POST['uploadDocuments'])){
    if(!empty($_FILES['certificate']['name'])){
        $upload_dir = wp_upload_dir();                
        $file_name =time().'_'.str_replace(' ','_',$_FILES['certificate']['name']);
        $file = $upload_dir['path'].'/'.$file_name;
        $returnCertifcate = $upload_dir['url'].'/'.$file_name;
        $success = move_uploaded_file($_FILES['certificate']['tmp_name'],$upload_dir['path'].'/'.$file_name);        
    }
    if(!empty($_FILES['license']['name'])){
        $upload_dir = wp_upload_dir();                
        $file_name =time().'_'.str_replace(' ','_',$_FILES['license']['name']);
        $file = $upload_dir['path'].'/'.$file_name;
        $returnLicense = $upload_dir['url'].'/'.$file_name;
        $success = move_uploaded_file($_FILES['license']['tmp_name'],$upload_dir['path'].'/'.$file_name); 
    }  
    if(!empty($selectDocuments)){
        $wpdb->query('truncate table `im_documents`');
        $query='insert into `im_documents`(`certificate`,`license`) values("'.$returnCertifcate.'","'.$returnLicense.'")'; 
    }else{
        $query='insert into `im_documents`(`certificate`,`license`) values("'.$returnCertifcate.'","'.$returnLicense.'")';
    }
    $wpdb->query($query);
    $successCert=1;
}
?>
<div class="wrap newForm">   
<div class="customAdmin">
		<h1 class="wp-heading-inline">Upload Documents</h1>
		<hr class="wp-header-end">
<?php
$userId=get_current_user_id();
$userDetails=get_user_by('id',$userId);

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
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="exampleInputEmail1">Certificate</label>
                    </th>
                    <td>


 <div class="imgSample msgcon">
                <input type="text" name="mgs">
                <div class="fileCon">
                    <label for="fileUp"><i class="fa fa-paperclip" aria-hidden="true"></i></label>
                    <input type="file" style="display:none"  name="certificate" required class="form-control"> 
                </div>
            </div><br><br>

                       
                        <?php
                        if(!empty($selectDocuments['certificate'])){
                            ?>
                        <img src="<?php echo $selectDocuments['certificate']; ?>" height="80px"/><br><br>
                        <a class="button button-primary" href="<?php echo $selectDocuments['certificate']; ?>" target="_blank">View</a>
                        <?php
                        }
                        
                        ?>
                    </td>

                </tr> 
                <tr>
                    <th scope="row">
                        <label for="exampleInputEmail1">License</label>
                    </th>
                    <td>

 <div class="imgSample msgcon">
                <input type="text" name="mgs">
                <div class="fileCon">
                    <label for="fileUp"><i class="fa fa-paperclip" aria-hidden="true"></i></label>
                     <input type="file"  style="display:none"  name="license" required class="form-control">
                </div>
            </div><br><br>
                   
                         <?php
                        if(!empty($selectDocuments['license'])){
                            ?>
                        <img src="<?php echo $selectDocuments['license']; ?>" height="80px"/><br><br>
                        <a class="button button-primary" href="<?php echo $selectDocuments['license']; ?>" target="_blank">View</a>
                      
                        <?php
                        }
                        
                        ?>
                    </td>

                </tr>
            
            
            </tbody>
        
        
        </table>
        <p class="submit">
      <button type="submit" name="uploadDocuments" class="button button-primary">Submit</button>
            <span><i>Already uploaded documents will be lost.When you submit new documents.</i></span>
    </p>
       
    </form>
    
    </div>
    </div>
    <?php


include 'includes/footer.php'; ?>