<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   protected $redirectTo = '/';
    // public function redirectTo()
    // {
    //     return route('home');
    // }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    /**
     * Override username functions
     * @since 1.0.0
     * */
    public function username()
    {
        return 'username';
    }

    /**
     * show admin login page
     * @since 1.0.0
     * */
    public function showAdminLoginForm()
    {
        return view('auth.admin.login');
    }

    /**
     * admin login system
     * */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|min:6'
        ], [
            'email.required' => __('email required'),
            'password.required' => __('password required')
        ]);

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->route('Dashboard')->withSuccess('You have successfully logged in!');
            
            // return response()->json([
            //     'msg' => __('Login Success Redirecting'),
            //     'type' => 'success',
            //     'status' => 'ok'
            // ]);
        }
        // return response()->json([
        //     'msg' => __('Your email or Password Is Wrong !!'),
        //     'type' => 'danger',
        //     'status' => 'not_ok'
        // ]);
        return \Redirect::to('/login');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        // return view('frontend.user.login');
        return view('auth.admin.login');
    }

    public function logout(){
        \Auth::logout();
        return \Redirect::to('/login');
    }
}
