// When the form is submitted this function removes
// the 'selected' attribute. This ensures we don't end
// up with two dropdown options that have an attribute called 'selected'.
// The 'selected' attribute gets added later when the ajax response
// displays the output on the page. This ensures that the language
// the user has selected stays selected.
function clearSelectedOptions() {
    var selectElement = document.getElementById('language-select');
    var options = selectElement.getElementsByTagName('option');
    
    for (var i = 0; i < options.length; i++) {
        if (options[i].hasAttribute('selected')) {
            options[i].removeAttribute('selected');
        }
    }
}


//* Replaced this with a better solution *
// This sets the language when the dropdown option is selected.
// This gets called after the ajax response is received when the page gets updated.
function updateSelectedLanguage(user_language) {
    var selectElement = document.getElementById("language-select");
    // translation_language = selectElement.value;
    // console.log("Selected language: " + translation_language);

    // Get the <option> element you want to add the 'selected' attribute to by its value
    var optionToSelect = selectElement.querySelector('option[value="' + user_language + '"]'); 

    // Add the 'selected' attribute to the option
    optionToSelect.setAttribute("selected", "selected");
}


// This function creates the three dot spinner.
// Calling this function starts the spinner.
function spinner() {
    // Select the element where the spinner will be displayed
    const spinnerElement = document.getElementById("spinner");
    
    // Define an array of dots
    const dots = ["", ".", "..", "..."];
    
    // Initialize the dot counter
    let dotIndex = 0;// Set the color and size of the spinner
	
    spinnerElement.style.color = "white";
    spinnerElement.style.fontSize = "25px";
	
	
    
    // Start the spinner animation
    setInterval(() => {
        // Update the text content of the spinner element with the current dot
        // This adds the >... symbol
        // spinnerElement.textContent = `>${dots[dotIndex]}`;
        
        // This does not have the >... symbol
        spinnerElement.textContent = `${dots[dotIndex]}`;
    
        // Increment the dot counter
        dotIndex = (dotIndex + 1) % dots.length;
    }, 500);
}


// We create the div containing the spinner.
// We append the div to the chat.
// This displays the spinner.
function create_spinner_div() {
    // Create a new div element
    const spinnerElement = document.createElement("div");
    
    // Set the id attribute of the div element to "spinner"
    spinnerElement.setAttribute("id", "spinner");
    
    var chat = document.getElementById("chat");
    
    // Append the div to the chat
    chat.appendChild(spinnerElement);
    
    // Start the spinner
    spinner();
}


// This function deletes the div containing the spinner.
// This causes the spinner to disappear.
function delete_spinner_div() {
    // Get the div element you want to delete
    const elementToDelete = document.getElementById("spinner");
    
    // Get the parent node of the div element
    const parentElement = elementToDelete.parentNode;
    
    // Remove the div element from its parent node
    parentElement.removeChild(elementToDelete);
}


// This function deletes the div containing the spinner.
// This causes the spinner to disappear.
function delete_temp_p() {
    // Get the div element you want to delete
    const elementToDelete = document.getElementById("temp_p");
    
    // Get the parent node of the div element
    const parentElement = elementToDelete.parentNode;
    
    // Remove the div element from its parent node
    parentElement.removeChild(elementToDelete);
}


// This functions takes a list of text (paragraphs).
// If the paragraph does not have p tags then it adds them.
function wrapInPTags(paragraphs) {
    let result = '';

    for (let i = 0; i < paragraphs.length; i++) {
        const paragraph = paragraphs[i];

        if (paragraph.includes('<p>')) {
            result += paragraph;
        } else {
            result += '<p>' + paragraph + '</p>';
        }
    }

    return result;
}


// This function formats the text into paragraphs.
function formatResponse(response) {
    // Split the response into lines
    const lines = response.split("\n");

    // Combine the lines into paragraphs
    const paragraphs = [];
    let currentParagraph = "";

    for (const line of lines) {
        if (line.trim()) {  // Check if the line is non-empty
            currentParagraph += line.trim() + " ";
        } else if (currentParagraph) {  // Check if the current paragraph is non-empty
            paragraphs.push(currentParagraph.trim());
            currentParagraph = "";
        }
    }

    // Append the last paragraph
    if (currentParagraph) {
        paragraphs.push(currentParagraph.trim());
    }

    // Some text thats returned has \n character but no <p> tags.
    // Other text has <p> tags that we can use when displaying the text on the page.
    // Here we check each list item (paragraph). If it doesn't have <p> tags then add them.
    // This is also important when we save and then reload the chat history.
    // If you change this make sure that the saving and reloading also works well.
    formattedResponse = wrapInPTags(paragraphs);
    
    // Add HTML tags to separate paragraphs
    // const formattedResponse = paragraphs.map(p => `<p>${p}</p>`).join("");
    
    return formattedResponse;
}


