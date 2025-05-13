<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ControllerHandleAmoMethods extends Controller{
  public function requestUserURI($item){
    $accessToken = json_decode(Storage::get('amo_tokens.json'), true)['access_token'];
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

  public function requestPostNotes($text, $id){
    $accessToken = json_decode(Storage::get('amo_tokens.json'), true)['access_token'];
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

  public function LeadsDbWrite($item){
    $query = DB::table('leads')->insert([
      'leadId' => $item['id'],
      'name' => $item['name'],
      'price' => $item['price'],
      'responsibleUserId' => $item['responsible_user_id'],
    ]);
  }
  public function LeadsDbRead($item){
    $req = DB::table('leads')->where('leadId', $item['id'])->first();
    return [
      'name' => $item['name'] !== $req->name,
      'price' => $item['price'] !== $req->price,
      'responsible_user_id' => $item['responsible_user_id'] !== $req->responsibleUserId,
    ];
  }
  public function LeadsDbChange($item){
     DB::table('leads')->where('leadId', $item['id'])->update([
      'name' => $item['name'],
      'price' => $item['price'],
      'responsibleUserId' => $item['responsible_user_id'],
    ]);
  }
}

