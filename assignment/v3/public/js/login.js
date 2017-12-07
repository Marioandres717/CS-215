var loginForm = document.getElementsByClassName("login_form");
   for(i = 0; i<loginForm.length; i++){
     loginForm[i].addEventListener("submit", loginValidation, false);
   }
 var passForm = document.getElementsByClassName("passcode_form");
    for(j = 0; j<passForm.length; j++){
      passForm[j].addEventListener("submit", passValidate, false);
    }
