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
                  <button class="btn btn-secondary float-right" data-bind='click: addContact'>Add new contact</button>

                      <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>First name:</th>
                          <th>Last name</th>
                          <th>Phone numbers:</th>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody data-bind="foreach: contacts">
                        <tr>
                          <td><input class="form-control" data-bind='value: firstname'  /></td>
                          <td><input class="form-control" data-bind='value: lastname'  /></td>
                          <td>
                            <table>
                              <thead>
                                <tr>
                                  <th>Type Phone Number:</th>
                                  <th>Number:</th>
                                </tr>
                              </thead>
                                 <tbody data-bind="foreach: numbers">
                                     <tr>
                                         <td><input class="form-control" data-bind='value: type' placeholder="Type phone number" /></td>
                                         <td><input type="text" oninput="this.value=this.value.replace(/[^0-9, - , . , + , / , _]/g,'');" class="form-control" data-bind='value: number'/></td>
                                         <td><button class="btn btn-link" href='#' data-bind='click: $root.deleteNumber'>Delete number</button></td>
                                     </tr>
                                 </tbody>
                             </table>
                             <button href="#" type="button" class="btn btn-link" data-bind='click: $root.addNubmer'>Add number</button>
                         </td>
                         <td><a href='#' data-bind='click: $root.deleteContact'>Delete contact</a><td>
                        </tr>
                      </tbody>
                    </table>


                <div class="card-footer">
                    <button  class="btn btn-secondary btn-lg btn-block" data-bind="click: saveContacts, enable: $root.contacts().length > 0">Save contacts</button>
                </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
window.onload = function(){

  function ContactsViewModel(contacts) {
      var self = this;
      self.contacts = ko.observableArray(ko.utils.arrayMap(contacts, function(contact) {
        return { firstname: contact.firstname, lastname: contact.lastname, numbers: ko.observableArray(contact.numbers) };
    }));

    self.addContact = function() {
        self.contacts.push({ firstname: "", lastname: "", numbers: ko.observableArray() });
    };

    self.deleteContact = function(contact) {
        self.contacts.remove(contact);
    };
    self.addNubmer = function(contact) {
        contact.numbers.push({ type: "", number: "" });
    };

    self.deleteNumber = function(phone) {
        $.each(self.contacts(), function() { this.numbers.remove(phone) })
    };

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
              location.reload();
           },
           error: function(result) {
               console.log(result);
          }
       });
     };
  }

  ko.applyBindings(new ContactsViewModel());
}
</script>
@endsection
