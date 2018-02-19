$(document).ready(function(){
    $('.editPopup .form-group').hide();
    $(document).on('click','.removeCrnt',function(){
      $('.loading_image').show();  
      var url= $(this).attr('data-att-href');
      $(this).parent().parent().remove();
        window.location.href=url;  
    });
    $('.alert-success').delay(1000).fadeOut();
    jQuery('#example').DataTable();
    jQuery('#tableId').DataTable();
    $(document).on('change','.editPopup',function(){
        if($(this).find('label input').prop('checked') == true) {
           $(this).find('.form-group').show(); 
        } else {
           $(this).find('.form-group').hide();  
        }
        /*console.log($(this).find('input[type="checkbox"]').checked);
        if($(this).find('input[type="checkbox"]').checked==true){
           $(this).find('.form-group').show(); 
        }else{
          $(this).find('.form-group').hide();  
        }*/
        
       /* return false;
        $('.loader').show();
        var ttitle=$(this).attr('data-valu');
        var areaId=$('#areaId').val();
        $('.headingTitle').html(ttitle);
        $('.title').html(ttitle);
        $('#addType').val(ttitle);
        $.ajax({
            dataType:'json',
            type:'post',
            data:{id:ttitle,action:'getDetails',areaId:areaId},
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            success:function(response){   
                $('.loader').hide();
                if(response.status=='true'){
                    console.log(response.data);
                    $('input[name=measurements]').val(response.data.measurements);
                    $('select[name=location]').val(response.data.location);
                    $('.blah').attr('src',response.data.typeImage);
                    $('.blah').show();
                    $('.drblah').show();
                    $('.drblah').attr('src',response.data.typeDiagram);
                    $("input[name=typeValue][value=" + response.data.typeValue + "]").prop('checked', true);
                    $('#exampleModal').modal('show');                
                }else{
                    $('.blah').hide();
                    $('.drblah').hide(); 
                    $('.blah').attr('src',''); 
                    $('.drblah').attr('src',''); 
                    $('#exampleModal').modal('show'); 
                }  
            }
        });*/
    });
    $(document).on('click','.editDetails',function(){
        $('.loader').show();
        $.ajax({
            dataType:'json',
            type:'post',
            data:$('#submitAreaDetails').serializeArray(),
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            success:function(response){
                $('.loader').hide();
                if(response.status=='true'){
                    $('.reponseDiv').show();
                    $('.reponseDiv').html('<div class="alert alert-success"><p>'+response.message+'</p></div>'); 
                    $('.reponseDiv').delay(2000).fadeOut();
                    setTimeout(function(){
                     $('#exampleModal').modal('hide');                     
                    },5000);                    
                }
            }
        });
    });   
   $(document).on('change',".imgInp",function(){
        readURL(this);
        $('.blah').show();
    });
    $(document).on('change',".drimgInp",function(){
        readURLImage(this);
        $('.drblah').show();
    });
    $(document).on('click','.acceptInspection',function(){
        $('.loader').show();
        var inspectionId=$(this).attr('data-id');
        $.ajax({
            dataType:'json',
            type:'post',
            data:{inspectionId:inspectionId,action:'changeStatus',type:'accept'},
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            success:function(response){
                $('.loader').hide();
                if(response.status=='true'){
                    $('.reponseDiv').html('<div class="alert alert-success"><p>'+response.message+'</p></div>');     
                    $('.reponseDiv').show();
                    setTimeout(function(){
                       location.reload();
                    },3000);
                }else{
                    $('.reponseDiv').html('<div class="alert alert-danger"><p>'+response.message+'</p></div>');  
                    $('.reponseDiv').show();
                     setTimeout(function(){
                       location.reload();
                    },3000);
                }
            }
        });
    });
    $(document).on('click','.declineInspection',function(){
        $('.loader').show();
        var inspectionId=$(this).attr('data-id');
        $.ajax({
            dataType:'json',
            type:'post',
            data:{inspectionId:inspectionId,action:'changeStatus',type:'decline'},
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            success:function(response){
                $('.loader').hide();
                if(response.status=='true'){
                    $('.reponseDiv').html('<div class="alert alert-success"><p>'+response.message+'</p></div>');     
                    $('.reponseDiv').show();
                    setTimeout(function(){
                       location.reload();
                    },3000);
                }else{
                    $('.reponseDiv').html('<div class="alert alert-danger"><p>'+response.message+'</p></div>');  
                    $('.reponseDiv').show();
                     setTimeout(function(){
                       location.reload();
                    },3000);
                }
            }
        });
    });
    $(document).on('click','.assignQA',function(){
        $('.loader').show();
       var inspectionId=$(this).attr('data-id');
       $.ajax({
           dataType:'json',
           type:'post',
           data:{action:'assignReporter',inspectionId:inspectionId,type:'QA'},
           url:SITE_URL+'/wp-admin/admin-ajax.php',
           success:function(response){
               $('.loader').hide();
               if(response.status=='true'){
                   $('.reponseDiv').show();
                   $('.reponseDiv').html('<div class="alert alert-success"><p>'+response.message+'</p></div>');
                   $('.reponseDiv').delay(3000).fadeOut();
                   location.reload();
               }              
           }
       });
   });
    $(document).on('click','.acceptReport',function(){
        $('.loader').show();
        var inspectionId=$(this).attr('data-id');
        $.ajax({
            dataType:'json',
            type:'post',
            data:{inspectionId:inspectionId,action:'changeStatusReport',type:'accept'},
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            success:function(response){
                $('.loader').show();
                if(response.status=='true'){
                    $('.reponseDiv').html('<div class="alert alert-success"><p>'+response.message+'</p></div>');     
                    $('.reponseDiv').show();
                    setTimeout(function(){
                       location.reload();
                    },3000);
                }else{
                    $('.reponseDiv').html('<div class="alert alert-danger"><p>'+response.message+'</p></div>');  
                    $('.reponseDiv').show();
                     setTimeout(function(){
                       location.reload();
                    },3000);
                }
            }
        });
    });
    $(document).on('click','.declineReport',function(){
        $('.loader').show();
        var inspectionId=$(this).attr('data-id');
        $.ajax({
            dataType:'json',
            type:'post',
            data:{inspectionId:inspectionId,action:'changeStatusReport',type:'decline'},
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            success:function(response){
                $('.loader').hide();
                if(response.status=='true'){
                                
                }
                location.reload();     
            }
        });
    });
    $(document).on('click','.selectedUser',function(){
         $('.loader').show();
         var usrId=$(this).attr('data-attr-id');
         var inspectionId=$(this).attr('data-attr-inspection');
         var divId=$(this).attr('data-div-id');
         $('#toUserId').val(usrId);
         $('#inspectionId').val(inspectionId);
         $('#divId').val(divId);
         $.ajax({
            type:'post',
            data:{usrId:usrId,inspectionId:inspectionId,action:'getMessages'},
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            success:function(response){   
                $('.loader').hide();
                if(response==''){
                  //$('#messageList'+divId).html('<li>No Converation Found.</li>');  
                  $('#messageList').html('<li>No Converation Found.</li>');  
                }else{
                 // $('#messageList'+divId).html(response);
                   // $("#messageList"+divId).scrollTop($("#messageList"+divId).get(0).scrollHeight, -1);     
                    $('#messageList').html(response);
                    $("#messageList").scrollTop($("#messageList").get(0).scrollHeight, -1); 
                }
                
            }
        });
    });
    $(document).on('click','.sendMessage',function(){
        var usrId=$(this).attr('data-attr-id');
        $('#chatForm').submit();
    });
    $(document).on('submit','#chatForm',function(e){
        e.preventDefault();
        var ToUSERID=$('#toUserId').val();
        var formData = new FormData(this);
        var message=$('input[name="mgs"]').val();
        var file=$('input[name="file"]').val();
        var temp='0';
        message=message.trim();
        if(message=='' && file==''){
            temp="1"; 
        }
        if(temp=='1'){
            alert('Please enter some text or select the image to send.');
            return false;
        }
        $('.loader').show();
        $.ajax({
            dataType:'json',
            type:'post',
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            success:function(response){
                $('.loader').hide();
               if(response.status=='true'){
                 $('#divId').val(response.conversationId);
                 $('.messageDiv').html(response.message);   
                 getMessageList(ToUSERID,response.inspectionId,response.conversationId);
                 $('#chatForm')[0].reset();
                 setTimeout(function(){
                     $('.messageDiv').hide(); 
                 },1000);
                 $(".do-nicescroll3").scrollTop($('.do-nicescroll3').get(0).scrollHeight, -1);
               }
            }
        });
    });
    setInterval(function(){
         var usrId=$('#toUserId').val();
         var inspectionId=$('#inspectionId').val();
         var divId=$('#divId').val();
         $.ajax({
            type:'post',
            data:{usrId:usrId,inspectionId:inspectionId,action:'getMessagesAjax'},
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            success:function(response){     
                if(response!=''){
                  // $('#messageList'+divId).html(response); 
                   // $("#messageList"+divId).scrollTop($("#messageList"+divId).get(0).scrollHeight, -1);
                    $('#messageList').html(response); 
                    $("#messageList").scrollTop($("#messageList").get(0).scrollHeight, -1);
                }                                
            }
        }); 
    },1000);
    $(document).on('click','.deleteNoti',function(){  
        $('.loading_image').show();
        $this=$(this);
        var delId=$(this).attr('data-attr-id');
        $.ajax({
            data: {notificationId:delId,action:'delete_notification'},
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType:'json',
            success: function(response) {
                $('.loading_image').hide();
                if(response.status=='true'){
                  $('.notiResponse').html('<div class="alert alert-success" role="alert">'+response.message+'</div>');
                    $('.notiResponse').show();
                    $('.notiResponse').delay(1500).fadeOut();
                  $this.parent().parent().delay(1500).fadeOut();  
                  $this.parent().parent().next().css('border-top','0');
                }
            }
        });       
    });
    $(document).on('change','.assignNewReporter',function(){
        var reporterId=$(this).val();
        var inspectionId=$(this).prev().val();
         $.ajax({
            data: {reporterId:reporterId,inspectionId:inspectionId,action:'assignNewReporter'},
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            type: 'POST',
            dataType:'json',
            success: function(response) {
                $('.loading_image').hide();
                if(response.status=='true'){
                    $('.reponseDiv').html('<div class="alert alert-success" role="alert">'+response.message+'</div>');
                    $('.reponseDiv').show();
                    $('.reponseDiv').delay(2000).fadeOut(); 
                    setTimeout(function(){
                        location.reload();
                    },1000);                    
                }
            }
        });  
    });
    $('.fileCon > label').on('click', function() {
        $(this).next().trigger('click');
    });
    $('.fileCon > input').on('change', function(e) {
        var fileName = e.target.files[0].name;
        $(this).parent().parent().find('input:text').val(fileName);
    });
    
    $(document).on('click','.areaImage',function(){
        $('.loader').show();
        var imgId=$(this).attr('data-attr-id');
        $this=$(this);
        $.ajax({
                dataType:'json',
                type:'post',
                data:{imgId:imgId,action:'delete_image'},
                url:SITE_URL+'/wp-admin/admin-ajax.php',
                success:function(response){
                    $('.loader').hide();
                    if(response.status=='true'){
                        $this.parent().parent().remove();
                        alert('Image deleted successfully.');
                    }                      
                }
            });
    });
});
function getMessageList(userid,inspectionId,divId){
        $.ajax({
            type:'post',
            data:{usrId:userid,inspectionId:inspectionId,divId:divId,action:'getMessages'},
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            success:function(response){   
                if(response==''){
                 // $('#messageList'+divId).html('<li>No Converation Found.</li>');   
                  $('#messageList').html('<li>No Converation Found.</li>');   
                }else{
                 // $('#messageList'+divId).html(response); 
                  $('#messageList').html(response); 
                //  $("#messageList"+divId).scrollTop($("#messageList"+divId).get(0).scrollHeight, -1);
                  $("#messageList").scrollTop($("#messageList").get(0).scrollHeight, -1);
                }
                 
                                
            }
        }); 
}    
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.blah').attr('src', e.target.result);
            $('#typeImage').val(e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        }
} 
function readURLImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.drblah').attr('src', e.target.result);
            $('#typeDiagram').val(e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        }
}