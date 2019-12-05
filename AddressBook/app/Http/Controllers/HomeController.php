<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Contacts;
use App\Phones;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
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
    public function contactlist()
    {
      // $contacts = Contacts::all();
      $contacts = Contacts::with('phones')->get();

      return view('contactlist', ['contacts' => $contacts]);

    }

    public function createContacts(Request $request)
    {
      if($request->ajax()){
        $contacts =  $request->all();
        $contact_data = array();
        // dd($contacts);
        foreach ($contacts['contacts'] as $contact) {
          $contact_data = [
             'firstname' => $contact['firstname'],
             'lastname'=> $contact['lastname'],
          ];

          if($c = Contacts::create($contact_data))
          {
            foreach ($contact['numbers'] as $num) {
              if(!empty($num['type']) && !empty($num['number']))
              {
                $phone= Phones::create([
                  'contact_id' => $c->id,
                  'type' => $num['type'],
                  'number' => $num['number'],
                ]);
                }
              }
        }
      }
      return 'create contacts';
    }
    return 'not create';
  }
}
