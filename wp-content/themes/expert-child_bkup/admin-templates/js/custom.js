$(document).ready(function(){
    $(document).on('click','.removeCrnt',function(){
      $('.loading_image').show();  
      var url= $(this).attr('data-att-href');
      $(this).parent().parent().remove();
        window.location.href=url;  
    });
    $('.alert-success').delay(1000).fadeOut();
    jQuery('#example').DataTable();
    jQuery('#tableId').DataTable();
    $(document).on('click','.editPopup',function(){
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
        });
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
            }
        });
    });
    $(document).on('click','.selectedUser',function(){
         $('.loader').show();
         var usrId=$(this).attr('data-attr-id');
         $('#toUserId').val(usrId);
         $.ajax({
            type:'post',
            data:{usrId:usrId,action:'getMessages'},
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            success:function(response){   
                $('.loader').hide();
                if(response==''){
                  $('#messageList'+usrId).html('<li>No Converation Found.</li>');  
                }else{
                  $('#messageList'+usrId).html(response);
                    $(".do-nicescroll3").scrollTop(jQuery('.do-nicescroll3').get(0).scrollHeight, -1); 
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
        if(message=='' && file==''){
            temp="1"; 
        }
        if(temp=='1'){
            alert('Please enter sone text or select the image to send.');
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
                 $('.messageDiv').html(response.message);   
                 getMessageList(ToUSERID);
                 $('#chatForm')[0].reset();
                 setTimeout(function(){
                     $('.messageDiv').hide(); 
                 },1000);
                 jQuery(".do-nicescroll3").scrollTop(jQuery('.do-nicescroll3').get(0).scrollHeight, -1);
               }
            }
        });
    });
    setInterval(function(){
         var usrId=$('#toUserId').val();
         $.ajax({
            type:'post',
            data:{usrId:usrId,action:'getMessagesAjax'},
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            success:function(response){     
                if(response!=''){
                   $('#messageList'+usrId).html(response); 
                }                                
            }
        }); 
    },1000);    
});
function getMessageList(userid){
        $.ajax({
            type:'post',
            data:{usrId:userid,action:'getMessages'},
            url:SITE_URL+'/wp-admin/admin-ajax.php',
            success:function(response){   
                if(response==''){
                  $('#messageList'+usrId).html('<li>No Converation Found.</li>');   
                }else{
                  $('#messageList'+userid).html(response); 
                  $(".do-nicescroll3").scrollTop(jQuery('.do-nicescroll3').get(0).scrollHeight, -1); 
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