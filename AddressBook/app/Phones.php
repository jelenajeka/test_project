<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Contacts;

class Phones extends Model
{
  protected $table = 'phones';

  protected $fillable = ['contact_id', 'type', 'number' ];
  public $timestamps = false;


}
