<?php

namespace App\Http\Controllers;

use App\Models\Policy;

class PolicyController extends Controller
{
    public function showPolicy()
    {
        $policies = Policy::get();
        return view('hrms.policies', ['policies' => $policies]);
    }
}
