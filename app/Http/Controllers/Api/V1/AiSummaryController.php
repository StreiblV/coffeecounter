<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\Types\Boolean;

class AiSummaryController extends Controller
{
    public function generateSummary(Request $request)
    {
        $debug = true;
        try {
            // Fetch OpenAI API key
            $apiKey = config('services.openai.key');
            if (!$apiKey) {
                return response()->json(['error' => 'Missing OpenAI API Key'], 500);
            }

            // Dummy data for testing
            $input = json_encode([
                ['timestamp' => now()->toDateTimeString(), 'type' => 'coffee'],
                ['timestamp' => now()->subMinutes(30)->toDateTimeString(), 'type' => 'wildkraut'],
            ]);

            // Prepare the payload
            $payload = [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You're a snarky assistant evaluating caffeine intake."
                    ],
                    [
                        'role' => 'user',
                        'content' => $input,
                    ],
                ],
                'max_tokens' => 200,
                'temperature' => 0.8,
            ];

            // Call OpenAI API
            if ($debug == true){
                $response = Http::withToken($apiKey)
                    ->withOptions(['verify' => false]) // Disable SSL verification
                    ->post('https://api.openai.com/v1/chat/completions', $payload);
            }else{
                $response = Http::withToken($apiKey)
                    ->post('https://api.openai.com/v1/chat/completions', $payload);
            }

            if ($response->failed()) {
                return response()->json([
                    'error' => 'OpenAI API call failed',
                    'details' => $response->json(),
                ], $response->status());
            }

            // Extract summary
            $summary = $response->json('choices.0.message.content');
            return response()->json(['summary' => $summary]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