// Function to create a new message container
function createMessageContainer(message) {
    var messageContainer = document.createElement("div");
    messageContainer.classList.add("message-container");
    messageContainer.classList.add("w3-animate-opacity");
    
    // Add an id attribute. This will help to scroll to
    // the bot message. This gets detelted after the page
    // is scrolled to the bot message.
    messageContainer.setAttribute("id", "chatbot");

    var messageText = document.createElement("span"); // p

    // This if statement sets the coour of the name that gets displayed
    if (message.sender == bot_name) {
        messageText.innerHTML = "<span class='set-color1'><b>&#x2022 " + message.sender + "</b></span>" + message.text;
    } else {
        messageText.innerHTML = "<span class='set-color2'><b>&#x2022 " + message.sender + "</b></span>" + message.text;
    }

    messageContainer.appendChild(messageText);

    return messageContainer;
}


// Function to add a new message to the chat
function addMessageToChat(message) {
    var chat = document.getElementById("chat");
    var messageContainer = createMessageContainer(message);
    
    chat.appendChild(messageContainer);
    
    // Scroll the page up by cicking on a div at the bottom of the page.
    simulateClick('scroll-page-up');
}

// Function to remove html tags from a string
function removeHtmlTags(str) {
    return str.replace(/(<([^>]+)>)/gi, "");
}

// Function to mute the cahtbot
// when it is speaking.
function quiet_please() {
    speechSynthesis.cancel();
    
    // Hide the moving audio bars and show the three dots bars
    hide('audioIndicator');
    show('audioIndicator1');
}






// Function that converts text to speech
function speak_thai(text) {
    // Create a new instance of SpeechSynthesisUtterance
    const utterance = new SpeechSynthesisUtterance();
	
	var speech_lang_code = "th-TH";
	var speech_voice_name = "Kanya";
	const speech_rate = 1
	
    
    // Set the text that you want to speak
    utterance.text = text;
	
	
	/////////////
	
	 // Ensure the language is set
    utterance.lang = speech_lang_code;

    // Get the list of available voices
    const voices = window.speechSynthesis.getVoices();
    
    // Find the voice
    const selectedVoice = voices.find(voice => voice.name === speech_voice_name);
    
    // Set the voice to the Thai if found
    if (selectedVoice) {
        utterance.voice = selectedVoice;
    }
	
	
	// Set the speaking rate
    utterance.rate = speech_rate;
    

    // Speak the text
    speechSynthesis.speak(utterance);
 
    
}







// Function that converts text to speech
function speak(text, speech_lang_code, speech_voice_name, speech_rate = 1) {
    // Create a new instance of SpeechSynthesisUtterance
    const utterance = new SpeechSynthesisUtterance();
    
    // Set the text that you want to speak
    utterance.text = text;
	
	// If speech recognition has been initialized.
	  // If the user just types then speech recognition 
	  // is not initialized and the recognition object does not exist.
	  if (window.recognition) {
		  
		  console.log('Stopping recognition...')
	  
		  // Pause (delete) the event listener.
		  // The handleEnd function identifies which event listener we want.
		  window.recognition.removeEventListener('end', handleEnd);
		  
		  // The recognition object has been attached to the window
		  // in order to make it available globally.
		  window.recognition.stop();
	  
	  }
	
	
	/////////////
	
	 // Ensure the language is set
    utterance.lang = speech_lang_code;

    // Get the list of available voices
    const voices = window.speechSynthesis.getVoices();
    
    // Find the voice with the name 'Paulina'
    const selectedVoice = voices.find(voice => voice.name === speech_voice_name);
    
    // Set the voice to the Spanish voice if found
    if (selectedVoice) {
        utterance.voice = selectedVoice;
    }
	
	
	/////////////
	
	
	// Set the speaking rate
    utterance.rate = speech_rate;
    

    // Speak the text
    speechSynthesis.speak(utterance);
    
    // When the chatbot starts speaking display the sound bar animation
    hide('audioIndicator1');
    show('audioIndicator');
    
    utterance.onend = function() {
        // When the chatbot stops speaking hide the sound bar animation
        hide('audioIndicator');
        show('audioIndicator1');
		
		// Only when the speech synthesis ends, start the mic.
		// If we don't use this then the event listener 
		// will start listening while the bot is still talking.
		// The bot will then hear it's own voice and respond to it.
		
		if (window.recognition) {
				
				console.log('Restarting recognition...')
			  
				// Add the event listener again.
				// The handleEnd function identifies which event listener we want.
				window.recognition.addEventListener('end', handleEnd);
				
				window.recognition.start();
	  		}
		
		
    };
    
}


