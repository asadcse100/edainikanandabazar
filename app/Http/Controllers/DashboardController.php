<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Setting;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ## get pages table ##
        $pages_tables = \App\Models\Epaper::GetTables('pages');
        $count_pages_table = count($pages_tables);
        $pages_table = $pages_tables[$count_pages_table - 1];


        foreach (glob('/uploads/temp/*', GLOB_ONLYDIR) as $key => $dir) {

            $title = basename($dir);
            $directory = 'uploads/temp/' . $title;

            $size = 0;
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) as $file) {
                $size += $file->getSize();
            }
            $size = ($size / 1024) / 1024;

            $data = array(
                'title' => $title,
                'size' => $size,
            );

            $folder_info[] = $data;

            $data['folder_info'] = $folder_info;
        }

        $total_pages = \DB::table($pages_table)->where($pages_table . '.publish_date', date('Y-m-d'))->where('status', 1)->get();
        $data['total_pages'] = count($total_pages);

        $total_users = \DB::table('users')->where('user_status', 1)->where('id', '!=', 1)->get();
        $data['total_users'] = count($total_users);

        $active_ads = \DB::table('advertisements')->where('ad_status', 1)->get();
        $data['active_ads'] = count($active_ads);

        $total_category = \DB::table('categories')->where('status', 1)->get();
        $data['total_category'] = count($total_category);

        return \View::make('admin.dashboard.index', $data);
    }

    /**
     * Show the application removeTempFolder.
     *
     * @return \Illuminate\Http\Response
     */
    public function removeTempFolder($folder_title)
    {

        $dir = 'uploads/temp/' . $folder_title;

        if ($dir) {

            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CHILD_FIRST
            );

            foreach ($files as $fileinfo) {
                $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                $todo($fileinfo->getRealPath());
            }

            rmdir($dir);

            return \Redirect::to('/home')->with('message', "Folder removed successfully !");
        } else {

            return \Redirect::to('/home')->with('message', "Folder could not found !");
        }
    }


    /**
     * Show the application profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $data['user_info'] = \DB::table('users')->where('email', \Auth::user()->email)->first();
        return \View::make('admin.dashboard.profile', $data);
    }


    /**
     * Show the application profileUpdate.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate()
    {

        date_default_timezone_set("Asia/Dhaka");
        $now = date('Y-m-d H:i:s');

        $rules = array(
            'name' => 'Required',
            'password' => 'min:6'
        );
        $v = \Validator::make(\Request::all(), $rules);

        if ($v->passes()) {

            try {
                $id = \Auth::user()->id;

                if (!empty(\Request::input('password'))) {

                    $data = array(
                        'name' => \Request::input('name'),
                        'mobile' => \Request::input('mobile'),
                        'address' => \Request::input('address'),
                        'password' => \Hash::make(\Request::input('password')),
                        'updated_at' => $now,
                    );
                } else {
                    $data = array(
                        'name' => \Request::input('name'),
                        'mobile' => \Request::input('mobile'),
                        'address' => \Request::input('address'),
                        'updated_at' => $now,
                    );
                }


                $update = \DB::table('users')->where('id', $id)->update($data);

                return \Redirect::to('/profile')->with('message', "Profile has been updated successfully !");
            } catch (\Exception $e) {

                return \Redirect::to('/profile')->with('message', "Problem updating profile.please try again");
            }
        } else return \Redirect::to('/profile')->withInput()->withErrors($v->messages());
    }

    public function settings(Request $request)
    {
        $data = [];
        $data['setting'] = Setting::first();
        return view('admin.settings.index', $data);
    }

    public function topbar_info(Request $request)
    {
        $data = [];
        $data['topbar_infos'] = \DB::table('topbar_infos')->get();
        return view('admin.settings.topbar_infos', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'water_mark' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $settings = Setting::first();

        $logoName = $settings->logo;
        $faviconName = $settings->favicon;
        $water_markName = $settings->water_mark;

        if(!empty($request->logo)){
            $logoName = 'logo'.time().'.'.$request->logo->extension();
            $request->logo->move(public_path('logo'), $logoName);
        }
        if(!empty($request->favicon)){
            $faviconName = 'favicon'.time().'.'.$request->favicon->extension();
            $request->favicon->move(public_path('favicon'), $faviconName);
        }
        if(!empty($request->water_mark)){
            $water_markName = 'water_mark'.time().'.'.$request->water_mark->extension();
            $request->water_mark->move(public_path('water_mark'), $water_markName);
        }
       
        Setting::updateOrInsert(
            [
                'id' => $request->id
            ],
            [
                'site_name' => $request->site_name,
                'logo' => $logoName,
                'favicon' => $faviconName,
                'water_mark' => $water_markName,
            ]
        );
    
        return back();
    }
    

    
    /**
     * Show the application user create.
     *
     * @return \Illuminate\Http\Response
     */
    public function topbarinfo_store()
    {
        date_default_timezone_set("Asia/Dhaka");
        $now=date('Y-m-d H:i:s');

        $rules=array(
          'title' => 'required',
          'url' => 'required',
          );
        $v=\Validator::make(\Request::all(), $rules);

        if($v->passes()){

            try{

                $topbar_data=array(
                 'title' => \Request::input('title'),
                 'url' => \Request::input('url'),
                 'user_status' => 1,
                 'created_at' => $now,
                 );

                $user_save=\DB::table('topbar_infos')->insert($topbar_data);

            }catch(\Exception $e){
                return \Redirect::to('/topbar_information')->with('message',"Problem insert topbar .please try again..!");
            }

            return \Redirect::to('/topbar_information')->with('message',"Topbar data has been created successfully !");

        }else 
        return \Redirect::to('/topbar_information')->withInput()->withErrors($v->messages());
    }


    /**
     * Show the application user update.
     *
     * @return \Illuminate\Http\Response
     */
    public function topbarinfo_update()
    {
        date_default_timezone_set("Asia/Dhaka");
        $now=date('Y-m-d H:i:s');
        $rules=array(
          'title' => 'required',
          'url' => 'required',
          'is_active' => 'required',
          );
        $v=\Validator::make(\Request::all(), $rules);

        if($v->passes()){

            try{
                $topbar_id=\Request::input('topbar_id');

                if(!empty($topbar_id)){

                        $topbar_data=array(
                         'title' => \Request::input('title'),
                         'url' => \Request::input('url'),
                         'is_active' => \Request::input('is_active'),
                         'updated_at' => $now,
                         );

                    $user_update=\DB::table('topbar_infos')->where('id', $topbar_id)->update($topbar_data);

                }else{
                    return \Redirect::to('/topbar_information')->with('message',"Topbar Id could not found.please try again..!");
                }
                
            }catch(\Exception $e){

                return \Redirect::to('/topbar_information')->with('message',"Problem updating Topbar info.please try again..!");
            }

            return \Redirect::to('/topbar_information')->with('message',"Topbar info has been updated successfully !");

        }else 
        return \Redirect::to('/topbar_information')->withErrors($v->messages());

    }



    #-------------------END-----------------#
}
