<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

	/**
	 * Show the application manage category.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data['category_list'] = \DB::table('categories')
			->leftjoin('users', 'users.id', '=', 'categories.created_by')
			->select('categories.*', 'users.name as creator_name')
			->get();

		return view('admin.manage-category.index', $data);
	}


	/**
	 * Show the application create category.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		date_default_timezone_set("Asia/Dhaka");
		$now = date('Y-m-d H:i:s');

		$rules = array(
			'category_name' => 'Required'
		);
		$v = \Validator::make(\Request::all(), $rules);

		if ($v->passes()) {

			try {

				$category_data = array(
					'name' => \Request::input('category_name'),
					'status' => 1,
					'created_by' => \Auth::user()->id,
					'created_at' => $now,
				);

				$category_save = \DB::table('categories')->insert($category_data);

				return \Redirect::to('/manage-category')->with('message', "New category has been added successfully !");
			} catch (\Exception $e) {

				return \Redirect::to('/manage-category')->with('message', "Problem creating new category.please try again..!");
			}
		} else return \Redirect::to('/manage-category')->withInput()->withErrors($v->messages());
	}


	/**
	 * Show the application update category.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update()
	{
		date_default_timezone_set("Asia/Dhaka");
		$now = date('Y-m-d H:i:s');

		$rules = array(
			'category_id' => 'Required',
			'category_name' => 'Required',
		);
		$v = \Validator::make(\Request::all(), $rules);

		if ($v->passes()) {

			try {
				$id = \Request::input('category_id');

				$category_data = array(
					'name' => \Request::input('category_name'),
					'updated_by' => \Auth::user()->id,
					'updated_at' => $now,
				);

				$category_update = \DB::table('categories')->where('id', $id)->update($category_data);

				return \Redirect::to('/manage-category')->with('message', "Category has been updated successfully !");
			} catch (\Exception $e) {

				return \Redirect::to('/manage-category')->with('message', "Problem updating category.please try again..!");
			}
		} else return \Redirect::to('/manage-category')->withInput()->withErrors($v->messages());
	}


	/**
	 * Show the application delete category.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id)
	{
		dd($id);
		try {

			$category_delete = \DB::table('categories')->where('id', $id)->delete();

			return \Redirect::to('/manage-category')->with('message', "Category has been deleted successfully !");
		} catch (\Exception $e) {

			return \Redirect::to('/manage-category')->with('message', "Problem deleting category.please try again..!");
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

		try {
			$change_data = array(
				'status' => $status,
				'updated_by' => \Auth::user()->id,
				'updated_at' => $now,
			);
			$status_change = \DB::table('categories')->where('id', $id)->update($change_data);

			if ($status == 1) {
				\Session::flash('message', "Category has been activated successfully !");
			} else {
				\Session::flash('message', "Category has been blocked successfully !");
			}
		} catch (\Exception $e) {

			\Session::flash('message', "Probling changing category status !");
		}
	}


	#---------------- End -----------------#
}
