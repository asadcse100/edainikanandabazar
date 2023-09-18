<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DatabaseTransactions;
use Schema;

class PageController extends Controller
{

    /**
     * Show the application manage-pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$data['category_list']=\DB::table('categories')->where('status',1)->get();
    	$data['edition_list']=\DB::table('editions')->where('status',1)->get();


    	if (isset($_GET['date']) && (!empty($_GET['date']))) {
    		$publish_date=date('Y-m-d',strtotime($_GET['date']));

    		$pages_table = 'pages_'.date('Y_m', strtotime($publish_date));

    		if(Schema::hasTable($pages_table)){

    			$data['page_list']=\DB::table($pages_table)
            // ->where($pages_table.'.status',1)
    			->where($pages_table.'.publish_date',$publish_date)
    			->leftjoin('categories','categories.id','=', $pages_table.'.category_id')
    			->select($pages_table.'.*','categories.name as category_name')
    			->orderBy('page_number', 'asc')
    			->get();
    		}
    	}
    	return \View::make('admin.manage-pages.index',$data);
    }


    /**
     * Show the application upload page.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$now = date('Y-m-d H:i:s');

    	$rules=array(
    		'publish_date' => 'Required',
    		'page_image' => 'Required|image|max:30000',
    		'edition' => 'Required',
    		'page_number' => 'Required',
    		);
    	$v = \Validator::make(\Request::all(), $rules);

    	if($v->passes()){

    		\DB::beginTransaction();
    		try{

    			$date=\Request::input('publish_date');
    			$date=date('Y-m-d', strtotime($date));
    			$page_number=\Request::input('page_number');
    			$image = \Request::file('page_image');
    			$image_name = $image->getClientOriginalName();
    			$image_name= 'page'.uniqid().'.'.$image->getClientOriginalExtension();

    			$directory_original_pages='uploads/temp/'.date('Y',strtotime($date)).'/'.date('m',strtotime($date)).'/'.date('d',strtotime($date)).'/original-pages';
    			$directory_pages='uploads/epaper/'.date('Y',strtotime($date)).'/'.date('m',strtotime($date)).'/'.date('d',strtotime($date)).'/pages';
    			$directory_images='uploads/epaper/'.date('Y',strtotime($date)).'/'.date('m',strtotime($date)).'/'.date('d',strtotime($date)).'/images';
    			$directory_thumb='uploads/epaper/'.date('Y',strtotime($date)).'/'.date('m',strtotime($date)).'/'.date('d',strtotime($date)).'/thumb';

    			if (!file_exists($directory_original_pages)) {
    				mkdir($directory_original_pages, 0777, true);
    			}
    			if (!file_exists($directory_pages)) {
    				mkdir($directory_pages, 0777, true);
    			}
    			if (!file_exists($directory_images)) {
    				mkdir($directory_images, 0777, true);
    			}
    			if (!file_exists($directory_thumb)) {
    				mkdir($directory_thumb, 0777, true);
    			}

    			\Image::make($image)->save($directory_original_pages.'/'.$image_name);
    			\Image::make($image)->resize(700, 910)->save($directory_pages.'/'.$image_name);
    			\Image::make($image)->resize(148, 222)->save($directory_thumb.'/'.$image_name);

    			$publish_date=date('Y-m-d',strtotime($date));
    			$page_data=array(
    				'publish_date' => $publish_date,
    				'image' => $image_name,
    				'page_number' => $page_number,
    				'category_id' => \Request::input('category'),
    				'status' => 0,
    				'created_by' => \Auth::user()->id,
    				'created_at' => $now,
    				);


                ## get pages table ##
    			$pages_tables = \App\Models\Epaper::GetTables('pages');
    			$count_pages_table = count($pages_tables);
    			$last_pages_table=$pages_tables[$count_pages_table-1];

                ## get edition_pages table ##
    			$edition_pages_tables = \App\Models\Epaper::GetTables('edition_pages');
    			$count_edition_pages_table = count($edition_pages_tables);
    			$last_edition_pages_table=$edition_pages_tables[$count_edition_pages_table-1];

                ## get images table ##
    			$images_tables = \App\Models\Epaper::GetTables('images');
    			$count_images_table = count($images_tables);
    			$last_images_table=$images_tables[$count_images_table-1];


                ## get required tables ##
    			$pages_table = 'pages_'.date('Y_m',strtotime($publish_date));
    			$edition_pages_table='edition_pages_'.date('Y_m',strtotime($publish_date));
    			$images_table='images_'.date('Y_m',strtotime($publish_date));

    			if(!Schema::hasTable($pages_table)){
    				\DB::statement('CREATE TABLE '.$pages_table.' LIKE '.$last_pages_table);
    			}
    			if(!Schema::hasTable($edition_pages_table)){
    				\DB::statement('CREATE TABLE '.$edition_pages_table.' LIKE '.$last_edition_pages_table);
    			}
    			if(!Schema::hasTable($images_table)){
    				\DB::statement('CREATE TABLE '.$images_table.' LIKE '.$last_images_table);
    			}


    			$page_save_id = \DB::table($pages_table)->insertGetId($page_data);

    			$edition=\Request::input('edition');
    			$edition_value=explode(',', $edition);
    			foreach ($edition_value as $key => $value) {
    				$edition_pages_data=array(
    					'edition_id' => $edition_value[$key],
    					'page_id' => $page_save_id,
    					);

    				$check_existing_edition=\DB::table($pages_table)->where('page_number', $page_number)->where($pages_table.'.publish_date', $publish_date)
    				->leftjoin($edition_pages_table, $edition_pages_table.'.page_id','=', $pages_table.'.id')
    				->where($edition_pages_table.'.edition_id', $edition_value[$key])->select($pages_table.'.*', $edition_pages_table.'.*', $edition_pages_table.'.id as update_edition_id')->first();

    				if(!empty($check_existing_edition)){
    					$edition_pages_update = \DB::table($edition_pages_table)->where('id', $check_existing_edition->update_edition_id)->update($edition_pages_data);
    				}else{
    					$edition_pages_save = \DB::table($edition_pages_table)->insert($edition_pages_data);
    				}
    			}

    		}catch(\Exception $e){
    			\DB::rollback();

    			if (file_exists($directory_pages.'/'.$image_name)) {
    				unlink($directory_pages.'/'.$image_name);
    			}

    			if (file_exists($directory_thumb.'/'.$image_name)) {
    				unlink($directory_thumb.'/'.$image_name);
    			}

    			return \Redirect::back()->with('errormessage',"Problem uploading new page.please try again");
    		}
    		\DB::commit();

    		return \Redirect::back()->with('message',"New page has been uploaded successfully !");

    	}else return \Redirect::back()->withInput()->withErrors($v->messages());
    }



    /**
     * Show the application ajaxEditPage.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxEditPage($publish_date, $page_id)
    {
		
    	$data['category_list']=\DB::table('categories')->where('status',1)->get();
    	$data['edition_list']=\DB::table('editions')->where('status',1)->get();


    	$pages_table = 'pages_'.date('Y_m', strtotime($publish_date));

    	$page_info=\DB::table($pages_table)
    	->where($pages_table.'.id', $page_id)
        // ->where($pages_table.'.status',1)
    	->where($pages_table.'.publish_date',$publish_date)
    	->leftjoin('categories','categories.id','=', $pages_table.'.category_id')
    	->select($pages_table.'.*','categories.*', $pages_table.'.id as page_id')
    	->first();

    	$data['page_info']=$page_info;
    	return \View::make('admin.manage-pages.ajax-page-update',$data);
    }


    /**
     * Show the application update Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePage($page_id)
    {

    	$now = date('Y-m-d H:i:s');

    	$rules=array(
    		// 'edition' => 'Required',
    		'page_number' => 'Required',
    		);
    	$v = \Validator::make(\Request::all(), $rules);

    	if($v->passes()){

    		\DB::beginTransaction();
    		try{

    			$page_number=\Request::input('page_number');
    			$publish_date=\Request::input('publish_date');

                ## DB Table Selection ##
    			$pages_table='pages_'.date('Y_m', strtotime($publish_date));
    			$edition_pages_table='edition_pages_'.date('Y_m', strtotime($publish_date));
                ## end DB Table Selection ##


                ## page data update ##
    			$page_data=array(
    				'page_number' => $page_number,
    				'category_id' => \Request::input('category'),
    				'updated_by' => \Auth::user()->id,
    				'updated_at' => $now,
    				);

    			$page_update = \DB::table($pages_table)->where('id', $page_id)->update($page_data);
                ## end page data update ##


    			$editions=\Request::input('edition');
    			if($editions != Null){
    				      ## editions data update ##
    				$edition_pages_remove = \DB::table($edition_pages_table)->where('page_id', $page_id)->delete();

    			// $editions=\Request::input('edition');
    				$editions=\Request::input('edition');
    				$edition_value=explode(',', $editions);

    				foreach ($edition_value as $key => $edition) {
    					$edition_pages_data=array(
    						'edition_id' => $edition_value[$key],
    						'page_id' => $page_id,
    						);
    					$edition_pages_update = \DB::table($edition_pages_table)->insert($edition_pages_data);
    				}
                ## end editions data update ##
    			}
    			

    		}catch(\Exception $e){
    			\DB::rollback();

    			return \Redirect::back()->with('errormessage',"Problem updating page.please try again");
    		}
    		\DB::commit();

    		return \Redirect::back()->with('message',"Page info has been updated successfully !");

    	}else return \Redirect::back()->withInput()->withErrors($v->messages());
    }



    /**
     * Show the application delete Page.
     *
     * @return \Illuminate\Http\Response
     */
    public function deletePage($id,$image_name,$publish_date)
    {

        ## get db table ##
    	$pages_table = 'pages_'.date('Y_m', strtotime($publish_date));
    	$images_table = 'images_'.date('Y_m', strtotime($publish_date));
    	$edition_pages_table = 'edition_pages_'.date('Y_m', strtotime($publish_date));


    	\DB::beginTransaction();
    	try{

    		$page_delete = \DB::table($pages_table)->where('id',$id)->delete();

    		$edition_delete=\DB::table($edition_pages_table)->where('page_id',$id)->delete();

    		unlink('uploads/epaper/'.date('Y',strtotime($publish_date)).'/'.date('m',strtotime($publish_date)).'/'.date('d',strtotime($publish_date)).'/pages/'.$image_name);
    		unlink('uploads/epaper/'.date('Y',strtotime($publish_date)).'/'.date('m',strtotime($publish_date)).'/'.date('d',strtotime($publish_date)).'/thumb/'.$image_name);

    		$images=\DB::table($images_table)->where('page_id',$id)->get();

    		foreach ($images as $key => $images_delete) {
    			unlink('uploads/epaper/'.date('Y',strtotime($publish_date)).'/'.date('m',strtotime($publish_date)).'/'.date('d',strtotime($publish_date)).'/images/'.$images_delete->image);
    		}
    		$image_delete=\DB::table($images_table)->where('page_id',$id)->delete();

    	}catch(\Exception $e){
    		\DB::rollback();
    		return \Redirect::back()->with('errormessage',"Problem deleting page.please try again");
    	}
    	\DB::commit();
    	return \Redirect::back()->with('message',"Page has been deleted successfully !");


    }



