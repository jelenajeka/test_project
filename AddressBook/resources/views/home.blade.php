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

                  <form data-bind="submit: addContact">
                    <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>First name:</th>
                        <th>Last name</th>
                        <!-- <th>Type phone number:</th> -->
                        <th>Phone numbers:</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input class="form-control" data-bind="value: firstname" required /></td>
                        <td><input class="form-control" data-bind="value: lastname" required /></td>
                        <!-- <td><select class="form-control" data-bind="options: $root.availableTypes, value: type, optionsText: 'type'"></select></td> -->
                        <td>
                          <table>
                              <thead>
                                <tr>
                                  <th>Type Phone Number:</th>
                                  <th>Number:</th>
                                </tr>
                              </thead>
                               <tbody data-bind="foreach: phones">
                                   <tr>
                                       <td><input class="form-control" data-bind='value: type' /></td>
                                       <td><input class="form-control" data-bind='value: number'/></td>
                                       <td><a class="btn btn-link" href='#' data-bind='click: $root.deleteNumber'>Delete number</a></td>
                                   </tr>
                               </tbody>
                           </table>
                           <button type="button" class="btn btn-link" data-bind='click: addNubmer, enable: phones().length < 10'>Add number</button>
                       </td>
                        <td><button  class="btn btn-secondary" type="submit">Add contact</button><td>
                      </tr>
                    </tbody>
                  </form>

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
                        <th>Numbers:</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody data-bind="foreach: contacts, visible: contacts().length > 0">
                      <tr>
                        <td><input class="form-control" data-bind="value: firstname" disabled/></td>
                        <td><input class="form-control" data-bind="value: lastname" disabled/></td>
                        <td>
                           <ul  data-bind="foreach: numbers">
                            <li style="list-style-type:none;"><label data-bind="text: type"/>:</li>
                            <!-- <li style="list-style-type:none;"><label data-bind="text: number"/></li> -->
                          </ul>
                      </td>
                        <td>
                          <ul  data-bind="foreach: numbers">
                            <li style="list-style-type:none;"><label data-bind="text: number"/></li>
                          </ul>
                        </td>
                        <td><button class="btn btn-link" data-bind="click: $parent.deleteContact">delete contact</button></td>
                      </tr>
                    </tbody>
                </table>


                <button  class="btn btn-secondary btn-lg btn-block" data-bind="click: saveContacts, enable: $root.contacts().length > 0">Save contacts</button>
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
    this.numbers = ko.observableArray(data.numbers);
  }

  function Number(data) {
    this.type = ko.observable(data.type);
    this.number = ko.observable(data.number);
  }


  function ContactsViewModel() {
    var self = this;
    self.contacts = ko.observableArray([]);
    self.phones = ko.observableArray([]);
    self.firstname = ko.observable();
    self.lastname = ko.observable();
    self.type = ko.observable();
    self.number = ko.observable();


    self.addContact = function() {

      self.phones.push(new Number( { type: this.type(), number: this.number(),}));
      console.log(self.phones);
      console.log(JSON.stringify(ko.toJS(self.phones())));
      // self.phones("","");
      self.contacts.push(new Contact( { firstname: this.firstname(), lastname: this.lastname(),
        numbers: this.phones()}));
        console.log(self.contacts);
        console.log(JSON.stringify(ko.toJS(self.contacts())));

      self.firstname("");
      self.lastname("");
      self.phones([]);
    };
    self.deleteContact = function(contact) { self.contacts.remove(contact) };

    self.addNubmer = function(contact){
      // contact.phones.push({type: ko.observable(""), number: ko.observable("")});
      contact.phones.push(new Number("",""));
      console.log('add row number');
    };


    self.deleteNumber = function(phone) { self.phones.remove(phone) };

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
