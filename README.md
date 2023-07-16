Instructions for Chat Applications:
1. Running application on local using using Slim framework. 
2. Languages used for application→ PHP, HTML,JS
Steps:
i- localhost:8081/util/db_setup → Redirect helps to create database and table using sqlite.
ii- localhost:8081/ → Redirect to a sample login page for guest username.
iii- localhost:8081/homepage → Redirect user to main page of application where user can send messages on the open group.
Iv- localhost:8081/logged_users → To show all the users whose session are still UP.
v- localhost:8081/check_list → To show all the message from the users as a list.

Note: Because of bad GUI, URIs might not work.  Functions tested through postman. No test cases added.  

Routes specified in → routes.php
Database Connection → DatabaseConfig.php
index.php → Main Page
login_page.php → HTML login form with asking username from user and passing to backend.
chat_client.php → HTML page for message sending in chat application

System Design in /Chatsys.pdf