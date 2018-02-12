<?php
include('includes/header.php');
global $wpdb;

if(isset($_POST['editInspection'])) {
	$wpdb->query('update `im_areas` set `areaName`="'.$_POST['areaName'].'",`visualObservation`="'.$_POST['visualObservation'].'",`sampleType`="'.$_POST['sampleType'].'",`serial`="'.$_POST['serial'].'",`image`="",`diagram`="",`generalObservation`="'.$_POST['generalObservation'].'",`recommendations`="'.$_POST['recommendations'].'",`temprature`="'.$_POST['temprature'].'",`rhRelativeHumidity`="'.$_POST['rhRelativeHumidity'].'",`type`="'.$_POST['type'].'",`typeValue`="'.$_POST['typeValue'].'",`measurements`="'.$_POST['measurements'].'",`location`="'.$_POST['location'].'" where `id`="'.$_GET['areaId'].'"');
}
$getAreaDetails=$wpdb->get_row('select * from `im_areas` where `id`="'.$_GET['areaId'].'"',ARRAY_A);
?>
<div class="wrap">
  <h1>Edit Inspection</h1>
	<form name="" action="" method="post">
		<input type="hidden" id="areaId" value="<?php echo $_GET['areaId']; ?>" />
		<table class="form-table">
			<tr>
				<th scope="row"><label for="exampleInputEmail1">Area Name</label></th>
				<td><input type="text" name="areaName" value="<?php echo $getAreaDetails['areaName'];?>" class="form-control" placeholder="Area Name"></td>
			</tr>
			<tr>
				<th scope="row"><label for="exampleInputEmail1">Visual Observation</label></th>
				<td>
					<div class="radio ">
						<label><input type="radio" <?php if( 'normal'==strtolower($getAreaDetails[ 'visualObservation'])){ echo 'checked'; } ?> name="visualObservation" value="Normal">Normal</label>
					</div>
					<div class="radio ">
						<label><input type="radio" <?php if( 'abnormal'==strtolower($getAreaDetails[ 'visualObservation'])){ echo 'checked'; } ?> name="visualObservation" value="Abnormal">Abnormal</label>
					</div>
				</td>
			</tr>
			<tr>
				<?php $selectArray = array('AOC');?>
				<th scope="row"><label for="exampleInputEmail1">Sample Type </label></th>
				<td>
					<select name="sampleType" class="selectpicker">
						<?php
						if(!empty($selectArray)) {
							$selected='';
							foreach($selectArray as $k=>$v){
								if(strtolower($v)==strtolower($getAreaDetails['sampleType'])) {
									$selected='selected="selected"';
								}
								?>
								<option value="<?php echo $v; ?>"><?php echo $v; ?></option>
								<?php
							}
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="exampleInputEmail1">Serial</label></th>
				<td><input type="text" name="serial" value="<?php echo $getAreaDetails['serial'];?>" class="form-control" placeholder="Serial"></td>
			</tr>
			<tr>
				<th scope="row"><label for="exampleInputEmail1">General Observation</label></th>
				<td><input type="text" value="<?php echo $getAreaDetails['generalObservation'];?>" name="generalObservation" class="form-control" placeholder="General Observation"></td>
			</tr>
			<tr>
				<th scope="row"><label for="exampleInputEmail1">Recommendation</label></th>
				<td><input type="text" value="<?php echo $getAreaDetails['recommendations'];?>" name="recommendations" class="form-control" placeholder="Recommendation"></td>
			</tr>
			<tr>
				<th scope="row"><label for="exampleInputEmail1">Temprature</label></th>
				<td><input type="text" value="<?php echo $getAreaDetails['temprature'];?>" name="temprature" class="form-control" placeholder="Temprature"></td>
			</tr>
			<tr>
				<th scope="row"><label for="exampleInputEmail1">RH relative Humidity</label></th>
				<td><input type="text" name="rhRelativeHumidity" value="<?php echo $getAreaDetails['rhRelativeHumidity'];?>" class="form-control" placeholder="RH relative Humidity"></td>
			</tr>
			<tr>
				<th scope="row"></th>
				<td>
					<?php
					$array=array(
						'Visible Mold like substance',
						'Moisture Stains Present',
						'Mold odor',
						'Remove Celling',
						'Remove Drywall',
						'Remove Baseboard',
						'Micro Clean Surfaces',
						'Horizontal Surface Cleaning',
						'Clean Furniture',
						'Clean Carpets',
						'Discard Carpets',
						'Fog Area with Antimicrobial'
					);

					if(!empty($array)) {
						foreach($array as $k=>$v) {
							$checked='';
							if(strtolower($v)==strtolower($getAreaDetails['type'])) {
								$checked='checked';
							}
							?>
							<div class="radio editPopup" data-valu="<?php echo $v; ?>">
								<label>
									<input <?php echo $checked; ?> type="radio" name="type" value="<?php echo $v; ?>">
									<?php echo $v; ?>
								</label>
							</div>
							<?php
						}
					}
					?>
				</td>
			</tr>
            <tr>
        <th scope="row"><label for="exampleInputEmail1">Lab Results</label></th>
        <td>
        <select  class="form-control" name="lab_results">
        <option value="">Select Spoke Count</option>
        <option value="Elevated Spore Count">Elevated Spore Count</option>
        <option value="Acceptable Spore Count">Acceptable Spore Count</option>
        <option value="Positive">Positive</option>
        <option value="Negative">Negative</option>
        <option value="See Observations">See Observations</option>
        </select>
        </td>
        </tr>        
        <tr>
        <th scope="row"><label for="exampleInputEmail1">Mold Spores</label></th>
        <td>
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
                ?>
                <input type="checkbox" class="form-control" name="mold_spores[]" value="<?php echo $key; ?>"/><?php echo $key; ?>
            <?php
            }
            ?>
            
        </td>
        </tr>
		</table>
		<button type="submit" name="editInspection" class="button button-primary">Submit</button>
	</form>
</div>
	<?php include 'includes/footer.php'; ?>