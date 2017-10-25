<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\CateParent;
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
use App\Models\Tag;
use App\Models\TagObjects;
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
        $arrSearch['parent_id'] = $parent_id = isset($request->parent_id) ? $request->parent_id : null;
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
        if( $parent_id ){
            $query->where('product.parent_id', $parent_id);
        }
        if( $cate_id ){
            $query->where('product.cate_id', $cate_id);
        }        
  
        if( $name != ''){
            $query->where('product.name', 'LIKE', '%'.$name.'%');          
        }
        $query->join('users', 'users.id', '=', 'product.created_user');
        $query->join('cate_parent', 'cate_parent.id', '=', 'product.parent_id');
        $query->join('cate', 'cate.id', '=', 'product.cate_id');
        $query->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id');        
        if($is_hot){
            $query->orderBy('product.display_order', 'asc');
        }else{
            $query->orderBy('product.id', 'desc');    
        }
        
        $items = $query->select(['product_img.image_url','product.*','product.id as product_id', 'full_name' , 'product.created_at as time_created', 'users.full_name', 'cate_parent.name as ten_loai', 'cate.name as ten_cate'])
        ->paginate(50);   

        $loaiSpArr = CateParent::all();  
        if( $parent_id ){
            $cateArr = Cate::where('parent_id', $parent_id)->orderBy('display_order', 'desc')->get();
        }else{
            $cateArr = (object) [];
        }
        $colorList = Color::orderBy('display_order')->get();              
        foreach($colorList as $color){
            $colorArr[$color->id] = $color;
        }
        return view('backend.product.index', compact( 'items', 'arrSearch', 'loaiSpArr', 'cateArr', 'colorArr'));
    }   
    public function imageOfColor(Request $request){
        $color_id = $request->color_id;
        $product_id = $request->product_id;
        $detail = Product::find($product_id);
        $detailColor = Color::find($color_id);

        $hinhArr = ProductImg::where('product_id', $product_id)->where('color_id', $color_id)->get(); 

         return view('backend.product.image', compact( 'detail', 'detailColor', 'hinhArr'));
    }  
    public function ajaxSearch(Request $request){    
        $search_type = $request->search_type;
        $arrSearch['parent_id'] = $parent_id = isset($request->parent_id) ? $request->parent_id : -1;
        $arrSearch['cate_id'] = $cate_id = isset($request->cate_id) ? $request->cate_id : -1;
        $arrSearch['name'] = $name = isset($request->name) && trim($request->name) != '' ? trim($request->name) : '';
        
        $query = Product::whereRaw('1');
        
        if( $parent_id ){
            $query->where('product.parent_id', $parent_id);
        }
        if( $cate_id ){
            $query->where('product.cate_id', $cate_id);
        }
        if( $name != ''){
            $query->where('product.name', 'LIKE', '%'.$name.'%');
            $query->orWhere('name_extend', 'LIKE', '%'.$name.'%');
        }
        $query->join('users', 'users.id', '=', 'product.created_user');
        $query->join('cate_parent', 'cate_parent.id', '=', 'product.parent_id');
        $query->join('cate', 'cate.id', '=', 'product.cate_id');
        $query->leftJoin('product_img', 'product_img.id', '=','product.thumbnail_id');        
        $query->orderBy('product.id', 'desc');
        $items = $query->select(['product_img.image_url','product.*','product.id as product_id', 'full_name' , 'product.created_at as time_created', 'users.full_name', 'cate_parent.name as ten_loai', 'cate.name as ten_cate'])
        ->paginate(1000);

        $loaiSpArr = CateParent::all();  
        if( $parent_id ){
            $cateArr = Cate::where('parent_id', $parent_id)->orderBy('display_order', 'desc')->get();
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
        $tagList = Tag::where('type', 1)->get();        
        $parent_id = $request->parent_id ? $request->parent_id : null;
        $cate_id = $request->cate_id ? $request->cate_id : null;
        $cateList = (object) [];     
        $loaiSpArr = CateParent::all();      
        if($parent_id > 0){
            $cateList = Cate::where('parent_id', $parent_id)->get();
        }
        $colorList = Color::orderBy('display_order')->get();      
        $sizeList = Size::orderBy('display_order')->get();        
        return view('backend.product.create', compact('loaiSpArr', 'cateList', 'parent_id', 'colorList', 'cate_id', 'sizeList', 'tagList'));
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
                                            'parent_id' => $dataArr['parent_id'],
                                            'cate_id' => $dataArr['cate_id']
                                        ]);
        }
        $rs = Product::create($dataArr);

        $product_id = $rs->id;

        // xu ly tags
        if( !empty( $dataArr['tags'] ) && $product_id ){
            foreach ($dataArr['tags'] as $tag_id) {
                TagObjects::create(['object_id' => $product_id, 'tag_id' => $tag_id, 'type' => 1]);
            }
        }  

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
       
        $listColor  =ProductColor::where('product_id', $id)->get();
        if($listColor->count() > 0){
            foreach($listColor as $color){
                $currArr[] = $color->color_id;                
            }
        }
        if( !empty($dataArr['color_id'])){ 
	    if(isset($currArr)){
            $oldDiffArr = array_diff($currArr, $dataArr['color_id']);
            if(!empty($oldDiffArr)){
                foreach($oldDiffArr as $color_id){
                    ProductInventory::where(['product_id' => $id, 'color_id' => $color_id])->delete();
                    ProductColor::where(['product_id' => $id, 'color_id' => $color_id])->delete();                   
                }
            }  
            $newDiffArr = array_diff($dataArr['color_id'], $currArr);
            if ($newDiffArr){
                foreach( $newDiffArr as $color_id){
                    ProductColor::create(['product_id' => $id, 'color_id' => $color_id]);
                }
            }                  
            }else{
               foreach($dataArr['color_id'] as $color_id){
			ProductColor::create(['product_id' => $id, 'color_id' => $color_id]);
               }	 
            }		     
        }
    }
    public function storeSize($id, $dataArr){
        
        $listSize  =ProductSize::where('product_id', $id)->get();
        if($listSize->count() > 0){
            foreach($listSize as $size){
                $currArr[] = $size->size_id;                
            }
        }
        if( !empty($dataArr['size_id'])){
	    if(isset($currArr)){
            $oldDiffArr = array_diff($currArr, $dataArr['size_id']);
            if(!empty($oldDiffArr)){
                foreach($oldDiffArr as $size_id){
                    ProductInventory::where(['product_id' => $id, 'size_id' => $size_id])->delete();
                    ProductSize::where(['product_id' => $id, 'size_id' => $size_id])->delete();
                }
            }  
            $newDiffArr = array_diff($dataArr['size_id'], $currArr);
            if ($newDiffArr){
                foreach( $newDiffArr as $size_id){
                    ProductSize::create(['product_id' => $id, 'size_id' => $size_id]);
                }
            }}else{
		foreach($dataArr['size_id'] as $size_id){
			ProductSize::create(['product_id' => $id, 'size_id' => $size_id]);
		}
            }
        }
    }

    public function storeImage(Request $request){
        $dataArr = $request->all();
       
        //process new image
        if( isset( $dataArr['thumbnail_id'])){
            if( (int) $dataArr['thumbnail_id'] > 0){
                ProductImg::where(['color_id' => $dataArr['color_id'], 'product_id' => $dataArr['product_id']])->update(['is_thumbnail' => 0]);
                ProductImg::find($dataArr['thumbnail_id'])->update(['is_thumbnail' => 1]);                
            }
            $thumbnail_id = $dataArr['thumbnail_id'];

            $imageArr = []; 
            $dataInsert['product_id'] = $dataArr['product_id'];
            $dataInsert['color_id'] = $dataArr['color_id']; 
           // ProductImg::where('product_id', $dataArr['product_id'])->where('color_id', $dataArr['color_id'])->delete();
            
            if( !empty( $dataArr['image_tmp_url'] )){
                $countImg = 0;
                foreach ($dataArr['image_tmp_url'] as $k => $image_url) {
                    $countImg++;
                    $origin_img = base_path().$image_url;
                    
                    if( $image_url ){

                        $is_thumbnail = $dataArr['thumbnail_id'] == $image_url  ? 1 : 0;

                        $img = Image::make($origin_img);
                        $w_img = $img->width();
                        $h_img = $img->height();
                        $tile1 = 1;        
                                         
                        $new_img = str_replace('/uploads/images/', '/uploads/images/thumbs/', $origin_img);
                       
                        if($w_img/$h_img <= $tile1){

                            Image::make($origin_img)->resize(210, null, function ($constraint) {
                                    $constraint->aspectRatio();
                            })->crop(210, 210)->save($new_img, 100);
                        }else{
                            Image::make($origin_img)->resize(null, 210, function ($constraint) {
                                    $constraint->aspectRatio();
                            })->crop(210, 210)->save($new_img, 100);
                        }                                        

                     
                        $dataInsert['display_order'] = $countImg;
                        $dataInsert['is_thumbnail'] = $is_thumbnail;
                        $dataInsert['image_url'] = $image_url;
                        $rs = ProductImg::create($dataInsert);
                        if($is_thumbnail == 1){
                            $thumbnail_id = $rs->id;
                        }
                    }

                }
            }
            
            $detailProduct = Product::find($dataArr['product_id']);
            if($detailProduct->color_id_main == $dataArr['color_id']){
                $model = Product::find( $dataArr['product_id'] );
                $model->thumbnail_id = $thumbnail_id;
                $model->save();
            }
        }
        Session::flash('message', 'Cập nhật thành công');
        return redirect()->route('product.image', [$dataArr['product_id'], $dataArr['color_id']]);
    }
    public function deleteImg(Request $request){
        $id = $request->id;
        ProductImg::find($id)->delete();
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
        $tagList = Tag::where('type', 1)->get();
        $colorSelected = $sizeSelected = $colorArr = $sizeArr = [];
        $hinhArr = (object) [];
        $detail = Product::find($id);

        $hinhArr = ProductImg::where('product_id', $id)->lists('image_url', 'id');
        
        
        $loaiSpArr = CateParent::all();
        
        $parent_id = $detail->parent_id; 
            
        $cateArr = Cate::where('parent_id', $parent_id)->select('id', 'name')->orderBy('display_order', 'desc')->get();
        
        
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
        $arrInv = [];
        //get inventory
        $rsInv = ProductInventory::where('product_id', $id)->orderBy('color_id')->orderBy('size_id')->get();
        foreach($rsInv as $inv){
            $arrInv[$inv->color_id][$inv->size_id] = $inv->amount;
        }    
        $tagSelected = Product::productTag($id);  
        return view('backend.product.edit', compact( 'detail', 'hinhArr', 'colorList', 'sizeList' , 'loaiSpArr', 'cateArr', 'meta', 'colorSelected', 'sizeSelected', 'colorArr', 'sizeArr', 'arrInv', 'tagSelected', 'tagList'));
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

        $loaiSpArr = CateParent::all();
        
        $parent_id = $detail->parent_id; 
            
        $cateArr = Cate::where('parent_id', $parent_id)->select('id', 'name')->orderBy('display_order', 'desc')->get();
        
        $loaiThuocTinhArr = LoaiThuocTinh::where('parent_id', $parent_id)->orderBy('display_order')->get();
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
        $dataArr['updated_user'] = Auth::user()->id;    

        $dataArr['price_sell'] = $dataArr['is_sale'] == 1 ? $dataArr['price_sale'] : $dataArr['price'];
            
        $model = Product::find($dataArr['id']);

        $model->update($dataArr);
        
        $product_id = $dataArr['id'];      


        TagObjects::deleteTags( $dataArr['id'], 1);
        
        // xu ly tags
        if( !empty( $dataArr['tags'] ) && $dataArr['id'] ){
            foreach ($dataArr['tags'] as $tag_id) {
                TagObjects::create(['object_id' => $dataArr['id'], 'tag_id' => $tag_id, 'type' => 1]);
            }
        }    
        $this->storeInventory( $product_id, $dataArr);
        $this->storeColor( $product_id, $dataArr);
        $this->storeSize( $product_id, $dataArr);
      
        Session::flash('message', 'Chỉnh sửa thành công');

        return redirect()->route('product.edit', $product_id);
        
    }
    public function storeInventory($product_id, $dataArr){
        ProductInventory::where('product_id', $product_id)->delete();
        foreach($dataArr['amount'] as $color_id => $arrSizeInventory){
            foreach($arrSizeInventory as $size_id => $amount){
                $amount = (int) str_replace(",", "", $amount);
                ProductInventory::create(['product_id' => $product_id, 'size_id' => $size_id, 'color_id' => $color_id, 'amount' => $amount]);
            }
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

