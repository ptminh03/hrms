<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

const TYPES = [
    'post' => 1,
    'leave' => 2,
    'device' => 3,
];

class AuthController extends Controller
{
    
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function showLogin()
    {
        return view('hrms.auth.login');
    }

    public function doLogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if ($user) {
            $data = [
                'email' => $email,
                'password' => $password,
            ];
            if (Auth::attempt($data)) {
                return redirect()->route('index');
            }
        }
        Session::flash('class', 'alert-danger');
        Session::flash('message', 'Email hoặc mật khẩu không đúng !');

        return redirect()->route('auth.login');
    }

    public function doLogout()
    {
        Auth::logout();

        return redirect()->route('auth.login');
    }

    public function dashboard()
    {
        // $events   = $this->convertToArray(Event::where('date', '>', Carbon::now())->orderBy('date', 'desc')->take(3)->get());
        // $meetings = $this->convertToArray(Meeting::where('date', '>', Carbon::now())->orderBy('date', 'desc')->take(3)->get());
        return view('hrms.dashboard');
    }

    public function index()
    {
        $news = News::select(\DB::raw("
            news.id,
            news.type,
            ( CASE
                WHEN news.type = 1 THEN news.target_id
                ELSE NULL
            END ) as author,
            news.title,
            news.content,
            ( CASE
                WHEN news.type = 2 THEN leaves.id
                ELSE NULL
            END ) as target_id,
            employees.id,
            employees.name,
            employees.photo,
            news.updated_at
        "))
        ->leftJoin('leaves', function($join) {
            $join->on('news.target_id', '=', 'leaves.id');
            $join->on('news.type', \DB::raw(TYPES['leave']));
        })
        // ->leftJoin('devices', function($join) {
        //     $join->on('news.target_id', '=', 'devices.id');
        //     $join->on('news.type', \DB::raw(TYPES['device']));
        // })
        ->leftJoin('employees', function($join) {
            $join
            ->on('news.target_id', '=', 'employees.id')
            ->on('news.type', \DB::raw(TYPES['post']));

            $join
            ->orOn('news.type', \DB::raw(TYPES['leave']))
            ->on('leaves.process_by', '=', 'employees.id');
        })
        ->where('news.type', TYPES['post'])
        ->orWhere([
            ['news.type', TYPES['leave']],
            ['leaves.employee_id', Auth::user()->id]
        ])
        ->orWhere([
            ['news.type', TYPES['device']],
            // ['devices.employee_id', \DB::raw(Auth::user()->id)]
        ])
        ->orderBy('news.updated_at', 'desc')->paginate(1);

        return view('hrms.auth.index', ['news' => $news]);
    }

    // public function notFound()
    // {
    //     return view('hrms.auth.not_found');
    // }

    // public function showRegister()
    // {
    //     return view('hrms.auth.register');
    // }

    // public function doRegister(Request $request)
    // {
    //     return view('hrms.auth.register');
    // }

    // public function calendar()
    // {
    //     return view('hrms.auth.calendar');
    // }

    public function changePassword()
    {
        return view('hrms.auth.change');
    }

    public function processPasswordChange(Request $request)
    {
        $password = $request->old;
        $user = User::where('id', Auth::user()->id)->first();

        if (Hash::check($password, $user->password)) {
            $user->password = bcrypt($request->new);
            $user->save();
            Auth::logout();

            return redirect()->to('/')->with('message', 'Password updated! LOGIN again with updated password.');
        } else {
            Session::flash('flash_message', 'The supplied password does not matches with the one we have in records');

            return redirect()->back();
        }
    }

    public function resetPassword()
    {
        return view('hrms.auth.reset');
    }

    public function processPasswordReset(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();

        if ($user) {
            $string = strtolower(str_random(6));

            $this->mailer->send('hrms.auth.reset_password', ['user' => $user, 'string' => $string], function ($message) use ($user) {
                $message->from('no-reply@dipi-ip.com', 'Digital IP Insights');
                $message->to($user->email, $user->name)->subject('Your new password');
            });

            User::where('email', $email)->update(['password' => bcrypt($string)]);
            dd('vac');
            return redirect()->route('auth.login')->with('message', 'Login with your new password received on your email');
        } else {
            return redirect()->route('auth.login')->with('message', 'Your email is not registered');
        }

    }

    // public function convertToArray($values)
    // {
    //     $result = [];
    //     foreach ($values as $key => $value) {
    //         $result[$key] = $value;
    //     }

    //     return $result;
    // }

    public function test()
    {
        $user = User::where(['email' => 'ptminh03@gmail.com', 'password' => md5('123456')])->first();
        // dd($user);
        $auth = Auth::attempt(['email' => 'ptminh03@gmail.com', 'password' => '123456']);
        dd($auth);
    }
}
