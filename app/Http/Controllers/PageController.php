<?php

namespace App\Http\Controllers;

use app\models\page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct(){}
    //
    public function index()
{
    $pages = Page::all();
    return view('pages.index', compact('pages'));
}

public function create()
{
    return view('pages.create');
}

public function store(Request $request)
{
    $page = new Page();
    $page->title = $request->title;
    $page->content = $request->content;
    $page->save();

    return redirect()->route('pages.index');
}

public function edit(Page $page)
{
    return view('pages.edit', compact('page'));
}

public function update(Request $request, Page $page)
{
    $page->title = $request->title;
    $page->content = $request->content;
    $page->save();

    return redirect()->route('pages.index');
}

public function destroy(Page $page)
{
    $page->delete();

    return redirect()->route('pages.index');
}

}
