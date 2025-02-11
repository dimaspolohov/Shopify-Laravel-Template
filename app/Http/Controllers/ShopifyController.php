<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class ShopifyController extends Controller
{
    public function __construct()
    {
    }

    public function index(): Factory|View|Application
    {
        $store = Auth::user();
        return view('welcome', compact('store'));
    }
}
