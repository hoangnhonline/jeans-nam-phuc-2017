@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Sản phẩm mới    
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('product.index') }}">Sản phẩm mới</a></li>
      <li class="active">Thêm mới</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('product.index') }}" style="margin-bottom:5px">Quay lại</a>
    <form role="form" method="POST" action="{{ route('product.store') }}" id="dataForm">
    <input type="hidden" name="is_copy" value="1">
    <div class="row">
      <!-- left column -->

      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Thêm mới</h3>
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}          
            <div class="box-body">
                @if (count($errors) > 0)
                  <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                  </div>
                @endif
                <div>

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Thông tin chi tiết</a></li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                   
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="form-group col-md-6 none-padding">
                          <label for="email">Danh mục cha<span class="red-star">*</span></label>
                          <select class="form-control req" name="parent_id" id="parent_id">
                            <option value="">--Chọn--</option>
                            @foreach( $loaiSpArr as $value )
                            <option value="{{ $value->id }}" {{ $value->id == old('parent_id') || $value->id == $parent_id ? "selected" : "" }}>{{ $value->name }}</option>
                            @endforeach
                          </select>
                        </div>
                          <div class="form-group col-md-6 none-padding pleft-5">
                          <label for="email">Danh mục con<span class="red-star">*</span></label>
                          <?php 
                          $parent_id = old('parent_id');
                          if($parent_id > 0){
                            $cateList = DB::table('cate')->where('parent_id', $parent_id)->orderBy('display_order')->get();
                          }
                          ?>
                          <select class="form-control req" name="cate_id" id="cate_id">
                            <option value="">--Chọn--</option>
                            @foreach( $cateList as $value )
                            <option value="{{ $value->id }}" {{ $value->id == old('cate_id') || $value->id == $cate_id ? "selected" : "" }}>{{ $value->name }}</option>
                            @endforeach
                          </select>
                        </div>  
                        <div class="form-group" >                  
                          <label>Tên <span class="red-star">*</span></label>
                          <input type="text" class="form-control req" name="name" id="name" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">                  
                          <label>Slug <span class="red-star">*</span></label>                  
                          <input type="text" class="form-control req" readonly="readonly" name="slug" id="slug" value="{{ old('slug') }}">
                        </div> 
                        <div class="col-md-4 none-padding">
                          <div class="checkbox">
                              <label><input type="checkbox" name="is_hot" value="1" {{ old('is_hot') == 1 ? "checked" : "" }}> NỔI BẬT </label>
                          </div>                          
                        </div>
                        <div class="col-md-4 none-padding">
                          <div class="checkbox">
                              <label><input type="checkbox" name="is_new" value="1" {{ old('is_new') == 1 ? "checked" : "" }}> NEW </label>
                          </div>                          
                        </div>                        
                        <div class="col-md-4 none-padding pleft-5">
                            <div class="checkbox">
                              <label><input type="checkbox" name="is_sale" id="is_sale" value="1" {{ old('is_sale') == 1 ? "checked" : "" }}> SALE </label>
                          </div>
                        </div>
                        <div class="form-group col-md-6 none-padding" >                  
                            <label>Giá<span class="red-star">*</span></label>
                            <input type="text" class="form-control req number" name="price" id="price" value="{{ old('price') }}">
                        </div>
                        <div class="form-group col-md-6" >                  
                            <label>Giá SALE</label>
                            <input type="text" class="form-control number" name="price_sale" id="price_sale" value="{{ old('price_sale') }}">
                        </div>     
                         <div class="input-group">
                          <label>Phong cách sản phẩm (tags)</label>
                          <select class="form-control select2" name="tags[]" id="tags" multiple="multiple">                  
                          @if( $tagList->count() > 0)
                          @foreach( $tagList as $value )
                          <option value="{{ $value->id }}" {{ (old('tags') && in_array($value->id, old('tags'))) ? "selected" : "" }}>{{ $value->name }}</option>
                          @endforeach
                          @endif
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
                            @foreach($colorList as $color)
                            <li class="col-md-2" style="list-style:none">
                                <label>
                                  <input type="checkbox" class="color_id" name="color_id[]" value="{{ $color->id }}">
                                  <img src="{{ Helper::showImage($color->image_url) }}" width="26" title="{{ $color->name }}" alt="{{ $color->name }}" style="border:1px solid #CCC">
                                </label>
                              </li>
                            @endforeach
                          </ul>
                        </div>     
                        <div class="clearfix"></div>
                        <div class="form-group">
                          <label>Size</label>
                          <ul>
                            @foreach($sizeList as $size)
                            <li class="col-md-2" style="list-style:none">
                                <label>
                                  <input type="checkbox" class="size_id" name="size_id[]" value="{{ $size->id }}">
                                  {{ $size->name }}
                                </label>
                              </li>
                            @endforeach
                          </ul>
                        </div>                        
                        <div style="margin-bottom:10px;clear:both"></div>                                      
                         
                        <div class="form-group">
                          <label>Chi tiết</label>
                          <textarea class="form-control" rows="10" name="chi_tiet" id="chi_tiet">{{ old('chi_tiet') }}</textarea>
                        </div>
                        <div class="clearfix"></div>
                    </div><!--end thong tin co ban-->                        
                  </div>

                </div>
                  
            </div>
            <div class="box-footer">              
              <button type="button" class="btn btn-default btn-sm" id="btnLoading" style="display:none"><i class="fa fa-spin fa-spinner"></i></button>
              <button type="submit" class="btn btn-primary btn-sm" id="btnSave">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('product.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <div class="col-md-4">      
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Thông tin SEO</h3>
          </div>

          <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <label>Meta title </label>
                <input type="text" class="form-control" name="meta_title" id="meta_title" value="{{ old('meta_title') }}">
              </div>
              <!-- textarea -->
              <div class="form-group">
                <label>Meta desciption</label>
                <textarea class="form-control" rows="6" name="meta_description" id="meta_description">{{ old('meta_description') }}</textarea>
              </div>  

              <div class="form-group">
                <label>Meta keywords</label>
                <textarea class="form-control" rows="4" name="meta_keywords" id="meta_keywords">{{ old('meta_keywords') }}</textarea>
              </div>  
              <div class="form-group">
                <label>Custom text</label>
                <textarea class="form-control" rows="6" name="custom_text" id="custom_text">{{ old('custom_text') }}</textarea>
              </div>
            
        </div>
        <!-- /.box -->     

      </div>
      <!--/.col (left) -->      
    </div>
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

<div id="tagModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <form method="POST" action="{{ route('tag.ajax-save') }}" id="formAjaxTag">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tạo mới tag</h4>
                </div>
                <div class="modal-body" id="contentTag">
                    <input type="hidden" name="type" value="1">
                    <!-- text input -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tags<span class="red-star">*</span></label>
                            <textarea class="form-control" name="str_tag" id="str_tag" rows="4" >{{ old('str_tag') }}</textarea>
                        </div>
                    </div>
                    <div classs="clearfix"></div>
                </div>
                <div style="clear:both"></div>
                <div class="modal-footer" style="text-align:center">
                    <button type="button" class="btn btn-primary btn-sm" id="btnSaveTagAjax"> Save</button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" id="btnCloseModalTag">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style type="text/css">
  .nav-tabs>li.active>a{
    color:#FFF !important;
    background-color: #c70f19 !important;
  }
  .error{
    border : 1px solid red;
  }
</style>
@stop
@section('javascript_page')
<script type="text/javascript">

$(document).on('click', '.remove-image', function(){
  if( confirm ("Bạn có chắc chắn không ?")){
    $(this).parents('.col-md-3').remove();
  }
});

$(document).ready(function(){        
      $('#btnAddTag').click(function(){
          $('#tagModal').modal('show');
      });
    });
    $(document).on('click', '.remove-image', function(){
      if( confirm ("Bạn có chắc chắn không ?")){
        $(this).parents('.col-md-3').remove();
      }
    });
    $(document).on('click', '#btnSaveTagAjax', function(){
        $.ajax({
          url : $('#formAjaxTag').attr('action'),
          data: $('#formAjaxTag').serialize(),
          type : "post", 
          success : function(str_id){          
            $('#btnCloseModalTag').click();
            $.ajax({
              url : "{{ route('tag.ajax-list') }}",
              data: { 
                type : 1 ,
                tagSelected : $('#tags').val(),
                str_id : str_id
              },
              type : "get", 
              success : function(data){
                  $('#tags').html(data);
                  $('#tags').select2('refresh');
                  
              }
            });
          }
        });
     }); 
     

    $(document).ready(function(){
      $('#contentTag #name').change(function(){
           var name = $.trim( $(this).val() );
           if( name != '' && $('#contentTag #slug').val() == ''){
              $.ajax({
                url: $('#route_get_slug').val(),
                type: "POST",
                async: false,      
                data: {
                  str : name
                },              
                success: function (response) {
                  if( response.str ){                  
                    $('#contentTag #slug').val( response.str );
                  }                
                }
              });
           }
        });
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
        }else{
          if($('input.color_id:checked').length == 0){
            alert('Vui lòng chọn màu'); return false;
          }
          if($('input.size_id:checked').length == 0){
            alert('Vui lòng chọn size'); return false;
          }  
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
      $('#is_old').change(function(){
        if($(this).prop('checked') == true){
          $('#price_new').addClass('req');
        }else{
          $('#price_new').val('').removeClass('req');
        }
      });
      $('#is_sale').change(function(){
        if($(this).prop('checked') == true){
          $('#price_sale, #sale_percent').addClass('req');          
        }else{
          $('#price_sale, #sale_percent').val('').removeClass('req');
        }
      });
      $('#price_sale').blur(function(){

        var sale_percent = 0;
        var price = parseInt($('#price').val());
        var price_sale = parseInt($('#price_sale').val());
        if(price_sale > 0){
          $('#is_sale').prop('checked', true);          
          if(price_sale > price){
            price_sale = price;
            $('#price_sale').val(price_sale);
          }
          if( price > 0 ){
            sale_percent = 100 - Math.floor(price_sale*100/price);
            $('#sale_percent').val(sale_percent);
          }
        }
      }); 
       $('#sale_percent').blur(function(){
        var price_sale = 0;
        var price = parseInt($('#price').val());
        var sale_percent = parseInt($('#sale_percent').val());
        sale_percent = sale_percent > 100 ? 100 : sale_percent;
        if( sale_percent > 0){
          $('#is_sale').prop('checked', true);
        }
        if(sale_percent > 100){
          sale_percent = 100;
          $('#sale_percent').val(100);
        }
        if( price > 0 ){
          price_sale = Math.ceil((100-sale_percent)*price/100);
          $('#price_sale').val(price_sale);
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
        location.href="{{ route('product.create') }}?parent_id=" + $(this).val();
      })
      $(".select2").select2();
      $('#dataForm').submit(function(){
        /*var no_cate = $('input[name="category_id[]"]:checked').length;
        if( no_cate == 0){
          swal("Lỗi!", "Chọn ít nhất 1 thể loại!", "error");
          return false;
        }
        var no_country = $('input[name="country_id[]"]:checked').length;
        if( no_country == 0){
          swal("Lỗi!", "Chọn ít nhất 1 quốc gia!", "error");
          return false;
        }        
        */
        $('#btnSave').hide();
        $('#btnLoading').show();
      });
      var editor = CKEDITOR.replace( 'chi_tiet',{
          language : 'vi',
          height: 300        
      });    
     

      $('#name').change(function(){
         var name = $.trim( $(this).val() );
         if( name != ''){
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
              }
            });
         }
      });  
     
     
      
    });
    
</script>
@stop
