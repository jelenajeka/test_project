@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h4 class="float-left">Add Contact</h4>
                  <a class="float-right"href="/contactlist">view contact list</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="/addContact" class="form form-group" method="POST">
                        @csrf
                        <table>
                          <tr>
                            <td><label class="formControlRange">First name:</label></td>
                          <td><input class="form-control" name="fistname" ></td>
                        </tr>
                        <tr>
                        <td><label class="formControlRange">Last name:</label></td>
                        <td><input class="form-control" name="lastname" ></td>
                      </tr>
                      <tr>
                        <td>
                          <select class="formControlRange">
                            <option value="" disabled selected>Choose number:</option>
                            <option name="type">Mobile:</option>
                            <option name="type">Home:</option>
                            <option name="type">Fax:</option>
                          </select>
                        </td>
                        <td><input class="form-control" name="number"></td>
                        <td><a href="" onclick="addNubmer()">Add number</a></td>
                        <td></td>
                      </tr>
                    </table>
                    <button class="form-control" type="submit">Dodaj</button>
                  </form>
                </div>
            </div>
        </div>


    </div>
</div>
<script>

</script>
@endsection
