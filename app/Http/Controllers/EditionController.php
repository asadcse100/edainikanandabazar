<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class EditionController extends Controller
{

    /**
     * Show the application manage-edition.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$data['edition_list']=\DB::table('editions')
    	->leftjoin('users','users.id','=','editions.created_by')
    	->select('editions.*','users.name as creator_name')
    	->get();

    	return \View::make('admin.manage-edition.index',$data);
    }


    /**
     * Show the application create edition.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	date_default_timezone_set("Asia/Dhaka");
    	$now = date('Y-m-d H:i:s');

    	$rules=array(
    		'edition_name' => 'Required',
    		'edition_title' => 'Required',
    		);
    	$v = \Validator::make(\Request::all(), $rules);

    	if($v->passes()){

    		try{

    			$edition_data=array(
    				'name' => \Request::input('edition_name'),
    				'title' => \Request::input('edition_title'),
    				'status' => 1,
    				'created_by' => \Auth::user()->id,
    				'created_at' => $now,
    				);

    			$edition_save = \DB::table('editions')->insert($edition_data);

    			return \Redirect::to('/manage-edition')->with('message',"New edition has been added successfully !");

    		}catch(\Exception $e){

    			return \Redirect::to('/manage-edition')->with('message',"Problem creating new edition.please try again..!");
    		}

    	}else return \Redirect::to('/manage-edition')->withInput()->withErrors($v->messages());
    }



    /**
     * Show the application update edition.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
    	date_default_timezone_set("Asia/Dhaka");
    	$now = date('Y-m-d H:i:s');

    	$rules=array(
    		'edition_name' => 'Required',
    		'edition_title' => 'Required',
    		);
    	$v = \Validator::make(\Request::all(), $rules);

    	if($v->passes()){

    		try{
    			$id = \Request::input('edition_id');

    			$edition_data=array(
    				'name' => \Request::input('edition_name'),
    				'title' => \Request::input('edition_title'),
    				'updated_by' => \Auth::user()->id,
    				'updated_at' => $now,
    				);

    			$edition_save = \DB::table('editions')->where('id',$id)->update($edition_data);

    			return \Redirect::to('/manage-edition')->with('message',"Edition has been updated successfully !");

    		}catch(\Exception $e){

    			return \Redirect::to('/manage-edition')->with('message',"Problem updating edition.please try again..!");
    		}

    	}else return \Redirect::to('/manage-edition')->withInput()->withErrors($v->messages());
    }



    /**
     * Show the application delete edition.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
    	try{

    		$edition_delete = \DB::table('editions')->where('id',$id)->delete();

    		return \Redirect::to('/manage-edition')->with('message',"Edition has been deleted successfully !");

    	}catch(\Exception $e){

    		return \Redirect::to('/manage-edition')->with('message',"Problem deleting edition.please try again..!");
    	}
    }


    /**
     * Show the application change category status.
     *
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($id, $status)
    {
    	date_default_timezone_set("Asia/Dhaka");
    	$now = date('Y-m-d H:i:s');

    	try{
    		$change_data=array(
    			'status' => $status,
    			'updated_by' => \Auth::user()->id,
    			'updated_at' => $now,
    			);
    		$status_change = \DB::table('editions')->where('id',$id)->update($change_data);

    		if($status==1){
    			\Session::flash('message',"Edition has been activated successfully !");
    		}else{
    			\Session::flash('message',"Edition has been blocked successfully !");
    		}
    		
    	}catch(\Exception $e){

    		\Session::flash('message',"Probling changing edition status !");
    	}
    }

    #---------------End-----------------#
}
