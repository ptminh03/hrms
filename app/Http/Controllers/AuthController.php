<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;

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
        return view('hrms.auth.show_login');
    }

    public function processLogin(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if ($user) {
            $data = [
                'email' => $email,
                'password' => $password
            ];
            if (Auth::attempt($data)) {
                $now = Carbon::now();
                $attendance = Attendance::where(['employee_id' => Auth::id(), 'year' => $now->year, 'month' => $now->month, 'day' => $now->day])->first();
                if ( $attendance )
                {
                    if ( empty($attendance->start_at) )
                    {
                        $attendance->start_at = $now->toTimeString();
                        $attendance->save();
                    } else {
                        $attendance->end_at = $now->toTimeString();
                        $attendance->save();
                    }
                } else {
                    Attendance::create([
                        'employee_id' => Auth::id(),
                        'year' => $now->year,
                        'month' => $now->month,
                        'day' => $now->day,
                        'start_at' => $now->toTimeString()
                    ]);
                }
                return redirect()->route('index');
            }
        }
        Session::flash('class', 'alert-danger');
        Session::flash('message', 'Email hoặc mật khẩu không đúng !');
        return redirect()->route('auth.login');
    }

    public function processLogout()
    {
        
        $now = Carbon::now();
        $attendance = Attendance::where(['employee_id' => Auth::id(), 'year' => $now->year, 'month' => $now->month, 'day' => $now->day])->first();
        if ( $attendance )
        {
            $attendance->end_at = $now->toTimeString();
            $attendance->save();
        }
        
        Auth::logout();
        return redirect()->route('auth.login');
    }

    public function index()
    {
        $news = News::select(DB::raw("
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
            $join->on('news.type', DB::raw(TYPES['leave']));
        })
        ->leftJoin('device_assigns', function($join) {
            $join->on('news.target_id', '=', 'device_assigns.id');
            $join->on('news.type', DB::raw(TYPES['device']));
        })
        ->leftJoin('employees', function($join) {
            $join
            ->on('news.target_id', '=', 'employees.id')
            ->on('news.type', DB::raw(TYPES['post']));

            $join
            ->orOn('news.type', DB::raw(TYPES['leave']))
            ->on('leaves.process_by', '=', 'employees.id');
        })
        ->where('news.type', TYPES['post'])
        ->orWhere([
            ['news.type', TYPES['leave']],
            ['leaves.employee_id', Auth::user()->id]
        ])
        ->orWhere([
            ['news.type', TYPES['device']],
            ['device_assigns.employee_id', DB::raw(Auth::user()->id)]
        ])
        ->orderBy('news.id', 'desc')->paginate(15);
        dd($news);
        return view('hrms.auth.index', compact('news'));
    }

    public function er()
    {
        $news = News::select(DB::raw("
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
                WHEN news.type = 3 THEN device_assigns.id
                ELSE NULL
            END ) as target_id,
            employees.id,
            employees.name,
            employees.photo,
            news.status,
            news.updated_at
        "))
        ->leftJoin('leaves', function($join)
        {
            $join->on('news.target_id', 'leaves.id');
            $join->on('news.type', DB::raw(2));
        })
        ->leftJoin('device_assigns', function($join)
        {
            $join->on('news.target_id', 'device_assigns.id');
            $join->on('news.type', DB::raw(3));
        })
        ->leftJoin('employees', function($join) {
            $join
            ->on('news.target_id', '=', 'employees.id')
            ->on('news.type', DB::raw(1));

            $join
            ->orOn('news.type', DB::raw(2))
            ->on('leaves.process_by', '=', 'employees.id');

            $join
            ->orOn('news.type', DB::raw(3))
            ->on('leaves.process_by', '=', 'employees.id');
        })
        ->where('news.type', 1)
        ->orWhere('leaves.employee_id', Auth::user()->id)
        ->orWhere('device_assigns.employee_id', Auth::user()->id)
        ->orderBy('news.id', 'desc')
        ->paginate(15);
        return view('hrms.auth.index', compact('news'));
    }

    public function showChangePassword()
    {
        return view('hrms.auth.show_change_password');
    }

    public function processChangePassword(Request $request)
    {
        $password = $request->old;
        $user = User::where('id', Auth::user()->id)->first();

        if (Hash::check($password, $user->password)) {
            $user->password = bcrypt($request->new);
            $user->save();
            Auth::logout();

            return redirect()
                ->route('auth.login')
                ->with('message', 'Đổi mật khẩu thành công, vui lòng đăng nhập lại.')
                ->with('class', 'alert-success');
        } else {
            Session::flash('message', 'Mật khẩu cũ không đúng')->with('class');
            
            return back()
                ->with('message', 'Đổi mật khẩu thành công, vui lòng đăng nhập lại.')
                ->with('class', 'alert-success');;
        }
    }

    public function showResetPassword()
    {
        return view('hrms.auth.show_reset_password');
    }

    public function processResetPassword(Request $request)
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

            return redirect()->route('auth.login')->with('message', 'Login with your new password received on your email');
        } else {
            return redirect()->route('auth.login')->with('message', 'Your email is not registered');
        }

    }
}
