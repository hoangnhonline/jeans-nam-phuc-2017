<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Hình ảnh : <a href="<?php echo e(route('product.edit', [$detail->id])); ?>"><?php echo e($detail->name); ?></a> - <?php echo e($detailColor->name); ?>

    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?php echo e(route('articles.index')); ?>">Hình ảnh sản phẩm</a></li>
      <li class="active"><span class="glyphicon glyphicon-pencil"></span></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="<?php echo e(route('product.index')); ?>" style="margin-bottom:5px">Quay lại</a>   
    <form role="form" method="POST" action="<?php echo e(route('product.store-image')); ?>">
    <div class="row">
      <!-- left column -->
      <input name="id" value="<?php echo e($detail->id); ?>" type="hidden">
      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            Hình ảnh 
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
                <input type="hidden" name="product_id" value="<?php echo e($detail->id); ?>">
                <input type="hidden" name="color_id" value="<?php echo e($detailColor->id); ?>">
                <div class="form-group" style="margin-top:10px;margin-bottom:10px">  
                   <button class="btn btn-primary btn-sm" id="btnUploadImage" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload</button> 
                   <div class="clearfix"></div>
                    <div id="div-image" style="margin-top:10px">
                        <?php if( $hinhArr ): ?>
                        <?php foreach( $hinhArr as $k => $hinh): ?>
                        <div class="col-md-3">                              
                            <img class="img-thumbnail" src="<?php echo e(Helper::showImage($hinh->image_url)); ?>" style="width:100%">
                            <div class="checkbox">                                   
                                <label><input type="radio" name="thumbnail_id" class="thumb" value="<?php echo e($hinh->id); ?>" <?php echo e($hinh->is_thumbnail == 1 ? "checked" : ""); ?>> Ảnh đại diện </label>
                                <button class="btn btn-danger btn-sm remove-image" type="button" data-value="<?php echo e($hinh->id); ?>" data-id="<?php echo e($hinh->id); ?>" ><span class="glyphicon glyphicon-trash"></span></button>
                            </div>
                            <input type="hidden" name="image_id[]" value="<?php echo e($hinh->id); ?>">
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div style="clear:both"></div>
                </div>
               
                  
            </div>               
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="<?php echo e(route('articles.index')); ?>">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<input type="hidden" id="route_upload_tmp_image" value="<?php echo e(route('image.tmp-upload')); ?>">
<!-- Modal -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript_page'); ?>
<script type="text/javascript">
var h = screen.height;
var w = screen.width;
var left = (screen.width/2)-((w-300)/2);
var top = (screen.height/2)-((h-100)/2);
function openKCFinder_singleFile() {
        window.KCFinder = {};
        window.KCFinder.callBack = function(url) {
            console.log(url);
            window.KCFinder = null;
        };
        window.open('<?php echo e(URL::asset("public/admin/dist/js/kcfinder/browse.php?type=images")); ?>', 'kcfinder_single','scrollbars=1,menubar=no,width='+ (w-300) +',height=' + (h-300) +',top=' + top+',left=' + left);
    }
 
function openKCFinder_multipleFiles() {
    window.KCFinder = {};
    window.KCFinder.callBackMultiple = function(files) {
        var strHtml = '';
        for (var i = 0; i < files.length; i++) {
             strHtml += '<div class="col-md-3">';

        strHtml += '<img class="img-thumbnail" src="' + '<?php echo e(env('APP_URL')); ?>' + files[i]  + '" style="width:100%">';
         strHtml += '<div class="checkbox">';
         strHtml += '<input type="hidden" name="image_tmp_url[]" value="' + files[i]  + '">';
        
        strHtml += '<label><input type="radio" name="thumbnail_id" class="thumb" value="' +  files[i]  + '"> &nbsp; Ảnh đại diện </label>';
        strHtml += '<button class="btn btn-danger btn-sm remove-image" type="button" data-value="' + '<?php echo e(env('APP_URL')); ?>' + files[i]  + '" data-id="" ><span class="glyphicon glyphicon-trash"></span></button></div></div>';
      
            console.log(files[i]);
        }
        $('#div-image').append(strHtml);
            if( $('#div-image input.thumb:checked').length == 0){
              $('#div-image input.thumb').eq(0).prop('checked', true);
            }
        window.KCFinder = null;
    };
      window.open('<?php echo e(URL::asset("public/admin/dist/js/kcfinder/browse.php?type=images")); ?>', 'kcfinder_multiple','scrollbars=1,menubar=no,width='+ (w-300) +',height=' + (h-300) +',top=' + top+',left=' + left);
}
$(document).ready(function(){
   $('#btnUploadImage').click(function(){        
      //$('#file-image').click();
      openKCFinder_multipleFiles();
    }); 

});
$(document).on('click', '.remove-image', function(){
    var obj = $(this);
      if( confirm ("Bạn có chắc chắn không ?")){
        $(this).parents('.col-md-3').remove();
        if(parseInt(obj.data('value')) > 0){
          $.ajax({
            url : "<?php echo e(route('product.remove-img')); ?>",
            type : 'GET',
            data : {
              id : obj.data('value')
            },
            success : function(data){

            }
          });
        }
      }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>