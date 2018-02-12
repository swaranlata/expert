<?php 
include('includes/header.php');
global $wpdb;
$rows=$wpdb->get_results('select * from `im_notifications` where `opponentId`="'.get_current_user_id().'" order by id desc',ARRAY_A);
?>
<div class="wrap">
	<div class="customAdmin">
		<h1 class="wp-heading-inline">Notifications</h1>
		<hr class="wp-header-end">
        <div class="notiResponse" style="display:none;"></div>
		<div class="notifications">
				<div class="notification-list">
                    <?php
                    if(!empty($rows)){
                           foreach($rows as $k=>$v){
                               ?>
                       <div class="notification">
						<div class="noti-head">
							<h2><?php echo get_user_meta($v['userId'],'first_name',true).' '.get_user_meta($v['senderId'],'last_name',true); ?></h2>
							<div class="time"><?php echo getTiming(strtotime($v['created']));?></div>
                            <span class="deleteNoti" data-attr-id="<?php echo $v['id']; ?>">x</span>
						</div>
						<div class="noti-con">
							<p><?php echo $v['title']; ?></p>
						</div>
					   </div>
                            <?php } 
                    } ?>
                                        
	
				</div>
			</div>
		
	</div>
</div>
<?php include 'includes/footer.php'; ?>