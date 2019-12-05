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
                           <button type="button" class="btn btn-link" data-bind='click: addNubmer, enable: phones().length < 25'>Add number</button>
                       </td>
                        <td><button  class="btn btn-secondary" type="submit">Add contact</button><td>
                      </tr>
                    </tbody>
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
                        <td>
                           <ul  data-bind="foreach: numbers">
                            <li style="list-style-type:none;"><label data-bind="text: type"/></li>
                            <li style="list-style-type:none;"><label data-bind="text: number"/></li>
                        </ul>
                      </td>
                        <td></td>
                        <td><button class="btn btn-link" data-bind="click: $parent.deleteContact">delete contact</button></td>
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
    // this.numbers = ko.observableArray(data.numbers.type, data.numbers.number);
    this.numbers = ko.observableArray(data.numbers);

   //  this.numbers = ko.observableArray(ko.utils.arrayMap(data.numbers, function(item){
   //        console.log(item);
   //     return new Number(item.type, item.number);
   // }));
  }
  function Number(data) {
    this.type = ko.observable(data.type);
    this.number = ko.observable(data.number);
  }

  // function Number(type, number) {
  //   var self = this;
  //   self.type = type;
  //   self.number = number;
  // }
  // function NumbersViewModel()
  // {
  //   var self = this;
  //   self.phones = ko.observableArray([]);
  //   self.addNumber = function(){
  //     self.phones.push(new Number("", ""));
  //     // console.log("radi");
  //   }
  // }

  function ContactsViewModel() {
    var self = this;
    self.contacts = ko.observableArray([]);
    self.numbers = ko.observableArray([]);
    self.phones = ko.observableArray([]);
    self.firstname = ko.observable();
    self.lastname = ko.observable();
    self.type = ko.observable();
    self.number = ko.observable();


    // self.addNumbers = function (data){
    //   console.log("data", data);
    //   self.numbers.push(new Number({ type: this.type(), number: this.number(),}));
    //   console.log(self.numbers());
    // }
    // for (var i = 0; i < self.numbers.length; i++) {
    //   self.addNumbers(self.numbers[i]);
    //   }

    self.addContact = function() {

      // self.contacts.push(new Contact( { firstname: this.firstname(), lastname: this.lastname(),
      //   numbers: ko.observableArray([{type: "", number: this.number()}])}));
        // console.log(self.contacts);


        // self.contacts.push(new Contact( { firstname: this.firstname(), lastname: this.lastname(),
        //   numbers: ko.observableArray([])}));


        self.phones.push(new Number( { type: this.type(), number: this.number(),}));
        console.log(self.phones);
        console.log(JSON.stringify(ko.toJS(self.phones())));
        self.contacts.push(new Contact( { firstname: this.firstname(), lastname: this.lastname(),
          numbers:this.phones()}));
          console.log(self.contacts);
          console.log(JSON.stringify(ko.toJS(self.contacts())));

        self.firstname("");
        self.lastname("");
        // self.type("");
        // self.number("");
    };
    self.deleteContact = function(contact) { self.contacts.remove(contact) };

 //    self.contacts = ko.observableArray(ko.utils.arrayMap(self.contacts, function(contact) {
 //     return {
 //         firstname: appearance.firstname,
 //         lastname: appearance.lastname,
 //         numbers: ko.observableArray()
 //     };
 // }));

    // self.addNumber = function(){
    //   self.numbers.push(new Number("", ""));
    //   console.log("radi");
    // };

    self.addNubmer = function(contact){
      contact.phones.push({type: ko.observable(""), number: ko.observable("")})
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
  // ko.applyBindings(new NumbersViewModel());


}
</script>
@endsection
