<?php
// chatbot.php

header('Content-Type: application/json');

// Your OpenAI API key
$apiKey = 'YOUR API KEYS';


// Load website data from JSON


// Receive the user input from the AJAX request
$userInput = $_POST['user_input'] ?? 'Hello';

// OpenAI chat completion endpoint
$apiUrl = 'https://api.openai.com/v1/chat/completions';

// Data for the API request
$postData = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        [
            'role' => 'system',
            'content' => 'answers should be based only on gym and workouts. If user ask anything unrelated to this, ignore the question polietly. Start with, I am your AI Personal Trainer. Give output in html code. this goes as a message so if you give html code with p, li and other tags it will be great. Always give content with html'
        ],
        [
            'role' => 'user',
            'content' => $userInput
        ]
    ]
];

// Initialize cURL session
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);

// Execute the request
$response = curl_exec($ch);

// Close the cURL session
curl_close($ch);

// Decode the response
$responseData = json_decode($response, true);

// Check for errors and log them
if (!$responseData) {
    error_log('API request failed: ' . $response);
    echo json_encode(['message' => 'The chatbot is currently unavailable.']);
    exit;
}

// Extract the chatbot's message from the response
$botMessage = $responseData['choices'][0]['message']['content'] ?? 'Sorry, I am unable to respond at the moment.';

// Send the response back to the client
echo json_encode(['message' => $botMessage]);
