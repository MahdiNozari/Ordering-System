<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $footer = Footer::first();
        return view('footer.index',compact('footer'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Footer $footer)
    {
        return view('footer.edit',compact('footer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Footer $footer)
    {
        $request->validate([
            'contact_address' => 'required|string',
            'contact_phone' => 'required|string',
            'contact_email' => 'required|email',
            'title' => 'required|string',
            'body' => 'required|string',
            'work_days' => 'required|string',
            'work_hour_from' => 'required|string',
            'work_hour_to' => 'required|string',
            'telegram_link' => 'string|nullable',
            'whatsapp_link' => 'string|nullable',
            'instagram_link' => 'string|nullable',
            'youtube_link' => 'string|nullable',
            'copyright' => 'required|string',
        ]);

        $footer->update([
            'contact_address' =>  $request->contact_address,
            'contact_phone' =>  $request->contact_phone,
            'contact_email' =>  $request->contact_email,
            'title' =>  $request->title,
            'body' =>  $request->body,
            'work_days' =>  $request->work_days,
            'work_hour_from' =>  $request->work_hour_from,
            'work_hour_to' =>  $request->work_hour_to,
            'telegram_link' =>  $request->telegram_link,
            'whatsapp_link' =>  $request->whatsapp_link,
            'instagram_link' =>  $request->instagram_link,
            'youtube_link' =>  $request->youtube_link,
            'copyright' =>  $request->copyright
        ]);

        return redirect()->route('footer.index')->with('success', 'تنظیمات بخش فوتر با موفقیت ویرایش شد');
    }
}
