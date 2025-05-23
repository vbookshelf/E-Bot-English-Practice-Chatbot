# E-Bot English Practice Chatbot
### Practice English conversation using AI

Live Demo:<br>
https://e-bot.woza.work/

E-Bot is an AI voice agent. Voice agents combine speech with the reasoning abilities of LLMs (Large Language Models). This combination creates realtime and human-like voice interactions. In this project the voice agent is an AI English teacher that helps learners practice English conversation.

Normally voice agents use paid API services for speech-to-text and text-to-speech. These services improve the quality of the output speech. They also make the app more stable on different platforms and browsers - desktop, mobile etc. But they also add cost and increased latency to the project. E-Bot, however, uses free tools that are built into Javascript - Javascript SpeechRecognition and Javascript SpeechSynthesis. This results in low latency and zero cost (when using the Google Gemini free tier). However, the stability of the app can vary across different platforms and browsers. Currently it works best in Google Chrome running on a desktop.

<br>
<img src="https://github.com/vbookshelf/E-Bot-English-Practice-Chatbot/blob/main/images/teacher2.png" width="300"></img>
<br>

<br>
<br>

## What problem does this solve?

English is the language of international business, science and technology. Many people in non-English speaking countries want to learn English because of the benefits it provides. Some of these include:
- Access to higher paying jobs
- Access to online freelance work
- Access to overseas study opportunities
- Ability to participate in online learning communities like Kaggle.
- Ability to travel with less language anxiety

A challenge that many learners face is they don't have the opportunity to interact with native English speakers.

E-Bot is a virtual English teacher that helps learners practice English through text and voice conversation - supporting them with corrections, translated responses and spoken responses. It’s ideal for shy English learners and those who don’t have English speaking friends to practice with.

<br>
<br>

## Quick Info
- Supports both voice and text
- Mobile optimized web app
- Minimalist and visually calm UI design
- Frontend: Html, CSS, Javascript
- Backend: PHP
- Uses the Gemini 2.0 Flash API (Free version)
- Set up as a three-agent LLM system - chat, correction, translation
- Uses Javascript SpeechRecognition to convert the user's speech into text.
- Uses Javascript SpeechSynthesis to convert text to speech
- Has visual audio cues for deaf learners
- Can be deployed on any website hosting platform

<i>Powered by Google Gemini 2.0 Flash (Free version)<br>
15 RPM (requests per minute)<br>
1 million TPM (tokens per minute)<br>
1,500 RPD (requests per day)</i>
<br>
<br>


## App Description

E-Bot helps learners improve their English by engaging them in casual conversation. During this conversation the chatbot automatically translates it’s responses into the user’s first language, speaks it’s responses out loud and corrects any spelling or grammar errors that the user makes.

Each of these three features can be enabled or disabled. The user can replay the chatbot’s spoken responses at any time by simply clicking on the response text. The app’s accessibility features include visual audio cues for deaf users to alert them that audio is being played.


The LLM (Large Language Model) backend is a three-agent system consisting of a chat agent, correction agent and a translation agent. During each conversation turn API calls are made to the Gemini API to generate chat responses, correct spelling and grammar errors, and to translate text into the user’s first language.

I chose Javascript SpeechRecognition and Javascript SpeechSynthesis beacuse they are free. They are also very fast. The quality may not be as good as some paid services, but I found that over time this doesn't matter. The user's brain adjusts to accomodate the chatbot's weaknesses. 

I chose Gemini 2.0 Flash because it's powerful, fast and Google offers a generous free tier that can be used to build demos like this.

<br>
<br>

## Accesibility Features
- Animated sound bars are present. This is a visual cue that tells deaf users that sound is playing.
- A speaker icon is displayed below the chatbot's responses. This is a cue that tells deaf users what text is being spoken. This icon changes depending on whether Auto Speak is enabled or disabled.
- Text is large and easy to read.
- Should a user need the chatbot to say something again, any response can be spoken out loud by clicking on it.
<br>
<br>

## How does the app work?

This is how the app works at a high level.

The system consists of three agents:

- proofreader_agent
- chat_agent
- translation_agent
  
Each agent is simply a Gemini 2.0 Flash model with a different system message.

