<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('front.pages.about');
    }

    public function contact()
    {
        return view('front.pages.contact');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required|min:10'
        ]);

        // Burada mesaj gönderme işlemleri yapılacak
        // Mail::to('info@site.com')->send(new ContactForm($request->all()));

        return back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }

    public function privacy()
    {
        return view('front.pages.privacy');
    }

    public function terms()
    {
        return view('front.pages.terms');
    }

    public function faq()
    {
        return view('front.pages.faq');
    }

    public function shipping()
    {
        return view('front.pages.shipping');
    }

    public function return()
    {
        return view('front.pages.return');
    }

    public function help()
    {
        return view('front.pages.help');
    }
} 