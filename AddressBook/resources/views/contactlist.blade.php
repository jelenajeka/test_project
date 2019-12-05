@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h4 class="float-left">Contacts</h4>
                @auth
                  <a class="btn btn-primary float-right"href="/home">add contact</a>
                @endauth
              </div>

                <div class="card-body">
                  <table class="table table-hover">
                     <thead>
                       <tr>
                         <th>First Name:</th>
                         <th>Last Name</th>
                         <th>Numbers:</th>
                       </tr>
                     <tbody>
                         @foreach($contacts as $contact)
                         <tr>
                           <td>{{$contact->firstname}}</td>
                           <td>{{$contact->lastname}}</td>
                           <td>
                             <table>
                               <tbody>
                                 @foreach($contact['phones'] as $num)
                                 <tr>
                                   <td>{{$num->type}}</td>
                                   <td>{{$num->number}}</td>
                                 </tr>
                                 @endforeach
                               </tbody>
                             </table>
                           </td>
                         </tr>
                         @endforeach

                     </tbody>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
