<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Sản phẩm mới    
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?php echo e(route('product.index')); ?>">Sản phẩm mới</a></li>
      <li class="active">Chỉnh sửa</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="<?php echo e(route('product.index', ['parent_id' => $detail->parent_id, 'cate_id' => $detail->cate_id])); ?>" style="margin-bottom:5px">Quay lại</a>
    <a class="btn btn-primary btn-sm" href="<?php echo e(route('product-detail', [$detail->slug, $detail->id] )); ?>" target="_blank" style="margin-top:-6px"><i class="fa fa-eye" aria-hidden="true"></i> Xem</a>
    <form role="form" method="POST" action="<?php echo e(route('product.update')); ?>" id="dataForm">
    <div class="row">
      <!-- left column -->
      <input type="hidden" name="id" value="<?php echo e($detail->id); ?>">
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Chỉnh sửa</h3>
          </div>
          <!-- /.box-header -->               
            <?php echo csrf_field(); ?>          
            <div class="box-body">
                <?php if(Session::has('message')): ?>
                <p class="alert alert-info" ><?php echo e(Session::get('message')); ?></p>
                <?php endif; ?>
                <?php if(count($errors) > 0): ?>
                  <div class="alert alert-danger">
                    <ul>
                        <?php foreach($errors->all() as $error): ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endif; ?>
                <div>

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Thông tin chi tiết</a></li>                                   
                    <li role="presentation"><a href="#thuoctinh" aria-controls="thuoctinh" role="tab" data-toggle="tab">Số lượng</a></li> 
                    <li role="presentation"><a href="#thongtinseo" aria-controls="thongtinseo" role="tab" data-toggle="tab">Thông tin SEO</a></li>                                  
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="form-group col-md-6 none-padding">
                          <label for="email">Danh mục cha<span class="red-star">*</span></label>
                          <select class="form-control req" name="parent_id" id="parent_id">
                            <option value="">--Chọn--</option>
                            <?php foreach( $loaiSpArr as $value ): ?>
                            <option value="<?php echo e($value->id); ?>"
                            <?php 
                            if( old('parent_id') && old('parent_id') == $value->id ){ 
                              echo "selected";
                            }else if( $detail->parent_id == $value->id ){
                              echo "selected";
                            }else{
                              echo "";
                            }
                            ?>

                            ><?php echo e($value->name); ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                          <div class="form-group col-md-6 none-padding pleft-5">
                          <label for="email">Danh mục con<span class="red-star">*</span></label>

                          <select class="form-control req" name="cate_id" id="cate_id">
                            <option value="">--Chọn--</option>
                            <?php foreach( $cateArr as $value ): ?>
                            <option value="<?php echo e($value->id); ?>" 
                              <?php 
                            if( old('cate_id') && old('cate_id') == $value->id ){ 
                              echo "selected";
                            }else if( $detail->cate_id == $value->id ){
                              echo "selected";
                            }else{
                              echo "";
                            }
                            ?>
                            ><?php echo e($value->name); ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>  
                        <div class="form-group" >                  
                          <label>Tên <span class="red-star">*</span></label>
                          <input type="text" class="form-control req" name="name" id="name" value="<?php echo e(old('name', $detail->name)); ?>">
                        </div>
                        <div class="form-group">                  
                          <label>Slug <span class="red-star">*</span></label>                  
                          <input type="text" class="form-control req" readonly="readonly" name="slug" id="slug" value="<?php echo e(old('slug', $detail->slug)); ?>">
                        </div>                        
                        <div class="col-md-3 none-padding">
                          <div class="checkbox">
                              <label><input type="checkbox" name="is_hot" value="1" <?php echo e(old('is_hot', $detail->is_hot) == 1 ? "checked" : ""); ?>> NỔI BẬT </label>
                          </div>                          
                        </div>
                        <div class="col-md-3 none-padding">
                          <div class="checkbox">
                              <label><input type="checkbox" name="is_new" value="1" <?php echo e(old('is_new', $detail->is_new) == 1 ? "checked" : ""); ?>> NEW </label>
                          </div>                          
                        </div>                        
                        <div class="col-md-3 none-padding pleft-5">
                            <div class="checkbox">
                              <label><input type="checkbox" name="is_sale" id="is_sale" value="1" <?php echo e(old('is_sale', $detail->is_sale) == 1 ? "checked" : ""); ?>> SALE </label>
                          </div>
                        </div>
                        <div class="form-group col-md-6 none-padding" >                  
                            <label>Giá<span class="red-star">*</span></label>
                            <input type="text" class="form-control req number" name="price" id="price" value="<?php echo e(old('price', $detail->price)); ?>">
                        </div>
                        <div class="form-group col-md-6" >                  
                            <label>Giá SALE</label>
                            <input type="text" class="form-control number <?php echo e(old('is_sale', $detail->is_sale) == 1  ? "req" : ""); ?>" name="price_sale" id="price_sale" value="<?php echo e(old('price_sale', $detail->price_sale)); ?>">
                        </div>
                        <div class="input-group">
                          <label>Tags</label>
                          <select class="form-control select2" name="tags[]" id="tags" multiple="multiple">                  
                          <?php if( $tagList->count() > 0): ?>
                          <?php foreach( $tagList as $value ): ?>
                          <option value="<?php echo e($value->id); ?>" <?php echo e(in_array($value->id, old('tags', $tagSelected)) ? "selected" : ""); ?>><?php echo e($value->name); ?></option>
                          <?php endforeach; ?>
                          <?php endif; ?>
                          </select>
                          <span class="input-group-btn">
                          <button style="margin-top:24px" class="btn btn-primary btn-sm" id="btnAddTag" type="button" data-value="3">
                          Tạo mới
                          </button>
                          </span>
                      </div>
                        <div class="clearfix" style="margin-bottom:10px"></div>
                        <div class="form-group">
                          <label>Màu sắc</label>
                          <ul>
                            <?php foreach($colorList as $color): ?>
                            <li class="col-md-2" style="list-style:none">
                                <label>
                                  <input type="checkbox" name="color_id[]" <?php echo e(in_array($color->id, old('color_id', $colorSelected)) ? "checked" : ""); ?> value="<?php echo e($color->id); ?>">
                                  <img src="<?php echo e(Helper::showImage($color->image_url)); ?>" width="26" title="<?php echo e($color->name); ?>" alt="<?php echo e($color->name); ?>" style="border:1px solid #CCC">
                                </label>
                              </li>
                            <?php endforeach; ?>
                          </ul>
                        </div>     
                        <div class="clearfix"></div>
                        <div class="form-group">
                          <label>Size</label>
                          <ul>
                            <?php foreach($sizeList as $size): ?>
                            <li class="col-md-2" style="list-style:none">
                                <label>
                                  <input type="checkbox" name="size_id[]" <?php echo e(in_array($size->id, old('size_id', $sizeSelected)) ? "checked" : ""); ?> value="<?php echo e($size->id); ?>">
                                  <?php echo e($size->name); ?>

                                </label>
                              </li>
                            <?php endforeach; ?>
                          </ul>
                        </div>                        
                        <div style="margin-bottom:10px;clear:both"></div>
                        
                      <div style="margin-bottom:10px;clear:both"></div>
                      <div class="form-group col-md-12 none-padding">
                          <label>Mô tả</label>
                          <textarea class="form-control" rows="4" name="mo_ta" id="mo_ta"><?php echo e(old('mo_ta', $detail->mo_ta)); ?></textarea>
                        </div>
                      
                       
                      <div class="form-group">
                        <label>Chi tiết</label>
                        <textarea class="form-control" rows="10" name="chi_tiet" id="chi_tiet"><?php echo e(old('chi_tiet', $detail->chi_tiet)); ?></textarea>
                      </div>
                        <div class="clearfix"></div>
                    </div><!--end thong tin co ban-->                    
                     <div role="tabpanel" class="tab-pane" id="thuoctinh">                    
                      <table class="table table-bordered">
                        <tr>
                          <th></th>                          
                          <th class="text-center" style="white-space:nowrap">Đại diện</th>
                          
                          <?php foreach($detail->sizes as $size): ?>                         
                   
                          <th class="text-center">Size <?php echo e($sizeArr[$size->size_id]->name); ?></th>
                          <?php endforeach; ?>
                        </tr>
                        <?php $iDaiDien = 0; ?>
                        <?php foreach($detail->colors as $color): ?>
                               <?php                            
                               $iDaiDien ++; 

                               if($detail->color_id_main){
                                  $color_id_main = $detail->color_id_main;
                               }else{
                                  if($iDaiDien == 1){
                                    $color_id_main = $color->color_id;
                                  }
                               }
                               ?>
                        <tr>
                          <td style="white-space:nowrap;text-align:center"><img src="<?php echo e(Helper::showImage($colorArr[$color->color_id]->image_url)); ?>" width="30" style="border:1px solid #CCC"></br><?php echo e($colorArr[$color->color_id]->name); ?></td>
                          <td class="text-center" style="vertical-align:middle">
                            <input type="radio" <?php echo e($color_id_main == $color->color_id ? "checked" : ""); ?>  name="color_id_main" value="<?php echo e($color->color_id); ?>">
                          </td>
                          <?php foreach($detail->sizes as $size): ?>          
                          <?php 
                          $valueAmount = !empty($arrInv) ? $arrInv[$color->color_id][$size->size_id] : "";
                          ?>               
                          <td style="padding-left:1px;padding-right:1px; vertical-align:middle">
                            <input type="text" class="form-control number"  name="amount[<?php echo e($color->color_id); ?>][<?php echo e($size->size_id); ?>]" value="<?php echo e($valueAmount); ?>" >
                          </td>
                          <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                      </table>
                 
                     
                     </div>
                     <div role="tabpanel" class="tab-pane" id="thongtinseo">                    
                     <input type="hidden" name="meta_id" value="<?php echo e($detail->meta_id); ?>">
                        <div class="form-group">
                          <label>Meta title </label>
                          <input type="text" class="form-control" name="meta_title" id="meta_title" value="<?php echo e(!empty((array)$meta) ? $meta->title : ""); ?>">
                        </div>
                        <!-- textarea -->
                        <div class="form-group">
                          <label>Meta desciption</label>
                          <textarea class="form-control" rows="6" name="meta_description" id="meta_description"><?php echo e(!empty((array)$meta) ? $meta->description : ""); ?></textarea>
                        </div>  

                        <div class="form-group">
                          <label>Meta keywords</label>
                          <textarea class="form-control" rows="4" name="meta_keywords" id="meta_keywords"><?php echo e(!empty((array)$meta) ? $meta->keywords : ""); ?></textarea>
                        </div>  
                        <div class="form-group">
                          <label>Custom text</label>
                          <textarea class="form-control" rows="6" name="custom_text" id="custom_text"><?php echo e(!empty((array)$meta) ? $meta->custom_text : ""); ?></textarea>
                        </div>
                     
                     </div>
                  </div>

                </div>
                  
            </div>
            <div class="box-footer">             
              <button type="button" class="btn btn-default btn-sm" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary btn-sm" id="btnSave">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="<?php echo e(route('product.index', ['parent_id' => $detail->parent_id, 'cate_id' => $detail->cate_id])); ?>">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
     
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<input type="hidden" id="route_upload_tmp_image_multiple" value="<?php echo e(route('image.tmp-upload-multiple')); ?>">
<input type="hidden" id="route_upload_tmp_image" value="<?php echo e(route('image.tmp-upload')); ?>">
<style type="text/css">
  .nav-tabs>li.active>a{
    color:#FFF !important;
    background-color: #c70f19 !important;
  }
  .error{
    border : 1px solid red;
  }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript_page'); ?>
