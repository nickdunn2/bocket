<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class BookmarksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bookmark::with('tags')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bookmark = new Bookmark;
        $bookmark->user_id = \Auth::user()->id;
        $bookmark->link = $request->link;
        $bookmark->save();

        return $bookmark;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Bookmark::with('tags')->findOrFail($id);
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
        // To-Do: Can still change info/ownership on a bookmark not belonging to you.
        $bookmark = Bookmark::findOrFail($id);

        if (Gate::denies('update-destroy-bookmark', $bookmark)) {
            abort(403, 'Not authorized, dummy.');
        }

        $bookmark->user_id = \Auth::user()->id;
        $bookmark->link = $request->link;
        $bookmark->save();

        return $bookmark;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // To-Do: Can still delete a bookmark not belonging to you.
        $bookmark = Bookmark::findOrFail($id);

        if (Gate::denies('update-destroy-bookmark', $bookmark)) {
            abort(403, 'Not authorized, dummy.');
        }

        $bookmark->delete();
        return $bookmark;
    }
}