1- The user speaks or types a message. If the user speaks then the speech to text system converts the user's speech into text. This user message gets displayed on the page. The speech recognition system is able to detect both when the user starts and stops speaking.<br>
2- The user message is then sent to the proofreader_agent where any spelling or grammar errors are corrected.<br>
3- The corrected message is then sent to the chat_agent. The chat_agent outputs a response to the user message.<br>
4- The chat agent's response is then sent to the translation_agent. The translation agent translates the response into the user's first language.<br>
5- The corrected user message, chat agent response and the translation agent response are then displayed on the page.<br>
6- The text to speech system speaks the chat agent response out loud.<br>
7- To speed up the response time (reduce the latency) try turning off correction and translation in the settings menu.
<br>
<br>

## How does the text to speech conversion work?
The app is using Javascript SpeechSynthesis to convert text to speech. This is a free feature that's built into Javascript. SpeechSynthesis uses the voices available on your device to convert text to speech. Therefore, on different devices you will hear different voices. The quality of the voices will also vary. For example the voices on Android sound more natural than those on Mac OS. The demo video, linked above, is using a voice on Mac OS Big Sur. Besides being free, one of the main benefits of using JS SpeechSynthesis is that it's very fast.<br>
https://developer.mozilla.org/en-US/docs/Web/API/SpeechSynthesis
<br>
<br>

## Why are the LLM calls made from PHP instead of from Javascript?

LLM calls can be made directly from Javascript. The latency would be lower. However, the issue is how to secure the API key. In order to secure the API key it has to be placed on the server side. PHP is a server side language. Javascript runs on the client side i.e. locally in the browser. If the API key is hard coded into Javascript then anyone can see it. It's not secure.
<br>
<br>

## How can we be sure that the translations are high quality?
A full list of Gemini supported languages is available in the Geminin docs:<br>
https://ai.google.dev/gemini-api/docs/models/gemini#available-languages

If the translation language is included in this list then the chances are that the translation quality will be good. For low resource languages like Burmese, the translation quality may vary.
<br>
<br>
<br>

## How to deploy this app

In order to deploy this app you should know how to register a domain name and deploy a website using web hosts like Dreamhost, GoDaddy, HostGator etc.

These are the steps:

1. Create a hosted website domain. You will have a domain name like my-website.com.
1. Download the project folder from this repo.
2. Inside the project folder there is a file called ebot_config.ini.txt. Open this file and add your Google API key where indicated. Then rename this file to: ebot_config.ini
3. Open the file named main.php. You will see a variable named $path_to_config_ini that contains the path to the ebot_config.ini file. You can leave this as is. However, to secure your API key I suggest you place the ebot_config.ini file in a folder that’s located outside the your website root folder. Then change the $path_to_config_ini variable to the new file path.
4. Finally upload all the files located inside the project folder to your website domain. Don’t upload the project folder itself, only the files inside it. Also, don't upload the ebot_config.ini file if you have already uploaded it to a folder that's located outside your website root folder.
5. Navigate to your website url. The app should load and be working.
<br>
<br>
<br>


## How to modify the code to practice other languages

I've set up the version 2.0 code so that it can easily be modified to create chatbots that support other languages.

For example, if you wanted to create a chatbot that would help people pratice Thai, these are the steps you should follow:

1. In the cofig.js file modify the language code:<br>
   (Use IETF language tags)
   ```
   lang_code = "th-TH"; // Code for Thai
   ```
   This sets the speech detection language.
   
2. In the main.php file change these variables:
   ```
   $bot_language = "Thai";
   $speech_lang_code = "th-TH";
   $speech_voice_name = "Kanya";
   $speech_rate = 1;
   ```

   The voices need to be changed to match the language. For example, Kanya speaks Thai, but this voice does not work well for English. You can adjust the speaking speed by increasing or lowering the value of the $speech_rate variable.

   Run this Javascript code to see what voices are available for the language you want to use. Change the language code (en-US) to suit your language.
   This code will print a list of available voices. The ouput will appear in the console in your browser.
    ```
    <script>
      speechSynthesis.onvoiceschanged = () => {
        const voices = speechSynthesis.getVoices();
        voices
          .filter(v => v.lang === 'en-US')
          .forEach(v => console.log(`${v.name} (${v.lang})`));
      };
    </script>
    ```
3. You can set the display name of the chatbot in the name_config.php file.
   ```
   $bot_name = 'T-Bot';
   ```

4. When the above changes are made, the chatbot will be able to chat in your chosen language. Please note that not all languages are supported. And the LLM may produce low quality results for low resource languages.

5. If you want search engines to index your site then you should remove this line from the head element in the index.php file:
   ```
   <meta name="robots" content="noindex, nofollow">
   ```

Here are demos for two other chatbots:<br>
Thai: https://t-bot.woza.work/<br>
Japanese: https://j-bot.woza.work/
<br>
<br>

