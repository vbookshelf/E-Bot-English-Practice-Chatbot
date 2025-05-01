<?php
session_start();
include "php/name_config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Tell search engines not to index the site -->
    <meta name="robots" content="noindex, nofollow">
    
    <meta charset="utf-8">
    <title>E-Bot English Practice Chatbot</title>
	
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Practice English conversation using AI.">
	
    <!-- Image -->
    <link rel="shortcut icon" type="image/png" href="assets/e-icon.png">
	
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/e-bot.css">
	
</head>

<body>
    <p class="w3-small w3-padding-left w3-text-white hide-on-phone space-letters"><a href="https://github.com/vbookshelf/E-Bot-English-Practice-Chatbot" target="_blank">GitHub</a> - <a href="https://t-bot.woza.work/" target="_blank">Practice Thai</a> - <a href="https://j-bot.woza.work/" target="_blank">Practice Japanese</a></p>
    <div class="container w3-animate-opacity">
        <div id="main-image" class="w3-center w3-round w3-padding w3-text-blue">
			
            <!--
				<i class="fa fa-commenting-o w3-text-red" style="font-size:75px"></i> 
			-->
			
			<!--
            <h2 class="space-letters"><b>E-Bot English Practice <span class="hide-on-phone">AI Chatbot</span></b></h2>
			-->
			
			<h2 class="space-letters"><b>E-Bot English Practice Chatbot</b></h2>
			
            <h4 class="space-letters"><b>Practice English conversation using AI</b></h4>
		
        </div>
        <main id="chat" class="texts">
            <div class="message-container">
                <span id="first-chat-block" class="set-color1"><b>&#x2022 E-Bot</b></span>
                
                <ul class="lighter-black instruction-text">
					<li>Hi. Welcome to E-Bot.</li>
					<li>Please select your first language in the settings menu.</li>
					<li>For best results please use the Google Chrome browser.</li>
					<li>Also, don't allow your browser to translate this page.</li>
					<li>Chat ideas:<br>
						- Can we role-play a job interview?<br>
						- Who is Beyoncé?<br>
						- Is there life on other planets?
					</li>
					<li>Please be kind. E-Bot will make mistakes.</li>	
					
                </ul>
            </div>
            <!-- Add more message containers here -->
            <!-- The div for the spinner gets added and deleted here. -->
        </main>
        <div class="sticky-bar">
			
		<button class="" id="start-voicechat-btn" onclick="start_recog(submit_text_to_php, lang_code)">Start Voicechat</button>
			
            <form id="myForm" action="main.php" method="post">
                <input id="user-input" type="text" name="my_message" placeholder="Type or talk in English" autofocus>
                <input type="hidden" name="robotblock">
                <input id="submit-btn" type="submit" value="Send">
                <div class="w3-padding space-letters">
                    <button id="accordion"><i class="fa fa-gear w3-padding-right" style="font-size:25px;color:white"></i>Settings</button>
                    <span class="w3-padding-right" style="cursor: pointer;" onclick="quiet_please()">
                        <i class="fa fa-volume-off" style="font-size:27px"></i>
                        <i class="fa fa-close w3-padding-right" style="font-size:18px"></i>
                    </span>
                    <div id="audioIndicator">
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </div>
                    <div id="audioIndicator1">
                        <div class="bar1"></div>
                        <div class="bar1"></div>
                        <div class="bar1"></div>
                    </div>
                </div>
                <div class="wrapper">
                    <div class="form-elements">
                        <div id="panel">
                            <div id="line1" class="radio-group">
                                <label class="radio-option">
                                    <input id="speakid" class="w3-padding" type="radio" name="speak1" value="speak" onclick="toggleRadio(this)">
                                    Auto Speak
                                </label>
                                <label class="radio-option">
                                    <input id="correctid" type="radio" name="correct1" value="correct" onclick="toggleRadio(this)">
                                    Correction
                                </label>
                                <label class="radio-option">
                                    <input id="translateid" type="radio" name="translate1" value="translate" onclick="toggleRadio(this)">
                                    Translation
                                </label>
                            </div>
                            <div id="line2">
                                
                                <div id="dropdown1" class="dropdown-option w3-padding-left w3-padding-bottom">
                                    <select class="styled-dropdown" id="language-select" name='user_language' onchange="updateSelectedOption(this)">
										<option value="Burmese">Burmese (မြန်မာဘာသာ)</option>
                                        <option value="Chinese">Chinese (中文简体)</option>
										<option value="English">English</option>
                                        <option value="French">French (Français)</option>
                                        <option value="German">German (Deutsch)</option>
										<option value="Hindi">Hindi (हिन्दी)</option>
                                        <option value="Japanese">Japanese (日本語)</option>
                                        <option value="Korean">Korean (한국어)</option>
										 <option value="Portuguese">Portuguese</option>
										<option value="Russian">Russian (Русский)</option>
                                        <option value="Spanish">Spanish (Español)</option>
										<option value="Swahili">Swahili (Kiswahili)</option>
                                        <option value="Thai" selected>Thai (ไทย)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- The page gets scrolled up to this id. -->
    <div id="e-bot"></div>
    <!-- Onload a click is simulated on this to scroll the page to id="bottom-bar" -->
    <a href="#e-bot" id="scroll-page-up"></a>
    <a href="#test100" id="scroll-to-last-message"></a>
    <a href="#chatbot" id="scroll-to-bot-message"></a>
	
