// blog followers
function blog_follower() {
  var follow_obj;
  var follower_id = document.getElementById("follower_id").value;
  var blog_following_id = document.getElementById("blog_following_id").value;
  var blog_user_id = document.getElementById("blog_user_id").value;
  if (window.XMLHttpRequest) follow_obj = new XMLHttpRequest();
  else follow_obj = new ActiveXObject("Mircosoft.XMLHTTP");
  follow_obj.onreadystatechange = function () {
    if (
      follow_obj.readyState == 4 &&
      follow_obj.status == 200 &&
      follow_obj.statusText === "OK"
    ) {
      document.getElementById("folow-btn").innerHTML = follow_obj.responseText;
    }
  };
  follow_obj.open("POST", "actions.php");
  follow_obj.setRequestHeader("content-type","application/x-www-form-urlencoded");
  follow_obj.send(
    "follow_blog=true&follower_id=" +
      follower_id +
      "&blog_following_id=" +
      blog_following_id +
      "&blog_user_id=" +
      blog_user_id
  );
}
blog_follower();
// blog_following
function blog_following(follower_id, blog_following_id) {
  var follow_obj;
  var follower_id = document.getElementById("follower_id").value;
  var blog_following_id = document.getElementById("blog_following_id").value;
  if (window.XMLHttpRequest) follow_obj = new XMLHttpRequest();
  else follow_obj = new ActiveXObject("Mircosoft.XMLHTTP");
  follow_obj.onreadystatechange = function () {
    if (
      follow_obj.readyState == 4 &&
      follow_obj.status == 200 &&
      follow_obj.statusText === "OK"
    ) {
      // alert("Blog " + follow_obj.responseText);
      blog_follower();
    }
  };
  follow_obj.open("POST", "actions.php");
  follow_obj.setRequestHeader(
    "content-type",
    "application/x-www-form-urlencoded"
  );
  follow_obj.send(
    "follow_blog_update=true&follower_id=" +
      follower_id +
      "&blog_following_id=" +
      blog_following_id
  );
}

// show post with blog
function show_post_with_blogs(){
  var obj;
  if (window.XMLHttpRequest) obj = new XMLHttpRequest();
  else obj = new ActiveXObject("Mircosoft.XMLHTTP");
  obj.onreadystatechange = function () {
    if (
      obj.readyState == 4 &&
      obj.status == 200 &&
      obj.statusText === "OK"
    ) {
      document.querySelector("#post_with_cat").innerHTML=obj.responseText;
    }
  };
  obj.open("POST", "actions.php");
  obj.setRequestHeader("content-type","application/x-www-form-urlencoded");
  obj.send("show_post_with_blogs=true&post_per_page="+document.getElementById("post_per_page").value 
    +"&post_idees="+document.getElementById("post_idees").value 
    +"&blog_following_id=" +document.querySelector("#blog_following_id").value);
}
show_post_with_blogs();

function checkCategory(cat_title){
  var obj;
  if (window.XMLHttpRequest) obj = new XMLHttpRequest();
  else obj = new ActiveXObject("Mircosoft.XMLHTTP");
  obj.onreadystatechange = function () {
    if (
      obj.readyState == 4 &&
      obj.status == 200 &&
      obj.statusText === "OK"
    ) {
      document.querySelector("#post_with_cat").innerHTML=obj.responseText;
    }
  };
  obj.open("POST", "actions.php");
  obj.setRequestHeader("content-type","application/x-www-form-urlencoded");
  obj.send("get_with_cat=true&cat_title="+cat_title+"&post_idees="+document.getElementById("post_idees").value+
    "&post_per_page="+document.getElementById("post_per_page").value
    +"&blog_following_id=" +document.querySelector("#blog_following_id").value);
}
function post_limit(val){
  var obj;
  if (window.XMLHttpRequest) obj = new XMLHttpRequest();
  else obj = new ActiveXObject("Mircosoft.XMLHTTP");
  obj.onreadystatechange = function () {
    if (
      obj.readyState == 4 &&
      obj.status == 200 &&
      obj.statusText === "OK"
    ) {
      document.querySelector("#post_with_cat").innerHTML=obj.responseText;
    }
  };
  obj.open("POST", "actions.php");
  obj.setRequestHeader("content-type","application/x-www-form-urlencoded");
  obj.send("blog_pagination=true&start_val="+val+"&post_idees="+document.getElementById("post_idees").value+
    "&post_per_page="+document.getElementById("post_per_page").value
    +"&blog_following_id=" +document.querySelector("#blog_following_id").value);
}