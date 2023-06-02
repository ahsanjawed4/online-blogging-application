$(document).ready(function () {
  $("#example").DataTable();
});
function view_comments() {
  var obj;
  if (window.XMLHttpRequest) obj = new XMLHttpRequest();
  else obj = new ActiveXObject("Microsoft.XMLHTTP");
  obj.onreadystatechange = function () {
    if (obj.readyState == 4 && obj.status == 200 && obj.statusText == "OK") {
      document.querySelector("#view_comments").innerHTML = obj.responseText;
      $("#example").DataTable();
    }
  };
  obj.open("GET", "actions.php?view_comments=true");
  obj.send();
}
view_comments();
function update_comment(status, { value }) {
  var update_status = "";
  if (status == "Active") update_status = "InActive";
  else update_status = "Active";
  var obj;
  if (window.XMLHttpRequest) obj = new XMLHttpRequest();
  else obj = new ActiveXObject("Microsoft.XMLHTTP");
  obj.onreadystatechange = function () {
    if (obj.readyState == 4 && obj.status == 200 && obj.statusText == "OK") {
      view_comments();
    }
  };
  obj.open("POST", "actions.php");
  obj.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  obj.send("update_comment=true&status=" + update_status + "&id=" + value);
}
