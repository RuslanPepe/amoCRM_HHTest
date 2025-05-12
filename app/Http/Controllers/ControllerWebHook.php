<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ControllerAmoMethods;

class ControllerWebHook extends ControllerAmoMethods{
  public function handler(Request $request){
    $json = Storage::get('amo_tokens.json');
    $data = json_decode($json, true);
    $access_token = $data['access_token'] ?? null;
    date_default_timezone_set('Europe/Moscow');
    response()->json(['status' => 'OK'], 200)->send();

    $typeHandle = array_keys($request)[1];
    $typeHandleAction = array_keys($request[$typeHandle])[0];

    switch ($typeHandleAction){
      case 'add':
        $this->handleAddWebHookAdd($request->all());
        break;
      case 'update':
        $this->handleAddWebHookUpdate($request->all());
    }



  }
}
