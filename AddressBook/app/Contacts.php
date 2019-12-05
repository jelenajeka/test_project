<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Phones;

class Contacts extends Model
{
  protected $table = 'contacts';

  protected $fillable = ['firstname', 'lastname' ];
  public $timestamps = false;


  public function phones()
  {
    return $this->hasMany('App\Phones','contact_id','id');
  }
}
