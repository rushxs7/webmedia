<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $links = Link::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('shortener.index', ['links' => $links]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'link' => 'url'
        ]);

        $hashIds = new Hashids();

        // Shorten URL
        $link = Link::create([
            'user_id' => Auth::id(),
            'original_link' => $request->link
        ]);

        $link->hash = $hashIds->encode($link->id, 7);
        $link->save();

        return Redirect::route('shortener.index')->with('success', 'Shortened URL succesfully.');

        // Return with flash message
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        // Destroy link
        $link->delete();
        return Redirect::route('shortener.index')->with('success', 'Link deleted succesfully.');
    }
}
