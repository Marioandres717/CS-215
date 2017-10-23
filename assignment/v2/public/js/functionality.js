function checkEmail(elements){
  var email = elements[0].value;
  var email_v = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;

  if(email=="" || email==null || !email_v.test(email)){
    var newItem = document.createElement("p");
    newItem.innerHTML = "Please enter a valid email";
    elements.insertBefore(newItem, elements.childNodes[0]);
    elements.valid = false;
    console.log(elements.valid);
  }

};

function validate(event){

  var elements = event.currentTarget;
  elements.valid = new Boolean(true);
  console.log(elements.valid);

  checkEmail(elements);
  console.log(elements.valid);


  if(elements.valid == true){
    event.preventDefault();
  }
};

function passValidate(event){
  alert("YOU SUBMITTED");
};
