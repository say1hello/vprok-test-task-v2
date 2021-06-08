<?php

namespace App\Http\Controllers\Api;

use App\Models\ShortLink;
use App\Http\Requests\ShortLinkRequest;

class ShortLinkController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ShortLink::all();
    }

    /**
     * @param string $code
     * @return array
     */
    public function show(string $code)
    {
        $link = ShortLink::where('code', $code)->firstOrFail()->link;

        return ['data' => $link];
    }

    /**
     * @param ShortLinkRequest $request
     * @return mixed
     */
    public function store(ShortLinkRequest $request)
    {
        $requestData = $request->validated();

        if ($shortLink = ShortLink::where('link', $requestData['link'])->first()) {
            $code = $shortLink->code;
        } else {
            $input['link'] = $requestData['link'];
            $input['code'] = ShortLink::generateUniqueID();
            $code = ShortLink::create($input)->code;
        }

        return ['data' => route('shorten.link', $code)];
    }
}
