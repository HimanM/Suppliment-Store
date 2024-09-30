import mysql.connector
import os
import sys
import subprocess
# import google.generativeai as genai
from mysql.connector import Error
from flask import Flask, request, jsonify
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from dotenv import load_dotenv
import threading
import time
from datetime import datetime



#Configurations from .env
load_dotenv()
# genai.configure(api_key=(os.getenv("GEMINI_API_KEY")))
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



@app.route('/send_promotion_email', methods=['POST'])
def send_promotion_email():
    data = request.form
    title = data.get('title')
    body = data.get('body')

    # Run email sending in a separate thread to avoid blocking
    threading.Thread(target=send_bulk_emails, args=(title, body)).start()

    return jsonify({"status": "Emails are being sent!"}), 200


def send_bulk_emails(title, body):
    emails = get_user_emails()
    for email in emails:
        sendEmail(email,title,body)
        time.sleep(10)
    print(f"Sending emails with title: {title} and body: {body}")


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


def dbConnection():
    connection = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="supplement_store"
        )
    return connection

def get_user_emails():
    # List to store emails
    emails = []

    try:
        # Connect to the database
        connection = dbConnection()
        cursor = connection.cursor()

        # Query to get emails from users who opted for notifications
        query = """
            SELECT email FROM users WHERE offer_notifications = 'yes'
        """
        cursor.execute(query)

        # Fetch all results and append emails to the list
        results = cursor.fetchall()
        for row in results:
            emails.append(row[0])  # row[0] contains the email field

    except mysql.connector.Error as err:
        print(f"Error: {err}")
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()

    return emails

# Function to check reminders
def check_reminders():
    try:
        # Connect to the database
        conn = dbConnection()
        cursor = conn.cursor(dictionary=True)

        # SQL query to fetch due reminders
        query = """
        SELECT hs.title, hs.description, hs.reminder_time, u.email 
        FROM health_schedule hs
        JOIN schedule_reminders sr ON hs.id = sr.schedule_id
        JOIN users u ON hs.user_id = u.id
        WHERE sr.reminder_day = DAYNAME(NOW()) AND DATE_FORMAT(hs.reminder_time, '%H:%i') = DATE_FORMAT(NOW(), '%H:%i')
        """
        
        cursor.execute(query)
        reminders = cursor.fetchall()
        for reminder in reminders:
            # Compose the reminder message
            subject = f"Reminder: {reminder['title']}"
            message = f"{reminder['description']}\n\nReminder Time: {reminder['reminder_time']}"
            
            print("Reminder Found\n"+message)
            sendEmail(reminder['email'],subject,message)
            # send_reminder_email(reminder['email'], subject, message)

        cursor.close()
        conn.close()
    
    except mysql.connector.Error as err:
        print(f"Database error: {err}")

def run_reminder_checker(interval=55):
    print("Reminder Sender Started")
    while True:
        check_reminders()  # Check reminders at every interval
        time.sleep(interval)  # Wait for the defined interval (in seconds)

def run_flask():
    print("Flask Started")
    app.run(debug = True)

def install_requirements():
    # Check if 'pip' is available
    try:
        subprocess.check_call([sys.executable, '-m', 'pip', 'install', '--upgrade', 'pip'])
        
    except subprocess.CalledProcessError as e:
        print(f"Error upgrading pip: {e}")
        sys.exit(1)

    # Install packages from requirements.txt
    try:
        subprocess.check_call([sys.executable, '-m', 'pip', 'install', '-r', 'requirements.txt'])
        time.sleep(2)

        if os.name == 'nt':
            # For Windows
            os.system('cls')
        else:
            # For Unix-based systems (Linux, macOS)
            os.system('clear')

    except subprocess.CalledProcessError as e:
        print(f"Error installing packages: {e}")
        sys.exit(1)

if __name__ == "__main__":
    
    install_requirements()
    reminder_thread = threading.Thread(target=run_reminder_checker)
    reminder_thread.start()
    run_flask()
    



