// AJAX FUNCTIONS
// ENABLE UPDATES FOR INDEX PAGE
// THE clearInterval function works only with global variables
var enableUpdate = false;
var messagesInterval;
var commentInterval;
function enableUpdates(){

  enableUpdate = !enableUpdate;
  if(enableUpdate) {
    document.getElementById("turn-off").classList.remove("active");
    messagesInterval = setInterval(updates, 5000);
    commentInterval = setInterval(commentUpdates, 5000);
  }
  else {
    document.getElementById("turn-off").classList.add("active");
    if(messagesInterval !== undefined) clearInterval(messagesInterval);
    if(commentInterval !== undefined) clearInterval(commentInterval);
  }
}

//UPDATE MESSAGES FROM MESSAGE LIST PAGE
function updates(){
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      debugger;
      var newMessages = JSON.parse(this.responseText);
      if(newMessages.foo == 1){
      }else{
        for(i = 1; i < newMessages.length; i++){
           var row = "<p>Last view: "+newMessages[i].lastView+"</p>"+
           "<h2>"+newMessages[i].title+"</h2>"+
           "<p>Date post: "+newMessages[i].date+"</p>"+
           "<p>Time post: "+newMessages[i].time+"</p>"+
           "<button type='submit' name='delete_button' value='$m_id' class='btn-delete default-page'><i class='fa fa-trash' aria-hidden='true'></i></button>"+
           "<p class='post-content'>"+newMessages[i].content+"</p>"+
           "<img class='index-img' src='"+newMessages[i].image+"'/>"+
           "<hr>";
           var newDiv = document.createElement("div");
           newDiv.innerHTML = row;
           document.getElementById("update_msg").appendChild(newDiv);
           newDiv.id = newMessages[i].message_id;
           newDiv.classList.add("msg-post");
           var spaceDiv = document.createElement("div");
           document.getElementById("update_msg").appendChild(spaceDiv);
           spaceDiv.classList.add("space");
          }
        }
      }
    }
    xhr.open("GET", "updateMessages.php", true);
    xhr.send();
}

//UPDATE COMMENTS FROM MESSAGE LIST PAGE
function commentUpdates(){
  var xhc = new XMLHttpRequest();
  xhc.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      var newComments = JSON.parse(this.responseText);
      if(newComments.foo == 1){
      }else{
        for(i = 1; i < newComments.length; i++){
           var row = "<h3>"+newComments[i].title+"</h3>"+
                     "<p> Date: "+newComments[i].date+"</p>"+
                     "<p> Time: "+newComments[i].time+"</p>"+
                     "<p>"+newComments[i].content+"</p>"+
                     "<hr>";
                     var child = document.createElement("div");
                     child.innerHTML = row;
                     var parent =  document.getElementById(newComments[i].message_id);
                     parent.appendChild(child);
                     child.classList.add("reply-post");
           }
         }
      }
    }
    xhc.open("GET", "updateComments.php", true);
    xhc.send();
}
// REQUEST SUGGESTIONS FOR THE PASSCODE
function suggestPasscode(event){
  var str = event.currentTarget.value;
  if(str.length == 0){
    document.getElementById(suggestions).innerHTML = "";
  } else {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){
       var response = JSON.parse(this.responseText);
        var row = '<h3>Try this passcodes</h3>';
        for(i = 0; i < response.suggestions.length; i++){
          row += "<p class='desirePass'>" + response.suggestions[i] + "</p>";
        }
        document.getElementById("suggestions").innerHTML = row;

        //LISTEN FOR CLICKS FOR THE DESIRED PASSCODE
        var x = document.getElementsByClassName("desirePass");
        for(u = 0; u < x.length; u++){
        x[u].addEventListener("click", addString, false);
        }
      }
    }
    xhr.open("GET", "passgen.php?q="+str, true);
    xhr.send();
  }
};

// ADDS THE CLICKED STRING TO THE PASSCODE INPUT
function addString(e){
link = e.currentTarget.innerHTML;
document.getElementById("passcode").value = link;
};


// GENERAL FUNCTIONS
function checkEmail(email){
  var email_v = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;

  if(email=="" || email==null || !email_v.test(email)){
    document.getElementById("email_id").innerHTML="Please enter a valid email";
    return false;
  }
    document.getElementById("email_id").innerHTML= "";
  return true;
};

