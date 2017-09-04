<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Màu   
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?php echo e(route('color.index')); ?>">Màu</a></li>
      <li class="active">Chỉnh sửa</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default" href="<?php echo e(route('color.index')); ?>" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="<?php echo e(route('color.update')); ?>">
    <div class="row">
      <!-- left column -->
      <input name="id" value="<?php echo e($detail->id); ?>" type="hidden">
      <div class="col-md-7">
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
                
              <div class="form-group" >
                
                <label>Tên màu<span class="red-star">*</span></label>
                <input type="text" class="form-control" name="name" id="name" value="<?php echo e($detail->name); ?>">
              </div>                
              <div class="form-group" style="margin-top:10px;margin-bottom:10px">  
                  <label class="col-md-4 row">Hình ảnh ( 26x26 px)</label>    
                  <div class="col-md-8 div-upload">
                    <img src="<?php echo e($detail->image_url ? Helper::showImage($detail->image_url ) : URL::asset('public/admin/dist/img/img.png')); ?>" class="img-thumbnail show_thumbnail" width="40" height="40">
                    
                    <input type="file" data-value="image_url" class="click-choose-file" style="display:none" />
                 
                    <button class="btn btn-default btn-sm btnUpload" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload</button>
                  </div>
                  <div style="clear:both"></div>
                </div>    
            </div>       
            <input type="hidden" name="image_url" id="image_url" value="<?php echo e($detail->image_url); ?>"/>          
            <input type="hidden" name="image_url_name" id="image_url_name" value="<?php echo e($detail->image_url_name); ?>"/>               
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Lưu</button>
              <a class="btn btn-default" class="btn btn-primary" href="<?php echo e(route('color.index')); ?>">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>         
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>