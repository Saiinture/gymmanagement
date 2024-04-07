<?php
session_start();
//the isset function to check username is already loged in and stored on the session
if(!isset($_SESSION['user_id'])){
header('location:../index.php');	
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Gym System</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="../css/fullcalendar.css" />
<link rel="stylesheet" href="../css/matrix-style.css" />
<link rel="stylesheet" href="../css/matrix-media.css" />
<link href="../font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="../css/jquery.gritter.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="index.php">Perfect Gym System</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<?php include '../includes/topheader.php'?>
<!--close-top-Header-menu-->
<!--sidebar-menu-->
<?php $page="chat"; include '../includes/sidebar.php'?>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.php" title="You're right here" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
    
<!--End-Action boxes-->  

<style>
  /* Chat Container Styles */

#chat-container {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 20px;
    max-height: 400px;
    /* Adjust height as needed */
    overflow-y: scroll;
}


/* Chat Messages Styles */

.chat-message {
    padding: 10px;
    margin: 5px 0;
    border-radius: 5px;
}


/* Differentiate between user and bot messages */

.user-message {
    background-color: #d1ecf1;
    text-align: right;
}

.bot-message {
    background-color: #d4edda;
}


/* Input Group Styles */

.input-group {
    max-width: 600px;
    /* Adjust width as needed */
    margin: 0 auto;
}


/* Send Button Styles */

#send-button {
    background-color: #007bff;
    color: white;
}

#send-button:hover {
    background-color: #0056b3;
}


/* Placeholder text color */

#user-input::placeholder {
    color: #999;
}

</style>

    <div class="row-fluid"> 
    <div class="">
        <h2 class="text-center my-4">AI Personal Trainer</h2>
        <p class="text-center">Ask anything about Gym & Workouts</p>
        <div id="chat-container" class="border bg-light p-3 mb-4" style="height: 300px; overflow-y: auto;">
            <!-- Chat messages will be displayed here -->
        </div>
        <div class="input-group mb-3">
            <input type="text" id="user-input" class="form-control" placeholder="Type your message here..." aria-label="User's message" aria-describedby="button-addon2">
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="send-button">Send</button>
            </div>
        </div>
    </div>
	  
	  
	  
    </div><!-- End of row-fluid -->
  </div><!-- End of container-fluid -->
</div><!-- End of content-ID -->
</div>
<!--end-main-container-part-->

<!--Footer-part-->

<div class="row-fluid">
  <div id="footer" class="span12"> <?php echo date("Y");?> &copy; </a> </div>
</div>

<style>
#footer {
  color: white;
}
</style>

<!--end-Footer-part-->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


<script>
  document.getElementById('send-button').addEventListener('click', function() {
    var userInput = document.getElementById('user-input').value;
    var chatContainer = document.getElementById('chat-container');

    if (userInput.trim() === '') {
        return; // Don't send empty messages
    }

    var userMessageDiv = document.createElement('div');
userMessageDiv.classList.add('chat-message', 'user-message');
// This will parse the HTML in userInput and render it accordingly
userMessageDiv.innerHTML = userInput; // userInput should be a string containing HTML
chatContainer.appendChild(userMessageDiv);



    // Scroll to the bottom of the chat container
    chatContainer.scrollTop = chatContainer.scrollHeight;

    // Clear the input field
    document.getElementById('user-input').value = '';

    // Send the user input to chatbot.php
    // Send the user input to chatbot.php
    fetch('chatbot.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'user_input=' + encodeURIComponent(userInput)
        })
        .then(response => response.json())
        .then(data => {
            // Log the data to the console for debugging
            console.log(data);

            // Check if the data.message property exists before trying to access it
            if (data && data.message) {
                // Display the chatbot's response
                var botMessageDiv = document.createElement('div');
                botMessageDiv.classList.add('chat-message', 'bot-message');
                botMessageDiv.innerHTML = data.message;
    chatContainer.appendChild(botMessageDiv);
            } else {
                // If data.message is undefined, log an error message and/or display a default message
                console.error('The response data does not contain a message property.');
                var botMessageDiv = document.createElement('div');
                botMessageDiv.classList.add('chat-message', 'bot-message');
                botMessageDiv.textContent = 'Sorry, I am unable to respond at the moment.';
                chatContainer.appendChild(botMessageDiv);
            }

            // Scroll to the bottom of the chat container
            chatContainer.scrollTop = chatContainer.scrollHeight;
        })
        .catch(error => {
            // Log any error that occurs during the fetch operation
            console.error('Error:', error);
        });

});
</script>
</body>
</html>
