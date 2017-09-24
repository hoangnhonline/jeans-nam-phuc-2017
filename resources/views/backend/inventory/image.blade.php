@extends('backend.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Hình ảnh : <a href="{{ route('inventory.edit', [$detail->id])}}">{{ $detail->name }}</a> - {{ $detailColor->name }}
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="{{ route('articles.index') }}">Hình ảnh sản phẩm</a></li>
      <li class="active"><span class="glyphicon glyphicon-pencil"></span></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <a class="btn btn-default btn-sm" href="{{ route('inventory.index') }}" style="margin-bottom:5px">Quay lại</a>   
    <form role="form" method="POST" action="{{ route('inventory.store-image') }}">
    <div class="row">
      <!-- left column -->
      <input name="id" value="{{ $detail->id }}" type="hidden">
      <div class="col-md-8">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            Hình ảnh 
          </div>
          <!-- /.box-header -->               
            {!! csrf_field() !!}

            <div class="box-body">
              @if(Session::has('message'))
              <p class="alert alert-info" >{{ Session::get('message') }}</p>
              @endif
              @if (count($errors) > 0)
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif                
                <input type="hidden" name="product_id" value="{{ $detail->id }}">
                <input type="hidden" name="color_id" value="{{ $detailColor->id }}">
                <div class="form-group" style="margin-top:10px;margin-bottom:10px">  
                   <button class="btn btn-primary btn-sm" id="btnUploadImage" type="button"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload</button> 
                   <div class="clearfix"></div>
                    <div id="div-image" style="margin-top:10px">
                        @if( $hinhArr )
                        @foreach( $hinhArr as $k => $hinh)
                        <div class="col-md-3">                              
                            <img class="img-thumbnail" src="{{ Helper::showImage($hinh->image_url) }}" style="width:100%">
                            <div class="checkbox">                                   
                                <label><input type="radio" name="thumbnail_id" class="thumb" value="{{ $hinh->id }}" {{ $hinh->is_thumbnail == 1 ? "checked" : "" }}> Ảnh đại diện </label>
                                <button class="btn btn-danger btn-sm remove-image" type="button" data-value="{{  $hinh->id }}" data-id="{{ $hinh->id }}" ><span class="glyphicon glyphicon-trash"></span></button>
                            </div>
                            <input type="hidden" name="image_id[]" value="{{ $hinh->id }}">
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div style="clear:both"></div>
                </div>
               
                  
            </div>               
            <div class="box-footer">
              <button type="submit" class="btn btn-primary btn-sm">Lưu</button>
              <a class="btn btn-default btn-sm" class="btn btn-primary btn-sm" href="{{ route('articles.index')}}">Hủy</a>
            </div>
            
        </div>
        <!-- /.box -->     

      </div>
      
    </form>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<input type="hidden" id="route_upload_tmp_image" value="{{ route('image.tmp-upload') }}">
<!-- Modal -->

@stop
@section('javascript_page')
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
        window.open('{{ URL::asset("public/admin/dist/js/kcfinder/browse.php?type=images") }}', 'kcfinder_single','scrollbars=1,menubar=no,width='+ (w-300) +',height=' + (h-300) +',top=' + top+',left=' + left);
    }
 
function openKCFinder_multipleFiles() {
    window.KCFinder = {};
    window.KCFinder.callBackMultiple = function(files) {
        var strHtml = '';
        for (var i = 0; i < files.length; i++) {
             strHtml += '<div class="col-md-3">';

        strHtml += '<img class="img-thumbnail" src="' + '{{ env('APP_URL') }}' + files[i]  + '" style="width:100%">';
         strHtml += '<div class="checkbox">';
         strHtml += '<input type="hidden" name="image_tmp_url[]" value="' + files[i]  + '">';
        
        strHtml += '<label><input type="radio" name="thumbnail_id" class="thumb" value="' +  files[i]  + '"> &nbsp; Ảnh đại diện </label>';
        strHtml += '<button class="btn btn-danger btn-sm remove-image" type="button" data-value="' + '{{ env('APP_URL') }}' + files[i]  + '" data-id="" ><span class="glyphicon glyphicon-trash"></span></button></div></div>';
      
            console.log(files[i]);
        }
        $('#div-image').append(strHtml);
            if( $('#div-image input.thumb:checked').length == 0){
              $('#div-image input.thumb').eq(0).prop('checked', true);
            }
        window.KCFinder = null;
    };
      window.open('{{ URL::asset("public/admin/dist/js/kcfinder/browse.php?type=images") }}', 'kcfinder_multiple','scrollbars=1,menubar=no,width='+ (w-300) +',height=' + (h-300) +',top=' + top+',left=' + left);
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
            url : "{{ route('inventory.remove-img') }}",
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
@stop
