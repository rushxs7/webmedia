<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $links = Link::where('user_id', Auth::id())->get();

        // return view();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'link' => 'url'
        ]);

        // Shorten URL

        // Return with flash message
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        // Destroy link
    }
}
