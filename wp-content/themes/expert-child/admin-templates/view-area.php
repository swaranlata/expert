<?php
include('includes/header.php');
global $wpdb;
$getAreaDetails=$wpdb->get_row('select * from `im_areas` where `id`="'.$_GET['areaId'].'"',ARRAY_A);
$userLoginId=get_current_user_id();
$userData=get_user_by('id',$userLoginId);
$role=$userData->roles[0];
?>
<div class="wrap newForm">
    <h1>View Area</h1>
    <div id="MainView">
         <?php
        $inspectionDetails=getLocalInspectionDetails($getAreaDetails['inspectionId']);
        if($role=='contributor'){
            $checkReportStatus=checkReportStatus($getAreaDetails['inspectionId']);
            if($checkReportStatus['status']!='2'){
                                    ?>
                <a style="float:right !important;" class="editArea button button-primary" href="<?php echo admin_url().'/admin.php?page=editArea&areaId='.$_GET['areaId']; ?>">Edit Area</a>
        <?php }
        }elseif($role=='subscriber'){
               if($inspectionDetails['status']!='2'){
                ?>
         <a style="float:right !important;" class="editArea button button-primary" href="<?php echo admin_url().'/admin.php?page=editArea&areaId='.$_GET['areaId']; ?>">Edit Area</a>
        <?php
              }
            }?>
        <table class="dataTable" cellpadding="10">
            <tbody>
                <tr>
                    <th scope="row">
								<label for="exampleInputEmail1">Area ID : </label>
							</th>
                    <td>
                        <?php echo $getAreaDetails['id'];?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
								<label for="exampleInputEmail1">Area Name : </label>
							</th>
                    <td>
                        <?php echo $getAreaDetails['areaName'];?>
                    </td>
                </tr>
                <tr>
                     <th scope="row">
								<label for="exampleInputEmail1">Visual Observation : </label>
							</th>
                    <td>
                        <?php echo $getAreaDetails['visualObservation'];?>
                    </td>
                </tr>
                <tr>
                     <th scope="row">
								<label for="exampleInputEmail1">Sample Type : </label>
							</th>
                   <td>
                        <?php echo $getAreaDetails['sampleType'];?>
                    </td>
                </tr>
                <tr>
                     <th scope="row">
								<label for="exampleInputEmail1">Serial : </label>
							</th>
                    <td>
                        <?php echo $getAreaDetails['serial'];?>
                    </td>
                </tr>
                <tr>
                     <th scope="row">
								<label for="exampleInputEmail1">General Observation : </label>
							</th>
                    <td>
                        <?php echo $getAreaDetails['generalObservation'];?>
                    </td>
                </tr>
                <tr>
                       <th scope="row">
								<label for="exampleInputEmail1">Recommendations : </label>
							</th>
                   <td>
                        <?php echo $getAreaDetails['recommendations'];?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
								<label for="exampleInputEmail1">Temprature : </label>
							</th>
                   <td>
                        <?php echo $getAreaDetails['temprature'];?>
                    </td>
                </tr>
                <tr>
                     <th scope="row">
								<label for="exampleInputEmail1">RH Relative Humidity : </label>
							</th>
                    <td>
                        <?php echo $getAreaDetails['rhRelativeHumidity'];?>
                    </td>
                </tr>
                <tr>
                     <th scope="row">
								<label for="exampleInputEmail1">Image : </label>
							</th>
                    <td> <?php $getAreaImages = getAreaImages($_GET['areaId'],'image');
                    if(!empty($getAreaImages)){
                    	?>
                    	<div class="imageContainer">
                    	<?php
                        foreach($getAreaImages as $k=>$v){
                            ?>
								<div class="imageContainerWrapper"><div class="imageContainerInner" style="background-image: url(<?php echo site_url().$v['images']; ?>)"></div></div>
								<?php
                        }
                        ?>
	                    </div>
                        <?php
                    }
                    
                    ?></td>
                </tr>
                <tr>
                    <th scope="row">
								<label for="exampleInputEmail1">Diagram : </label>
							</th>
                    <td><?php $getAreaImages = getAreaImages($_GET['areaId'],'diagram');
                    if(!empty($getAreaImages)){
                    	?>
                    	<div class="imageContainer">
                    	<?php
                        foreach($getAreaImages as $k=>$v){
                            ?>
								<div class="imageContainerWrapper"><div class="imageContainerInner" style="background-image: url(<?php echo site_url().$v['images']; ?>)"></div></div>
								<?php
                        }
                        ?>
                        </div>
                        <?php
                    }
                    
                    ?></td>
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
											<input <?php echo $checked; ?> type="checkbox" name="data[
											<?php echo $v['id']; ?>][type]" value="
											<?php echo $v['name']; ?>">
											<?php echo $v['name']; ?>
										 </label>
										<div class="form-group">
											<label for="recipient-name" class="col-form-label title">
												<?php echo $v['name']; ?>
											 : </label>
											<div class="radio ">
												<label>
													<input type="radio" <?php if($issueDetails[ 'typeValue']=='yes' ){ echo 'checked'; } ?> name="data[
													<?php echo $v['id']; ?>][typeValue]" value="yes">Yes  </label>
											</div>
											<div class="radio ">
												<label>
													<input <?php if($issueDetails[ 'typeValue']=='no' ){ echo 'checked'; } ?> type="radio" name="data[
													<?php echo $v['id']; ?>][typeValue]" value="no">No  </label>
											</div>
											<input type="hidden" name="data[<?php echo $v['id']; ?>][selectionId]" value="<?php echo $v['id']; ?>" />
										</div>
										<div class="form-group">
											<label for="recipient-name" class="col-form-label">Observation/Recommendation/Measurements:  </label>
											<input type="text" value="<?php echo $issueDetails['measurements'];?>" class="form-control" name="data[<?php echo $v['id']; ?>][measurements]">
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
											<label for="message-text" class="col-form-label">Location: : </label>
											<select name="data[<?php echo $v['id']; ?>][location]" class="selectpicker form-control">
												<?php
                            if(!empty($locations)){
                                foreach($locations as $keys=>$location){
                                    $selectionLocation='';
                                    if($keys==$issueDetails['location']){
                                       $selectionLocation='selected'; 
                                    }
                                    ?>
													<option <?php echo $selectionLocation; ?> value="
														<?php echo $location; ?>">
														<?php echo $location; ?>
													</option>
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
													<label for="fileUp"><i class="fa fa-paperclip" aria-hidden="true"></i>  </label>
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
													<label for="fileUp"><i class="fa fa-paperclip" aria-hidden="true"></i></label>
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
												<div class="imageContainerWrapper"><div class="imageContainerInner" style="background-image: url(<?php echo site_url().$vImg['images']; ?>)"></div></div>
												
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
								<label for="exampleInputEmail1">Lab Results : </label>
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
								<label for="exampleInputEmail1">Mold Spores : </label>
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
											<input <?php echo $check; ?> type="checkbox" class="form-control" name="mold_spores[]" value="
											<?php echo $key; ?>"/>
											<?php echo $key; ?>
										</li>
										<?php
            }
            ?>
								</ul>
							</td>
						</tr>
						
            </tbody>
        </table>
        <table class="wp-list-table widefat striped dataTable">
						<thead>
							<tr>
								<th>Sample ID</th>
								<th>Sample Type</th>
								<th>Serial</th>
								<th>Observation</th>
								<th>Image</th>
								<th>Diagram</th>
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
								<td>
                                    <?php
                                $images=getSampleImages($v['id'],'image');
                            if(!empty($images)){
                                      ?>
                                      <div class="imageContainer">
                                      <?php
                                            foreach($images as $key=>$val){
                                    ?>
                                     <div class="imageContainerWrapper"><div class="imageContainerInner" style="background-image: url(<?php echo site_url().$val['images']; ?>)">  </div>
                                    </div>
                            <?php

                                } 
                                      ?> 
                                     </div>
                                      <?php
                                        }
                                        ?>
                                          </td>
								<td><?php
                                $images=getSampleImages($v['id'],'diagram');
                            if(!empty($images)){
                                      ?>
                                      <div class="imageContainer">
                                      <?php
                                            foreach($images as $key=>$val){
                                    ?>
                                     <div class="imageContainerWrapper"><div class="imageContainerInner" style="background-image: url(<?php echo site_url().$val['images']; ?>)">  </div>
                                    </div>
                            <?php

                                } 
                                      ?> 
                                     </div>
                                      <?php
                                        }
                                        ?></td>
							</tr>
							<?php
                }
            }else{
                ?>
								<tr>
									<td colspan="7" class="text-center">No Samples Found.</td>
								</tr>
								<?php
            }
            
            
            ?>
						</tbody>
            <tfoot>
							<tr>
								<th>Sample ID</th>
								<th>Sample Type</th>
								<th>Serial</th>
								<th>Observation</th>
								<th>Image</th>
								<th>Diagram</th>
							</tr>
						</tfoot>
					</table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>