<?php 
include('includes/header.php');
global $wpdb;
$currentUserId=get_current_user_id();
$user_meta=get_userdata($currentUserId);
$user_roles=$user_meta->roles;
if($user_roles[0]=='subscriber'){//reporter
	$getUserList=$wpdb->get_results('select * from `im_inspection_assignments`  where `reporterId`="'.$currentUserId.'"',ARRAY_A);
} elseif($user_roles[0]=='contributor') {
	$getUserList=$wpdb->get_results('select * from `im_inspection_assignments`  where `qaId`="'.$currentUserId.'"',ARRAY_A);
}

?>
<div class="wrap">
	<div class="customAdmin">
		<div class="container">
			<h1>Send Message</h1>
			<div class="row">
				<div class="col-md-3 order-1">
					<div class="sideBarContainer">
						<!--<div class="sideHead">General Chat</div>-->
						<ul>
							<?php
								$chatUserId=array();
								if(!empty($getUserList)) {
									foreach($getUserList as $k=>$v) {
										if($user_roles[0]=='subscriber') {//reporter
											$chatUserId[]=$v['qaId'];
											$chatUserId[]=$v['inspectorId'];
										} elseif($user_roles[0]=='contributor') {//QA
											$chatUserId[]=$v['reporterId'];
										}
									}
                                    $chatUserId=array_filter($chatUserId);
								}
                            	if(!empty($chatUserId)) {
                                    $chatUserId=array_unique($chatUserId);
									$i = 0;
									foreach($chatUserId as $k=>$v) {
										$userInfo=get_user_by('id',$v);
                                        $class='';
                                        if($k == 0) {
                                            $class="active";
                                        } ?>
											<li><a class="selectedUser <?php echo $class; ?>" href="javascript:void(0);" data-attr-id="<?php echo $v; ?>" data-link="link<?php echo $k; ?>"><?php echo ucfirst($userInfo->data->display_name); ?></a></li>
										<?php
										$i++;
									}
								}
							?>
						</ul>
					</div>
				</div>
				<div class="col-md-9 order-2">
					<div class="messageContainer brdr">
						<!-- Just For the time using for -->
						<?php
						$chatUserId=array();
						if(!empty($getUserList)) {
							foreach($getUserList as $k=>$v) {
								if($user_roles[0]=='subscriber') {//reporter
								$chatUserId[]=$v['qaId'];
								$chatUserId[]=$v['inspectorId'];
								}elseif($user_roles[0]=='contributor') {//QA
									$chatUserId[]=$v['reporterId'];
								}
							}
						}

						if(!empty($chatUserId)) {
							foreach($chatUserId as $k=>$v) {
								$userInfo=get_user_by('id',$v);
								?>
								<ul id="messageList<?php echo $v;?>" class="do-nicescroll3 messageList<?php if($k == 0) {echo ' active';} ?>" data-tab="link<?php echo $k; ?>"></ul>
								<?php
							}
						}
						?>
						<!-- Just For the time using for -->
                        <?php  if(!empty($chatUserId)){
                                ?>
                        <div class="messageDiv"></div>
						<form class="mgsForm" id="chatForm" method="post" enctype="multipart/form-data">
							<div class="inline-form">
								<input type="hidden" id="toUserId" name="toUserId">
								<input type="hidden"  name="action" value="send_message">
								<div class="msgcon">
									<input type="text" name="mgs">
									<div class="fileCon">
										<label for="fileUp"><i class="fa fa-paperclip" aria-hidden="true"></i></label>
										<input class="hide" type="file" id="fileUp" name="file" />
									</div>
								</div>
								<button type="button" class="sendMessage"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
								<!-- <input type="button" value="Send"> -->
							</div>
						</form>
                        <?php
    
                            }else{
    ?><p>No User Found for conversation.</p>
                        <?php
}?>

						

						<div class="loader" style="background-image: url(<?php echo site_url().'/wp-content/themes/expert-child/image/spinner.gif'; ?>);display:none;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
	.messageList[data-tab]:not(.active) {display: none;}
</style>
<script src="<?php echo site_url().'/wp-content/themes/expert-child/admin-templates/js/jquery.nicescroll.min.js';?>"></script>
<script>
    jQuery(".do-nicescroll3").niceScroll({
        cursorwidth:12,
        cursoropacitymin:0.4,
        cursorcolor:'#6e8cb6',
        cursorborder:'none',
        cursorborderradius:4,
        autohidemode:'leave'
    });
    jQuery(".do-nicescroll3").scrollTop(jQuery('.do-nicescroll3').get(0).scrollHeight, -1);
	jQuery('.sideBarContainer li > a').on('click', function() {
		var thisLink = jQuery(this).data('link');
		jQuery(this).parent().siblings().find('a').removeClass('active');
		jQuery(this).addClass('active');
		if (!(jQuery('.messageList[data-tab="' + thisLink + '"]').is(':visible'))) {
			jQuery('.messageList').slideUp('slow');
			jQuery('.messageList[data-tab="' + thisLink + '"]').slideDown('slow');
		}
	});
</script>
<?php include 'includes/footer.php'; ?>