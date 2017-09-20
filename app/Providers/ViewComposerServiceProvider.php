<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\CateParent;
use App\Models\Cate;
use App\Models\Settings;
use App\Models\Color;
use App\Models\Text;
use Auth;
use Request;
//use App\Models\Entity\SuperStar\Account\Traits\Behavior\SS_Shortcut_Icon;

class ViewComposerServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//Call function composerSidebar
		$this->composerMenu();	
		
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Composer the sidebar
	 */
	private function composerMenu()
	{
		$cateArrByLoai = [];		
		view()->composer( '*' , function( $view ){
			
			$loaiSpList = CateParent::where(['status' => 1])->orderBy('display_order')->get();

	        if( $loaiSpList ){
	            foreach ( $loaiSpList as $key => $value) {	            	          		
	            	$cateArrByLoai[$value->id] = Cate::where(['status' => 1, 'parent_id' => $value->id])
	                    ->orderBy('display_order')
	                    ->select('name', 'slug', 'id')
	                    ->get();
	            }
	        }    
	        $settingArr = Settings::whereRaw('1')->lists('value', 'name');
	        $textList = Text::whereRaw('1')->lists('content', 'id');
	        $routeName = \Request::route()->getName();
	       // var_dump("<pre>", $menuDoc);die;   
	        //var_dump("<pre>", $loaiSpKey);die;
	        $colorList = Color::orderBy('display_order')->get();
	        
	        $isEdit = Auth::check();	        

			$view->with( [
					'loaiSpList' => $loaiSpList, 
					'settingArr' => $settingArr,
					'cateArrByLoai' => $cateArrByLoai,
					'routeName' => $routeName,
					'colorList' => $colorList,
					'textList' => $textList,
					'isEdit' => $isEdit
					] );
		});
	}
	
}
