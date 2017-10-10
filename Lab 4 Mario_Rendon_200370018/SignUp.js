function isValid()
{
  var email = document.forms["sign-up-form"]["email"].value;
  var username = document.forms["sign-up-form"]["username"].value;
  var password = document.forms["sign-up-form"]["password"].value;
  var confirmPass = document.forms["sign-up-form"]["confirm"].value;

 if(email.length == 0){
   document.getElementById('head').innerHTML = "* All inputs are mandatory *";
   document.forms["sign-up-form"]["email"].focus();
   return false;
 };

 if(emailValidation(email, "Please Enter your email address in this username@somewhere.sth")){
   if(userValid(username, "Please Enter your Username format(No leading or trailing spaces)")){
     if(passLength(password, "Please Enter the passord correctly (8 characters long, at least one non-letter)")){
       if(matchingPass(passord, confirmPass, "The confirmed password should be the same as the password above")){
         return true;
       }
     }
   }
 }
return false;
};

function emailValidation(email, message){
var email_check = /^[\w-.+]+@[a-zA-Z0-9.-]+.[a-zA-z0-9]{2,4}$/;
if(email.match(email_check)){
  return true;
  } else {
    document.getElementById('head').innerHTML = message;
    document.forms["sign-up-form"]["email"].focus();
    return false;
  }
};

function userValid(username, message){
var user_check = /^[0-9a-zA-Z]+$/;
if(username.match(user_check)){
  return true;
} else{
  document.getElementById('T1').innerHTML = message;
  document.forms["sign-up-form"]["username"].focus();
  return false;
}
};

function passLength(password, message){
var pass_check= /^[A-Za-z0-9_@#$%!*&]{8}$/;
if(password.match(pass_check)){
    return true;
    }
} else{
  document.getElementById('T2').innerHTML = message;
  document.forms["sign-up-form"]["password"].focus();
  return false;
}
};

function matchingPass(password, confirmPass, message){

};
