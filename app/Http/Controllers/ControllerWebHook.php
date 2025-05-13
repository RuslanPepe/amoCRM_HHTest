<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ControllerAmoMethods;
use Monolog\Logger;

class ControllerWebHook extends ControllerAmoMethods{
  public function handler(Request $request){
    date_default_timezone_set('Europe/Moscow');

    $typeHandle = array_keys($request->all())[1];
    $typeHandleAction = array_keys($request->all()[$typeHandle])[0];

    switch ($typeHandleAction){
      case 'add':
        $this->handleWebHookAdd($request->all());
        break;
      case 'update':
        if ($typeHandle == 'leads'){
          $this->handleWebHookUpdateLeads($request->all());
        }
        if ($typeHandle == 'contacts'){
          $this->handleWebhookUpdateContacts($request->all());
        }
    }
    return response()->json(['message' => 'Processed successfully'], 200);
  }
}
