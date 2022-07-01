<?php

namespace BenCarr\Embed\Http\Controllers;

use BenCarr\Embed\Actions\EmbedManager;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PreviewController extends Controller
{
    use ValidatesRequests;

    public function index(Request $request)
    {
        $valid = validator([
            'url' => urldecode($request->get('url')),
        ], ['url' => ['required', 'url']])->validate();

        $embed = EmbedManager::url($valid['url'])->get();

        if ( ! $embed) {
            return view('embed::error');
        }

        return view('embed::preview', ['embed' => $embed]);
    }
}