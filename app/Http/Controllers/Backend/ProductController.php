<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\LoaiSp;
use App\Models\Cate;
use App\Models\Color;
use App\Models\LoaiThuocTinh;
use App\Models\ThuocTinh;
use App\Models\SpThuocTinh;
use App\Models\ProductImg;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\ProductInventory;
use App\Models\MetaData;
use App\Models\Size;
use Helper, File, Session, Auth, URL, Image;

class ProductController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {

        $arrSearch['status'] = $status = isset($request->status) ? $request->status : 1;
        $arrSearch['is_hot'] = $is_hot = isset($request->is_hot) ? $request->is_hot : null;
        $arrSearch['is_sale'] = $is_sale = isset($request->is_sale) ? $request->is_sale : null;
        $arrSearch['is_new'] = $is_new = isset($request->is_new) ? $request->is_new : null;        
        $arrSearch['loai_id'] = $loai_id = isset($request->loai_id) ? $request->loai_id : null;
        $arrSearch['cate_id'] = $cate_id = isset($request->cate_id) ? $request->cate_id : null;
       
        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = Product::where('product.status', $status);
        if( $is_hot ){
            $query->where('product.is_hot', $is_hot);
        }
        if( $is_new ){
            $query->where('product.is_new', $is_new);
        }
       
        if( $is_sale ){
            $query->where('product.is_sale', $is_sale);
        }
        if( $loai_id ){
            $query->where('product.loai_id', $loai_id);
        }
        if( $cate_id ){
            $query->where('product.cate_id', $cate_id);
        }        
  
        if( $name != ''){
            $query->where('product.name', 'LIKE', '%'.$name.'%');          
        }
        $query->join('users', 'users.id', '=', 'product.created_user');
        $query->join('loai_sp', 'loai_sp.id', '=', 'product.loai_id');
        $query->join('cate', 'cate.id', '=', 'product.cate_id');
        $query->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id');        
        if($is_hot){
            $query->orderBy('product.display_order', 'asc');
        }else{
            $query->orderBy('product.id', 'desc');    
        }
        
        $items = $query->select(['product_img.image_url','product.*','product.id as product_id', 'full_name' , 'product.created_at as time_created', 'users.full_name', 'loai_sp.name as ten_loai', 'cate.name as ten_cate'])
        ->paginate(50);   

        $loaiSpArr = LoaiSp::all();  
        if( $loai_id ){
            $cateArr = Cate::where('loai_id', $loai_id)->orderBy('display_order', 'desc')->get();
        }else{
            $cateArr = (object) [];
        }

