<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Màu
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?php echo e(route( 'color.index' )); ?>">Màu</a></li>
    <li class="active">Danh sách</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <?php if(Session::has('message')): ?>
      <p class="alert alert-info" ><?php echo e(Session::get('message')); ?></p>
      <?php endif; ?>
      <a href="<?php echo e(route('color.create')); ?>" class="btn btn-info btn-sm" style="margin-bottom:5px">Tạo mới</a>
      
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Danh sách ( <span class="value"><?php echo e($items->total()); ?> màu )</span></h3>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">

          <form action="<?php echo e(route('cap-nhat-thu-tu')); ?>" method="POST">
           <?php if( $items->count() > 0 ): ?> 
          <button type="submit" class="btn btn-warning btn-sm">Cập nhật thứ tự</button>
          <?php endif; ?>
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="table" value="color">
            <table class="table table-bordered" id="table-list-data">
              <tr>
                <th style="width: 1%">#</th>    
                <th>Thứ tự</th>                        
                <th>Tên màu</th>
                <th>Hình ảnh</th>
                <th width="1%;white-space:nowrap">Thao tác</th>
              </tr>
              <tbody>
              <?php if( $items->count() > 0 ): ?>
                <?php $i = 0; ?>
                <?php foreach( $items as $item ): ?>
                  <?php $i ++; ?>
                <tr id="row-<?php echo e($item->id); ?>">
                  <td><span class="order"><?php echo e($i); ?></span></td>      
                  <td width="100">
                    <input type="text" name="display_order[]" value="<?php echo e($item->display_order); ?>" class="form-control" style="width:60px">
                    <input type="hidden" name="id[]" value="<?php echo e($item->id); ?>">
                  </td>     
                  <td>                  
                    <a href="<?php echo e(route( 'color.edit', [ 'id' => $item->id ])); ?>"><?php echo e($item->name); ?></a>
                  </td>
                  <td>
                    <img src="<?php echo e(Helper::showImage($item->image_url )); ?>" width="40" style="border:1px solid #CCC">
                  </td>
                  <td style="white-space:nowrap">                  
                    <a href="<?php echo e(route( 'color.edit', [ 'id' => $item->id ])); ?>" class="btn btn-warning btn-sm">Chỉnh sửa</a>                 
                    
                    <a onclick="return callDelete('<?php echo e($item->title); ?>','<?php echo e(route( 'color.destroy', [ 'id' => $item->id ])); ?>');" class="btn btn-danger btn-sm">Xóa</a>
                    
                  </td>
                </tr> 
                <?php endforeach; ?>
              <?php else: ?>
              <tr>
                <td colspan="3">Không có dữ liệu.</td>
              </tr>
              <?php endif; ?>

            </tbody>
            </table>
            <?php if( $items->count() > 0 ): ?>
            <button type="submit" class="btn btn-warning btn-sm">Cập nhật thứ tự</button>
            <?php endif; ?>
           </form>
        </div>        
      </div>
      <!-- /.box -->     
    </div>
    <!-- /.col -->  
  </div> 
</section>
<!-- /.content -->
</div>
<style type="text/css">
  a.color_code {
    display: block;
    width: 50px;
    height: 50px;
    box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.29);
    border: 1px solid rgba(0, 0, 0, 0.2);
    text-align: center;
    line-height: 28px;
    font-size: 10px;
    color: #FFF;
}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript_page'); ?>
<script type="text/javascript">
function callDelete(name, url){  
  swal({
    title: 'Bạn muốn xóa "' + name +'"?',
    text: "Dữ liệu sẽ không thể phục hồi.",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then(function() {
    location.href= url;
  })
  return flag;
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>