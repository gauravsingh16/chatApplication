Instructions for Chat Applications:

1. Running application on local using using Slim framework. 
2. Languages used for application→ PHP, HTML,JS
3. Run Project with : php -S localhost:8081 -t public

Routes:
ii- localhost:8081/ → Redirect to a sample login page for guest username.
iii- localhost:8081/login → Redirect user to main page of application after storing username.
Iv- localhost:8081/logged_users → To show all the users whose session are still UP.
v- localhost:8081/newgroup → User can create new public group.
vi- localhost:8081/allgroups → Returns list of all groups.
Vii- localhost:8081/chatsend → Route for message send button.
Viii- localhost:8081/chatlist → Shows all the messages of a group with its users. 

Note: Because of bad GUI, URLs might not work.  Functions tested through postman and using mock test cases.  

Routes specified in → routes.php
Database Connection → DatabaseConfig.php   #broken need help.
index.php → PHP RUN.
login_page.php → HTML login form with asking username from user and passing to PHP.
chat_client.php → Homepage for message sending in chat application

System design in chatsys.pdf