// Function to remove items from a json string
// before it gets displayed on the page.
function replaceItemsInString(inputString) {
    const itemsToReplace = ["```", "json", "{", "}", '"correction": "', '"translation": "', "#"];
    
    let modifiedString = inputString;
    itemsToReplace.forEach(item => {
        const regex = new RegExp(item, 'g'); // Create a global regular expression for each item
        modifiedString = modifiedString.replace(regex, "");
    });
    
    modifiedString = modifiedString.trim();
    
    // Use slice to get the string from the start up to the second last character
    modifiedString = modifiedString.slice(0, -1);
    
    modifiedString = removeEmojis(modifiedString);
    
    return modifiedString;
}


function removeEscapeSlashes(str) {
  return str.replace(/\\(["'\\])/g, '$1');
}

function removeNewlines(str) {
  return str.replace(/[\r\n]+/g, '');
}


// Function to remove emojis from text
function removeEmojis(text) {
    return text.replace(/[\u{1F600}-\u{1F64F}]/gu, '')  // Emoticons
               .replace(/[\u{1F300}-\u{1F5FF}]/gu, '')  // Miscellaneous Symbols and Pictographs
               .replace(/[\u{1F680}-\u{1F6FF}]/gu, '')  // Transport and Map Symbols
               .replace(/[\u{1F700}-\u{1F77F}]/gu, '')  // Alchemical Symbols
               .replace(/[\u{1F780}-\u{1F7FF}]/gu, '')  // Geometric Shapes Extended
               .replace(/[\u{1F800}-\u{1F8FF}]/gu, '')  // Supplemental Arrows-C
               .replace(/[\u{1F900}-\u{1F9FF}]/gu, '')  // Supplemental Symbols and Pictographs
               .replace(/[\u{1FA00}-\u{1FA6F}]/gu, '')  // Chess Symbols
               .replace(/[\u{1FA70}-\u{1FAFF}]/gu, '')  // Symbols and Pictographs Extended-A
               .replace(/[\u{2600}-\u{26FF}]/gu, '')    // Miscellaneous Symbols
               .replace(/[\u{2700}-\u{27BF}]/gu, '')    // Dingbats
               .replace(/[\u{FE00}-\u{FE0F}]/gu, '')    // Variation Selectors
               .replace(/[\u{1F1E6}-\u{1F1FF}]/gu, '')  // Flags
               .replace(/[\u{1F900}-\u{1F9FF}]/gu, '')  // Supplemental Symbols and Pictographs
               .replace(/[\u{1FA70}-\u{1FAFF}]/gu, ''); // Symbols and Pictographs Extended-A
}


// Function to get the user's preferred language
function getUserLanguage() {
    // Use navigator.languages if available, otherwise fallback to navigator.language
    const languages = navigator.languages && navigator.languages.length ? navigator.languages : [navigator.language || navigator.userLanguage];
    return languages[0];  // Return the first preferred language
}


function hide(elementId) {
    document.getElementById(elementId).style.display = "none";
}


function show(elementId) {
    document.getElementById(elementId).style.display = "inline-block";
}


function removeITags(html) {
    // Use a regular expression to remove <i> tags and their content
    return html.replace(/<i[^>]*>.*?<\/i>/gi, '');
}


function speakText(innerHtml) {
    // Remove the <i> tags associated with the icon
    var processedText = removeITags(innerHtml);
    
    speak(processedText, speech_lang_code, speech_voice_name, speech_rate);
}


// Simulates a click.
function simulateClick(tabID) {
    // Simulate a click.
    document.getElementById(tabID).click();
}


// Adding and removing the checked attribute ensures
// that the radio button remains checked or unchecked
// after the form is submitted. Otherwise it will return
// to its default status each time a chat message is sent.
function toggleRadio(radio) {
    // Check the previous state stored in a custom property
    if (radio.wasChecked) {
        // If it was previously checked, uncheck it
        radio.checked = false;
        radio.removeAttribute('checked');
        radio.wasChecked = false;  // Update the state to reflect that it's no longer checked
    } else {
        // If it was not checked, check it
        radio.checked = true;
        radio.setAttribute('checked', 'checked');
        radio.wasChecked = true;  // Update the state to reflect that it's now checked
    }
}


function checkRadioButton(radioName, radioID) {
    var radio = document.querySelector(`input[name="${radioName}"]`);
    if (radio) {
        radio.checked = true;
    }
    // This makes sure the button does not uncheck
    // when the form is submitted. It stays checked.
    document.getElementById(radioID).setAttribute('checked', 'checked');
}


function uncheckRadioButton(radioName, radioID) {
    var radio = document.querySelector(`input[name="${radioName}"]`);
    if (radio) {
        radio.checked = false;
    }
    document.getElementById(radioID).removeAttribute('checked');
}


function updateSelectedOption(selectElement) {
    // Remove 'selected' attribute from all options
    for (let option of selectElement.options) {
        option.removeAttribute('selected');
    }

    // Add 'selected' attribute to the currently selected option
    selectElement.options[selectElement.selectedIndex].setAttribute('selected', 'selected');
}


