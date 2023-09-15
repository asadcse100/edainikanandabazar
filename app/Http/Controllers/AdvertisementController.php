<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{

    /**
     * Show the application manage advertisements.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['advertisements'] = \DB::table('advertisements')->get();

        return \View::make('admin.manage-advertisements.index', $data);
    }


    /**
     * Show the application Advertisement update.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        date_default_timezone_set("Asia/Dhaka");
        $now = date('Y-m-d H:i:s');

        $rules = array(
            'ad_status' => 'required',
            'ad_code' => 'required',
        );
        $v = \Validator::make(\Request::all(), $rules);

        if ($v->passes()) {

            try {
                $ad_id = \Request::input('ad_id');

                if (!empty($ad_id)) {

                    if (\Request::input('ad_status') == '1') {
                        $active_from = date("Y-m-d", strtotime($now));
                        $active_upto = null;
                    } else {
                        $active_from = null;
                        $active_upto = date("Y-m-d", strtotime($now));
                    }
                    $ad_data = array(
                        'ad_code' => \Request::input('ad_code'),
                        'ad_status' => \Request::input('ad_status'),
                        'active_from' => $active_from,
                        'active_upto' => $active_upto,
                        'updated_at' => $now,
                        'updated_by' => \Auth::user()->id,
                    );


                    $ad_update = \DB::table('advertisements')->where('id', $ad_id)->update($ad_data);
                } else {
                    return \Redirect::to('/manage-advertisements')->with('message', "Advertisement ID could not found.please try again..!");
                }
            } catch (\Exception $e) {

                return \Redirect::to('/manage-advertisements')->with('message', "Problem updating advertisement.please try again..!");
            }

            return \Redirect::to('/manage-advertisements')->with('message', "Advertisement has been updated successfully !");
        } else return \Redirect::to('/manage-advertisements')->withErrors($v->messages());
    }



    #---------------- End -----------------#
}