   /**
     * Show the application manage-pages.
     *
     * @return \Illuminate\Http\Response
     */
   public function publishPages()
   {
   	$data['category_list']=\DB::table('categories')->where('status',1)->get();
   	$data['edition_list']=\DB::table('editions')->where('status',1)->get();


   	if (isset($_GET['date']) && (!empty($_GET['date']))) {
   		$publish_date=date('Y-m-d',strtotime($_GET['date']));

   		$pages_table = 'pages_'.date('Y_m', strtotime($publish_date));

   		if(!Schema::hasTable($pages_table)){
   			return view('errors.404');
   		}

   		$data['page_list']=\DB::table($pages_table)
   		->where($pages_table.'.status',0)
   		->where($pages_table.'.publish_date',$publish_date)
   		->leftjoin('categories','categories.id','=', $pages_table.'.category_id')
   		->select($pages_table.'.*','categories.name as category_name')
   		->orderBy('page_number', 'asc')
   		->get();
   	}
   	return \View::make('admin.manage-pages.publish',$data);
   }


    /**
     * Show the application manage-pages.
     *
     * @return \Illuminate\Http\Response
     */
    public function publishDate($date)
    {

    	if (!empty($date)) {
    		$publish_date=date('Y-m-d',strtotime($date));

    		$pages_table = 'pages_'.date('Y_m', strtotime($publish_date));

    		if(!Schema::hasTable($pages_table)){
    			return view('errors.404');
    		}

    		$page_list=\DB::table($pages_table)
    		->where($pages_table.'.status',0)
    		->where($pages_table.'.publish_date',$publish_date)
    		->leftjoin('categories','categories.id','=', $pages_table.'.category_id')
    		->select($pages_table.'.*','categories.name as category_name')
    		->orderBy('page_number', 'asc')
    		->get();


    		if(!empty($page_list)){
    			foreach ($page_list as $key => $page) {
    				$data = array(
    					'status' => 1,
    					);

    				\DB::table($pages_table)->where('id', $page->id)->update($data);
    			}
                \DB::table('publish_dates')->insert(['publish_date' => $publish_date, 'status' => 1]);
    		}

    		return redirect()->to('publish-pages')->with('message', "Pages published successfully !");

    	}
    	else return redirect()->to('publish-pages')->with('message', "Please select valid date !"); 


    }

    #----------------- End -----------------#
  }
