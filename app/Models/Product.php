<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Product extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'product';

	 /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                    'ma_sp', 
                    'name', 
                    'alias',                     
                    'slug',                     
                    'thumbnail_id', 
                    'is_hot', 
                    'is_sale', 
                    'is_new',                    
                    'price',                    
                    'price_sale',
                    'loai_id', 
                    'cate_id', 
                    'mo_ta',                    
                    'xuat_xu',                     
                    'chi_tiet',                                          
                    'sale_percent', 
                    'so_luong_ban', 
                    'views', 
                    'so_lan_mua',                     
                    'display_order',                                         
                    'status', 
                    'created_user', 
                    'updated_user', 
                    'meta_id',
                    'price_sell'                    
                    ];
    
    public function sizes()
    {
        return $this->hasMany('App\Models\ProductSize', 'product_id');
    }
    public function colors()
    {
        return $this->hasMany('App\Models\ProductColor', 'product_id');
    }
    public function cate(){
        return $this->belongsTo('App\Models\Cate', 'cate_id');
    }
    public function loaiSp(){
        return $this->belongsTo('App\Models\LoaiSp', 'loai_id');
    }
}