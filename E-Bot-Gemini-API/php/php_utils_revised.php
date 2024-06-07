<?php

/**
 * Load configuration from a file
 *
 * @param string $file The configuration file path
 * @return array The parsed configuration
 * @throws Exception if the file does not exist
 */
function load_config($file) {
    if (!file_exists($file)) {
        throw new Exception("Configuration file not found: $file");
    }
    return parse_ini_file($file, true);
}



/**
 * Make an API call
 *
 * @param string $system_message The system message
 * @param array $message_history The message history
 * @return array|string The API response or an error message
 */
function make_api_call($system_message, $message_history) {
    global $path_to_config_ini;
    global $url;
    global $temperature;
    global $max_tokens;

    $timestamp = date('Y-m-d H:i:s');
    $file_path = "php-errors.log";

    try {
        $config = load_config($path_to_config_ini);
    } catch (Exception $e) {
        error_log($timestamp . ' ' . $e->getMessage(), 3, $file_path);
        return 'Failed to load configuration.';
    }

    $apiKey = $config['api']['API_KEY'] ?? '';
    if (empty($apiKey) || empty($url)) {
        error_log($timestamp . ' API key or URL not configured properly.', 3, $file_path);
        return 'API key or URL not configured properly.';
    }

    $system_instruction = [
        "parts" => [
            "text" => $system_message
        ]
    ];
    $generationConfig = [
        "temperature" => $temperature,
        "maxOutputTokens" => $max_tokens,
    ];
    $data = [
        "system_instruction" => $system_instruction,
        "contents" => $message_history,
        "generationConfig" => $generationConfig
    ];
    $headers = [
        "x-goog-api-key: {$apiKey}",
        "Content-Type: application/json"
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if (curl_errno($curl)) {
        error_log($timestamp . ' cURL error: ' . curl_error($curl), 3, $file_path);
        curl_close($curl);
        return 'api_error';
    }

    if ($httpStatusCode >= 400) {
        error_log($timestamp . ' HTTP error: ' . $httpStatusCode . ' - Response: ' . $result, 3, $file_path);
        curl_close($curl);
        return 'api_error';
    }

    curl_close($curl);

    $decodedResult = json_decode($result, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log($timestamp . ' JSON decode error: ' . json_last_error_msg(), 3, $file_path);
        return 'api_error';
    }

    return $decodedResult;
}



/**
 * Extract text from API response
 *
 * @param array $response The API response
 * @return string The extracted text or error message
 */
function extract_text_from_response($response) {
    if (isset($response["candidates"][0]['content']['parts'][0]['text'])) {
        return $response["candidates"][0]['content']['parts'][0]['text'];
    } elseif (isset($response['error'])) {
        return "Error: " . $response['error']['code'] . "<br>" . $response['error']['message'];
    } else {
        return "Sorry. Something went wrong. Please try again.";
    }
}



/**
 * Run agent without memory
 *
 * @param string $system_message The system message
 * @param string $prompt The prompt
 * @return array The output type and text
 */
function run_agent_without_memory($system_message, $prompt) {
    $my_message1 = ["text" => $prompt];
    $parts_list = [$my_message1];
    $message_history = [["role" => "user", "parts" => $parts_list]];

    $response = make_api_call($system_message, $message_history);

    if ($response == "api_error") {
        $response = make_api_call($system_message, $message_history);
    }
	
	
	
	// If the API call failed ten try again (two more trys)
	//----------

    if ($response != "api_error") {
        $response_text = extract_text_from_response($response);
        if ($response_text == "Sorry. Something went wrong. Please try again.") {
            $response = make_api_call($system_message, $message_history);
        }
    }
	
	
	
    if ($response != "api_error") {
        $response_text = extract_text_from_response($response);
        if ($response_text == "Sorry. Something went wrong. Please try again.") {
            $response = make_api_call($system_message, $message_history);
        }
    }
	
	//----------
	
	

    if ($response != "api_error") {
        $response_text = extract_text_from_response($response);
        $output_type = check_output_type($response_text);

        if ($output_type == "is_json_string") {
            $output_text = json_decode($response_text, true);
        } elseif ($output_type == "is_json_object") {
            $response_text = json_encode($response_text);
            $output_text = json_decode($response_text, true);
        } else {
            $output_text = $response_text;
        }

        return [$output_type, $output_text];
    } else {
        return ["is_plain_text", "api_error"];
    }
}



/**
 * Run agent with memory
 *
 * @param string $system_message The system message
 * @param array $message_history The message history
 * @return array The output type and text
 */
function run_agent_with_memory($system_message, $message_history) {
    $response = make_api_call($system_message, $message_history);

	
	
	
	// If the API call failed then try again (two more trys)
	//----------
	
    if ($response == "api_error") {
        $response = make_api_call($system_message, $message_history);
    }
	
	
	if ($response == "api_error") {
        $response = make_api_call($system_message, $message_history);
    }
	
	//----------
	
	
	

    if ($response != "api_error") {
		
		
		// If the API call failed then try again (two more trys)
		//----
		
        $response_text = extract_text_from_response($response);
		
        if ($response_text == "Sorry. Something went wrong. Please try again.") {
            $response = make_api_call($system_message, $message_history);
        }
		
		
		$response_text = extract_text_from_response($response);
		
        if ($response_text == "Sorry. Something went wrong. Please try again.") {
            $response = make_api_call($system_message, $message_history);
        }	
		//----
		
    }
	
	
	
	

    if ($response != "api_error") {
        $response_text = extract_text_from_response($response);
        $output_type = check_output_type($response_text);

        if ($output_type == "is_json_string") {
            $output_text = json_decode($response_text, true);
        } elseif ($output_type == "is_json_object") {
            $response_text = json_encode($response_text);
            $output_text = json_decode($response_text, true);
        } else {
            $output_text = $response_text;
        }

        return [$output_type, $output_text];
    } else {
        return ["is_plain_text", "api_error"];
    }
}



/**
 * Check the output type
 *
 * @param mixed $output The output
 * @return string The type of output
 */
function check_output_type($output) {
    if (is_object($output)) {
        return "is_json_object";
    } elseif (is_string($output)) {
        $decoded = json_decode($output, true);
        if ($decoded !== null) {
            return "is_json_string";
        } else {
            return "is_plain_text";
        }
    }
}



/**
 * Convert variable to string
 *
 * @param mixed $variable The variable to convert
 * @return string The variable as a string
 */
function convertToString($variable) {
    if (is_array($variable)) {
        return json_encode($variable);
    } else {
        return (string) $variable;
    }
}

?>
