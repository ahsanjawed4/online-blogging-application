$(document).ready(function () {
  $("#example").DataTable();
});
// View Categories
function viewCategories(){
	var category_view;
	if (window.XMLHttpRequest) category_view = new XMLHttpRequest();
	else category_view = new ActiveXObject("Mircosoft.XMLHTTP");
	category_view.onreadystatechange = function () {
		if (category_view.readyState == 4 && category_view.status == 200 && category_view.statusText === "OK") {
			document.getElementById("category_table").innerHTML=category_view.responseText;
  			$("#example").DataTable();
		}
	};
	category_view.open("GET", "actions.php?view_category=true");
	category_view.send();
}
viewCategories();
// Add Category
function addCategory(){
	var flag=true;
	var category_title = document.getElementById("category_title").value;
	var category_description = document.getElementById("category_description").value;
	if(!category_title || !category_description){flag=false}
		if(flag){
		  var category_obj;
		  var category_title = document.getElementById("category_title").value;
		  var category_description = document.getElementById("category_description").value;
		  var categoryData=new FormData();
		  categoryData.append("category_title",category_title);
		  categoryData.append("category_description",category_description);
		  categoryData.append("category","true");
		  if (window.XMLHttpRequest) category_obj = new XMLHttpRequest();
		  else category_obj = new ActiveXObject("Mircosoft.XMLHTTP");
		  category_obj.onreadystatechange = function () {
		    if (
		      category_obj.readyState == 4 &&
		      category_obj.status == 200 &&
		      category_obj.statusText === "OK"
		    ) {
		      	document.getElementById("success_msg").innerHTML=category_obj.responseText;
		  		document.getElementById("error_msg").innerHTML="";
		  		category_title="";
		  		category_description="";
				viewCategories();
		    }
		  };
		  category_obj.open("POST", "actions.php");
		  category_obj.send(categoryData);
		}
		else{ 
			document.getElementById("error_msg").innerHTML="Kindly insert Data";
			document.getElementById("success_msg").innerHTML="";
		}
}
// update Status
function update_cat_status(id,status){
	update_status="";
	if(status==="Active") update_status="InActive";
	else{update_status="Active"};
	var category_status_obj;
	if (window.XMLHttpRequest) category_status_obj = new XMLHttpRequest();
	else category_status_obj = new ActiveXObject("Mircosoft.XMLHTTP");
	category_status_obj.onreadystatechange = function () {
		if (category_status_obj.readyState == 4 && category_status_obj.status == 200 && category_status_obj.statusText === "OK") {
		  alert(category_status_obj.responseText);
		  viewCategories();
		}
	};
	category_status_obj.open("POST", "actions.php");
	category_status_obj.setRequestHeader("content-type","application/x-www-form-urlencoded");
	category_status_obj.send("update_cat_status=true&id="+id +"&status="+update_status);
}
// updateCategory
function updateCategory(title,description,id){
	var update_cat_obj;
	if (window.XMLHttpRequest) update_cat_obj = new XMLHttpRequest();
	else update_cat_obj = new ActiveXObject("Mircosoft.XMLHTTP");
	update_cat_obj.onreadystatechange = function () {
	  if (update_cat_obj.readyState == 4 && update_cat_obj.status == 200 && update_cat_obj.statusText === "OK") {
	  	document.getElementById("manage_categories_row").innerHTML=update_cat_obj.responseText;
	  }
	}
	update_cat_obj.open("POST", "actions.php");
	update_cat_obj.setRequestHeader("content-type","application/x-www-form-urlencoded");
	update_cat_obj.send("updateCategory=true&title="+title+"&description="+description+"&id="+id);
}
// Updated
function updated(id){
	var update_cat_title=document.getElementById("update_cat_title").value;
    var update_cat_description=document.getElementById("update_cat_description").value;
	var update_cat;
	if (window.XMLHttpRequest) update_cat = new XMLHttpRequest();
	else update_cat = new ActiveXObject("Mircosoft.XMLHTTP");
	update_cat.onreadystatechange = function () {
	  if (update_cat.readyState == 4 && update_cat.status == 200 && update_cat.statusText === "OK") {
	  	if(update_cat.responseText){
	  		document.getElementById("manage_categories_row").innerHTML="";
	  		alert("Updated");
	  		viewCategories();
	  	}
	  }
	}
	update_cat.open("POST", "actions.php");
	update_cat.setRequestHeader("content-type","application/x-www-form-urlencoded");
	update_cat.send("Updated=true&update_cat_title="+update_cat_title+"&update_cat_description="+update_cat_description+"&id="+id);
}