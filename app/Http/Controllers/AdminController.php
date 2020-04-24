<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('admin.home');
    }

    public function scrapping() {
    	$client=new Client();
    	$crawler=$client->request('GET', 'https://www.vestuariolaboral.com');

        dd($crawler);
    }
}