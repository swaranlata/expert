<?php
include('includes/header.php');
global $wpdb;
$success=0;
if(isset($_POST['editInspection'])) {
    $mold_spores='';
    if(!empty($_POST['mold_spores'])){
      $mold_spores=implode(',',$_POST['mold_spores']);  
    }    
    $wpdb->query('update `im_areas` set `areaName`="'.$_POST['areaName'].'",`visualObservation`="'.$_POST['visualObservation'].'",`sampleType`="'.$_POST['sampleType'].'",`serial`="'.$_POST['serial'].'",`generalObservation`="'.$_POST['generalObservation'].'",`recommendations`="'.$_POST['recommendations'].'",`temprature`="'.$_POST['temprature'].'",`rhRelativeHumidity`="'.$_POST['rhRelativeHumidity'].'",`mold_spores`="'.$mold_spores.'",`labResults`="'.$_POST['lab_results'].'" where `id`="'.$_GET['areaId'].'"');
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
                $query='insert into `im_images`(`areaId`,`images`,`imageType`,`type`) values("'.$_GET['areaId'].'","'.$return.'","0","0")';
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
                $qry='insert into `im_images`(`areaId`,`images`,`imageType`,`type`) values("'.$_GET['areaId'].'","'.$return.'","1","0")';
                $wpdb->query($qry); 
           }
            
       }  
    }  
    if(!empty($_POST['data'])){
        $dataCount=count($_POST['data']);
        for($counter=1;$counter<=$dataCount;$counter++){
            if(isset($_POST['data'][$counter]['type']) and !empty($_POST['data'][$counter]['type'])){
                $checkIssueExist=getIssueId($counter,$_GET['areaId']);
                if(!empty($checkIssueExist)){
                   $query= 'update `im_issues` set `typeValue`="'.$_POST['data'][$counter]['typeValue'].'",`measurements`="'.$_POST['data'][$counter]['measurements'].'",`location`="'.$_POST['data'][$counter]['location'].'" where `id`="'.$checkIssueExist.'"';   
                }else{
                  $query= 'insert into `im_issues`(`selectionId`,`type`,`typeValue`,`measurements`,`location`,`areaId`) values("'.$_POST['data'][$counter]['selectionId'].'","'.$_POST['data'][$counter]['type'].'","'.$_POST['data'][$counter]['typeValue'].'","'.$_POST['data'][$counter]['measurements'].'","'.$_POST['data'][$counter]['location'].'","'.$_GET['areaId'].'")'; 
                }
                $wpdb->query($query);                  
            }         
        }
    }
    $_FILES['typeDiagram']=array_filter($_FILES['typeDiagram']);
    if(!empty($_FILES['typeDiagram'])){
        for($itest=1;$itest<12;$itest++){  
            $_FILES['typeDiagram']['name'][$itest]=array_filter($_FILES['typeDiagram']['name'][$itest]);
            foreach($_FILES['typeDiagram']['name'][$itest] as $k=>$v){
                if(!empty($v)){
                    $getIssueId=getIssueId($itest,$_GET['areaId']);
                    $upload_dir = wp_upload_dir();   
                    $return = str_replace(site_url(),'',$upload_dir['url'].'/'.$v);
                    move_uploaded_file($_FILES['typeDiagram'][$itest]['tmp_name'][$i],$upload_dir['path'].'/'.$v);   
                    if(!empty($getIssueId)){
                        $wpdb->query('insert into `im_images`(`areaId`,`images`,`imageType`,`type`) values("'.$getIssueId.'","'.$return.'","1","1")');  
                    }
                }                
            }            
        }
    }
    if(!empty($_FILES['typeImage'])){
        for($i=1;$i<12;$i++){   
            $_FILES['typeImage']['name'][$i]=array_filter($_FILES['typeImage']['name'][$i]);   
            foreach($_FILES['typeImage']['name'][$i] as $k=>$v){
                if(!empty($v)){
                    $getIssueId=getIssueId($i,$_GET['areaId']);
                    $upload_dir = wp_upload_dir();   
                    $return = str_replace(site_url(),'',$upload_dir['url'].'/'.$v);
                    move_uploaded_file($_FILES['typeImage']['tmp_name'][$i][$k],$upload_dir['path'].'/'.$v); 
                    if(!empty($getIssueId)){
                       $qry='insert into `im_images`(`areaId`,`images`,`imageType`,`type`) values("'.$getIssueId.'","'.$return.'","0","1")';
                        $wpdb->query($qry); 
                    }                    
                }                                                                     
            }            
        }
    }
    $success=1;
   }
