<?php
include('includes/header.php');
global $wpdb;
$getClient=$wpdb->get_row('delete from `im_clients` where `id`="'.$_GET['clientId'].'"',ARRAY_A);
if(!empty($getClient)){
  ?>
<script>
window.location.href='<?php echo admin_url().'admin.php?page=clients&status=deleted'; ?>';
</script>
<?php
}

?>