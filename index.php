<?php

  $accessToken = "EAAJTC6sof2wBACGf5fYprTX2fqKz5Ckr80OuHtaXOJeBZAfqHZCySZAreC1MsDMjnQKucHLV1MMKVQiRxeIgyVjvV6JGCLa6nXzM7vO8WqZC2dCKN1VzESxAi1l7ULUEFO9W3Wow1v5Ayf2qvMbEZBr5zmF1hAtRDhoAFxmStJwZDZD";

  if(isset($_REQUEST['hub_challenge'])){
    $challenge = $_REQUEST['hub_challenge'];
    $token = $_REQUEST['hub_verify_token'];
  }
  if($token == "psToken1234#"){
    echo $challenge;
  }

  $input = json_decode(file_get_contents('php://input'), true);

  $userID = $input['entry'][0]['messaging'][0]['sender']['id'];

  $message = $input['entry'][0]['messaging'][0]['message']['text'];

  $reply = "I don't understand. Ask me to tell a joke. ;-)";

  if(preg_match('/(send|tell|text)(.*?)joke/', $message)){
    $res = json_decode(file_get_contents('http://api.icndb.com/jokes/random'), true);
    $reply = $res['value']['joke'];
  }


    $url = "https://graph.facebook.com/v2.6/me/messages?access_token=$accessToken";

    $jsonData = "{
      'recipient': {
        'id': '$userID'
      },
      'message': {
        'text': '$reply'
      }
    }";

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    if(!empty($input['entry'][0]['messaging'][0]['message'])){
      curl_exec($ch);
      //..........
    }
 ?>
