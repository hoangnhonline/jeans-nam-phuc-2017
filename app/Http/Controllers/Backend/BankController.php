<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Bank;

use Helper, File, Session, Auth;

class BankController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index(Request $request)
    {
        $items = Bank::where('status', 1)->orderBy('display_order', 'asc')->get();
        return view('backend.bank.index', compact( 'items' ));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('backend.bank.create');
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
        ],
        [
            'name.required' => 'Bạn chưa nhập tên',                    
        ]);
        
        $dataArr['display_order'] = Helper::getNextOrder('bank');
        $rs = Bank::create($dataArr);

        Session::flash('message', 'Tạo mới thành công');

        return redirect()->route('bank.index');
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
        $detail = Bank::find($id);

        $meta = (object) [];
        if ( $detail->meta_id > 0){
            $meta = MetaData::find( $detail->meta_id );
        }

        return view('backend.bank.edit', compact( 'detail', 'meta'));
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
        ],
        [
            'name.required' => 'Bạn chưa nhập tên',                   
        ]);
       
        $model = Bank::find($dataArr['id']);
        $model->update($dataArr);

        Session::flash('message', 'Cập nhật thành công');

        return redirect()->route('bank.edit', $dataArr['id']);
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
        $model = Bank::find($id);
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('bank.index');
    }

    public function destroyThuocTinh($id)
    {
        // delete
        $model = HoverInfo::find($id);
        $parent_id = $model->parent_id;
        $model->delete();

        // redirect
        Session::flash('message', 'Xóa thành công');
        return redirect()->route('bank.list-thuoc-tinh', ['parent_id' => $parent_id]);
    }
}
