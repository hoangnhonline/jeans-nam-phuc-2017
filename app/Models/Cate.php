<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Cate extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cate';  

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
    protected $fillable = [ 'name', 'alias', 'slug', 'description', 'image_url', 'parent_id', 'display_order', 'meta_id', 'is_hot', 'status', 'created_user', 'updated_user'];
    public function product()
    {
        return $this->hasMany('App\Models\Product', 'cate_id');
    }
    public function cateParent()
    {
        return $this->belongsTo('App\Models\CateParent', 'parent_id');
    }
}
