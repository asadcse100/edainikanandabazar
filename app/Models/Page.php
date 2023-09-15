<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Page extends Model
{

	public static function PageEdition($date, $page_id){

    	## get edition_pages table ##
		$edition_pages_tables = \App\Models\Epaper::GetTables('edition');
		$count_edition_pages_table = count($edition_pages_tables);
		$edition_pages_table=$edition_pages_tables[$count_edition_pages_table-1];

		foreach ($edition_pages_tables as $key => $edition_pages_list) {
			if(($edition_pages_list == 'edition_pages_'.date('Y_m',strtotime($date)))){

				$edition_pages_tables = $edition_pages_list;

				$get_edition=\DB::table($edition_pages_tables)
				->where($edition_pages_tables.'.page_id', $page_id)
				->leftjoin('editions','editions.id','=', $edition_pages_tables.'.edition_id')
				->get();

				return $get_edition;

			}  
		}

		
	}



    #-----------------End-----------------#
}
