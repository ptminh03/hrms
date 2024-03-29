<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Payment;
use App\Models\PaymentDetail;
use Exception;
use DB;

class PaymentController extends Controller
{
    public function create()
    {
        $months = [
            1 => 'January', 2 => 'Febuary', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
            7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
        $now = Carbon::now();
        $years = [];
        for ($i = 2019; $i <= $now->year; $i++) {
            $years[] = $i;
        }
        return view('hrms.payment.create', compact('months', 'years'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'month' => 'numeric|min:1|max:12',
        ],
        [
            'month.numeric' => 'Month is invalid',
            'month.min' => 'Month is invalid',
            'month.max' => 'Month is invalid',
        ]);
        
        $now = Carbon::now();
        if ( $request->year > $now->year)
        {
            return back()
                ->with('message', 'Year is invalid')
                ->with('class', 'alert-danger');
        }

        if ( $request->year == $now->year && $request->month >= $now->month)
        {
            return back()
                ->with('message', 'Time is invalid')
                ->with('class', 'alert-danger');
        }

        if ( Payment::where(['year' => $request->year, 'month' => $request->month])->first() )
        {
            return back()
                ->with('message', 'Payment already exist')
                ->with('class', 'alert-danger');
        }

        $payment = new Payment;
        $payment->month = $request->month;
        $payment->year = $request->year;

        $employees = DB::select('SELECT employees.id as employee_id, employees.code, employees.name, employees.account_number, employees.salary, 
        CASE WHEN employees_leaves.non_paid IS NULL THEN ? ELSE employees_leaves.non_paid END as non_paid
        FROM employees
        LEFT JOIN
            (SELECT leaves.employee_id,
             SUM(CASE WHEN session_id = ? THEN ? WHEN session_id IS NULL THEN ? ELSE ? END) as non_paid
            FROM hrms.leaves
            inner join leave_types on leaves.leave_type_id = leave_types.id and leave_types.description = ?
            inner join leave_details on leaves.id = leave_details.leave_id  and month(leave_details.date_leave) = ? and year(leave_details.date_leave) = ?
            where leaves.status = ?
            GROUP by leaves.employee_id) 
            as employees_leaves
        ON employees.id = employees_leaves.employee_id
        WHERE employees.date_of_resignation IS NULL
        AND employees.deleted_at IS NULL', [0, 2, 1, 0, 0.5, 'Non paid', $request->month, $request->year, 1]);
        foreach ($employees as $index => $employee)
        {
            $employees[$index]->payment = round($employee->salary*(22 - $employee->non_paid)/22);
            $payment->total_payments += $employees[$index]->payment;
        }
        
        DB::beginTransaction();
        try {
            $payment->save();
            foreach ($employees as $index => $employee)
            {
                $employees[$index]->payment_id = $payment->id;
            }
            $list = json_decode(json_encode($employees),true);
            PaymentDetail::insert($list);
            DB::commit();

            return redirect()
                ->route('payment.index')
                ->with('message', 'Create payment success')
                ->with('class', 'alert-success');
        } catch (Exception $e) {
            DB::rollBack();

            return back()
                ->with('message', 'Create payment failed')
                ->with('class', 'alert-danger');
        }
    }

    public function index()
    {
        $now = Carbon::now();
        $years = [];
        for ($i = 2019; $i <= $now->year; $i++) {
            $years[] = $i;
        }
        $payments = Payment::orderBy('year', 'desc')->orderBy('month', 'desc')->paginate(15);
        return view('hrms.payment.index', compact('payments', 'years')); 
    }

    public function show($id)
    {
        if ( !$payment = Payment::find($id) )
        {
            return back()
                ->with('message', 'Payment not found')
                ->with('class', 'alert-danger');
        }
        $info = [
            'year' => $payment->year,
            'month' => $payment->month
        ];

        $paymentDetails = PaymentDetail::where('payment_id', $id);
        if ( !empty (request()->q) ) {
            $paymentDetails = $paymentDetails->whereRaw('LOWER(name) like \'%'. strtolower(request()->q). '%\'');
        }
        $paymentDetails = $paymentDetails->paginate(20);
        return view('hrms.payment.show', compact('paymentDetails', 'info')); 
    }
}
