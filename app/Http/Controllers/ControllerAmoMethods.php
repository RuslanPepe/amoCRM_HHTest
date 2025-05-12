<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ControllerAmoMethods extends Controller{

  public function handleAddWebHookAdd($request){
    $access_token = json_decode(Storage::get('amo_tokens.json'), true)['access_token'];
    $associationType = ['leads' => 'сделки', 'contacts' => 'контакта'];
    $typeHandle = array_keys($request)[1];
    $typeHandleAction = array_keys($request[$typeHandle])[0];

    if ($typeHandleAction == 'add'){
      logger($request);
      $item = $request[$typeHandle][$typeHandleAction][0];
      $userData = json_decode($this->requestUserURI($access_token, $item), true);

      $responsible = $userData['name'];
      $nameLeads = $item['name'];
      $createAtTime = date('d.m.y, G:i', $item['created_at']);
      $idLeadsNotes = $typeHandle == 'contacts' ? array_keys($item['linked_leads_id'])[0] : $item['id'];
      $this->requestPostNotes($access_token, "Название $associationType[$typeHandle]: $nameLeads,\nОтветственный: $responsible,\nДата создания $associationType[$typeHandle]: $createAtTime", $idLeadsNotes);
    }
  }

  public function requestUserURI($accessToken, $item){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://ura685105.amocrm.ru/api/v4/users/'.$item['responsible_user_id']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $accessToken,
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
  }

  public function requestPostNotes($accessToken, $text, $id){
    $entityType = 'leads';
    $apiUrl = "https://ura685105.amocrm.ru/api/v4/{$entityType}/{$id}/notes";
    $data = [
      [
        'note_type' => 'common',
        'params' => [
          'text' => $text
        ]
      ]
    ];

    $jsonData = json_encode($data);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json',
      'Authorization: Bearer '.$accessToken,
      'Content-Length: ' .strlen($jsonData)
    ]);
    curl_exec($curl);
    curl_close($curl);
  }
}
