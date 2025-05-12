<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerHandleAmoMethods extends Controller{
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