function checkPassword(password){
  var password_v = /^(?=.*[0-9!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;  // HAVE TO CHANGE

  if(password == "" || password == null || !password_v.test(password)){
    document.getElementById("password_id").innerHTML = "Password Must be 8 characters or longer";
    return false;
  }
  document.getElementById("password_id").innerHTML = "";
  return true;
};

function checkPasscode(pass){
  var pass_v = /^[a-zA-Z0-9]{8}$/;
  if(pass == "" || pass == null || !pass_v.test(pass)){
    document.getElementById("passcode_id").innerHTML = "Code is 8 char long, letters and digits only";
    return false;
  }
 document.getElementById("passcode_id").innerHTML= "";
 return true;
};

function checkFirstName(firstName){
  if(firstName == "" || firstName == null){
    document.getElementById("firstName_id").innerHTML ="Required Field";
    return false;
  }
  document.getElementById("firstName_id").innerHTML ="";
  return true;
};

function checkLastName(lastName){
  if(lastName == "" || lastName == null){
    document.getElementById("lastName_id").innerHTML ="Required Field";
    return false;
  }
  document.getElementById("lastName_id").innerHTML ="";
  return true;
};

function checkDate(date){
  var date_v = /^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/;
  if(date == null || date == "" || !date_v.test(date)){
    document.getElementById("dateOfBirth_id").innerHTML = "Invalid date format";
    return false;
  }
  document.getElementById("dateOfBirth_id").innerHTML = "";
  return true;
};

function checkConfirmPass(originalPass, ConfirmPass){
  if(ConfirmPass !== originalPass){
    document.getElementById("repeatPassword_id").innerHTML = "Passwords do not match";
    return false;
  }
  document.getElementById("repeatPassword_id").innerHTML = "";
  return true;
}

function checkRecipientEmail(recipient){
  if(recipient == "" || recipient == null){
    document.getElementById("recipient-email_id").innerHTML = "Enter a valid recipient";
    return false;
  }
  document.getElementById("recipient-email_id").innerHTML = "";
  return true;
};

function checkContentOfMsg(content){
  if(content == "" || content == null){
    document.getElementById("message_id").innerHTML = "Cannot send empty messages";
    return false;
  }
  document.getElementById("message_id").innerHTML = "";
  return true;
};

function charCounter(event){
  var numberOfChar = event.currentTarget;
  document.getElementById('message_id').innerHTML = " Characters left: " + (500 - numberOfChar.value.length);
};



// LOGIN PAGE FUNCTIONS
function loginValidation(event){
  var validEmail = checkEmail(document.getElementById("email").value);
  var validPass = checkPassword(document.getElementById("password").value);

  if(validEmail == false || validPass == false){
    event.preventDefault();
  }
};

function passValidate(event){
  var success = checkPasscode(document.getElementById("passcode").value);
  if(success == false){
    event.preventDefault();
  }
};

// SIGN UP FUNCTIONS
function signUpValidation(event){
  var fname = checkFirstName(document.getElementById("firstName").value);
  var lname = checkLastName(document.getElementById("lastName").value);
  var email = checkEmail(document.getElementById("email").value);
  var date = checkDate(document.getElementById("dateOfBirth").value);
  var password = checkPassword(document.getElementById("password").value);
  var confirmPass = checkConfirmPass(document.getElementById("password").value, document.getElementById("repeatPassword").value);

  if(fname == false || lname == false || email == false || date == false || password == false || confirmPass == false){
    event.preventDefault();
  }
};

// POST MESSAGE FUNCTIONS
function messageValidation(event){
  var recipient = checkRecipientEmail(document.getElementById("recipientEmail").value);
  var message = checkContentOfMsg(document.getElementById("message").value);
  var passcode = checkPasscode(document.getElementById("passcode").value);

  if(recipient == false || message == false || passcode == false){
    event.preventDefault();
  }
};

// REPLY MESSAGE FUNCTIONS
function ReplyValidation(event){
  var recipient = checkRecipientEmail(document.getElementById("recipientEmail").value);
  var message = checkContentOfMsg(document.getElementById("message").value);

  if(recipient == false || message == false){
    event.preventDefault();
  }
};
