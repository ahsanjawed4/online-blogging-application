$(document).ready(function () {
  $("#example").DataTable();
});
function view_posts() {
  var obj;
  if (window.XMLHttpRequest) obj = new XMLHttpRequest();
  else obj = new ActiveXObject("Mircosoft.XMLHTTP");
  obj.onreadystatechange = function () {
    if (obj.readyState == 4 && obj.status == 200 && obj.statusText === "OK") {
      document.getElementById("post_table").innerHTML = obj.responseText;
      $("#example").DataTable();
    }
  };
  obj.open("GET", "actions.php?view_posts=true");
  obj.send();
}
view_posts();
function show_post_form() {
  var obj;
  if (window.XMLHttpRequest) obj = new XMLHttpRequest();
  else obj = new ActiveXObject("Mircosoft.XMLHTTP");
  obj.onreadystatechange = function () {
    if (obj.readyState == 4 && obj.status == 200 && obj.statusText === "OK") {
      document.getElementById("manage_posts_col").innerHTML = obj.responseText;
    }
  };
  obj.open("GET", "actions.php?post_form=true");
  obj.send();
}
show_post_form();
function addAttachment() {
  var element = document.getElementById("post_att_div");
  element.style.height = "200px";
  if (element.clientHeight == 200) {
    element.style.overflow = "auto";
  }
  if (window.XMLHttpRequest) obj_checked = new XMLHttpRequest();
  else obj_checked = new ActiveXObj_checkedect("Mircosoft.XMLHTTP");
  obj_checked.onreadystatechange = function () {
    if (
      obj_checked.readyState == 4 &&
      obj_checked.status == 200 &&
      obj_checked.statusText === "OK"
    ) {
      element.innerHTML += obj_checked.responseText;
    }
  };
  obj_checked.open("POST", "actions.php");
  obj_checked.setRequestHeader(
    "content-type",
    "application/x-www-form-urlencoded"
  );
  obj_checked.send("check_att=true");
}
function removeAttachment(obj) {
  obj.parentNode.remove();
}
// Variables
function add_post() {
  var post_title = document.querySelector("#post_title");
  var post_image = document.querySelector("#post_image").files[0];
  var post_summary = document.querySelector("#post_summary");
  var post_description = document.querySelector("#post_description");
  var post_blog = document.querySelector("#post_blog");
  var post_comment_mode = document.querySelector("#post_comment_mode");
  var post_category = document.getElementsByClassName("post_category");
  var check_post_attch = document.querySelector("#check_post_attch");
  var checking = false;
  var flag = true;
  var postData = new FormData();
  if (
    !post_title.value ||
    !post_image ||
    !post_summary.value ||
    !post_description.value ||
    !post_blog.value ||
    !post_comment_mode.value
  ) {
    flag = false;
  }
  var count = 0;
  for (var i = 0; i <= post_category.length - 1; i++) {
    if (post_category[i].checked) count = count + 1;
  }
  if (!count) {
    flag = false;
  }
  var attachement_image = document.querySelectorAll(".attachement_image");
  var post_attachement_title = document.querySelectorAll(
    ".post_attachement_title"
  );
  var attachement_count = 0;
  for (var a = 0; a <= post_attachement_title.length - 1; a++) {
    attachement_count++;
  }
  if (attachement_count) {
    postData.append("attachement_count", attachement_count);
    for (var b = 0; b <= attachement_count - 1; b++) {
      postData.append(
        "post_attachement_title_" + b,
        post_attachement_title[b].value
      );
      postData.append("attachement_image_" + b, attachement_image[b].files[0]);
    }
  }
  if (flag) {
    postData.append("post_title", post_title.value);
    postData.append("post_image", post_image);
    postData.append("post_summary", post_summary.value);
    postData.append("post_description", post_description.value);
    postData.append("post_blog", post_blog.value);
    postData.append("post_comment_mode", post_comment_mode.value);
    var cat_ideees = "";
    for (var i = 0; i <= post_category.length - 1; i++) {
      if (post_category[i].checked) cat_ideees += post_category[i].value + ",";
    }
    postData.append("post_category", cat_ideees);
    postData.append("post", "true");

    var post_obj;
    if (window.XMLHttpRequest) post_obj = new XMLHttpRequest();
    else post_obj = new ActiveXpost_Object("Mircosoft.XMLHTTP");
    post_obj.onreadystatechange = function () {
      if (
        post_obj.readyState == 4 &&
        post_obj.status == 200 &&
        post_obj.statusText === "OK"
      ) {
        document.getElementById("manage_posts_col").innerHTML =
          post_obj.responseText;
        alert("Post Added Successfully");
        view_posts();
      }
    };
    post_obj.open("POST", "actions.php");
    post_obj.send(postData);
  } else document.querySelector("#post_error").innerHTML = "Kindly Select Data";
}

