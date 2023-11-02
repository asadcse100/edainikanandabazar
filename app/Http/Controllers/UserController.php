<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{

    /**
     * Show the application manage-users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['users_info']=\DB::table('users')->where('id', '!=', 1)->get();

        return \View::make('admin.manage-users.index',$data);
    }



    /**
     * Show the application user create.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     date_default_timezone_set("Asia/Dhaka");
    //     $now=date('Y-m-d H:i:s');

    //     $rules=array(
    //       'name' => 'required',
    //       'email' => 'required|email',
    //       'password' => 'required|min:6',
    //       'role' => 'required',
    //       );
    //     $v=\Validator::make(\Request::all(), $rules);

    //     if($v->passes()){

    //         try{

    //             $name_explode=explode(' ',strtolower(\Request::input('name')));
    //             $name_implode=implode('-',$name_explode);

    //             if(!empty(\Request::file('user_image'))){
    //                 $image = \Request::file('user_image');
    //                 $img_ext=$image->getClientOriginalExtension();
    //                 $filename  = $name_implode.'-'.time().'.'.$img_ext;
    //                 $path ='assets/images/avatars/' . $filename;
    //                 \Image::make($image)->resize(150, 170)->save($path);
    //             }else{
    //                 $filename='';
    //             }

    //             $user_data=array(
    //              'name' => \Request::input('name'),
    //              'email' => \Request::input('email'),
    //              'password' => bcrypt(\Request::input('password')),
    //              'role' => \Request::input('role'),
    //              'user_image' => $filename,
    //              'login_status' => 0,
    //              'user_status' => 1
    //              );
    //              \DB::enableQueryLog();
    //             $user_save=\DB::table('users')->insert($user_data);
    //         }catch(\Exception $e){

    //             unlink('assets/images/avatars/'.$filename);

    //             return \Redirect::to('/manage-users')->with('message',"Problem creating user.please try again..!");
    //         }

    //         return \Redirect::to('/manage-users')->with('message',"User has been created successfully !");

    //     }else return \Redirect::to('/manage-users')->withInput()->withErrors($v->messages());
    // }

    public function create()
{
    date_default_timezone_set("Asia/Dhaka");
    $now = now();

    $rules = [
        'name'     => 'required',
        'email'    => 'required|email',
        'password' => 'required|min:6',
        'role'     => 'required',
    ];

    $validator = \Validator::make(\Request::all(), $rules);

    if ($validator->passes()) {
        try {
            $name = \Request::input('name');
            $name_implode = str_replace(' ', '-', strtolower($name));
            $filename = '';

            if (!empty(\Request::file('user_image'))) {
                $image = \Request::file('user_image');
                $img_ext = $image->getClientOriginalExtension();
                $filename = $name_implode . '-' . time() . '.' . $img_ext;
                $path = 'assets/images/avatars/' . $filename;
                \Image::make($image)->resize(150, 170)->save($path);
            }

            $user_data = [
                'name'         => $name,
                'email'        => \Request::input('email'),
                'password'     => bcrypt(\Request::input('password')),
                'role'         => \Request::input('role'),
                'user_image'   => $filename,
                'login_status' => 0,
                'user_status'  => 1,
                'created_at'   => $now
            ];

            \DB::enableQueryLog();
            \DB::table('users')->insert($user_data);

            return \Redirect::to('/manage-users')->with('message', "User has been created successfully!");
        } catch (\Exception $e) {
            dd($e->getMessage());
            if (!empty($filename)) {
                unlink('assets/images/avatars/' . $filename);
            }

            return \Redirect::to('/manage-users')->with('message', "Problem creating user. Please try again..!");
        }
    } else {
        return \Redirect::to('/manage-users')->withInput()->withErrors($validator->messages());
    }
}



    /**
     * Show the application user update.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        date_default_timezone_set("Asia/Dhaka");
        $now=date('Y-m-d H:i:s');

        $rules=array(
          'name' => 'required',
          'email' => 'required|email',
          'role' => 'required',
          'user_status' => 'required',
          );
        $v=\Validator::make(\Request::all(), $rules);

        if($v->passes()){

            try{
                $user_id=\Request::input('user_id');

                if(!empty($user_id)){

                    if(!empty(\Request::input('password'))){

                        $user_data=array(
                         'name' => \Request::input('name'),
                         'email' => \Request::input('email'),
                         'password' => bcrypt(\Request::input('password')),
                         'role' => \Request::input('role'),
                         'user_status' => \Request::input('user_status'),
                         'updated_at' => $now,
                         );

                    }else{

                        $user_data=array(
                         'name' => \Request::input('name'),
                         'email' => \Request::input('email'),
                         'role' => \Request::input('role'),
                         'user_status' => \Request::input('user_status'),
                         'updated_at' => $now,
                         );
                    }
                    

                    $user_update=\DB::table('users')->where('id', $user_id)->update($user_data);

                }else{
                    return \Redirect::to('/manage-users')->with('message',"User ID could not found.please try again..!");
                }
                
            }catch(\Exception $e){

                return \Redirect::to('/manage-users')->with('message',"Problem updating user.please try again..!");
            }

            return \Redirect::to('/manage-users')->with('message',"User has been updated successfully !");

        }else return \Redirect::to('/manage-users')->withErrors($v->messages());

    }

    #----------------- End -----------------#
}
