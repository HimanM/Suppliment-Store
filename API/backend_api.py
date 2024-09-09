import mysql.connector
import json
import datetime
import os
import google.generativeai as genai
from mysql.connector import Error
from flask import Flask, request, jsonify
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from dotenv import load_dotenv



#Configurations from .env
load_dotenv()
genai.configure(api_key=(os.getenv("GEMINI_API_KEY")))
EMAIL = os.getenv("EMAIL")
APP_PASSWORD = os.getenv("APP_PASSWORD")


app = Flask(__name__)


@app.route('/send_mail', methods=['POST'])
def handle_query():
    # Get JSON data from the request
    data = request.get_json()

    # Extract variables from the JSON data
    email = data.get('user_email')
    subject = data.get('subject')
    content = data.get('content')

    sendEmail(email,subject,content)

    return ("Mail delivered"), 200

    # connection = dbConnection()
    # try:
    #     if connection.is_connected():
    #         cursor = connection.cursor()
    #         cursor.execute(f"SELECT email FROM users WHERE id ={user_id}")
    #         data = cursor.fetchall()
    #         email = data[0][0]
    #         print(email)

    #         sendEmail(email,query,answer)

    # except Error as e:
    #     print(f"Error: {e}")

    # finally:
    #     if connection.is_connected():
    #         cursor.close()
    #         connection.close()

def sendEmail(email,subject,content):
    # Email account credentials
    sender_email = EMAIL
    password = APP_PASSWORD  

    receiver_email  = email

    # Create the email
    msg = MIMEMultipart()
    msg['From'] = sender_email
    msg['To'] = receiver_email
    msg['Subject'] = subject

    # Body of the email
    body = content
    msg.attach(MIMEText(body, 'plain'))

    # Send the email
    try:
        with smtplib.SMTP('smtp.gmail.com', 587) as server:
            server.starttls()  # Secure the connection
            server.login(sender_email, password)
            text = msg.as_string()
            server.sendmail(sender_email, receiver_email, text)
            print('Email sent successfully!')
    except Exception as e:
        print(f'Failed to send email. Error: {e}')


def convert_set_to_json(content_set):
    try:
        # Convert the set to a list
        content_list = list(content_set)
        
        # Print the contents of the list for debugging
        print("Content List:", content_list)
        
        # Ensure there is exactly one item in the list
        if len(content_list) != 1:
            raise ValueError("The set does not contain exactly one item.")
        
        # Extract the JSON string
        json_string = content_list[0]
        
        # Remove any extra quotes or whitespace
        json_string = json_string.strip().strip("'").strip('"')
        
        # Print the cleaned JSON string for debugging
        print("Cleaned JSON String:", json_string)
        
        # Convert the JSON string to a Python dictionary
        content_dict = json.loads(json_string)
        
        # Convert the dictionary to a JSON string
        formatted_json = json.dumps(content_dict, indent=4)
        return formatted_json

    except json.JSONDecodeError as e:
        print(f"Error decoding JSON: {e}")
        return None
    except Exception as e:
        print(f"Error converting set to JSON: {e}")
        return None


def dbConnection():
    connection = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="mhsp db"
        )
    return connection


def getPersonalizedContent(user_id):
    # Create the model
    generation_config = {
        "temperature": 1,
        "top_p": 0.95,
        "top_k": 64,
        "max_output_tokens": 8192,
        "response_mime_type": "application/json",
    }

    model = genai.GenerativeModel(
    model_name="gemini-1.5-flash",
    generation_config=generation_config,
    # safety_settings = Adjust safety settings
    # See https://ai.google.dev/gemini-api/docs/safety-settings
    system_instruction="Analyze the mood records of the user (which are provided in JSON format in the message) to identify patterns or trends . The JSON data will include timestamps and mood descriptions. Generate and send personalized content as tips, exercises, or articles to support the user's mental health in follwing JSON format. \n{\n  \"content\": [\n    {\n      \"type\": \"tip\",\n      \"title\": \"<YOUR RESPONSE>\",\n      \"body\": \"<YOUR RESPONSE>\"\n    },\n    {\n      \"type\": \"article\",\n      \"title\": \"<YOUR RESPONSE>\",\n      \"link\": \"<YOUR RESPONSE>\",\n      \"description\": \"<YOUR RESPONSE>\"\n    },\n    {\n      \"type\": \"exercise\",\n      \"title\": \"<YOUR RESPONSE>\",\n      \"description\": \"<YOUR RESPONSE>\"\n    }\n  ]\n}\n\nEnsure the content is relevant to the user's current emotional state, and handle all data confidentially and securely.(remember to analyze both frequent and old records to check patterns and trends)",

    )

    chat_session = model.start_chat(
        history=[
        ]
    )

    response = chat_session.send_message(getMoodLogs(user_id))
    response = response.text
    return response


def getMoodLogs(userId):
    try:
        connection = dbConnection()

        if connection.is_connected():
            cursor = connection.cursor()
            cursor.execute(f"SELECT * FROM mood_logs WHERE user_id ={userId}")
            data = cursor.fetchall()
            
            # Define the keys corresponding to the fields
            keys = ["id", "user_id", "mood", "intensity", "timestamp", "description", "tags"]

            # Convert each tuple to a dictionary
            json_data = [dict(zip(keys, item)) for item in data]

            # Custom serializer to handle datetime objects
            def custom_serializer(obj):
                if isinstance(obj, datetime.datetime):
                    return obj.isoformat()  # Convert datetime to string in ISO format
                raise TypeError("Type not serializable")

            # Convert the list of dictionaries to JSON
            json_output = json.dumps(json_data, default=custom_serializer, indent=4)
            return json_output

    except Error as e:
        print(f"Error: {e}")

    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()


@app.route("/get-content/<user_id>")
def getContent(user_id):
    content = {getPersonalizedContent(user_id)}
    content_dict = convert_set_to_json(content)
    
    print(content_dict)
    
    return (content_dict), 200


@app.route('/chat', methods=['POST'])
def chatBot():
    data = request.json
    user_message = data['user_message']
    print(user_message)
    history = []

    # Create the model
    generation_config = {
        "temperature": 1,
        "top_p": 0.95,
        "top_k": 64,
        "max_output_tokens": 8192,
        "response_mime_type": "text/plain",
    }

    model = genai.GenerativeModel(
    model_name="gemini-1.5-flash",
    generation_config=generation_config,
    # safety_settings = Adjust safety settings
    # See https://ai.google.dev/gemini-api/docs/safety-settings
    system_instruction="You are a friendly and helpful chatbot named ChatBuddy. Your primary goal is to assist users in a warm and approachable manner. Use a casual and conversational tone, making sure the user feels comfortable and understood. When answering questions, be clear and informative, but avoid overwhelming the user with too much information at once. If a user expresses concerns or negative emotions, respond with empathy and offer support. Use emojis occasionally to express emotions and make the conversation more engaging. Always strive to make the user’s experience pleasant and helpful.\n",
    )

    chat_session = model.start_chat(
        history=history
    )

    response = chat_session.send_message(user_message)
    message = response.text

    history.append({
      "role": "user",
      "parts": [
        user_message,
      ],
    })

    history.append({
      "role": "model",
      "parts": [
        message,
      ],
    })

    print(message)
    return message

if __name__ == "__main__":
    app.run(debug = True)



