<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerAmoMethods extends ControllerHandleAmoMethods {

  public function handleWebHookAdd($request): void {
    $access_token = json_decode(Storage::get('amo_tokens.json'), true)['access_token'];
    $associationType = ['leads' => 'сделки', 'contacts' => 'контакта'];
    $typeHandle = array_keys($request)[1];
    $typeHandleAction = array_keys($request[$typeHandle])[0];

    $item = $request[$typeHandle][$typeHandleAction][0];
    $userData = json_decode($this->requestUserURI($access_token, $item), true);

    $responsible = $userData['name'];
    $nameLeads = $item['name'];
    $createAtTime = date('d.m.y, G:i', $item['created_at']);
    $idLeadsNotes = $typeHandle == 'contacts' ? array_keys($item['linked_leads_id'])[0] : $item['id'];
    $this->requestPostNotes($access_token, "Название $associationType[$typeHandle]: $nameLeads,\nОтветственный: $responsible,\nДата создания $associationType[$typeHandle]: $createAtTime", $idLeadsNotes);
  }

  public function handleWebHookUpdate($request): void{
//    $access_token = json_decode(Storage::get('amo_tokens.json'), true)['access_token'];
//    $associationType = ['leads' => 'сделки', 'contacts' => 'контакта'];
//    $typeHandle = array_keys($request)[1];
//    $typeHandleAction = array_keys($request[$typeHandle])[0];

    logger($request);
  }

}
