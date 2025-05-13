<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerAmoMethods extends ControllerHandleAmoMethods {

  public function handleWebHookAdd($request): void {
    $associationType = ['leads' => 'сделки', 'contacts' => 'контакта'];
    $typeHandle = array_keys($request)[1];
    $typeHandleAction = array_keys($request[$typeHandle])[0];

    $item = $request[$typeHandle][$typeHandleAction][0];
    $userData = json_decode($this->requestUserURI($item), true);
    if ($typeHandle == 'leads'){
      $this->LeadsDbWrite($item);
    }

    $responsible = $userData['name'];
    $nameLeads = $item['name'];
    $createAtTime = date('d.m.y, G:i', $item['created_at']);
    $idLeadsNotes = $typeHandle == 'contacts' ? array_keys($item['linked_leads_id'])[0] : $item['id'];
    $this->requestPostNotes("Название $associationType[$typeHandle]: $nameLeads,\nОтветственный: $responsible,\nДата создания $associationType[$typeHandle]: $createAtTime", $idLeadsNotes);
  }

  public function handleWebHookUpdateLeads($request): void{
    $typeHandle = array_keys($request)[1];
    $typeHandleAction = array_keys($request[$typeHandle])[0];

    $item = $request[$typeHandle][$typeHandleAction][0];
    $changed = $this->LeadsDbRead($item);
    $this->LeadsDbChange($item);
    $name = $changed['name'] ? "Название сделки: $item[name]\n" : '';
    $price = $changed['price'] ? "Прайс: $item[price]\n" : '';
    $createAtTime = 'Время: '.date('d.m.y, G:i', $item['created_at']);
    $item['responsible_user_id'] = 123;
    $responsible = '';
    if ($changed['responsible_user_id']){
      $req = $this->requestUserURI($item['responsible_user_id']);
      $responsible = "Ответственный: $req\n";
    }
    $text = "$name $price $responsible $createAtTime";
    if ($name || $price || $responsible){
      $this->requestPostNotes($text, $item['id']);
    }
  }

  public function handleWebhookUpdateContacts($request): void{
    $typeHandle = array_keys($request)[1];
    $typeHandleAction = array_keys($request[$typeHandle])[0];
    $item = $request[$typeHandle][$typeHandleAction];
    $createAtTime = 'Время: '.date('d.m.y, G:i', $item[0]['updated_at']);
    $text = "Название контакта: ".$item[0]['name']."\n";
    for ($i = 0; $i < count($item[0]['custom_fields']); $i++) {
      $text .= $item[0]['custom_fields'][$i]['name'].': '.$item[0]['custom_fields'][$i]['values'][0]['value']."\n";
    }
    $text .= $createAtTime;
    $this->requestPostNotes($text, array_keys($item[0]['linked_leads_id'])[0]);
  }
}










