<?php

const CLIENT_ID = '1234';
const CLIENT_SECRET = '1235';
const API_SCOPES = 'read';
const AUTH_URL = 'https://api.example.com/oauth2/auth';
const TOKEN_URL = 'https://api.example.com/oauth2/token';
const API_URL = 'https://api.example.com/user';
const REDIRECT_URI = 'http://localhost:8080';;

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $token = getAccessToken($code);
    $data = getData($token);
    echo "Retrieved data: " . $data;
} else {
    $authorizationUrl = getAuthorizationUrl();

    header('Location: ' . $authorizationUrl);
    exit;
}

function getAuthorizationUrl(): string
{
    $params = [
        'client_id' => CLIENT_ID,
        'redirect_uri' => REDIRECT_URI,
        'response_type' => 'code',
        'scope' => API_SCOPES,
    ];

    return AUTH_URL . '?' . http_build_query($params);
}

function getAccessToken($code)
{
    $data = [
        'grant_type' => 'authorization_code',
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'redirect_uri' => REDIRECT_URI,
        'code' => $code,
    ];

    $ch = curl_init(TOKEN_URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    $tokenData = json_decode($response, true);

    if (isset($tokenData['access_token'])) {
        return $tokenData['access_token'];
    } else {
        echo "Error: Failed to retrieve access token";
        exit;
    }
}

function getData(string $accessToken): bool|string
{
    $ch = curl_init(API_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $accessToken,
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
