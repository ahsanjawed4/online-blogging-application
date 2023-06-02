// Global Variables;
var fname = document.getElementById("fname");
var lname = document.getElementById("lname");
var email = document.getElementById("email");
var confirm_email = document.getElementById("confirm_email");
var password = document.getElementById("password");
var confirm_password = document.getElementById("confirm_password");
var user_image = document.getElementById("user_image");
var date_of_birth = document.getElementById("date_of_birth");
var gender = null;
var male = document.getElementById("male");
var female = document.getElementById("female");
var other = document.getElementById("other");
var address = document.getElementById("address");
var fname_error = document.getElementById("fname_error");
var lname_error = document.getElementById("lname_error");
var email_error = document.getElementById("email_error");
var confirm_email_error = document.getElementById("confirm_email_error");
var password_error = document.getElementById("password_error");
var confirm_password_error = document.getElementById("confirm_password_error");
var profile_img_error = document.getElementById("profile_img_error");
var dob_error = document.getElementById("dob_error");
var gender_error = document.getElementById("gender_error");
var aaddrress_error = document.getElementById("adress_error");
// function close_index() {
//   window.location.href = "./index.php";
// }
// reset user
function resetUser() {
  fname.value = "";
  lname.value = "";
  email.value = "";
  confirm_email.value = "";
  password.value = "";
  confirm_password.value = "";
  user_image.value = "";
  date_of_birth.value = "";
  address.value = "";
  male.checked = false;
  female.checked = false;
  other.checked = false;
  fname_error.innerHTML = "";
  lname_error.innerHTML = "";
  email_error.innerHTML = "";
  confirm_email_error.innerHTML = "";
  password_error.innerHTML = "";
  confirm_password_error.innerHTML = "";
  profile_img_error.innerHTML = "";
  dob_error.innerHTML = "";
  gender_error.innerHTML = "";
  aaddrress_error.innerHTML = "";
}
// Patterns
var fname_lname_pattern = RegExp(/^[A-Z a-z 0-9]{3,}$/);
var email_pattern = RegExp(/^[A-Z a-z 0-9]{2,}[@][a-z]{5,}[.][a-z]{2,}$/);
var password_pattern = RegExp(/^[A-Z a-z 0-9]{8,}$/);
var date_pattern = RegExp(/^[0-9]{4}[-]{1}[0-9]{2}[-]{1}[0-9]{2}$/);
// register user
function registerUser() {
  var flag = true;
  if (fname.value) {
    if (fname_lname_pattern.test(fname.value)) {
      fname_error.innerHTML = "";
    } else {
      fname_error.innerHTML = "atleast 3 characters long";
      flag = false;
    }
  } else {
    flag = false;
    fname_error.innerHTML = "required";
  }
  if (lname.value) {
    lname_error.innerHTML = "";
    if (fname_lname_pattern.test(lname.value)) {
      lname_error.innerHTML = "";
    } else {
      lname_error.innerHTML = "atleast 3 characters long";
      flag = false;
    }
  } else {
    lname_error.innerHTML = "required";
    flag = false;
  }
  if (email.value) {
    email_error.innerHTML = "";
    if (email_pattern.test(email.value)) {
      email_error.innerHTML = "";
    } else {
      email_error.innerHTML = "email like:abc@gmail.com";
      flag = false;
    }
  } else {
    email_error.innerHTML = "required";
    flag = false;
  }
  if (confirm_email.value) {
    confirm_email_error.innerHTML = "";
    if (confirm_email.value != email.value) {
      confirm_email_error.innerHTML = "email is not matched";
      flag = false;
    } else confirm_email_error.innerHTML = "";
  } else {
    confirm_email_error.innerHTML = "required";
    flag = false;
  }
  if (password.value) {
    password_error.innerHTML = "";
    if (password_pattern.test(password.value)) {
      password_error.innerHTML = "";
    } else {
      password_error.innerHTML = "atleast 8 characters long";
      flag = false;
    }
  } else {
    password_error.innerHTML = "required";
    flag = "false";
  }
  if (confirm_password.value) {
    confirm_password_error.innerHTML = "";
    if (confirm_password.value != password.value) {
      confirm_password_error.innerHTML = "confirm password is not matched";
      flag = false;
    } else confirm_password_error.innerHTML = "";
  } else {
    confirm_password_error.innerHTML = "required";
    flag = false;
  }
  if (user_image.value) profile_img_error.innerHTML = "";
  else {
    profile_img_error.innerHTML = "required";
    flag = false;
  }
  if (date_of_birth.value) {
    dob_error.innerHTML = "";
    if (date_pattern.test(date_of_birth.value)) {
      dob_error.innerHTML = "";
    } else {
      dob_error.innerHTML = "Invalid Date of Birth i.e:2001-0-26";
      flag = false;
    }
  } else {
    dob_error.innerHTML = "required";
    flag = false;
  }
  if (male.checked) gender = male.value;
  if (female.checked) gender = female.value;
  if (other.checked) gender = other.value;
  if (gender) gender_error.innerHTML = "";
  else {
    gender_error.innerHTML = "required";
    flag = false;
  }
  if (address.value) aaddrress_error.innerHTML = "";
  else {
    aaddrress_error.innerHTML = "required";
    flag = false;
  }
  if (flag) return flag;
  else return false;
}
