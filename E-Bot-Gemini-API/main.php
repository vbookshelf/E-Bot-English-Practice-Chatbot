<?php
session_start();

include "php/name_config.php";
include "php/php_utils_revised.php";



// ERROR LOGGING
// Php errors are logged to a file named: php-errors.log
// This file will be automatically created the first time
// an error occurs.


// ADD YOUR GOOGLE API KEY
// Add your gemini API key to the ebot_config.ini.txt file.
// Change the file name from ebot_config.ini.txt to ebot_config.ini
// The ebot_config.ini file gets loaded in the php funtion that
// makes the API request.


// *** IMPORTANT SECURITY NOTE ***
// The ebot_config.ini file is currently located inside the website root folder.
// Please Secure your API Key by moving the ebot_config.ini file
// to a folder that's located outside your website root folder.
// Specify the path to the ebot_config.ini file here.

$path_to_config_ini = 'ebot_config.ini';


$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent";



//-----------
// Settings
//-----------

$temperature = 0.5;

$max_tokens = 300;






// If the message history session variable does NOT existt
if (!isset($_SESSION['message_history'])) {
	
	// Create a message_history list
	$_SESSION['message_history'] = array();
	$message_history = $_SESSION['message_history'];
	
	// Randomly set the chatbot's mood.
	// This stays the same for the entire session.
	$mood_list = array('bubbly', 'contemplative', 'cheerful');
	$length = count($mood_list);
	$limit = $length - 1; 
	$randomNumber = random_int(0, $limit); // the $limit is inclusive
	$mood = $mood_list[$randomNumber];
	
	// Remember: The system message is only set once in the message history.
	$_SESSION['emotion'] = $mood;
	
} else {
	
	// Assign the session variable
	$message_history = $_SESSION['message_history'];
	
	
	// Remember: The system message is only set once in the message history.
	$mood = $_SESSION['emotion'];
}





// This function cleans and secures the user input
function test_input(&$data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = strip_tags($data);
		//$data = htmlentities($data);
		
		return $data;
	}
	


// This code is triggered when the user submits a message.
// The form data arrives here via Ajax.
if (isset($_REQUEST["my_message"]) && empty($_REQUEST["robotblock"])) {
	
	
	
	// Initialize variables
	$corrected_user_message = "none";
	$translated_chat_agent_response = "none";
	
	
	// Check the status of the radio buttons
	if (isset($_REQUEST["speak1"])) {
		$speak_request = 'selected';
	} else {
		$speak_request = 'not_selected';	
	}
	
	if (isset($_REQUEST["correct1"])) {
		$correction_request = 'selected';
	} else {
		$correction_request = 'not_selected';	
	}
	
	if (isset($_REQUEST["translate1"])) {
		$translation_request = 'selected';
	} else {
		$translation_request = 'not_selected';	
	}
	
	
	
	// Get the user's first language
	$translation_language = $_REQUEST["user_language"];
	
	
	// Get the user's message
	$user_message = $_REQUEST["my_message"];
	
	
	// Clean and secure the user's text input
	$user_message = test_input($user_message);
	
	
	
	
	
	
	//---------------------
	// Run the chat agent
	//---------------------
	// Creates the responses to
	// the users chat messages
	
	
// Chat Agent
$chat_agent_system_message = <<<EOT
You don't have a name. Engage in casual conversation with the user. Don't behave like an assistant. Don't use emojis. Be kind and encouraging. You are {$mood}. You use simple words and phrases that a child would understand. You don't use discourse markers like "aw" "shucks" and "um".
EOT;

	
	$my_message1 = array("text" => $user_message);
	$parts_list = array();
	$parts_list[] = $my_message1;
	$message_history[] = array("role" => "user", "parts" => $parts_list);
	
	$chat_agent_response_list = run_agent_with_memory($chat_agent_system_message, $message_history);
	// This response is always plain text
	$chat_agent_response = $chat_agent_response_list[1];
	
	// This text will be spoken out loud
	$text_to_speak = test_input($chat_agent_response);
	
	// Update the chat history
	$message_dict = array("text" => $chat_agent_response);
	$parts_list = array();
	$parts_list[] = $message_dict;
	$message_history[] = array("role" => "model", "parts" => $parts_list);
	
	$_SESSION['message_history'] = $message_history;
	
	
	
	
	
	
	//---------------------------
	// Run the proofreader agent
	//---------------------------
	// Checks the user message for errors
	
	
	if ($correction_request == 'selected' && $user_message != 'api_error' && $user_message != 'Sorry. Something went wrong. Please try again.') {
		
// Proofreader Agent 
$proofreader_agent_system_message = <<<EOT
You are a highly skilled english proofreader. You will be given text delimited by triple hash tags (###). You task is to correct the spelling, punctuation and grammar errors. Think step by step. Return your corrected text. If the original text does not contain any errors then respond with: "---". 
	Respond in a consistent format. Output a JSON string with the following schema:
{
"correction": <"Your corrected version of the user_message or '---'.">
}
	
EOT;
		
		// Remove any html	
		$user_message = strip_tags($user_message);
		
		$text_to_proofread = "###" . $user_message . "###";
		$corrected_user_message_list = run_agent_without_memory($proofreader_agent_system_message, $text_to_proofread);
		
		// Process the response
		if ($corrected_user_message_list[0] != "is_plain_text") {
			// It is json
			$corrected_user_message = $corrected_user_message_list[1]["correction"];
		} else {
			// It is plain text
			$corrected_user_message = $corrected_user_message_list[1];
		}
		
	
	} else {
		
		$corrected_user_message = 'none';
		
	}
	
	
	
	
	//---------------------------
	// Run the translation agent
	//---------------------------
	// Translates the chat agent's response
	// into the user's first language.

	
	if ($translation_request == 'selected' && $user_message != 'api_error' && $user_message != 'Sorry. Something went wrong. Please try again.') {
			
		
// Translation Agent
$translation_agent_system_message = <<<EOT
You are a highly skilled {$translation_language} translator. You will be given text. You task is to translate the text into {$translation_language}. Return your translated text.
	Respond in a consistent format. Output a JSON string with the following schema:
{
"translation": "<Your translated version of the text.>"
}
	
EOT;
		
		// Remove any html
		$chat_agent_response = strip_tags($chat_agent_response);
		
		$translated_chat_agent_response_list = run_agent_without_memory($translation_agent_system_message, $chat_agent_response);
		
		
		// Process the response
		if ($translated_chat_agent_response_list[0] != "is_plain_text") {
			// It is json
			$translated_chat_agent_response = $translated_chat_agent_response_list[1]["translation"];
		} else {
			// It is plain text
			$translated_chat_agent_response = $translated_chat_agent_response_list[1];
		}
	
	} else {
		
		$translated_chat_agent_response = 'none';
		
	}
	
	
	
	
	
	//------------------------
	// Create the output text
	//------------------------
	// This is sent to the main 
	// web page via Ajax.
	
	
	
	$response = array('success' => true, 
		'translation_language' => $translation_language, 
		'check_variable' => $mood, 
		'text_to_speak' => $text_to_speak, 
		'speak_status' => $speak_request,
		'chat_text' => $chat_agent_response, 
		'corrected_text' => $corrected_user_message,
		"translated_text" => $translated_chat_agent_response);
	
  	echo json_encode($response);
	
	
}

?>