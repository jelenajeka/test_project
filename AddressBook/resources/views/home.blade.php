@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h4 class="float-left">Add Contact</h4>
                  <a class="btn btn-primary float-right" href="/contactlist">View contact list</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- <form action="/addContact" class="form form-group" method="POST">
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
                  </form> -->

                  <form data-bind="submit: addContact">
                    <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>First name:</th>
                        <th>Last name</th>
                        <th>Choose number:</th>
                        <th>Number:</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input class="form-control" data-bind="value: firstname" /></td>
                        <td><input class="form-control" data-bind="value: lastname" /></td>
                        <!-- <td><select class="form-control" data-bind="options: $root.availableTypes, value: type, optionsText: 'type'"></select></td> -->
                        <td><td>
                        <td><button  class="btn btn-secondary" type="submit">Add contact</button><td>
                      </tr>
                  </form>
                  <button class="btn btn-link" type="button" name="button" onclick="izlistaj()">izlistaj</button>

                  <!-- <ul data-bind="foreach: contacts, visible: contacts().length > 0">
                      <li>
                          <input data-bind="value: firstname" />
                          <input data-bind="value: lastname" />
                      </li>
                  </ul> -->



                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>First name:</th>
                        <th>Last name</th>
                        <th>Choose number:</th>
                        <th>Number:</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody data-bind="foreach: contacts, visible: contacts().length > 0">
                      <tr>
                        <td><input class="form-control" data-bind="value: firstname" disabled/></td>
                        <td><input class="form-control" data-bind="value: lastname" disabled/></td>
                        <td><td>
                        <td><td>
                        <td><button class="btn btn-link"data-bind="click: $parent.deleteContact">delete contact</button></td>
                      </tr>
                    </tbody>
                </table>


                <button  class="btn btn-secondary btn-lg btn-block" data-bind="click: saveContacts">Save contacts</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.onload = function(){

  function Contact(data) {
    this.firstname = ko.observable(data.firstname);
    this.lastname = ko.observable(data.lastname);
  }

  function ContactsViewModel() {
    var self = this;
    self.contacts = ko.observableArray([]);
    self.firstname = ko.observable();
    self.lastname = ko.observable();

    self.availableTypes = [
        { type: "Mobile",  },
        { type: "Home", },
        { type: "Fax",  }
    ];
    self.addContact = function() {
        self.contacts.push(new Contact( { firstname: this.firstname(), lastname: this.lastname()},));

        console.log(JSON.stringify(ko.toJS(self.contacts())));
        self.firstname("");
        self.lastname("");
    };
    self.deleteContact = function(contact) { self.contacts.remove(contact) };

    self.saveContacts = function(){
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax("/createContacts", {
           data: ko.toJSON({ contacts: self.contacts }),
           type: "post",
           contentType: "application/json",
           success: function(result) {
             console.log(result);
            }
       });
    };

  }



  ko.applyBindings(new ContactsViewModel());

}
</script>
@endsection
