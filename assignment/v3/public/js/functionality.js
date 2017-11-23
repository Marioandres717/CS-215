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
