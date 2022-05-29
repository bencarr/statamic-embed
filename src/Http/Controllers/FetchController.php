<?php

namespace BenCarr\Embed\Http\Controllers;

use BenCarr\Embed\Actions\FetchEmbed;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FetchController extends Controller
{
    use ValidatesRequests;

    public function index(Request $request)
    {
        $valid = validator([
            'url' => urldecode($request->get('url')),
        ], ['url' => ['required', 'url']])->validate();

        return FetchEmbed::url($valid['url'])->get();
    }
}