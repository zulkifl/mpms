/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var base_url='/bizbuysell/frontend/web';

if(window.location.href=='http://bizbuysell.alfoze.com/index.php?r=franchise%2Fbuyfranchise'
        || window.location.href=='http://bizbuysell.alfoze.com/index.php?r=franchise%2Fbrowsefranchise')
{
     $('.bs_sale').removeClass("active");
     $('.fs_sale').addClass("active");
     $('.d_sale').removeClass("active");
     $('.form_franchise').show();
     $('.form_business').hide();
     $('.business_directory').hide(); 
}
else
{    
$('.form_franchise').hide();
 $('.business_directory').hide(); 
}



 (function($){
 
    $(document).on('click', '.showModalButton', function () {
        //check if the modal is open. if it's open just reload content not whole modal
        //also this allows you to nest buttons inside of modals to reload the content it is in
        //the if else are intentionally separated instead of put into a function to get the 
        //button since it is using a class not an #id so there are many of them and we need
        //to ensure we get the right button and content. 
        if ($('#modal').data('bs.modal').isShown) {
            $('#modal').find('#modalContent')
                    .load($(this).attr('value'));
            //dynamiclly set the header for the modal
            document.getElementById('modalHeaderTitle').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        } else {
            //if modal isn't open; open it and load content
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value'));
            //dynamiclly set the header for the modal
            document.getElementById('modalHeaderTitle').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        }
    });
 })(jQuery);
 
 $('.bs_sale').click(function(){
     
     $('.bs_sale').addClass("active");
     $('.fs_sale').removeClass("active");
     $('.d_sale').removeClass("active");
     $('.form_franchise').hide();
     $('.business_directory').hide();    
     $('.form_business').show();  
     
 });
 
 $('.fs_sale').click(function(){
     
     $('.bs_sale').removeClass("active");
     $('.fs_sale').addClass("active");
     $('.d_sale').removeClass("active");
    $('.form_franchise').show();
    $('.business_directory').hide();
     $('.form_business').hide();  
     
 });
 
  $('.d_sale').click(function(){
     
     $('.bs_sale').removeClass("active");
     $('.fs_sale').removeClass("active");
     $('.d_sale').addClass("active");
    $('.form_franchise').hide();
    $('.business_directory').show();
     $('.form_business').hide();  
     
 });
 
    $('.bts_sub').click(function(){
     $(".form_business").submit();
       
    });

     $('.bts_sub1').click(function(){

       $('.form_franchise').submit();  
    });

    $('.bts_sub2').click(function(){

       $('.business_directory').submit();  
    });
    
 
$('.b_search').click(function(){
    
    var val=$('#business_key').val();
    if(val=='' || val==null)
    {
    alert('Required Field');
    $('#business_key').focus();
    return false;
    }
    else
    {
        var url=$('.b_search').attr('href');
   
        $('.b_search').attr('href',url+val);
        return true;
    }    
      
});

$('.f_search').click(function(){
    
    var val=$('#franchise_key').val();
    if(val=='' || val==null)
    {
    alert('Required Field');
    $('#franchise_key').focus();
    return false;
    }
    else
    {
        var url=$('.f_search').attr('href');
        $('.f_search').attr('href',url+val);
        return true;
    }    
      
});

 
 $('.del_msg').click(function(){
     
     var r=confirm('Are you sure you want to delete this?');
     if(r == true)
     { return true;}
     else 
     {
         return false;
     }   
 });
 
 $('.a_search').click(function(){
      var url=$('.a_search').attr('href');
      $('.a_search').attr('href',url+$('#b_filter').val());
      return true; 
 });
 
 $('.fa_search').click(function(){
      var url=$('.fa_search').attr('href');
      $('.fa_search').attr('href',url+$('#bf_filter').val());
      return true; 
 });
 
 $(document).ready(function() {

  var owl = $("#owl-demo");
  owl.owlCarousel({
     rewindNav : false,	
     pagination : false,
      itemsCustom : [
        [0, 2],
        [450, 4],
        [600, 7],
        [700, 4],
        [1000, 4],
        [1200, 4],
        [1400, 4],
        [1600, 4]
      ],
      navigation : true
 
  });
  $('.owl-next').addClass('btn-info');
  $('.owl-prev').addClass('btn-info');

$('.sign_12').click(function(){
    $('#c_pas').text('');
    var pass=$('#signupform-password').val();
    var c_pass=$('#c_type').val();
    if(pass==c_pass)
    {

        return true;
    }
    else 
    {
        $('#c_pas').text('Password And Confirm Password Does Not Match.');
     return false;   
    }    
    
});

});


