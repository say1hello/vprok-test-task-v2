<?php

namespace App\Http\Controllers;

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
        $shortLinks = ShortLink::latest()->get();

        return view('shortenLink', compact('shortLinks'));
    }

    /**
     * @param ShortLinkRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ShortLinkRequest $request)
    {
        $requestData = $request->validated();

        if (ShortLink::where('link', $requestData['link'])->first()) {
            return redirect('generate-shorten-link')
                ->with('success', 'Shorten Link already exist!');
        }

        $input['link'] = $requestData['link'];
        $input['code'] = ShortLink::generateUniqueID();

        ShortLink::create($input);

        return redirect('generate-shorten-link')
            ->with('success', 'Shorten Link Generated Successfully!');
    }

    /**
     * @param string $code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function shortenLink(string $code)
    {
        return redirect(ShortLink::where('code', $code)->firstOrFail()->link);
    }
}
