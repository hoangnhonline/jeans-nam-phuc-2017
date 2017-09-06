/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  "use strict";

  /* Morris.js Charts */


  //Fix for charts under tabs
  $('.box ul.nav a').on('shown.bs.tab', function () {
    //area.redraw();
    //donut.redraw();
    //line.redraw();
  });

  $('.btnUpload').click(function(){    
      $(this).parents('.div-upload').find('.click-choose-file').click();
    });
    
    var files = "";
    $('.click-choose-file').change(function(e){
       var obj = $(this);
       var valueObj = obj.data('value');
       files = e.target.files;
       
       if(files != ''){
         var dataForm = new FormData();        
        $.each(files, function(key, value) {
           dataForm.append('file', value);
        });   
        
        dataForm.append('date_dir', 0);
        dataForm.append('folder', 'tmp');

        $.ajax({
          url: $('#route_upload_tmp_image').val(),
          type: "POST",
          async: false,      
          data: dataForm,
          processData: false,
          contentType: false,
          success: function (response) {
            if(response.image_path){
              obj.parents('.div-upload').find('img.show_thumbnail').attr('src', $('#upload_url').val() + response.image_path);
              $( '#' + valueObj ).val( response.image_path );
              $( '#' + valueObj + '_name' ).val( response.image_name );
            }             
          }
        });
      }
    });

    $('.btnUploadProduct').click(function(){    
      $(this).parents('.div-upload').find('.click-choose-file-product').click();
    });
    
    var files = "";
    $('.click-choose-file-product').change(function(e){
       var obj = $(this);
       var valueObj = obj.data('value');
       files = e.target.files;
       
       if(files != ''){
         var dataForm = new FormData();        
        $.each(files, function(key, value) {
           dataForm.append('file', value);
        });   
        
        dataForm.append('date_dir', 0);
        dataForm.append('folder', 'tmp');

        $.ajax({
          url: $('#route_upload_tmp_image').val(),
          type: "POST",
          async: false,      
          data: dataForm,
          processData: false,
          contentType: false,
          success: function (response) {
            if(response.image_path){
              obj.parents('.div-upload').find('img.show_thumbnail').attr('src', $('#upload_url').val() + response.image_path);
              obj.parents('.div-upload').find('.color_id_url').val( response.image_path );
              obj.parents('.div-upload').find('.color_id_name').val( response.image_name );
            }             
          }
        });
      }
    });
});