$('.fav_business').click(function(){
   var b_text=$(this).text();
    var id1=$(this).attr('val');
     if(b_text=='Favorite')
    {
  $.ajax({
       url: base_url+'/index.php?r=business%2Fadd_favorite',
       type: 'post',
       data: {"id": id1},
       success: function (data) {
         //$('#fs'+id1).hide('slow');
         // $('#fs1'+id1).show('slow');
       $('#fs'+id1).removeClass( "fav_business" );
       $('#fs'+id1).removeClass( "btn-default" );
       $('#fs'+id1).addClass( "un_fav_bus" );
       $('#fs'+id1).addClass( "btn-success" );
       $('#fs'+id1).text('Un Favorite');
       
       $('#fs1'+id1).removeClass( "fav_business" );
       $('#fs1'+id1).removeClass( "btn-default" );
       $('#fs1'+id1).addClass( "un_fav_bus" );
       $('#fs1'+id1).addClass( "btn-success" );
       $('#fs1'+id1).text('Un Favorite');
       
       }
  });
    } else 
    {
       $.ajax({
       url: base_url+'/index.php?r=business%2Fun_favorite',
       type: 'post',
       data: {"id": id1},
       success: function (data) {
      // $('#fs1'+id1).hide('slow');
       // $('#fs'+id1).show('slow');
       
        $('#fs1'+id1).removeClass( "un_fav_bus" );
       $('#fs1'+id1).removeClass( "btn-success" );
       $('#fs1'+id1).addClass( "fav_business" );
       $('#fs1'+id1).addClass( "btn-default" );
       $('#fs1'+id1).text('Favorite'); 
       
        $('#fs'+id1).removeClass( "un_fav_bus" );
       $('#fs'+id1).removeClass( "btn-success" );
       $('#fs'+id1).addClass( "fav_business" );
       $('#fs'+id1).addClass( "btn-default" );
       $('#fs'+id1).text('Favorite'); 
       
          
       }
  
  });  
    }
  return false;
});


$('.un_fav_bus').click(function(){
  var b_text=$(this).text();
    var id1=$(this).attr('val');
    if(b_text=='Un Favorite')
    {
  $.ajax({
       url: base_url+'/index.php?r=business%2Fun_favorite',
       type: 'post',
       data: {"id": id1},
       success: function (data) {
      // $('#fs1'+id1).hide('slow');
       // $('#fs'+id1).show('slow');
       
        $('#fs1'+id1).removeClass( "un_fav_bus" );
       $('#fs1'+id1).removeClass( "btn-success" );
       $('#fs1'+id1).addClass( "fav_business" );
       $('#fs1'+id1).addClass( "btn-default" );
       $('#fs1'+id1).text('Favorite'); 
       
        $('#fs'+id1).removeClass( "un_fav_bus" );
       $('#fs'+id1).removeClass( "btn-success" );
       $('#fs'+id1).addClass( "fav_business" );
       $('#fs'+id1).addClass( "btn-default" );
       $('#fs'+id1).text('Favorite'); 
       
          
       }
  
  });
   }
   else
   {
        $.ajax({
       url: base_url+'/index.php?r=business%2Fadd_favorite',
       type: 'post',
       data: {"id": id1},
       success: function (data) {
         //$('#fs'+id1).hide('slow');
         // $('#fs1'+id1).show('slow');
       $('#fs'+id1).removeClass( "fav_business" );
       $('#fs'+id1).removeClass( "btn-default" );
       $('#fs'+id1).addClass( "un_fav_bus" );
       $('#fs'+id1).addClass( "btn-success" );
       $('#fs'+id1).text('Un Favorite');
       
       $('#fs1'+id1).removeClass( "fav_business" );
       $('#fs1'+id1).removeClass( "btn-default" );
       $('#fs1'+id1).addClass( "un_fav_bus" );
       $('#fs1'+id1).addClass( "btn-success" );
       $('#fs1'+id1).text('Un Favorite');
       
       }
  });
   }    
  return false;
});



