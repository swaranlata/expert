jQuery(document).ready(function(){
   jQuery('#toplevel_page_inspection ul li').hide();
   jQuery('#toplevel_page_inspection ul li:nth-child(2)').show();
   jQuery('#menu-dashboard ul li:last-child').hide();
   jQuery('.capabilities').hide();
   jQuery('#toplevel_page_inspection-reports ul li:last-child').hide();
   //jQuery('#email').next('<span class="description">Email cannot be changed.</span>');
   jQuery('h2:contains("About Yourself"), h2:contains("About the user"), h2:contains("Personal Options")').remove();
   jQuery(document).on('click','.assignReporter',function(){
       var inspectionId=jQuery(this).attr('data-id');
       jQuery.ajax({
           dataType:'json',
           type:'post',
           data:{action:'assignReporter',inspectionId:inspectionId,type:'reporter'},
           url:SITE_URL+'/wp-admin/admin-ajax.php',
           success:function(response){
               if(response.status=='true'){
                   jQuery('.reponseDiv').show();
                   jQuery('.reponseDiv').html('<div class="alert alert-success"><p>'+response.message+'</p></div>');
                   jQuery('.reponseDiv').delay(3000).fadeOut();
                   location.reload();
               }              
           }
       });
   });
});