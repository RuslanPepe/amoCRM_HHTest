<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model{
  protected $table = 'leads';

  protected $fillable = [
    'lead_id',
    'name',
    'price',
    'responsible_user_id',
  ];

  public static function findLeadId($leadId){
    return self::where('lead_id', $leadId)->first();
  }
}
