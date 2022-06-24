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
        try {
            $valid = validator([
                'url' => urldecode($request->get('url')),
            ], ['url' => ['required', 'url']])->validate();

            $embed = EmbedManager::url($valid['url'])->get();

            return view('embed::preview', ['embed' => $embed]);
        } catch (\Throwable $exception)
        {
            return view('embed::error', ['exception' => $exception]);
        }
    }
}