<script type="text/javascript">

$(document).on('click', '.remove-image', function(){
  if( confirm ("Bạn có chắc chắn không ?")){
    $(this).parents('.col-md-3').remove();
  }
});

$(document).on('keypress', '#name_search', function(e){
  if(e.which == 13) {
      e.preventDefault();
      filterAjax($('#search_type').val());
  }
});

    $(document).ready(function(){
           $('#btnSave').click(function(){
        var errReq = 0;
        $('#dataForm .req').each(function(){
          var obj = $(this);
          if(obj.val() == '' || obj.val() == '0'){
            errReq++;
            obj.addClass('error');
          }else{
            obj.removeClass('error');
          }
        });
        if(errReq > 0){          
         $('html, body').animate({
              scrollTop: $("#dataForm .req.error").eq(0).parents('div').offset().top
          }, 500);
          return false;
        }
        /*
        if( $('#div-image img.img-thumbnail').length == 0){
          if(confirm('Bạn chưa upload hình sản phẩm. Vẫn tiếp tục lưu ?')){
            return true;
          }else{
            $('html, body').animate({
                scrollTop: $("#dataForm").offset().top
            }, 500);
            $('a[href="#settings"]').click();            
             return false;
          }
        }*/
      });
      
      $('#is_sale').change(function(){
        if($(this).prop('checked') == true){
          $('#price_sale').addClass('req');
        }else{
          $('#price_sale').val('').removeClass('req');
        }
      });
      $('#dataForm .req').blur(function(){    
        if($(this).val() != ''){
          $(this).removeClass('error');
        }else{
          $(this).addClass('error');
        }
      });
      $('#parent_id').change(function(){
        location.href="<?php echo e(route('product.create')); ?>?parent_id=" + $(this).val();
      })
      $(".select2").select2();
     
      var editor = CKEDITOR.replace( 'chi_tiet',{     
          height: 300
      });     
      var editor3 = CKEDITOR.replace( 'mo_ta',{  
          height : 100,
      });
      $('#btnUploadImage').click(function(){        
        $('#file-image').click();
      }); 
     
      var files = "";
      $('#file-image').change(function(e){
         files = e.target.files;
         
         if(files != ''){
           var dataForm = new FormData();        
          $.each(files, function(key, value) {
             dataForm.append('file[]', value);
          });   
          
          dataForm.append('date_dir', 0);
          dataForm.append('folder', 'tmp');

          $.ajax({
            url: $('#route_upload_tmp_image_multiple').val(),
            type: "POST",
            async: false,      
            data: dataForm,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#div-image').append(response);
                if( $('input.thumb:checked').length == 0){
                  $('input.thumb').eq(0).prop('checked', true);
                }
            },
            error: function(response){                             
                var errors = response.responseJSON;
                for (var key in errors) {
                  
                }
                //$('#btnLoading').hide();
                //$('#btnSave').show();
            }
          });
        }
      });
     

      $('#name').change(function(){
         var name = $.trim( $(this).val() );
         
            $.ajax({
              url: $('#route_get_slug').val(),
              type: "POST",
              async: false,      
              data: {
                str : name
              },              
              success: function (response) {
                if( response.str ){                  
                  $('#slug').val( response.str );
                }                
              },
              error: function(response){                             
                  var errors = response.responseJSON;
                  for (var key in errors) {
                    
                  }                  
              }
            });
         
      }); 
    });
    
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>