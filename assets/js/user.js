// AJAX
function get_users() {
  var obj_one;
  if (window.XMLHttpRequest) obj_one = new XMLHttpRequest();
  else obj_one = new ActiveXObject("Microsoft.XMLHTTP");
  obj_one.onreadystatechange = function () {
    if (
      obj_one.readyState == 4 &&
      obj_one.status == 200 &&
      obj_one.statusText == "OK"
    ) {
      document.getElementById("user_table").innerHTML = obj_one.responseText;
    }
  };
  obj_one.open("GET", "actions.php?get_users=true");
  obj_one.send();
}
get_users();
function filtering() {
  var obj_two;
  if (window.ActiveXObject) obj_two = new ActiveXObject("Microsoft.XMLHTTP");
  else obj_two = new XMLHttpRequest();
  obj_two.onreadystatechange = function () {
    if (
      obj_two.readyState == 4 &&
      obj_two.status == 200 &&
      obj_two.statusText == "OK"
    )
      document.getElementById("user_table").innerHTML = obj_two.responseText;
  };
  obj_two.open("POST", "actions.php");
  obj_two.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  obj_two.send(
    "search=true&searching=" + document.getElementById("filter_Value").value
  );
}
function user_status(prop, id) {
  var obj_three;
  if (window.ActiveXObject) obj_three = new ActiveXObject("Microsoft.XMLHTTP");
  else obj_three = new XMLHttpRequest();
  obj_three.onreadystatechange = function () {
    if (
      obj_three.readyState == 4 &&
      obj_three.status == 200 &&
      obj_three.statusText == "OK"
    ) {
      if (obj_three.responseText) get_users();
    }
  };
  obj_three.open("POST", "actions.php");
  obj_three.setRequestHeader(
    "content-type",
    "application/x-www-form-urlencoded"
  );
  obj_three.send("is_active=true&id=" + id + "&value=" + prop.value);
}
function account_approval(prop) {
  document.getElementById("reg_user").innerHTML = prop.value + " Users";
  var obj_four;
  if (window.ActiveXObject) obj_four = new ActiveXObject("Microsoft.XMLHTTP");
  else obj_four = new XMLHttpRequest();
  obj_four.onreadystatechange = function () {
    if (
      obj_four.readyState == 4 &&
      obj_four.status == 200 &&
      obj_four.statusText == "OK"
    ) {
      document.getElementById("user_table").innerHTML = obj_four.responseText;
    }
  };
  obj_four.open("POST", "actions.php");
  obj_four.setRequestHeader(
    "content-type",
    "application/x-www-form-urlencoded"
  );
  obj_four.send(
    "get_users=true&account_approval=true" + "&value=" + prop.value
  );
}
// Add user
function add_user() {
  var obj_nine;
  if (window.ActiveXObject) obj_nine = new ActiveXObject("Microsoft.XMLHTTP");
  else obj_nine = new XMLHttpRequest();
  obj_nine.onreadystatechange = function () {
    if (
      obj_nine.readyState == 4 &&
      obj_nine.status == 200 &&
      obj_nine.statusText == "OK"
    )
      document.getElementById("view_user").innerHTML = obj_nine.responseText;
  };
  obj_nine.open("POST", "actions.php");
  obj_nine.setRequestHeader(
    "content-type",
    "application/x-www-form-urlencoded"
  );
  obj_nine.send("add_user=true");
}
// add
function add() {
  var fname = document.getElementById("fname").value;
  var lname = document.getElementById("lname").value;
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  var user_image = document.getElementById("user_image").files[0];
  var date_of_birth = document.getElementById("date_of_birth").value;
  var addrress = document.getElementById("addrress").value;
  var gender = null;
  var male = document.getElementById("male");
  var female = document.getElementById("female");
  var other = document.getElementById("other");
  if (male.checked) gender = male.value;
  if (female.checked) gender = female.value;
  if (other.checked) gender = other.value;
  var flag = true;
  if (
    !fname ||
    !lname ||
    !email ||
    !password ||
    !user_image ||
    !date_of_birth ||
    !addrress ||
    !gender
  ) {
    flag = false;
  }
  if (flag) {
    var user_data = new FormData();
    user_data.append("fname", fname);
    user_data.append("lname", lname);
    user_data.append("email", email);
    user_data.append("password", password);
    user_data.append("user_image", user_image);
    user_data.append("date_of_birth", date_of_birth);
    user_data.append("addrress", addrress);
    user_data.append("gender", gender);
    user_data.append("user_added", "true");
    var add_user_obj;
    if (window.XMLHttpRequest) add_user_obj = new XMLHttpRequest();
    else add_user_obj = new ActiveXObject("Mircosoft.XMLHTTP");
    add_user_obj.onreadystatechange = function () {
      if (
        add_user_obj.readyState == 4 &&
        add_user_obj.status == 200 &&
        add_user_obj.statusText === "OK"
      ) {
        if (!add_user_obj.responseText) {
          document.getElementById("add_error").innerHTML =
            "This email is already registerd";
        } else {
          alert("User is registered");
          document.getElementById("view_user").innerHTML = "";
          get_users();
        }
      }
    };
    add_user_obj.open("POST", "actions.php");
    add_user_obj.send(user_data);
  } else {
    document.getElementById("add_error").innerHTML = "Kindly Insert Data";
  }
}
function resetData() {
  var fname = document.getElementById("fname");
  var lname = document.getElementById("lname");
  var email = document.getElementById("email");
  var confirm_email = document.getElementById("confirm_email");
  var password = document.getElementById("password");
  var confirm_password = document.getElementById("confirm_password");
  var date_of_birth = document.getElementById("date_of_birth");
  var addrress = document.getElementById("addrress");
  var male = document.getElementById("male");
  var female = document.getElementById("female");
  var other = document.getElementById("other");
  fname.value = "";
  lname.value = "";
  email.value = "";
  confirm_email.value = "";
  password.value = "";
  confirm_password.value = "";
  // user_image.files[0] = "";
  date_of_birth.value = "";
  addrress.value = "";
  if (male.checked) male.checked = false;
  if (female.checked) female.checked = false;
  if (other.checked) female.checked = false;
}
//  AJAX END
