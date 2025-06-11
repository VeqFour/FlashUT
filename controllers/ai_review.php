<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable('/Applications/XAMPP/xamppfiles/htdocs/FlashUT/config');
$dotenv->load();

// Force set the env value globally (required in some local setups)
putenv("OPENAI_API_KEY=" . $_ENV['OPENAI_API_KEY']);

use OpenAI\Client;

function reviewFlashcardWithAI($courseName, $question, $answer, $similarExamples = "") {
   try {
       $client = OpenAI::client(getenv("OPENAI_API_KEY"));

       $prompt = <<<EOT
       A student submitted the following flashcard for the course "$courseName".
       Submitted:
       Question: "$question"
       Answer: "$answer"
       These are some existing flashcards in the system:
       $similarExamples
       Your job:
       1. First, check if this flashcard is clearly relevant to the course "$courseName".
          - ❗ If it is NOT relevant, stop immediately and reply with the reason, followed by: "Verdict: Reject", If it IS relevant, then continue.
       2. Check if the question is clear and the answer is relevant to the question.
          - ❗ If it is NOT relevant, stop immediately and reply with the reason, followed by: "Verdict: Reject", If it IS relevant, then continue.
       3. Check if it's exactly similar to existing flashcards.
          - ❗ If it is too much similar, stop immediately and reply with the reason, followed by: "Verdict: Reject" and the flashcard existed from "$similarExamples", If it IS not similar, then continue.
       4. If passed all three previous conditions, provide helpful feedback, followed by: "Verdict: Approve".
       5. Always end with either: "Verdict: Approve" or "Verdict: Reject".
       EOT;

       $response = $client->chat()->create([
           'model' => 'gpt-4o',
           'messages' => [
               ['role' => 'system', 'content' => 'You are a helpful flashcard reviewer AI.'],
               ['role' => 'user', 'content' => $prompt],
           ],
       ]);

       return $response->choices[0]->message->content;

      } catch (Exception $e) {
         $errorMsg = "❌ AI Review Error: " . $e->getMessage();
         error_log($errorMsg); // ✅ Write to XAMPP error log
         return $errorMsg;
     }
}