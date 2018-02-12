<?php
include('includes/header.php');
global $wpdb;
$getAreaDetails=$wpdb->get_row('select * from `im_areas` where `id`="'.$_GET['areaId'].'"',ARRAY_A);
?>
<div class="wrap">
    <h1>View Area</h1>
    <div id="MainView">
        <table class="dataTable" cellpadding="10">
            <tbody>
                <tr>
                    <td>Area ID</td>
                    <td>
                        <?php echo $getAreaDetails['id'];?>
                    </td>
                </tr>
                <tr>
                    <td>Area Name</td>
                    <td>
                        <?php echo $getAreaDetails['areaName'];?>
                    </td>
                </tr>
                <tr>
                    <td>visual Observation</td>
                    <td>
                        <?php echo $getAreaDetails['visualObservation'];?>
                    </td>
                </tr>
                <tr>
                    <td>Sample Type</td>
                    <td>
                        <?php echo $getAreaDetails['sampleType'];?>
                    </td>
                </tr>
                <tr>
                    <td>Serial</td>
                    <td>
                        <?php echo $getAreaDetails['serial'];?>
                    </td>
                </tr>
                <tr>
                    <td>general Observation</td>
                    <td>
                        <?php echo $getAreaDetails['generalObservation'];?>
                    </td>
                </tr>
                <tr>
                    <td>Recommendations</td>
                    <td>
                        <?php echo $getAreaDetails['recommendations'];?>
                    </td>
                </tr>
                <tr>
                    <td>Temprature</td>
                    <td>
                        <?php echo $getAreaDetails['temprature'];?>
                    </td>
                </tr>
                <tr>
                    <td>RH Relative Humidity</td>
                    <td>
                        <?php echo $getAreaDetails['rhRelativeHumidity'];?>
                    </td>
                </tr>
                <tr>
                    <td>Type</td>
                    <td>
                        <?php echo $getAreaDetails['type'];?>
                    </td>
                </tr>
                <tr>
                    <td>Type Value</td>
                    <td>
                        <?php echo $getAreaDetails['typeValue'];?>
                    </td>
                </tr>
                <tr>
                    <td>Measurements</td>
                    <td>
                        <?php echo $getAreaDetails['measurements'];?>
                    </td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td>
                        <?php echo $getAreaDetails['location'];?>
                    </td>
                </tr>
                <tr>
                    <td>Image</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Diagram</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>