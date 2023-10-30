<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Epaper extends Model
{


	######################
	## GetTables
	######################
    public static function GetTables($table_prefix)
    {
      $tables_name = \DB::select("SHOW TABLES LIKE "."'" .$table_prefix. "%'");

      foreach ($tables_name as $table) {
        foreach ($table as $key => $table_name){
          $td_name[] = $table_name;
        }
    }

      return $td_name;
    }


	######################
	## Get Categories
	######################
	public static function GetCategories(){

		$categories=\DB::table('categories')->where('status',1)->get();
		return $categories;
	}


	######################
	## Get Category
	######################
	public static function GetCategory($category_id){

		$category_title=\DB::table('categories')->where('id',$category_id)->where('status',1)->first();
		return $category_title;
	}


	######################
	## Get Editions
	######################
	public static function GetEditions(){

		$editions=\DB::table('editions')->where('status',1)->get();
		return $editions;
	}


	######################
	## Get PageInfo
	######################
	public static function GetPageInfo(){

		## get pages table ##
		$pages_tables = \App\Models\Epaper::GetTables('pages');
		$count_pages_table = count($pages_tables);
		$pages_table=$pages_tables[$count_pages_table-1];
		$pages_table_lm=$pages_tables[$count_pages_table-2];

		$page_info=\DB::table($pages_table)->where('status',1)->orderBy('publish_date','desc')->first();
		if(empty($page_info)){
			$page_info=\DB::table($pages_table_lm)->where('status',1)->orderBy('publish_date','desc')->first();
		}
		return $page_info;
	}


	######################
	## GetAdvertisement
	######################
	public static function GetAdvertisement($ad_location){

		$get_advertisement=\DB::table('advertisements')->where('ad_slug',$ad_location)->where('ad_status',1)->first();
		return $get_advertisement;
	}


	######################
	## GetRelatedItem
	######################
	public static function GetRelatedItem($date, $related_item_id){

		## get images table ##
		$images_tables = \App\Models\Epaper::GetTables('images');
		$count_images_table = count($images_tables);
		$images_table=$images_tables[$count_images_table-1];

		foreach ($images_tables as $key => $images_tables_list) {
			if(($images_tables_list == 'images_'.date('Y_m',strtotime($date)))){

				$images_table = $images_tables_list;
			}
		}


		$get_related_item=\DB::table($images_table)->where('id',$related_item_id)->where('image_status',1)->first();

		if(!empty($get_related_item)){
			$related_image=$get_related_item->image;
		}else{
			$related_image=null;
		}
		
		return $related_image;
	}


	######################
	## GetBanglaDate
	######################
	public static function GetBanglaDate($date){

		$search_array= array("Sat", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", ":", ",");

		$replace_array= array("শনিবার", "রোববার", "সোমবার", "মঙ্গলবার", "বুধবার", "বৃহস্পতিবার", "শুক্রবার", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবার", "নভেম্বার", "ডিসেম্বার", ":", ",");

		$date_show = str_replace($search_array, $replace_array,date('D, d M Y', strtotime($date)));

		return $date_show;
	}


	######################
	## GetImageSize
	######################
	public static function GetImageSize($image_location){

		list($width, $height) = getimagesize($image_location);

		if(!empty($width)){
			$width=$width;
		}else{
			$width=500;
		}
		
		return $width;
	}


    #-----------------End-------------#
}
