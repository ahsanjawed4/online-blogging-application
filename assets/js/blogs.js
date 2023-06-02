// Data Table
$(document).ready(function () {
  $("#example").DataTable();
});
// Blog
// AJAX Start
// View Blogs
function viewBlogs() {
  var blog_view;
  if (window.XMLHttpRequest) blog_view = new XMLHttpRequest();
  else blog_view = new ActiveXObject("Mircosoft.XMLHTTP");
  blog_view.onreadystatechange = function () {
    if (
      blog_view.readyState == 4 &&
      blog_view.status == 200 &&
      blog_view.statusText === "OK"
    ) {
      document.querySelector("#blog_table").innerHTML = blog_view.responseText;
      $("#example").DataTable();
    }
  };
  blog_view.open("GET", "actions.php?blogs=true");
  blog_view.send();
}
viewBlogs();
// Add Blog
function adding_blog() {
  var blog_obj_one;
  if (window.XMLHttpRequest) blog_obj_one = new XMLHttpRequest();
  else blog_obj_one = new ActiveXObject("Mircosoft.XMLHTTP");
  blog_obj_one.onreadystatechange = function () {
    if (
      blog_obj_one.readyState == 4 &&
      blog_obj_one.status == 200 &&
      blog_obj_one.statusText === "OK"
    ) {
      document.getElementById("manage_blog_id").innerHTML =
        blog_obj_one.responseText;
    }
  };
  blog_obj_one.open("GET", "actions.php?adding_blog=true");
  blog_obj_one.send();
}
// creating blog
function create_blog() {
  var blog_title = document.getElementById("blog_title").value;
  var post_per_page = document.getElementById("post_per_page").value;
  var blog_cover_image = document.getElementById("blog_cover_image").files[0];
  var pattern = RegExp(/^[0-9]{1,}$/);
  var error_msg = "";
  var flag = true;
  if (!blog_title || !post_per_page || !blog_cover_image) {
    error_msg += "Kindly insert Data<br/>";
    flag = false;
  }
  if (flag) {
    if (!pattern.test(post_per_page)) {
      post_per_page = "";
      flag = false;
      error_msg += "Post Per Page must be an integer";
    }
  }
  if (flag) {
    var blogData = new FormData();
    blogData.append("blog_title", blog_title);
    blogData.append("post_per_page", post_per_page);
    blogData.append("blog_cover_image", blog_cover_image);
    blogData.append("create_blog", "true");
    var blog_obj_two;
    if (window.XMLHttpRequest) blog_obj_two = new XMLHttpRequest();
    else blog_obj_two = new ActiveXObject("Mircosoft.XMLHTTP");
    blog_obj_two.onreadystatechange = function () {
      if (
        blog_obj_two.readyState == 4 &&
        blog_obj_two.status == 200 &&
        blog_obj_two.statusText === "OK"
      ) {
        blog_title.value = "";
        document.getElementById("blog_success_msg").innerHTML =
          "Blog Successfully created";
        document.getElementById("blog_error_msg").innerHTML = "";
        document.getElementById("manage_blog_id").innerHTML =
          blog_obj_two.responseText;
        viewBlogs();
      }
    };
    blog_obj_two.open("POST", "actions.php");
    blog_obj_two.send(blogData);
  } else {
    document.getElementById("blog_error_msg").innerHTML = error_msg;
  }
}
function blogStatus(check, obj) {
  var status;
  if (check === "Active") status = "InActive";
  else {
    status = "Active";
  }
  var data = new FormData();
  data.append("id", obj.value);
  data.append("status", status);
  data.append("blog_status", "true");
  var blog_obj_three;
  if (window.XMLHttpRequest) blog_obj_three = new XMLHttpRequest();
  else blog_obj_three = new ActiveXObject("Mircosoft.XMLHTTP");
  blog_obj_three.onreadystatechange = function () {
    if (
      blog_obj_three.readyState == 4 &&
      blog_obj_three.status == 200 &&
      blog_obj_three.statusText === "OK"
    ) {
      viewBlogs();
      alert(`Blog ${status}`);
    }
  };
  blog_obj_three.open("POST", "actions.php");
  blog_obj_three.send(data);
}
// update_data_blog
function update_data_blog(id) {
  var blog_obj_four;
  if (window.XMLHttpRequest) blog_obj_four = new XMLHttpRequest();
  else blog_obj_four = new ActiveXObject("Mircosoft.XMLHTTP");
  blog_obj_four.onreadystatechange = function () {
    if (
      blog_obj_four.readyState == 4 &&
      blog_obj_four.status == 200 &&
      blog_obj_four.statusText === "OK"
    ) {
      document.getElementById("manage_blog_id").innerHTML =
        blog_obj_four.responseText;
    }
  };
  blog_obj_four.open("GET", "actions.php?update_data_blog=true&id=" + id);
  blog_obj_four.send();
}
// Edit Blog Data
function edit_blog_data(blog_background_image, id) {
  var img_data = document.getElementById("edit_img");
  var data = new FormData();
  data.append(
    "edit_blog_title",
    document.querySelector("#edit_blog_title").value
  );
  data.append(
    "edit_post_per_page",
    document.querySelector("#edit_post_per_page").value
  );
  if (img_data.files[0]) {
    data.append("edit_blog_cover_image", img_data.files[0]);
  }
  data.append("blog_background_image", blog_background_image);
  data.append("edit_blog_data", "true");
  data.append("id", id);
  var blog_obj_five;
  if (window.XMLHttpRequest) blog_obj_five = new XMLHttpRequest();
  else blog_obj_five = new ActiveXObject("Mircosoft.XMLHTTP");
  blog_obj_five.onreadystatechange = function () {
    if (
      blog_obj_five.readyState == 4 &&
      blog_obj_five.status == 200 &&
      blog_obj_five.statusText === "OK"
    ) {
      if (blog_obj_five.responseText) {
        viewBlogs();
        document.getElementById("manage_blog_id").innerHTML =
          blog_obj_five.responseText;
        alert("Blog updated");
      }
    }
  };
  blog_obj_five.open("POST", "actions.php");
  blog_obj_five.send(data);
}
// AJAX End