$getAreaDetails=$wpdb->get_row('select * from `im_areas` where `id`="'.$_GET['areaId'].'"',ARRAY_A);


?>
	<div class="wrap newForm">
		<h1>Edit Area</h1>
		<?php
    if(!empty($success)){
        ?>
			<div class="alert alert-success">
				<strong>Success!</strong> Area details updated successfully.
			</div>
			<?php
    }
    
    ?>
				<form name="" action="" method="post" enctype="multipart/form-data">
					<input type="hidden" id="areaId" value="<?php echo $_GET['areaId']; ?>" />
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="exampleInputEmail1">Area Name :</label>
							</th>
							<td>
								<input type="text" name="areaName" value="<?php echo $getAreaDetails['areaName'];?>" class="form-control" placeholder="Area Name">
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exampleInputEmail1">Visual Observation :</label>
							</th>
							<td>
								<div class="radio ">
									<label>
										<input type="radio" <?php if( 'normal'==strtolower($getAreaDetails[ 'visualObservation'])){ echo 'checked'; } ?> name="visualObservation" value="Normal">Normal </label>
								</div>
								<div class="radio ">
									<label>
										<input type="radio" <?php if( 'abnormal'==strtolower($getAreaDetails[ 'visualObservation'])){ echo 'checked'; } ?> name="visualObservation" value="Abnormal">Abnormal </label>
								</div>
							</td>
						</tr>
						<tr>
                             <?php $samples=getSampleType(); ?>
							<?php
                            
                           // $selectArray = array('AOC');
                            ?>
							<th scope="row">
								<label for="exampleInputEmail1">Sample Type  :</label>
							</th>
							<td>
								<select name="sampleType" class="selectpicker form-control">
                                    <?php 
                                    if(!empty($samples)){
                        foreach($samples as $k=>$v){
                            $selected='';
                            if($getAreaDetails['sampleType']==$v->post_title){
                                $selected="selected";
                            }
                            ?>
                     <option <?php echo $selected; ?> value="<?php echo $v->post_title; ?>"><?php echo $v->post_title?></option>
                    <?php
                            
                        }
                    }
                                    ?>
									<?php
                       /* if(!empty($selectArray)) {
                            $selected='';
                            foreach($selectArray as $k=>$v){
                                if(strtolower($v)==strtolower($getAreaDetails['sampleType'])) {
                                    $selected='selected="selected"';
                                }
                                ?>
										<option value="<?php echo $v; ?>">
											<?php echo $v; ?>
										</option>
										<?php
                            }
                        } */
                        ?>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exampleInputEmail1">Serial :</label>
							</th>
							<td>
								<input type="text" name="serial" value="<?php echo $getAreaDetails['serial'];?>" class="form-control" placeholder="Serial">
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exampleInputEmail1">General Observation :</label>
							</th>
							<td>
								<input type="text" value="<?php echo $getAreaDetails['generalObservation'];?>" name="generalObservation" class="form-control" placeholder="General Observation">
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exampleInputEmail1">Recommendation :</label>
							</th>
							<td>
                                <textarea name="recommendations" class="form-control" ><?php echo $getAreaDetails['recommendations'];?></textarea>
								<!--<input type="text" value="<?php //echo $getAreaDetails['recommendations'];?>" name="recommendations" class="form-control" placeholder="Recommendation">-->
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exampleInputEmail1">Temprature :</label>
							</th>
							<td>
								<input type="text" value="<?php echo $getAreaDetails['temprature'];?>" name="temprature" class="form-control" placeholder="Temprature">
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exampleInputEmail1">RH relative Humidity :</label>
							</th>
							<td>
								<input type="text" name="rhRelativeHumidity" value="<?php echo $getAreaDetails['rhRelativeHumidity'];?>" class="form-control" placeholder="RH relative Humidity">
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exampleInputEmail1">Image :</label>
							</th>
							<td>
								<div class="imgSample msgcon">
									<input type="text" name="mgs">
									<div class="fileCon">
										<label for="fileUp"><i class="fa fa-paperclip" aria-hidden="true"></i> </label>
										<input type="file" style="display:none" multiple name="image[]" class="form-control">
									</div>
								</div>
								<?php $getAreaImages = getAreaImages($_GET['areaId'],'image');
                    if(!empty($getAreaImages)){
                    	?>
                    	<div class="imageContainer">
                    	<?php
                        foreach($getAreaImages as $k=>$v){
                            ?>
								<div class="imageContainerWrapper"><div class="imageContainerInner" style="background-image: url(<?php echo site_url().$v['images']; ?>)"><span class="areaImage" data-attr-id="<?php echo $v['id'];?>" >&times;</span></div></div>
								<!-- <img src="<?php //echo site_url().$v['images']; ?>" width="60px"/> -->
								<?php
                        }
                        ?>
	                    </div>
                        <?php
                    }
                    
                    ?>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exampleInputEmail1">Diagram :</label>
							</th>
							<td>
								<div class="imgSample msgcon">
									<input type="text" name="mgs">
									<div class="fileCon">
										<label for="fileUp"><i class="fa fa-paperclip" aria-hidden="true"></i> </label>
										<input type="file" style="display:none" multiple name="diagram[]" class="form-control">
									</div>
								</div>
								<?php $getAreaImages = getAreaImages($_GET['areaId'],'diagram');
                    if(!empty($getAreaImages)){
                    	?>
                    	<div class="imageContainer">
                    	<?php
                        foreach($getAreaImages as $k=>$v){
                            ?>
								<div class="imageContainerWrapper"><div class="imageContainerInner" style="background-image: url(<?php echo site_url().$v['images']; ?>)"><span class="areaImage" data-attr-id="<?php echo $v['id'];?>">&times;</span></div></div>
								<!-- <img src="<?php echo site_url().$v['images']; ?>" width="60px"/> -->
								<?php
                        }
                        ?>
                        </div>
                        <?php
                    }
                    
                    ?>
							</td>
						</tr>
						<tr>
							<th scope="row"></th>
							<td>
								<?php
                    global $wpdb;
                    $array=$wpdb->get_results('select `id`,`name` from `im_selections`',ARRAY_A);
                    $getSelectedIssues=getSelectedIssues($getAreaDetails['id']);
                    if(!empty($array)) {
                        foreach($array as $k=>$v) {
                            $checked='';
                            if(in_array($v['id'],$getSelectedIssues)) {
                                $checked='checked';
                            }
                            $issueId=getIssueId($v['id'],$_GET['areaId']);
                            $issueDetails=getIssueDetails($issueId);
                            if(empty($issueDetails)){
                              $issueDetails=array(); 
                            }
                            ?>
									<div class="radio editPopup" data-final-value="<?php echo $v['id']; ?>" data-valu="<?php echo $v['name']; ?>">
										<label>
											<input <?php echo $checked; ?> type="checkbox" name="data[<?php echo $v['id']; ?>][type]" value="<?php echo $v['name']; ?>">
											<?php echo $v['name']; ?>
										 </label>
										<div class="form-group">
											<label for="recipient-name" class="col-form-label title">
												<?php echo $v['name']; ?>
											 :</label>
											<div class="radio ">
												<label>
													<input type="radio" <?php if($issueDetails[ 'typeValue']=='yes' ){ echo 'checked'; } ?> name="data[<?php echo $v['id']; ?>][typeValue]" value="yes">Yes </label>
											</div>
											<div class="radio ">
												<label>
													<input <?php if($issueDetails[ 'typeValue']=='no' ){ echo 'checked'; } ?> type="radio" name="data[<?php echo $v['id']; ?>][typeValue]" value="no">No</label>
											</div>
											<input type="hidden" name="data[<?php echo $v['id']; ?>][selectionId]" value="<?php echo $v['id']; ?>" />
										</div>
										<div class="form-group">
											<label for="recipient-name" class="col-form-label">Observation/Recommendation/Measurements: :</label>
                  <textarea name="data[<?php echo $v['id']; ?>][measurements]" class="form-control" ><?php echo $issueDetails['measurements'];?></textarea>
                                            
											<!--<input type="text" value="<?php //echo $issueDetails['measurements'];?>" class="form-control" name="data[<?php //echo $v['id']; ?>][measurements]">-->
										</div>
										<div class="form-group">
											<?php $locations=array(
                                                ''=>'Select Location',
                                                'North'=>'North',
                                                'South'=>'South',
                                                'East'=>'East',
                                                'West'=>'West',
                                                'North East'=>'North East',
                                                'North West'=>'North West',
                                                'South East'=>'South East',
                                                'South West'=>'South West'                            
                                        ); ?>
											<label for="message-text" class="col-form-label">Location :</label>
											<select name="data[<?php echo $v['id']; ?>][location]" class="selectpicker form-control">
												<?php
                            if(!empty($locations)){
                                foreach($locations as $keys=>$location){
                                    $selectionLocation='';
                                    if($keys==$issueDetails['location']){
                                       $selectionLocation='selected'; 
                                    }
                                    ?>
                                    <option <?php echo $selectionLocation; ?> value="<?php echo $location; ?>"><?php echo $location; ?></option>
													<?php
                                }
                            }
                            
                            ?>
											</select>
										</div>
										<div class="form-group">
											<div class="imgSample msgcon">
												<input type="text" name="mgs">
												<div class="fileCon">
													<label for="fileUp"><i class="fa fa-paperclip" aria-hidden="true"></i> </label>
													<input type="file" style="display:none" multiple class="imgInp" name="typeImage[<?php echo $v['id']; ?>][]">
												</div>
											</div>
											<?php
                                    $issueId=getIssueId($v['id'],$_GET['areaId']);
                                    $getIssueImages=getIssueImages($issueId,'image'); 
                                    if(!empty($getIssueImages)){
                                        ?>
                                    	<div class="imageContainer">
                                    	<?php
                                        foreach($getIssueImages as $kImg=>$vImg){
                                            ?>
                                            <div class="imageContainerWrapper">
												<div class="imageContainerInner"  style="background:url(<?php echo site_url().$vImg['images']?>)" class="">
													<span class="areaImage" data-attr-id="<?php echo $vImg['id'];?>">x</span>
												</div>
                                                </div>
												<?php
                                        }
                                        ?></div>
                                            
                                            <?php
                                    }
                                    
                                    
                                    
                                    ?>
										</div>
										<div class="form-group">
											<div class="imgSample msgcon">
												<input type="text" name="mgs">
												<div class="fileCon">
													<label for="fileUp"><i class="fa fa-paperclip" aria-hidden="true"></i> </label>
													<input type="file" style="display:none" multiple class="drimgInp" name="typeDiagram[<?php echo $v['id']; ?>][]">
												</div>
											</div>
											<?php
                                    $issueId=getIssueId($v['id'],$_GET['areaId']);
                                    $getIssueImages=getIssueImages($issueId,'diagram'); 
                                    if(!empty($getIssueImages)){
                                    	?>
                                    	<div class="imageContainer">
                                    	<?php
                                        foreach($getIssueImages as $kImg=>$vImg){
                                            ?>
												<div class="imageContainerWrapper"><div class="imageContainerInner" style="background-image: url(<?php echo site_url().$vImg['images']; ?>)"><span class="areaImage" data-attr-id="<?php echo $vImg['id'];?>">&times;</span></div></div>
												
												<?php
                                        }
                                        ?>
	                                    </div>
                                        <?php
                                    }
                                    
                                    
                                    
                                    ?>
										</div>
									</div>
									<?php
                        }
                    }
                    ?>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exampleInputEmail1">Lab Results :</label>
							</th>
							<td>
								<select class="form-control" name="lab_results">
									<?php 
            $labResultsArray=array(
                'Elevated Spore Count'=>'Elevated Spore Count',
                'Acceptable Spore Count'=>'Acceptable Spore Count',
                'Positive'=>'Positive',
                'Negative'=>'Negative',
                'See Observations'=>'See Observations'
            );
             if(empty($getAreaDetails['labResults'])){
                 ?>
									<option value="">Select Spoke Count</option>
									<?php
             }
            
                foreach($labResultsArray as $k=>$v){
                    $labSelect='';  
                    if($k==$getAreaDetails['labResults']){
                        $labSelect='selected';
                    }
                 ?>
										<option <?php echo $labSelect; ?> value="
											<?php echo $k; ?>">
											<?php echo $v; ?>
										</option>
										<?php
                }               
            ?>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="exampleInputEmail1">Mold Spores :</label>
							</th>
							<td>
								<ul class="list-container">
									<?php
            $inspectionTypes=array(
            'Chaetomium'=>'Chaetomium (Toxic)',
            'Stachybotrys'=>'Stachybotrys (Toxic)',
            'Alternaria'=>'Alternaria',
            'Bipolaris'=>'Bipolaris/Drechslera',
            'Cladosporium'=>'Cladosporium',
            'Curvularia'=>'Curvularia',
            'Chlamydospores'=>'Chlamydospores',
            'Memnoniella'=>'Memnoniella',
            'Myrothecium'=>'Myrothecium',
            'Nigrospora'=>'Nigrospora',
            'Penicillium'=>'Penicillium/Aspergillus',
            'Pithomyces'=>'Pithomyces',
            'Epicoccum'=>'Epicoccum',
            'Absidia'=>'Absidia',
            'Acremonium'=>'Acremonium',
            'Aureobasidium'=>'Aureobasidium',
            'Chrysonilia'=>'Chrysonilia',
            'Emericella'=>'Emericella',
            'Eurotium'=>'Eurotium',
            'Fusarium'=>'Fusarium',
            'Geomyces'=>'Geomyces',
            'Geotrichum'=>'Geotrichum',
            'Oidiodendron'=>'Oidiodendron',
            'Paecilomyces'=>'Paecilomyces',
            'Phialophora'=>'Phialophora',
            'Phoma'=>'Phoma',
            'Scopulariopsis'=>'Scopulariopsis',
            'Sistotrema'=>'Sistotrema',
            'Trichoderma'=>'Trichoderma',
            'Ulocladium'=>'Ulocladium',
            'Wallemia'=>'Wallemia',
            'Other(s)'=>'Other(s)'
            );
            foreach($inspectionTypes as $key=>$value){
                $moldSpores=explode(',',$getAreaDetails['mold_spores']);
                $check='';
                if(in_array($key,$moldSpores)){
                    $check='checked';
                }
                ?>
										<li>
											<input <?php echo $check; ?> type="checkbox" class="form-control" name="mold_spores[]" value="<?php echo $key; ?>"/>
											<?php echo $key; ?>
										</li>
										<?php
            }
            ?>
								</ul>
							</td>
						</tr>
						<tr>
							<th>Additional Samples:</th>
							<td align="right"><a class="button button-primary" href="<?php echo admin_url().'admin.php?page=add-sample&areaId='.$_GET['areaId'];?>">Add Sample</a></td>
						</tr>
					</table>
                    
					<table class="wp-list-table widefat striped dataTable">
						<thead>
							<tr>
								<th>Sample ID</th>
								<th>Sample Type</th>
								<th>Serial</th>
								<th>Observation</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $getAllSamplesByArea=getAllSampleByArea($_GET['areaId']);
          if(!empty($getAllSamplesByArea)){
                foreach($getAllSamplesByArea as $k=>$v){
                    ?>
							<tr>
								<td>
									<?php echo $k+1; ?>
								</td>
								<td>
									<?php echo $v['sampleType'];?>
								</td>
								<td>
									<?php echo $v['sampleSerialNo'];?>
								</td>
								<td>
									<?php echo $v['sampleObservation'];?>
								</td>
								<td><a href="<?php echo admin_url().'admin.php?page=edit-sample&areaId='.$v['areaId'].'&sampleId='.$v['id'];?>" class="button button-secondary"><i class="fa fa-pencil"></i></a><a class="button button-secondary" href="<?php echo admin_url().'admin.php?page=delete-sample&sampleId='.$v['id'];?>"><i class="fa fa-remove"></i></a></td>
							</tr>
							<?php
                }
            }else{
                ?>
								<tr>
									<td colspan="5" class="text-center">No Samples Found.</td>
								</tr>
								<?php
            }
            
            
            ?>
						</tbody>
					</table>
                    <br>
                    <button type="submit" name="editInspection" class="button button-primary">Submit</button>
					
				</form>
	</div>
	<?php include 'includes/footer.php'; ?>