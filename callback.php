<?php

// Menerima input dalam bentuk json
$input = file_get_contents("php://input");

// decode json menjadi array
$json_input = json_decode($input, TRUE);

$type = $json_input['type'];

switch ($type) {
    case 'message':
        // lakukan aksi
        break;

    case 'image':
        // lakukan aksi
        break;

    case 'video':
        // lakukan aksi
        break;

    case 'audio':
        // lakukan aksi
        break;

    case 'document':
        // lakukan aksi
        break;

    case 'location':
        // lakukan aksi
        break;

    case 'live_location':
        // lakukan aksi
        break;

    case 'sticker':
        // lakukan aksi
        break;

    case 'contact':
        // lakukan aksi
        break;
}