</body>
</html>




<!-- Import the utils.js file -->
<script src="js/utils.js"></script>

<script>
speechSynthesis.onvoiceschanged = () => {
  const voices = speechSynthesis.getVoices();
  voices
    .filter(v => v.lang === 'en-US')
    .forEach(v => console.log(`${v.name} (${v.lang})`));
};
</script>

<!-- 
Import the config.js file.
The language code varuable (lang_code) is set in this file.
-->
<script src="js/config.js"></script>

<script>
    // Event listener that prevents the form from submitting when
    // the "Settings" button is clicked.
    document.getElementById('accordion').addEventListener('click', function(event) {
        event.preventDefault();
        // Add your settings toggle code here
        console.log('Settings button clicked');
    });

    // JavaScript to toggle the visibility of the panel with a smooth transition
    document.getElementById('accordion').addEventListener('click', function() {
        var panel = document.getElementById('panel');
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
	
	

	
	// *** ON LOAD ***
    // Comment or uncomment these lines to check (select) radio
    // when the page loads.
    // Selects and checks radio buttons when the page loads
    window.onload = function() {
        checkRadioButton('speak1', 'speakid');
        checkRadioButton('correct1', 'correctid');
        checkRadioButton('translate1', 'translateid');
    };
</script>

<script>
    // These names are set in name_config.php
    // That file has been included at the top of this page.
    const bot_name = "<?php echo $bot_name; ?>";
    const user_name = "<?php echo $user_name; ?>";
    // Set the name of the bot in the first chat block
    document.getElementById("first-chat-block").innerHTML = "<b>&#x2022 " + bot_name + "</b>";
</script>

<script>
    // PHP Ajax Code
    ///////////////////
    var form = document.getElementById('myForm');
	
    form.onsubmit = function(event) {
        // Prevent the default form submission behavior
        event.preventDefault();
		
        // Get the form data
        var formData = new FormData(form);
		
        // Clear the form input
        form.reset();
		
        // Get the value of my_message
        var $my_message = formData.get("my_message");
		
        // This will prevent the form from submitting
        // if the user input field is empty.
        if ($my_message == "") {
            return; // Exit the function if the condition is not met
        }
		
        // Format the input into paragraphs. This
        // adds paragraph html to the students chat.
        // It's main use is in Maiya's chat where the long response needs 
        // to be formatted into separate paragraphs.
        $my_message = formatResponse($my_message);
		
        var input_message = {
            sender: user_name,
            text: $my_message
        };
		
        console.log(input_message.text);
		
        // Add a user message to the chat
        addMessageToChat(input_message);
		
        // Show the spinner while waiting for the response from openai
        create_spinner_div();
		
        // Scroll the page up by clicking on a div at the bottom of the page.
        simulateClick('scroll-page-up');
		
        // Delete the id from the message container.
        // It will get added again when the message container is created.
        var element = document.getElementById("chatbot");
        element.removeAttribute("id");
		
        // Send an AJAX request to the server to process the form data
        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.onload = function() {
			
            if (xhr.status === 200) {
				
                var response = JSON.parse(xhr.responseText);
				
                console.log("===API Output===");
				
				var check_text = response.check_array;
				
				console.log('==Check text==');
				console.log(check_text);
				
				// Make these variables global by attaching
				// them to the window object.
				window.speech_lang_code = response.speech_lang_code;
				window.speech_voice_name = response.speech_voice_name;
				window.speech_rate = response.speech_rate;
				
				
                var response_text = response.chat_text;
                var text_to_speak = response.text_to_speak;
                var speak_status = response.speak_status;
                var translation_language = response.translation_language;
                let correctedUserMessage = response.corrected_text;
				
                if (correctedUserMessage !== 'none' && correctedUserMessage !== 'api_error') {
                    correctedUserMessage = correctedUserMessage;
                }
				
                let translatedChatAgentResponse = response.translated_text;
				
                if (translatedChatAgentResponse !== 'none' && translatedChatAgentResponse !== 'api_error') {
                    translatedChatAgentResponse = replaceItemsInString(translatedChatAgentResponse);
					
					// Remove the escape backslashes (\")
					translatedChatAgentResponse = removeEscapeSlashes(translatedChatAgentResponse);
					
					// Remove newline chracters (\n\n)
					translatedChatAgentResponse = removeNewlines(translatedChatAgentResponse);
                }
				
				
                let chatAgentResponse = response.chat_text;
				
                // Remove emojis
                chatAgentResponse = removeEmojis(chatAgentResponse);
				
                let correctedText, translatedText, chatText, finalText;
				
                // Handle corrected user message
                if (correctedUserMessage !== 'none') {
                    correctedText = `<p class='lighter-black'><i>Correction: ${correctedUserMessage}</i></p>`;
                } else {
                    correctedText = "";
                }
				
                // Handle translated chat agent response
                if (translatedChatAgentResponse !== 'none') {
                    translatedText = `<p class='lighter-black'>${translatedChatAgentResponse}</p>`;
                } else {
                    translatedText = "";
                }
				
                console.log(speak_status);
				
                // For Deaf Accessibility.
                // Deaf people won't know that the audio is on
                // and the chatbot is speaking.
                if (speak_status == 'selected') {
                    // Handle chat agent response
                    chatText = `<p class="clickable" onclick="speakText(this.innerHTML)">${chatAgentResponse}<i class="fa fa-volume-up w3-text-teal display-block" style="font-size:18px"></i></p>`;
                } else {
                    // Handle chat agent response
                    chatText = `<p class="clickable" onclick="speakText(this.innerHTML)">${chatAgentResponse}<i class="fa fa-volume-off w3-text-teal display-block" style="font-size:18px"></i></p>`;
                }
				
                // Combine all parts into final text
                finalText = correctedText + chatText + translatedText;
				
                console.log(finalText);  // Output the final text
				
                var input_message = {
                    sender: bot_name,
                    text: finalText
                };
				
                console.log("--Check--");
                console.log(response.check_variable);
				
                // Add the 'selected' attribute to the dropdown menu
                updateSelectedLanguage(translation_language);
				
                // *** Remove any html and then speak *** //
                ////////////////////////////////////////////
                let cleaned_text = removeHtmlTags(text_to_speak);
				
                // Remove any emojis
                cleaned_text = removeEmojis(cleaned_text);
				
                if (speak_status == 'selected') {
                    speak(cleaned_text, speech_lang_code, speech_voice_name, speech_rate);	
                }
				
                // Delete the div containing the spinner
                delete_spinner_div();
				
                // Add the message from Maiya to the chat
                addMessageToChat(input_message);
				
                // Scroll the page up by clicking on a div at the bottom of the page.
                // ***** Change this to click on the bot message div, then delete the div id ****
                simulateClick('scroll-to-bot-message');
				
                // Delete the id from the message container.
                // It will get added again when the message container is created.
                var element = document.getElementById("chatbot");
				
                element.removeAttribute("id");
				
                // Only put the cursor into the input field
                // if the user is not using a cellphone.
                // If the cursor is in the input field on a phone then the keyboard
                // gets displayed. This affects the page scrolling to the bot message.
                var screenWidth = window.screen.width;
                var screenHeight = window.screen.height;
				
                // Assuming a threshold of 768 pixels as a cutoff for mobile devices
                var isMobile = screenWidth <= 768;
                if (isMobile) {
                    console.log("User is using a cellphone");
                } else {
                    console.log("User is not using a cellphone");
                    // Put the cursor in the form input field
                    const inputField = document.getElementById("user-input");
                    inputField.focus();
                }
            }
        };
        xhr.send(formData);
    };
</script>

<script>
	
// Event listener function
// When the end event is detected, the vent listener
// uses this function to restart the mic.
// In this way the mic always stays on.
// Adding and deleting the event listener is important to
// ensure that the mic stays on, but that it's also off
// when the bot is talking.
function handleEnd () {
	
  console.log('Event listener restarting mic...');
  window.recognition.start();
	  
  }
	

function initialize_recognition(lang_code) {
	
	window.SpeechRecognition =
	window.SpeechRecognition || window.webkitSpeechRecognition;
	
	const recognition = new SpeechRecognition();
	
	//recognition.continuous = true;
	
	// *** Comment out this line for better performance on Android. ***
	// When this line is commented out there's no intermediate voice detections,
	// however, the bot works much better on Android.
	//recognition.interimResults = true;
	
	// Set the language you want
	recognition.lang = lang_code; //'ja-JP'; // or 'th-TH' for Thai // en-US
	
	console.log('Detection lang:')
	console.log(lang_code)
	
	// Make the recognition object available globally
	window.recognition = recognition;
	
	
	console.log('recognition initialized')
	
	
	// Add event listener
	window.recognition.addEventListener('end', handleEnd);
	
	// Pause (Remove) the event listener
	//window.recognition.removeEventListener('end', handleEnd);
	
	
	window.recognition.start();
	
	
	// Select the button by ID
	const button = document.getElementById("start-voicechat-btn");
	
	// Set the border to yellow
	if (button) {
	    button.style.border = "2px solid orange";
		button.style.borderRadius = "5px";
		button.innerText = "Listening...";
		button.style.letterSpacing = "0.05em";
	}

}




function submit_text_to_php(my_text) {
		// Select the input element by its id
		const inputElement = document.getElementById('user-input');
		
		// Set the value attribute
		inputElement.setAttribute('value', my_text);
		
		// Simulate a click on the form submit button
		// This will send the form to the php code for processing.
		simulateClick('submit-btn');
		
		// Clear the value that was set
		inputElement.setAttribute('value', "");
	}

	
	
	

// Source: Speech Recognition App Using Vanilla JavaScript
// https://www.youtube.com/watch?v=-k-PgvbktX4

function start_recog(submit_text_to_php, lang_code) {
	
	
	initialize_recognition(lang_code);

	const texts = document.querySelector(".texts");
	
	//window.SpeechRecognition =
	  //window.SpeechRecognition || window.webkitSpeechRecognition;
	
	//const recognition = new SpeechRecognition();
	//recognition.interimResults = true;
	
	
	//window.recognition = recognition;
	
	// Create a temporary p element where the voice detection 
	// will be displayed.
	let p = document.createElement("p");
	// Set the id attribute
	p.setAttribute('id', 'temp_p');
	
	
	recognition.addEventListener("result", (e) => {
		
		
	  texts.appendChild(p);
	  
	  let text = Array.from(e.results)
	    .map((result) => result[0])
	    .map((result) => result.transcript)
	    .join("");
	
	  p.innerText = text;
	  
	  if (e.results[0].isFinal) {
	
	    	// Delete the temporary p element that 
			// showed the voice detection.
			delete_temp_p();
	  
		  // Format the input into paragraphs. This
		  // adds paragrah html to the user's chat.
		  // It's main use is where the bot's long response needs 
		  // to be formatted into separate paragraphs.
		  text = formatResponse(text);
			
		// Use the form to submit the text to php for processing
		submit_text_to_php(text);
		
	  }
	  
	});


	//makeApiRequest(text);
	//window.recognition.start();
}


</script>

<?php
// This is important.
// If this is not done then the session variables will still
// be available even after the tab is closed. By doing this the
// session variables get deleted when the tab is closed.
// You can print out the message history to confirm that the
// session variable has been deleted: print_r($_SESSION['message_history']);

// remove all session variables
session_unset();

// destroy the session
session_destroy();
?>