// update_post_status
function update_post_status(status, { value }) {
  var update_status = "";
  if (status == "Active") update_status = "InActive";
  else update_status = "Active";
  var update_obj;
  if (window.XMLHttpRequest) update_obj = new XMLHttpRequest();
  else update_obj = new ActiveXObject("Mircosoft.XMLHTTP");
  update_obj.onreadystatechange = function () {
    if (
      update_obj.readyState == 4 &&
      update_obj.status == 200 &&
      update_obj.statusText == "OK"
    ) {
      if (update_obj.responseText) {
        alert("Post " + update_status);
        view_posts();
      }
    }
  };
  update_obj.open("POST", "actions.php");
  update_obj.setRequestHeader(
    "content-type",
    "application/x-www-form-urlencoded"
  );
  update_obj.send(
    "update_post_status=true&status=" + update_status + "&id=" + value
  );
}
// update_post statua
function update_post(id) {
  var obj;
  if (window.XMLHttpRequest) obj = new XMLHttpRequest();
  else obj = new ActiveXObject("Mircosoft.XMLHTTP");
  obj.onreadystatechange = function () {
    if (obj.readyState == 4 && obj.status == 200 && obj.statusText == "OK") {
      document.getElementById("manage_posts_col").innerHTML = obj.responseText;
    }
  };
  obj.open("POST", "actions.php");
  obj.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  obj.send("update_post=true&id=" + id);
}
// update whole post
function updated_data(id) {
  var post_title = document.querySelector("#update_post_title").value;
  var post_image = document.querySelector("#update_post_image");
  var post_summary = document.querySelector("#update_post_summary").value;
  var old_featured_image = document.querySelector("#old_featured_image").value;
  var post_description = document.querySelector(
    "#update_post_description"
  ).value;
  var post_blog = document.querySelector("#update_post_blog").value;
  var post_comment_mode = document.querySelector(
    "#update_post_comment_mode"
  ).value;
  var post_categories = document.querySelectorAll(".update_post_category");
  var cat_idees = "";
  post_categories.forEach((a) => {
    if (a.checked) cat_idees += a.value + ",";
  });
  var update_post_form_data = new FormData();
  update_post_form_data.append("id", id);
  update_post_form_data.append("post_title", post_title);
  update_post_form_data.append("post_summary", post_summary);
  update_post_form_data.append("old_featured_image", old_featured_image);
  update_post_form_data.append("post_description", post_description);
  update_post_form_data.append("post_blog", post_blog);
  update_post_form_data.append("post_comment_mode", post_comment_mode);
  update_post_form_data.append("cat_idees", cat_idees);
  if (post_image.files[0])
    update_post_form_data.append("post_image", post_image.files[0]);
  update_post_form_data.append("update_post_data", "true");

  var obj_data_object;
  if (window.XMLHttpRequest) obj_data_object = new XMLHttpRequest();
  else obj_data_object = new ActiveXObject("Mircosoft.XMLHTTP");
  obj_data_object.onreadystatechange = function () {
    if (
      obj_data_object.readyState == 4 &&
      obj_data_object.status == 200 &&
      obj_data_object.statusText == "OK"
    ) {
      alert("Post Updated");
      show_post_form();
    }
  };
  obj_data_object.open("POST", "actions.php");
  obj_data_object.send(update_post_form_data);
}

// close_post
function close_post() {
  window.location.href = "./manage_posts.php";
}
// update_attachement
function update_attachement(status, { value }) {
  var post_iddd = document.querySelector("#post_iddd");
  update_status = "";
  if (status == "Active") update_status = "InActive";
  else update_status = "Active";
  var update_status = "";
  if (status == "Active") update_status = "InActive";
  else update_status = "Active";
  var update_obj;
  if (window.XMLHttpRequest) update_obj = new XMLHttpRequest();
  else update_obj = new ActiveXObject("Mircosoft.XMLHTTP");
  update_obj.onreadystatechange = function () {
    if (
      update_obj.readyState == 4 &&
      update_obj.status == 200 &&
      update_obj.statusText == "OK"
    ) {
      update_post(post_iddd.value);
    }
  };
  update_obj.open("POST", "actions.php");
  update_obj.setRequestHeader(
    "content-type",
    "application/x-www-form-urlencoded"
  );
  update_obj.send(
    "update_attachement=true&status=" + update_status + "&id=" + value
  );
}
