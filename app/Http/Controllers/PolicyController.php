<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function index()
    {
        $policies = Policy::orderBy('id', 'desc')->get();
        return view('hrms.policy.index', compact('policies'));
    }

    public function create()
    {
        return view('hrms.policy.create', compact('policies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'bail|required|unique:policies'
        ],
        [
            'title.required' => 'Title must NOT be empty',
            'title.unique' => 'Title already exist'
        ]);

        $policy = new Policy;
        $policy->title = $request->title;
        $policy->content = $request->content;
        $policy->save();

        return redirect()
            ->route('policy.index')
            ->with('message', 'Create policy success')
            ->with('class', 'alert-success');
    }

    public function edit($id)
    {
        if ( !$policy = Policy::find($id) )
        {
            return back()
                ->with('message', 'ID policy not found')
                ->with('class', 'alert-danger');
        }
        return view('hrms.policy.edit', compact('policy'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'bail|required|unique:policies'
        ],
        [
            'title.required' => 'Title must NOT be empty',
            'title.unique' => 'Title already exist'
        ]);

        if ( !$policy = Policy::find($id) )
        {
            return back()
                ->with('message', 'ID policy not found')
                ->with('class', 'alert-danger');
        }

        $policy->title = $request->title;
        $policy->content = $request->content;
        $policy->save();

        return redirect()
            ->route('policy.index')
            ->with('message', 'Edit policy success')
            ->with('class', 'alert-success');
    }

    public function destroy($id)
    {
        if ( !$policy = Policy::find($id) )
        {
            return back()
                ->with('message', 'ID policy not found')
                ->with('class', 'alert-danger');
        }

        $policy->delete();

        return back()
            ->with('message', 'Delete policy success')
            ->with('class', 'alert-success');
    }
}
