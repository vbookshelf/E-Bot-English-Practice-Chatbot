# E-Bot English Practice Chatbot
### Learn English by chatting with a virtual friend

Live Web App:<br>
https://e-bot.woza.work/

<br>
<br>

## What problem does this solve?

English is the language of international business, science and technology. Many people in non-English speaking countries want to learn English because of the benefits it provides. Some of these include:
- Access to higher paying jobs
- Access to online freelance work
- Access to overseas study opportunities
- Ability to participate in online learning communities like Kaggle.
- Ability to travel with less language anxiety

A challenge that many learners face is that they don't have the opportunity to interact with native English speakers.

E-Bot is a virtual English speaking friend that helps deaf and hearing learners practice English through casual text conversation - supporting them with corrections, translated responses and spoken responses. It’s ideal for shy English learners and those who don’t have English speaking friends to practice with.


<br>
<br>

## Quick Info

- Mobile optimized web app
- Minimalist and visually calm UI design
- Frontend: Html, CSS, Javascript
- Backend: PHP
- Uses the Gemini 1.5 Flash API (Free version)
- Set up as a three-agent LLM system - chat, correction, translation
- Uses Javascript SpeechSynthesis to convert text to speech
- Has visual audio cues for deaf learners
- Can be deployed on any website hosting platform

<i>Powered by Google Gemini 1.5 Flash (Fee version)<br>
15 RPM (requests per minute)<br>
1 million TPM (tokens per minute)<br>
1,500 RPD (requests per day)</i>
<br>
<br>

## Video Demo

YouTube Video:<br>
https://youtu.be/VA82S4BLnTs
<br>
<br>

## App Description

E-Bot helps learners improve their English by engaging them in a casual text conversation. During this conversation the chatbot automatically translates it’s responses into the user’s first language, speaks it’s responses out loud and corrects any spelling or grammar errors that the user makes.

Each of these three features can be enabled or disabled. The user can replay the chatbot’s spoken responses at any time by simply clicking on the response text. The app’s accessibility features include visual audio cues for deaf users to alert them that audio is being played.


The LLM (Large Language Model) backend is a three-agent system consisting of a chat agent, correction agent and a translation agent. During each conversation turn API calls are made to the Gemini-Flash API to generate chat responses, correct spelling and grammar errors, and to translate text into the user’s first language.

To create more variety in the chatbot’s responses, the code randomly sets the mood of the chatbot at the start of each user session. The three moods are: 'bubbly', 'contemplative' and 'cheerful'.
<br>
<br>

## Accesibility Features
- Animated sound bars are present. This is a visual cue that tells deaf users that sound is playing.
- A speaker icon is displayed below the chatbot's responses. This is a cue that tells deaf users what text is being spoken. This icon changes depending on whether Auto Speak is enabled or disabled.
- Text is large and easy to read.
- Should a user need the chatbot to repeat something it said, any response can be spoken out load by clicking on it.

<br>
<br>

## Who is the target user?


### Demographics

<b>Age:</b> 18-25<br>
<b>Gender:</b> All<br>
<b>Location:</b> Non-english speaking country<br>
<b>Education:</b> High school, College<br>
<b>Occupation:</b> Student, recently employed or online freelancer<br>
<b>Disabilities:</b> None, Deaf, Hard of hearing<br>

### Psychographics

<b>Interests:</b> Social activism, travel<br>
<b>Values:</b> Continuous learning<br>
<b>Personality Traits:</b> Tech-savvy, motivated, and open-minded<br>
<b>Goals:</b> To improve their English skills to enhance their academic and career prospects and to improve their travel experiences.<br>

### Behavioral Traits

<b>Tech Usage:</b> Uses a laptop for work and study. Uses a cellphone for social media and messaging.<br>
<b>Language Skills:</b> Basic to intermediate proficiency in English, looking to improve grammar, expand vocabulary and improve fluency<br>
<b>Challenges:</b> Finds it difficult to practice conversational English in a supportive environment, has limited opportunities to interact with native English speakers<br>
<b>Motivation:</b> Believes improving their English will improve their lives<br>
<b>Preferred Learning Style:</b> Practical application, enjoys learning through doing
<br>
<br>

## What needs does the target user have?

- A flexible learning option.
- A safe environment to practice conversational English.
- A friendly and patient practice partner who is willing to regularly repeat what they have said.
- Deaf or hard of hearing users need a text-based learning tool that's accessible and easy to use.
- Deaf or hard of hearing users need a clear visual indicator that tells them when audio is playing.

E-bot was designed to meet these needs.

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

## Error Logging

The Php code includes error logging. Errors are logged to a file named: <i>php-errors.log</i><br>
This final is automatically created when the first error happens. The log file will appear in the same location as index.php.
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

When there's an API error, the following message is displayed on the web page: <i>api_error</i>
<br>
<br>

## Known Issues
- Occasionally, the corrrection agent does not correct bad spelling or grammar. In general the correction agent works reliably.
- On some phones there's a short delay before the text of the first message is converted into speech. But after the first message, the text to speech conversion is fast and reliable.

<br>
<br>

## Revision History
Version 1.0<br>
31-May-2024<br>
First release
<br>
<br>

