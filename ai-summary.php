<?php

// In the year of our lord 2024, we crave for the machines dictating our lives.

session_start();

// Include database connection
require_once 'db.php';

require_once 'credentials.php'; // Must specify $OPENAI_API_KEY!

if (!isset($OPENAI_API_KEY)) {
    throw new Error('Missing $OPENAI_API_KEY!');
}

// Fetch user-specific data
$username = $_SESSION['username'];

// Fetch user ID if logged in
$userId = null;
if ($username) {
    $stmt = $pdo->prepare("SELECT id FROM coffee_users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $userId = $stmt->fetchColumn();
}

$stmt = $pdo->prepare("
    SELECT timestamp, type
    FROM coffee_entries
    WHERE user_id = :user_id AND DATE(timestamp) = CURDATE()
    ORDER BY timestamp ASC
");
$stmt->execute([':user_id' => $userId]);
$entries = $stmt->fetchAll();
$json = json_encode($entries);

// Send request to OpenAI
$url = 'https://api.openai.com/v1/chat/completions';
$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $OPENAI_API_KEY,
];

$data = [
    'model' => 'gpt-4o-mini',
    'messages' => [
        [
            'role' => 'system',
            'content' => "You're a snarky assistant who is evaluating people's caffeine intake.
You'll get JSON input that lists each coffee, energy drink and Wildkraut the user has consumed
(Wildkraut is some weird caffine-induced spice thingy you can inhale through the nose idk).

Generate a summary of 2-4 sentences that will be displayed to the user.
Make sure to roast people thoroughly if their intake is excessive and have fun with your judgement."
        ],
        [
            'role' => 'user',
            'content' => $json
        ],
    ],
    'max_tokens' => 200,
    'temperature' => 0.8,
];

// Set CURL options
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Get HTTP status code

if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch);
} elseif ($httpCode >= 400) {
    echo "HTTP Error: $httpCode\n";
    
    if ($response) {
        $errorResponse = json_decode($response, true);
        echo "Error Details: " . json_encode($errorResponse, JSON_PRETTY_PRINT) . "\n";
    }
} else {
    $responseDecoded = json_decode($response, true);

    if (isset($responseDecoded['choices'][0]['message']['content'])) {
        echo $responseDecoded['choices'][0]['message']['content'] . "\n";
    } else {
        echo "Unexpected Response Format:\n";
        print_r($responseDecoded);
    }
}

// Close cURL
curl_close($ch);