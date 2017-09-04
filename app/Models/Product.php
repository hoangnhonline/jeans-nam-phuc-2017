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
                    'is_old',
                    'price',
                    'price_new',
                    'price_sale',
                    'loai_id', 
                    'cate_id', 
                    'mo_ta',                    
                    'xuat_xu', 
                    'khuyen_mai', 
                    'chi_tiet', 
                    'bao_hanh', 
                    'so_luong_ton', 
                    'sale_percent', 
                    'so_luong_ban', 
                    'views', 
                    'so_lan_mua',                     
                    'display_order',                     
                    'color_id',
                    'status', 
                    'created_user', 
                    'updated_user', 
                    'meta_id',
                    'price_sell'                    
                    ];
    
    public function prices()
    {
        return $this->hasMany('App\Models\ProductPrice', 'product_id');
    }
    public function loaiSp(){
        return $this->belongsTo('App\Models\LoaiSp', 'loai_id');
    }
    public function thuocTinh(){
        return $this->hasOne('App\Models\SpThuocTinh', 'product_id');
    }
}