$('.fav_business1').click(function(){
   var b_text=$(this).text();
    var id1=$(this).attr('val');
     if(b_text=='Favorite')
    {
  $.ajax({
       url: base_url+'/index.php?r=franchise%2Fadd_favorite',
       type: 'post',
       data: {"id": id1},
       success: function (data) {
         //$('#fs'+id1).hide('slow');
         // $('#fs1'+id1).show('slow');
       $('#fs'+id1).removeClass( "fav_business" );
       $('#fs'+id1).removeClass( "btn-default" );
       $('#fs'+id1).addClass( "un_fav_bus" );
       $('#fs'+id1).addClass( "btn-success" );
       $('#fs'+id1).text('Un Favorite');
       
       $('#fs1'+id1).removeClass( "fav_business" );
       $('#fs1'+id1).removeClass( "btn-default" );
       $('#fs1'+id1).addClass( "un_fav_bus" );
       $('#fs1'+id1).addClass( "btn-success" );
       $('#fs1'+id1).text('Un Favorite');
       
       }
  });
    } else 
    {
       $.ajax({
       url: base_url+'/index.php?r=franchise%2Fun_favorite',
       type: 'post',
       data: {"id": id1},
       success: function (data) {
      // $('#fs1'+id1).hide('slow');
       // $('#fs'+id1).show('slow');
       
        $('#fs1'+id1).removeClass( "un_fav_bus" );
       $('#fs1'+id1).removeClass( "btn-success" );
       $('#fs1'+id1).addClass( "fav_business" );
       $('#fs1'+id1).addClass( "btn-default" );
       $('#fs1'+id1).text('Favorite'); 
       
        $('#fs'+id1).removeClass( "un_fav_bus" );
       $('#fs'+id1).removeClass( "btn-success" );
       $('#fs'+id1).addClass( "fav_business" );
       $('#fs'+id1).addClass( "btn-default" );
       $('#fs'+id1).text('Favorite'); 
       
          
       }
  
  });  
    }
  return false;
});


$('.un_fav_bus1').click(function(){
  var b_text=$(this).text();
    var id1=$(this).attr('val');
    if(b_text=='Un Favorite')
    {
  $.ajax({
       url: base_url+'/index.php?r=franchise%2Fun_favorite',
       type: 'post',
       data: {"id": id1},
       success: function (data) {
      // $('#fs1'+id1).hide('slow');
       // $('#fs'+id1).show('slow');
       
        $('#fs1'+id1).removeClass( "un_fav_bus" );
       $('#fs1'+id1).removeClass( "btn-success" );
       $('#fs1'+id1).addClass( "fav_business" );
       $('#fs1'+id1).addClass( "btn-default" );
       $('#fs1'+id1).text('Favorite'); 
       
        $('#fs'+id1).removeClass( "un_fav_bus" );
       $('#fs'+id1).removeClass( "btn-success" );
       $('#fs'+id1).addClass( "fav_business" );
       $('#fs'+id1).addClass( "btn-default" );
       $('#fs'+id1).text('Favorite'); 
       
          
       }
  
  });
   }
   else
   {
        $.ajax({
       url: base_url+'/index.php?r=franchise%2Fadd_favorite',
       type: 'post',
       data: {"id": id1},
       success: function (data) {
         //$('#fs'+id1).hide('slow');
         // $('#fs1'+id1).show('slow');
       $('#fs'+id1).removeClass( "fav_business" );
       $('#fs'+id1).removeClass( "btn-default" );
       $('#fs'+id1).addClass( "un_fav_bus" );
       $('#fs'+id1).addClass( "btn-success" );
       $('#fs'+id1).text('Un Favorite');
       
       $('#fs1'+id1).removeClass( "fav_business" );
       $('#fs1'+id1).removeClass( "btn-default" );
       $('#fs1'+id1).addClass( "un_fav_bus" );
       $('#fs1'+id1).addClass( "btn-success" );
       $('#fs1'+id1).text('Un Favorite');
       
       }
  });
   }    
  return false;
});

$("#lang_id").change(function(e) {
    var val=$(this).val();
	        $.ajax({
       url: base_url+'/index.php?r=site%2Fselectlanguage',
       type: 'post',
       data: {"lan": val},
       success: function (data) {
		  
        location.reload();
       }
  });
	
});


 function readURL(input) {
     $('#image_upload_preview').show();
     $('#image_upload_preview1').show();
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_upload_preview').attr('src', e.target.result);
                $('#image_upload_preview1').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#gallery-image_path").change(function () {
        readURL(this);

    });