## How to add a translation language
You will notice that the "Settings" menu has a dropdown with languages that can be selected. The chatbot's responses are translated into this language.

To add a translation language simply add that language to the dropdown menu. For example, if you wanted to add the Thai language then add this line to the dropdown menu in the index.php file:
```
<option value="Thai" selected>Thai (ไทย)</option>
```
When selected, the word "Thai" (from the 'value' setting) will automatically be passed to the translation model. The chatbot's responses will then be translated into Thai. The same approach can be used for other languages that you want to add.<br>

This is a list of languages that the Gemini model supports:<br>
https://ai.google.dev/gemini-api/docs/models/gemini#available-languages

If the language you want to use is not included in this list, the chatbot will still be able to translate, but the translations may not be very good.


<br>
<br>
<br>

## Error Logging

The Php code includes error logging. Errors are logged to a file named: <i>php-errors.log</i><br>
This file is automatically created when the first error happens. The log file will appear in the same location as index.php.
Here's an example of an API error that was logged:
```
2024-05-31 00:24:49 HTTP error: 500 - Response: {
  "error": {
    "code": 500,
    "message": "An internal error has occurred. Please retry or report in https://developers.generativeai.google/guide/troubleshooting",
    "status": "INTERNAL"
  }
}
```

<br>
<br>

## Known Issues
- The web app works best in the Google Chrome web browser. If you find that the speech functionality is not working on your Chrome desktop browser, try updating your Chrome browser to the latest version.
- Occasionally, the corrrection agent does not correct bad spelling or grammar. In general the correction agent works reliably.
- Everything works fine on Mac OS desktop however, the voice chat is not stable on Android. The chatbot hears itself talking. Then it responds to what it said. The code is designed to turn speech recognition off while the chatbot is talking. However, on Android it appears that the speech recognition is not being turned off. I didn't test the chatbot on Windows desktop.
- On Android there's a short delay before the text of the first message is converted into speech. But after the first message, the text to speech conversion is fast and reliable.
- On Mac OS the text to speech pronunciation of certain words is not correct. For example, "reading" is pronounced "redding" and "Ai" is pronounced "ah e".
- API errors can occur during a conversation. If an error occurs then ask your question again and continue the conversation. Just like a person, the chatbot remembers the past conversation. Therefore API errors are not a serious problem.
- The output text sometimes contains escaped characters (\\") and newline characters (\n\n). A factor that contributes to this is that models regularly do not correctly format their output as JSON. In the code I've priotitized extracting output text that doesn't create code errors over getting clean text i.e. text without escaped characters or newline characters. Even tho the text may contain strange characters it's still readable. This is a prototype app - this issue can be addressed later.

<br>
<br>

## Revision History

Version 2.0<br>
01-May-2025<br>
1- Added voice detection. The user can now talk to the chatbot.<br>
2- Made the code easy to modify to support other languages besides English.<br>
3- Changed model from Gemini 1.5 Flash to Gemini 2.0 Flash.<br>
4- Modified the API code. The code now tries three times to make an API call.<br>
5- Other minor changes.

Version 1.0<br>
7-June-2024<br>
First release
<br>
<br>

## Similar projects
- T-Bot Thai Language Practice Chatbot<br>
Practice Thai conversation using AI<br>
https://t-bot.woza.work/

- J-Bot Japanese Practice Chatbot<br>
Practice Japanese conversation using AI<br>
https://j-bot.woza.work/

- JaiTalk AI Translator<br>
Realtime Eng-Thai Voice and Text Translation<br>
https://jaitalk.woza.work/
<br>
<br>

## Resources

- Deeplearning.Ai Course<br>
  Building AI Voice Agents for Production<br>
  https://learn.deeplearning.ai/courses/building-ai-voice-agents-for-production

- Speech Recognition App Using Vanilla JavaScript<br>
https://www.youtube.com/watch?v=-k-PgvbktX4

- Text To Speech Converter in HTML CSS & JavaScript | No External Library or API Used<br>
https://www.youtube.com/watch?v=cvZrppquLQg

- Speech Recognition Using the Web Speech API in JavaScript<br>
https://www.section.io/engineering-education/speech-recognition-in-javascript/

- SpeechRecognition docs<br>
https://developer.mozilla.org/en-US/docs/Web/API/SpeechRecognition

- SpeechSynthesis docs<br>
https://developer.mozilla.org/en-US/docs/Web/API/SpeechSynthesis
<br>
<br>
