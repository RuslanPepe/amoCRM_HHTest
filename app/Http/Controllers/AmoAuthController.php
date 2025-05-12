<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AmoAuthController extends Controller
{
  private $subdomain = 'ura685105';
  private $client_id = 'ae357ef2-ee1c-45c6-a2db-6604be53cf34';
  private $client_secret = 'xbNMMLPqNWqcGsEIxvXEVfQAXTINpB9oGUIVVxjOsrjfba6O7wmSIT8F22pC1Cbd';
  private $redirect_uri = 'https://estatetraderu.ru/oauth/callback';

  public function redirect()
  {
    $link = "https://{$this->subdomain}.amocrm.ru/oauth?client_id={$this->client_id}&state=123&mode=post_message&redirect_uri={$this->redirect_uri}";
    return redirect($link);
  }

  public function callback(Request $request)
  {
    $code = $request->query('code');

    $response = Http::post("https://{$this->subdomain}.amocrm.ru/oauth2/access_token", [
      'client_id'     => $this->client_id,
      'client_secret' => $this->client_secret,
      'grant_type'    => 'authorization_code',
      'code'          => $code,
      'redirect_uri'  => $this->redirect_uri,
    ]);

    Storage::put('amo_tokens.json', $response->body());

    return response("Токены сохранены");
  }
}
