<?php

namespace App\Http\Controllers;


use App\Tag;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tag::with('bookmarks')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = new Tag;
        $tag->user_id = \Auth::user()->id;
        $tag->name = $request->name;
        $tag->save();

        return $tag;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Tag::with('bookmarks')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);

        if (Gate::denies('update-destroy-tag', $tag)) {
            abort(403, 'Not authorized, dummy.');
        }

        $tag->user_id = \Auth::user()->id;
        $tag->name = $request->name;
        $tag->save();
        return $tag;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // To-Do: Can still delete a tag not belonging to you.
        $tag = Tag::findOrFail($id);

        if (Gate::denies('update-destroy-tag', $tag)) {
            abort(403, 'Not authorized, dummy.');
        }
        $tag->delete();
        return $tag;
    }
}