        return view('backend.product.index', compact( 'items', 'arrSearch', 'loaiSpArr', 'cateArr'));
    }     
    public function ajaxSearch(Request $request){    
        $search_type = $request->search_type;
        $arrSearch['loai_id'] = $loai_id = isset($request->loai_id) ? $request->loai_id : -1;
        $arrSearch['cate_id'] = $cate_id = isset($request->cate_id) ? $request->cate_id : -1;
        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = Product::whereRaw('1');
        
        if( $loai_id ){
            $query->where('product.loai_id', $loai_id);
        }
        if( $cate_id ){
            $query->where('product.cate_id', $cate_id);
        }
        if( $name != ''){
            $query->where('product.name', 'LIKE', '%'.$name.'%');
            $query->orWhere('name_extend', 'LIKE', '%'.$name.'%');
        }
        $query->join('users', 'users.id', '=', 'product.created_user');
        $query->join('loai_sp', 'loai_sp.id', '=', 'product.loai_id');
        $query->join('cate', 'cate.id', '=', 'product.cate_id');
        $query->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id');        
        $query->orderBy('product.id', 'desc');
        $items = $query->select(['product_img.image_url','product.*','product.id as product_id', 'full_name' , 'product.created_at as time_created', 'users.full_name', 'loai_sp.name as ten_loai', 'cate.name as ten_cate'])
        ->paginate(1000);

        $loaiSpArr = LoaiSp::all();  
        if( $loai_id ){
            $cateArr = Cate::where('loai_id', $loai_id)->orderBy('display_order', 'desc')->get();
        }else{
            $cateArr = (object) [];
        }

        return view('backend.product.content-search', compact( 'items', 'arrSearch', 'loaiSpArr', 'cateArr', 'search_type'));
    }
  
    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create(Request $request)
    {
        $loai_id = $request->loai_id ? $request->loai_id : null;
        $cate_id = $request->cate_id ? $request->cate_id : null;
        $cateList = (object) [];     
        $loaiSpArr = LoaiSp::all();      
        if($loai_id > 0){
            $cateList = Cate::where('loai_id', $loai_id)->get();
        }
        $colorList = Color::orderBy('display_order')->get();      
        $sizeList = Size::orderBy('display_order')->get();        
        return view('backend.product.create', compact('loaiSpArr', 'cateList', 'loai_id', 'colorList', 'cate_id', 'sizeList'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */
    public function store(Request $request)
    {
        $dataArr = $request->all();

        $this->validate($request,[
            'name' => 'required',
            'slug' => 'required' ,
            'price' => 'required'            
        ],
        [
            'name.required' => 'Bạn chưa nhập tên sản phẩm',
            'slug.required' => 'Bạn chưa nhập slug',            
            'price.required' => 'Bạn chưa nhập giá'            
        ]);
       
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;
        $dataArr['is_sale'] = isset($dataArr['is_sale']) ? 1 : 0; 
        
        $dataArr['is_new'] = isset($dataArr['is_new']) ? 1 : 0;
        
        $dataArr['alias'] = Helper::stripUnicode($dataArr['name']);
        $dataArr['slug'] = str_replace(".", "-", $dataArr['slug']);
        $dataArr['slug'] = str_replace("(", "-", $dataArr['slug']);
        $dataArr['slug'] = str_replace(")", "", $dataArr['slug']);
        
        $dataArr['price'] = str_replace(',', '', $request->price);
        $dataArr['price_sale'] = str_replace(',', '', $request->price_sale);        
        $dataArr['so_luong_ton'] = str_replace(',', '', $request->so_luong_ton);

        $dataArr['status'] = 1;
        $dataArr['price_sell'] = $dataArr['is_sale'] == 1 ? $dataArr['price_sale'] : $dataArr['price'];
        $dataArr['created_user'] = Auth::user()->id;

        $dataArr['updated_user'] = Auth::user()->id;
        //luu display order
        if($dataArr['is_hot'] == 1){
            $dataArr['display_order'] = Helper::getNextOrder('product', 
                                            [                                            
                                            'loai_id' => $dataArr['loai_id'],
                                            'cate_id' => $dataArr['cate_id']
                                        ]);
        }
        $rs = Product::create($dataArr);

        $product_id = $rs->id;
        
        $this->storeColor( $product_id, $dataArr);
        $this->storeSize( $product_id, $dataArr);

       // $this->storeImage( $product_id, $dataArr);
        $this->storeMeta($product_id, 0, $dataArr);
        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('product.edit', $product_id);
    }

    public function storeMeta( $id, $meta_id, $dataArr ){
       
        $arrData = ['title' => $dataArr['meta_title'], 'description' => $dataArr['meta_description'], 'keywords'=> $dataArr['meta_keywords'], 'custom_text' => $dataArr['custom_text'], 'updated_user' => Auth::user()->id];
        if( $meta_id == 0){
            $arrData['created_user'] = Auth::user()->id;            
            $rs = MetaData::create( $arrData );
            $meta_id = $rs->id;

            $modelSp = Product::find( $id );
            $modelSp->meta_id = $meta_id;
            $modelSp->save();
        }else {
            $model = MetaData::find($meta_id);           
            $model->update( $arrData );
        }              
    }
    public function storeColor($id, $dataArr){
        
        ProductColor::where('product_id', $id)->delete();

        if( !empty($dataArr['color_id'])){
            foreach( $dataArr['color_id'] as $color_id){
                ProductColor::create(['product_id' => $id, 'color_id' => $color_id]);
            }
        }
    }
    public function storeSize($id, $dataArr){
        
        ProductSize::where('product_id', $id)->delete();

        if( !empty($dataArr['size_id'])){
            foreach( $dataArr['size_id'] as $size_id){
                ProductSize::create(['product_id' => $id, 'size_id' => $size_id]);
            }
        }
    }

    

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
    //
    }
   
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        $colorSelected = $sizeSelected = $colorArr = $sizeArr = [];
        $hinhArr = (object) [];
        $detail = Product::find($id);

        $hinhArr = ProductImg::where('product_id', $id)->lists('image_url', 'id');
        
        
        $loaiSpArr = LoaiSp::all();
        
        $loai_id = $detail->loai_id; 
            
        $cateArr = Cate::where('loai_id', $loai_id)->select('id', 'name')->orderBy('display_order', 'desc')->get();
        
        
        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }       
       
        $colorList = Color::orderBy('display_order')->get();      
        $sizeList = Size::orderBy('display_order')->get();    
        foreach($colorList as $color){
            $colorArr[$color->id] = $color;
        }
        foreach($sizeList as $size){
            $sizeArr[$size->id] = $size;
        }
        foreach($detail->colors as $color){
            $colorSelected[] = $color->color_id;
        } 
        foreach($detail->sizes as $size){
            $sizeSelected[] = $size->size_id;
        } 
            
        return view('backend.product.edit', compact( 'detail', 'hinhArr', 'colorList', 'sizeList' , 'loaiSpArr', 'cateArr', 'meta', 'colorSelected', 'sizeSelected', 'colorArr', 'sizeArr'));
    }
    public function copy($id)
    {
        $thuocTinhArr = [];
        $hinhArr = (object) [];
        $detail = Product::find($id);

        $hinhArr = ProductImg::where('product_id', $id)->lists('image_url', 'id');
        
        $tmp = SpThuocTinh::where('product_id', $id)->select('thuoc_tinh')->first();

        if( $tmp ){
            $spThuocTinhArr = json_decode( $tmp->thuoc_tinh, true);
        }        

        $loaiSpArr = LoaiSp::all();
        
        $loai_id = $detail->loai_id; 
            
        $cateArr = Cate::where('loai_id', $loai_id)->select('id', 'name')->orderBy('display_order', 'desc')->get();
        
        $loaiThuocTinhArr = LoaiThuocTinh::where('loai_id', $loai_id)->orderBy('display_order')->get();
        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }       
        if( $loaiThuocTinhArr->count() > 0){
            foreach ($loaiThuocTinhArr as $value) {

                $thuocTinhArr[$value->id]['id'] = $value->id;
                $thuocTinhArr[$value->id]['name'] = $value->name;

                $thuocTinhArr[$value->id]['child'] = ThuocTinh::where('loai_thuoc_tinh_id', $value->id)->select('id', 'name')->orderBy('display_order')->get()->toArray();
            }
            
        }        
        $colorArr = Color::all();          
            
        return view('backend.product.copy', compact( 'detail', 'hinhArr', 'thuocTinhArr', 'spThuocTinhArr', 'colorArr', 'loaiSpArr', 'cateArr', 'meta'));
    }
    public function ajaxDetail(Request $request)
    {       
        $id = $request->id;
        $detail = Product::find($id);
        return view('backend.product.ajax-detail', compact( 'detail' ));
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request)
    {
        $dataArr = $request->all();
        dd($dataArr);
        $this->validate($request,[
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required'         
        ],
        [
            'name.required' => 'Bạn chưa nhập tên sản phẩm',
            'slug.required' => 'Bạn chưa nhập slug',            
            'price.required' => 'Bạn chưa nhập giá'            
        ]);

        
        $dataArr['is_hot'] = isset($dataArr['is_hot']) ? 1 : 0;
        $dataArr['is_sale'] = isset($dataArr['is_sale']) ? 1 : 0;          
        $dataArr['is_new'] = isset($dataArr['is_new']) ? 1 : 0;

        $dataArr['slug'] = str_replace(".", "-", $dataArr['slug']);
        $dataArr['slug'] = str_replace("(", "-", $dataArr['slug']);
        $dataArr['slug'] = str_replace(")", "", $dataArr['slug']);
        $dataArr['alias'] = Helper::stripUnicode($dataArr['name']);

        $dataArr['price'] = str_replace(',', '', $request->price);
        $dataArr['price_sale'] = str_replace(',', '', $request->price_sale);        
        $dataArr['so_luong_ton'] = str_replace(',', '', $request->so_luong_ton);

        $dataArr['updated_user'] = Auth::user()->id;    

        $dataArr['price_sell'] = $dataArr['is_sale'] == 1 ? $dataArr['price_sale'] : $dataArr['price'];
            
        $model = Product::find($dataArr['id']);

        $model->update($dataArr);
        
        $product_id = $dataArr['id'];
       
        $this->storeThuocTinh( $product_id, $dataArr);

        $this->storeMeta( $product_id, $dataArr['meta_id'], $dataArr);
        $this->storeImage( $product_id, $dataArr);

        /*
          "color_id_url" => array:4 [▼
            0 => "tmp/1339337386492583760-574-574-1504688912.jpg"
            1 => "tmp/girl-xinh-facebook-tu-suong-1504688915.jpg"
            2 => "tmp/anh-teen-girl-9x-nung-niu-ben-chiec-dien-thoai-iphone-c77694-1504688918.jpg"
            3 => "tmp/bi-quyet-lam-dep-da-cua-co-nang-teen-d80a9f-1504688920.jpg"
          ]
          "color_id_name" => array:4 [▼
            0 => "1339337386492583760-574-574-1504688912.jpg"
            1 => "girl-xinh-facebook-tu-suong-1504688915.jpg"
            2 => "anh-teen-girl-9x-nung-niu-ben-chiec-dien-thoai-iphone-c77694-1504688918.jpg"
            3 => "bi-quyet-lam-dep-da-cua-co-nang-teen-d80a9f-1504688920.jpg"
          ]
          "color_id_ivt" => array:4 [▼
            0 => "1"
            1 => "2"
            2 => "3"
            3 => "4"
          ]
          "amount" => array:4 [▼
            1 => array:4 [▼
              1 => ""
              2 => ""
              7 => ""
              8 => ""
            ]
            2 => array:4 [▼
              1 => ""
              2 => ""
              7 => ""
              8 => ""
            ]
            3 => array:4 [▼
              1 => ""
              2 => ""
              7 => ""
              8 => ""
            ]
            4 => array:4 [▼
              1 => ""
              2 => ""
              7 => ""
              8 => ""
            ]
          ]
          "thumbnail_id" => "2"
        */
        Session::flash('message', 'Chỉnh sửa thành công');

        return redirect()->route('product.edit', $product_id);
        
    }
    public function storeImage($id, $dataArr){        
        //process old image
        $imageIdArr = isset($dataArr['image_id']) ? $dataArr['image_id'] : [];
        $hinhXoaArr = ProductImg::where('product_id', $id)->whereNotIn('id', $imageIdArr)->lists('id');
        if( $hinhXoaArr )
        {
            foreach ($hinhXoaArr as $image_id_xoa) {
                $model = ProductImg::find($image_id_xoa);
                $urlXoa = config('namphuc.upload_path')."/".$model->image_url;
                if(is_file($urlXoa)){
                    unlink($urlXoa);
                }
                $model->delete();
            }
        }       

        //process new image
        if( isset( $dataArr['thumbnail_id'])){
            $thumbnail_id = $dataArr['thumbnail_id'];

            $imageArr = []; 

            if( !empty( $dataArr['image_tmp_url'] )){

                foreach ($dataArr['image_tmp_url'] as $k => $image_url) {

                    if( $image_url && $dataArr['image_tmp_name'][$k] ){

                        $tmp = explode('/', $image_url);

                        if(!is_dir('public/uploads/'.date('Y/m/d'))){
                            mkdir('public/uploads/'.date('Y/m/d'), 0777, true);
                        }
                        if(!is_dir('uploads/thumbs/'.date('Y/m/d'))){
                            mkdir('uploads/thumbs/'.date('Y/m/d'), 0777, true);
                        }

                        $destionation = date('Y/m/d'). '/'. end($tmp);
                        
                        File::move(config('namphuc.upload_path').$image_url, config('namphuc.upload_path').$destionation);

                        $imageArr['is_thumbnail'][] = $is_thumbnail = $dataArr['thumbnail_id'] == $image_url  ? 1 : 0;

                        //if($is_thumbnail == 1){
                            $img = Image::make(config('namphuc.upload_path').$destionation);
                            $w_img = $img->width();
                            $h_img = $img->height();                            
                           // var_dump($w_img, $h_img);
                            if($h_img >= $w_img){
                                //die('height > hon');
                                Image::make(config('namphuc.upload_path').$destionation)->resize(210, null, function ($constraint) {
                                        $constraint->aspectRatio();
                                })->crop(210, 210)->save(config('namphuc.upload_thumbs_path').$destionation);
                            }else{                             
                                Image::make(config('namphuc.upload_path').$destionation)->resize(null, 210, function ($constraint) {
                                        $constraint->aspectRatio();
                                })->crop(210, 210)->save(config('namphuc.upload_thumbs_path').$destionation);
                            }

                        //}

                        $imageArr['name'][] = $destionation;
                        
                    }
                }
            }
            if( !empty($imageArr['name']) ){
                foreach ($imageArr['name'] as $key => $name) {
                    $rs = ProductImg::create(['product_id' => $id, 'image_url' => $name, 'display_order' => 1]);                
                    $image_id = $rs->id;
                    if( $imageArr['is_thumbnail'][$key] == 1){
                        $thumbnail_id = $image_id;
                    }
                }
            }
            $model = Product::find( $id );
            $model->thumbnail_id = $thumbnail_id;
            $model->save();
        }
    }
    public function ajaxSaveInfo(Request $request){
        
        $dataArr = $request->all();

        $dataArr['alias'] = Helper::stripUnicode($dataArr['name']);
        
        $dataArr['updated_user'] = Auth::user()->id;
        
        $model = Product::find($dataArr['id']);

        $model->update($dataArr);
        
        $product_id = $dataArr['id'];        

        Session::flash('message', 'Chỉnh sửa thành công');

    }
   
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        // delete
        $model = Product::find($id);        
        $model->delete();
        ProductImg::where('product_id', $id)->delete(); 
        ProductColor::where('product_id', $id)->delete(); 
        ProductSize::where('product_id', $id)->delete(); 
        ProductInventory::where('product_id', $id)->delete(); 
        // redirect
        Session::flash('message', 'Xóa thành công');
        
        return redirect(URL::previous());//->route('product.short');
        
    }
}
