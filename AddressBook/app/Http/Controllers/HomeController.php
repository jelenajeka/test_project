<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contacts;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function createContacts(Request $request)
    {
      $contacts =  $request->all();
      $contact_data = array();
      // dd($contacts);
      foreach ($contacts['contacts'] as $contact) {
        $contact_data = [
           'firstname' => $contact['firstname'],
           'lastname'=> $contact['lastname'],
        ];
        $c = Contacts::create($contact_data);
      }
      return 'create contacts';
    }
}
