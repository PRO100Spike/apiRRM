<?php

require_once __DIR__ .'/src/VotesApi.php';

try {
    $api = new VotesApi();
    echo $api->run();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}