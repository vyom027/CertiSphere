<?php

// use Webklex\PHPIMAP\ClientManager;

// require 'vendor/autoload.php'; // <-- this loads Composer packages

// $clientManager = new ClientManager();

// $client = $clientManager->make([
//     'host'          => 'mail.ljku.edu.in',
//     'port'          => 993,
//     'encryption'    => 'ssl',
//     'validate_cert' => true,
//     'username'      => '23004500210215@mail.ljku.edu.in',
//     'password'      => 'Vivek_2705', // 👈 enter the actual password
//     'protocol'      => 'imap'
// ]);

// try {
//     $client->connect();
//     echo "✅ Connected to mail.ljku.edu.in!";
// } catch (\Exception $e) {
//     echo "❌ Connection failed: " . $e->getMessage();
// }
$host = 'https://mail.ljku.edu.in'; // Zimbra server URL
$username = '23004500210215';       // Your Zimbra username
$password = 'Vivek_****';           // Your Zimbra password

// Step 1: Authentication
$authUrl = $host . '/service/soap';
$authData = json_encode([
    'account' => $username,
    'password' => $password
]);

$ch = curl_init($authUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $authData);
$response = curl_exec($ch);
curl_close($ch);

// Check the response and extract token
$authToken = json_decode($response, true)['authToken'];

// Step 2: Fetch Emails (GET Messages API)
$emailsUrl = $host . '/service/rest/messages';
$ch = curl_init($emailsUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: ' . $authToken
]);
$response = curl_exec($ch);
curl_close($ch);

// Display response or parse it
echo $response;
?>
