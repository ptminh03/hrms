<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $request = request();
        $news = News::where('type', '=', 1);
        if ( !empty( $request->q ) ) {
            $news = $news->whereRaw('LOWER(title) like \'%'. strtolower($request->q). '%\'');
        }
        $news = $news->orderBy('id', 'desc')->paginate(15);
        return view('hrms.news.index', compact('news'));
    }

    public function create()
    {
        return view('hrms.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:news',
        ],
        [
            'title.required' => 'Title must NOT be empty',
            'title.unique' => 'Title already exist',
        ]);

        $news = new News;
        $news->title = $request->title;
        $news->content = $request->content;
        $news->target_id = Auth::id();
        $news->type = 1;
        $news->save();

        return redirect()
            ->route('news.index')
            ->with('message', 'Create news success')
            ->with('class', 'alert-success');
    }

    public function show($id)
    {
        if ( !$news = News::find($id) )
        {
            return back()
                ->with('message', 'ID news not found')
                ->with('class', 'alert-danger');
        }

        return view('hrms.news.show', compact('news')); 
    }

    public function edit($id)
    {
        if ( !$news = News::find($id) )
        {
            return back()
                ->with('message', 'ID news not found')
                ->with('class', 'alert-danger');
        }

        if ( $news->target_id != Auth::id() )
        {
            return back()
                ->with('message', 'Permission denied')
                ->with('class', 'alert-danger');
        }

        return view('hrms.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ],
        [
            'title.required' => 'Title must NOT be empty',
        ]);

        if ( News::where('id', '<>', $id)->where('title', '=', $request->title)->first())
        {
            return back()
                ->with('message', 'Title already exists')
                ->with('class', 'alert-danger');
        }

        if ( !$news = News::find($id) )
        {
            return back()
                ->with('message', 'ID news not found')
                ->with('class', 'alert-danger');
        }

        if ( $news->target_id != Auth::id() )
        {
            return back()
                ->with('message', 'Permission denied')
                ->with('class', 'alert-danger');
        }

        $news->title = $request->title;
        $news->content = $request->content;
        $news->save();

        return redirect()
            ->route('news.index')
            ->with('message', 'Edit news success')
            ->with('class', 'alert-success');
    }

    public function destroy($id)
    {
        if ( !$news = News::find($id) )
        {
            return back()
                ->with('message', 'ID news not found')
                ->with('class', 'alert-danger');
        }

        if ( $news->target_id != Auth::id() )
        {
            return back()
                ->with('message', 'Permission denied')
                ->with('class', 'alert-danger');
        }

        $news->delete();

        return redirect()
            ->route('news.index')
            ->with('message', 'Delete news success')
            ->with('class', 'alert-success');
    }
}
