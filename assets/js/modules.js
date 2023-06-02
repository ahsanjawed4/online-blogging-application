// // view user
function view_user(id) {
  var obj_five;
  if (window.ActiveXObject) obj_five = new ActiveXObject("Microsoft.XMLHTTP");
  else obj_five = new XMLHttpRequest();
  obj_five.onreadystatechange = function () {
    if (
      obj_five.readyState == 4 &&
      obj_five.status == 200 &&
      obj_five.statusText == "OK"
    ) {
      document.getElementById("view_user").innerHTML = obj_five.responseText;
    }
  };
  obj_five.open("POST", "actions.php");
  obj_five.setRequestHeader(
    "content-type",
    "application/x-www-form-urlencoded"
  );
  obj_five.send("crud=true&view_user=true&id=" + id);
}
// edit user
function edit_user(id) {
  var obj_six;
  if (window.ActiveXObject) obj_six = new ActiveXObject("Microsoft.XMLHTTP");
  else obj_six = new XMLHttpRequest();
  obj_six.onreadystatechange = function () {
    if (
      obj_six.readyState == 4 &&
      obj_six.status == 200 &&
      obj_six.statusText == "OK"
    ) {
      document.getElementById("view_user").innerHTML = obj_six.responseText;
    }
  };
  obj_six.open("POST", "actions.php");
  obj_six.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  obj_six.send("crud=true&update_user=true&id=" + id);
}
// // edit_regiser_user
function edit_account(id, old_img) {
  var edit_fname = document.getElementById("edit_fname");
  var edit_lname = document.getElementById("edit_lname");
  var edit_email = document.getElementById("edit_email");
  var edit_image = document.querySelector("#edit_image");
  var edit_password = document.getElementById("edit_password");
  var edit_gender = document.getElementById("edit_gender");
  var edit_address = document.getElementById("edit_address");
  var edit_status = document.getElementById("edit_status");
  var edit_approved = document.getElementById("edit_approved");
  var edit_dob = document.getElementById("edit_dob");
  var userData = new FormData();
  userData.append("fname", edit_fname.value);
  userData.append("lname", edit_lname.value);
  userData.append("email", edit_email.value);
  userData.append("password", edit_password.value);
  userData.append("gender", edit_gender.value);
  userData.append("address", edit_address.value);
  userData.append("is_active", edit_status.value);
  userData.append("is_approved", edit_approved.value);
  userData.append("dob", edit_dob.value);
  userData.append("id", id);
  userData.append("old_img", old_img);
  userData.append("edit_user", "true");
  if (edit_image.files[0]) {
    userData.append("edit_user_img", edit_image.files[0]);
  }
  var obj_seven;
  if (window.ActiveXObject) obj_seven = new ActiveXObject("Microsoft.XMLHTTP");
  else obj_seven = new XMLHttpRequest();
  obj_seven.onreadystatechange = function () {
    if (
      obj_seven.readyState == 4 &&
      obj_seven.status == 200 &&
      obj_seven.statusText == "OK"
    ) {
      alert("Account Updated");
      // document.getElementById("view_user").innerHTML = obj_seven.responseText;
      get_users();
    }
  };
  obj_seven.open("POST", "actions.php");
  obj_seven.send(userData);
}
function close_index() {
  window.location.href = "./index.php";
}
// // close btn
function close_form(id) {
  document.getElementById(id).innerHTML = "";
}
function manage(address) {
  window.location.href = "./" + address + ".php";
}
function logout() {
  window.location.href = "./logout.php";
}
