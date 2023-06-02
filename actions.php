<?php
  session_start();
  require_once("./required/database-class.php");
  require_once("./email.php");
  require_once("./required/custom-functions.php");
  include_once("./includes/add-blog.php");
  include_once("./includes/add-post.php");
  // manage user
  if(isset($_REQUEST["get_users"]) AND $_REQUEST["get_users"]==="true"){
    if(isset($_REQUEST["account_approval"]) && $_REQUEST["account_approval"]==="true"){
      $value=$_REQUEST["value"];
      if($value==="Approved") $_SESSION["user"]->approved_status=$value;
      elseif($value==="Rejected") $_SESSION["user"]->approved_status=$value;
      elseif($value==="Pending") $_SESSION["user"]->approved_status=$value;
    }
    $approved_status="Pending";
    if(isset($_SESSION["user"]->approved_status)) $approved_status=$_SESSION["user"]->approved_status;
    $users=$database->manage_user("",$approved_status);
    if($users->num_rows>0)user_table($users);
    else echo "<h1 class='admin-heading text-center'>No User is in $approved_status State</h1>";
  }
  // search user
  elseif(isset($_REQUEST["search"]) && $_REQUEST["search"]==="true"){
    $approved_status="Pending";
    if(isset($_SESSION["user"]->approved_status)) $approved_status=$_SESSION["user"]->approved_status;
    $users=$database->manage_user($_REQUEST["searching"],$approved_status);
    if($users->num_rows>0)user_table($users);
    else echo "<h1 class='admin-heading text-center'>No User invalid Data:-".$_REQUEST["searching"]."</h1>";
  }
  elseif(isset($_REQUEST["is_active"]) && $_REQUEST["is_active"]==="true") {
    $users=$database->get_users();
    $email=null;
    while($user=mysqli_fetch_object($users))
      if($user->user_id==$_REQUEST["id"]){$email=$user->email;}
      $color= $_REQUEST["value"]=="Active" ? "green" : "red";
      EmailSent($email,"Account Status","Your Account Status is <span style='color:".$color."'>".$_REQUEST["value"]." </span>.");
    echo $database->update_user_status($_REQUEST["value"],$_REQUEST["id"]);
    // echo $database->update_user_status($_REQUEST["value"],$_REQUEST["id"]);
  }
  // View User
  elseif(isset($_REQUEST["crud"]) && $_REQUEST["crud"]==="true"){
    $user=$database->get_users();
    $data=null;
    while($record=mysqli_fetch_object($user)) 
      if($record->user_id==$_REQUEST["id"]) $data=$record;
    if(isset($_REQUEST["view_user"]) && $_REQUEST["view_user"]==="true")  view_user($data);
    elseif(isset($_REQUEST["update_user"]) && $_REQUEST["update_user"]==="true") edit_user($data);
  }
  // edit User
  elseif(isset($_REQUEST["edit_user"]) && $_REQUEST["edit_user"]==="true"){
    extract($_REQUEST);
    if(isset($_FILES["edit_user_img"]["name"])){
      $old_img=rand()."_".$_FILES["edit_user_img"]["name"];
      move_uploaded_file($_FILES["edit_user_img"]["tmp_name"],"./assets/images/users/$old_img");
    }
    $ddd=null;
    $msg=null;
    if($is_approved=="Approved" || $is_approved=="Rejected") $ddd=$is_approved;
    $update=$database->edit_user($fname,$lname,$email,$password,$gender,$old_img,$address,$is_active,$is_approved,$dob,$id);
    $msg=$ddd ? "and Your Account Approval Status is $ddd" : "";
    EmailSent($email,"Update Account","Your Account is updated by management $msg");
    // edit_user($data);
  }
  // update own account
  elseif(isset($_REQUEST["own_setting"]) AND $_REQUEST["own_setting"]==="true"){
    $user=$database->get_users();
    $data=null;
    while($record=mysqli_fetch_object($user)) 
      if($record->user_id==$_SESSION["user"]->user_id) $data=$record;
      edit_user($data);
  }
  // add user form
  elseif(isset($_REQUEST["add_user"]) && $_REQUEST["add_user"]==="true")
    add_user();
  // add user data
  elseif(isset($_REQUEST["user_added"]) && $_REQUEST["user_added"]==="true"){
    extract($_REQUEST);
    $file=$_FILES["user_image"];
    $flag=true;
    $users=$database->get_users();
    while($data=mysqli_fetch_object($users)){
      if($data->email==$email) $flag=false;
    }
    if($flag){
      $folder="users";
      if(!is_dir("./assets/images/$folder")){
        mkdir("./assets/images/$folder");
      }
      $destination=rand()."_".$_FILES["user_image"]["name"];
      $file_upload=move_uploaded_file($_FILES["user_image"]["tmp_name"],"./assets/images/$folder/$destination");
      if($file_upload){
        echo $user_added=$database->register_user(2,$fname,$lname,$email,$password,$gender,$date_of_birth,$destination,$addrress,"Pending","InActive");
      EmailSent($email,"Sign up Account","Congrats. Your Account is registered. Your account email is $email And Your Password is 
        <span class='text-success'>$password</span>");
      }
    }else {
      echo $flag;
    }
  }
  // adding blogs
  elseif (isset($_REQUEST["adding_blog"]) AND $_REQUEST["adding_blog"]==="true"){
    ?>
      <div class="col-md-8 col-10 py-3 px-5 border" id="manage_blogs">
        <?php add_update_blog() ?>
      </div>
    <?php
  }
  // View Blog
  elseif (isset($_REQUEST["blogs"]) && $_REQUEST["blogs"]==="true") {
    $data=$database->view_blogs();
    if($data->num_rows>0) our_blogs($data);
    else echo "<h1 class='admin-heading text-center'>No Blog is created</h1>";
  }
  // create blog
  elseif(isset($_REQUEST["create_blog"]) AND $_REQUEST["create_blog"]==="true"){
    settype($_SESSION["user"]->user_id,"integer");
    settype($_REQUEST["post_per_page"],"integer");
    $destination=rand()."_".$_FILES["blog_cover_image"]["name"];
    $blog=$database->add_blog($_SESSION["user"]->user_id,$_REQUEST["blog_title"],$_REQUEST["post_per_page"],$destination,"Active");
    if($blog){
      move_uploaded_file($_FILES["blog_cover_image"]["tmp_name"],"./assets/images/blogs/".$destination);
      ?>
        <div class="col-md-8 col-10 py-3 px-5 border" id="manage_blogs">
          <?php add_update_blog() ?>
        </div>
      <?php
    }
  }
  // update blog status
  elseif(isset($_REQUEST["blog_status"]) && $_REQUEST["blog_status"]=="true"){
    extract($_REQUEST);
    $updated=$database->update_blog_status($status,$id);
    echo $updated;
  }
  // update_data_blog
  elseif(isset($_REQUEST["update_data_blog"]) && $_REQUEST["update_data_blog"]==="true"){
    $data=null;
    $updated=$database->updateblogdata();
    while($record=mysqli_fetch_object($updated)) 
      if($_REQUEST["id"]==$record->blog_id){$data=$record;}
      ?>
      <div class="col-md-8 col-10 py-3 px-5 border" id="manage_blogs">
        <?php update_blog_data($data->blog_id,$data->blog_title,$data->post_per_page,$data->blog_background_image) ?>
      </div>
    <?php
  }
  // edit_blog_data
  elseif (isset($_REQUEST["edit_blog_data"]) && $_REQUEST["edit_blog_data"]==="true") {
    settype($_REQUEST["edit_post_per_page"], "integer");
    settype($_REQUEST["id"], "integer");
    $id=$_REQUEST["id"];
    $blog_title=$_REQUEST["edit_blog_title"];
    $post_per_page=$_REQUEST["edit_post_per_page"];
   $output=null;
   if(isset($_FILES["edit_blog_cover_image"]["name"])){
   $img_name=rand()."_".$_FILES["edit_blog_cover_image"]["name"];
      if($_REQUEST["blog_background_image"]!=$_FILES["edit_blog_cover_image"]["name"]){
        $folder="blogs";
        if(!is_dir("./assets/images/$folder")) {
          mkdir("./assets/images/$folder");
        }
        move_uploaded_file($_FILES["edit_blog_cover_image"]["tmp_name"],"./assets/images/$folder/".$img_name);
        $output=$database->edit_blog_data($blog_title,$post_per_page,$img_name,$id);
    }
    else $output=$database->edit_blog_data($blog_title,$post_per_page,$_REQUEST["blog_background_image"],$id);
   }
   else {
     $output=$database->edit_blog_data($blog_title,$post_per_page,$_REQUEST["blog_background_image"],$id);
   }
   if($output){
    ?>
      <div class="col-md-8 col-10 py-3 px-5 border" id="manage_blogs">
        <?php add_update_blog() ?>
      </div>
    <?php
   }
  }
  // blog followers
  elseif(isset($_REQUEST["follow_blog"]) AND $_REQUEST["follow_blog"]==="true"){
    extract($_REQUEST);
    $flag=false;
    $status=null;
    settype($follower_id,"integer");
    settype($blog_following_id,"integer");;
    $follow=$database->following_blogs();
    while($blog=mysqli_fetch_object($follow)) {
      if($blog->follower_id==$follower_id AND $blog->blog_following_id==$blog_following_id){
        $flag=true;
        $status=$blog->status;
      }
    } 
    if($blog_user_id !=$_SESSION["user"]->user_id){
      if($flag) {
        ?>
        <button class="btn btn-md  mt-1 fw-bold <?php echo  $status==="Followed" ? 'btn-success' : ' btn-outline-light' ?>" 
          onclick="blog_following('<?php echo $follower_id ?>','<?php echo $blog_following_id ?>')">
          <?php echo $status==="Followed" ? $status : "Follow"?></button>
        <?php
      }
      else{
      ?>
      <button class="btn btn-md  btn-outline-light mt-1 fw-bold" 
        onclick="blog_following('<?php echo $follower_id ?>','<?php echo $blog_following_id ?>')">Follow</button>
      <?php
      }
    } 
  }
  // follow_blog_update
  elseif(isset($_REQUEST["follow_blog_update"]) && $_REQUEST["follow_blog_update"]==="true"){
    extract($_REQUEST);
    settype($follower_id,"integer");
    settype($blog_following_id,"integer");
    $flag=false;
    $record=null;
    $data=$database->following_blogs();
    while($blog=mysqli_fetch_object($data)){
      if($blog->follower_id==$follower_id AND $blog->blog_following_id==$blog_following_id){
        $flag=true;
        $record=$blog;
      }
    }
    if($flag){
      $update_status="";
      if($record->status==="Unfollowed") $update_status="Followed";
      else $update_status="Unfollowed";
      $update_blog_following=$database->update_following_blogs($update_status,$record->follow_id);
      echo $update_status;
    }else{
      $insert_blog_following=$database->post_following_blogs($follower_id,$blog_following_id);
      echo "Followed";
    };
  }
  // view categories
  elseif (isset($_REQUEST["view_category"]) && $_REQUEST["view_category"]==="true") {
    $categories=$database->get_categories();
    if($categories->num_rows>0)  our_categories($categories);
    else echo "<h1 class='text-center text-primary my-5'>No Category is Found</h1>";
  }
  // categories
  elseif (isset($_REQUEST["category"]) AND $_REQUEST["category"]=="true") {
    $category=$database->insert_category($_REQUEST["category_title"],$_REQUEST["category_description"]);
    if($category) echo "Category Added";
  }
  // update_cat_status
  elseif (isset($_REQUEST["update_cat_status"]) AND $_REQUEST["update_cat_status"]==="true") {
    extract($_REQUEST);
    settype($id, "integer");
    $update_status=$database->update_cat_status($status,$id);
    echo "Category " .$status;
  }
  //updateCategory
  elseif (isset($_REQUEST["updateCategory"]) AND $_REQUEST["updateCategory"]==="true") {
    extract($_REQUEST);
    cat_update($title,$description,$id);
  }
  // Updated
  elseif (isset($_REQUEST["Updated"]) AND $_REQUEST["Updated"]==="true") {
    extract($_REQUEST);
    echo $update=$database->update_category($update_cat_title,$update_cat_description,$id);
  }
  // view_posts
  elseif (isset($_REQUEST["view_posts"]) AND $_REQUEST["view_posts"]==="true") {
    $posts=$database->get_posts("SELECT U.`user_id`,P.`post_id`,P.`post_title`,P.`post_summary`,P.`post_status` FROM `post` P 
    INNER JOIN `blog` B INNER JOIN `user` U ON P.`blog_id` = B.`blog_id` AND B.`user_id`=U.`user_id` ORDER BY P.`post_id` DESC");
    if($posts->num_rows){
      our_posts($posts);
    }else echo "<h1 class='text-center text-danger'>No Post is Added</h1>";
  }
  // update_post_status
  elseif (isset($_REQUEST["update_post_status"]) AND $_REQUEST["update_post_status"]==="true") {
    settype($_REQUEST["id"],"integer");
    echo $update_post=$database->update_post_status($_REQUEST["status"],$_REQUEST["id"]);
  }
  // update_post
  elseif (isset($_REQUEST["update_post"]) AND $_REQUEST["update_post"]=="true") {
    $blogs=$database->updateblogdata();
    $categories=$database->get_categories("InActive");
    update_posts($_REQUEST["id"],$blogs,$categories);
  }
  // Posts
  elseif (isset($_REQUEST["post_form"]) AND $_REQUEST["post_form"]==="true") {
    $blogs=$database->updateblogdata("InActive");
    $categories=$database->get_categories("InActive");
    addPost($blogs,$categories);
  } 
  // post Attachment
  elseif (isset($_REQUEST["check_att"]) && $_REQUEST["check_att"]==="true") {
      ?>
        <div class="attachement">
          <div class="form-group">
            <label>Post Attachement Title<span class="text-danger fs-5">*</span></label>
            <input type="text" class="form-control post_attachement_title" placeholder="Attachment Title"/>
          </div>
          <div class="form-group" style="width: 45%">
            <label>Post Attachement Image<span class="text-danger fs-5">*</span></label>
            <input type="file" class="form-control attachement_image"/>
          </div>
          <h3 class="fa-solid fa-square-xmark text-danger mt-3" onclick="removeAttachment(this)"></h3>
        </div>
      <?php 
  }
  // create_post
  elseif (isset($_REQUEST["post"]) AND $_REQUEST["post"]==="true") {
    extract($_REQUEST);
    settype($post_blog, "integer");
    settype($post_comment_mode, "integer");
    $destination=rand()."_".$_FILES["post_image"]["name"];
      $folder="posts";
      if(!is_dir("./assets/images/$folder")){mkdir("./assets/images/$folder");}
      $img_inserted=move_uploaded_file($_FILES["post_image"]["tmp_name"],"./assets/images/$folder/$destination");
      if($img_inserted){
        $post_execute=$database->insert_post($post_blog,$post_title,$post_summary,$post_description,$destination,"Active",$post_comment_mode);
        if($post_execute){
        $cat_data=substr($_REQUEST["post_category"], 0,-1);
        $cat_idees=explode(",", $cat_data);
          for($a=0; $a<=sizeof($cat_idees)-1; $a++){
            settype($cat_idees[$a], "integer");
            $cat_inserted=$database->insert_post_ategory($post_execute->insert_id,$cat_idees[$a]);
          }
        }
      }
      if(isset($_REQUEST["attachement_count"])){
        for($b=0; $b<=$_REQUEST["attachement_count"]-1; $b++){
          if(!$_REQUEST["post_attachement_title_".$b] OR !isset($_FILES["attachement_image_".$b]))
            continue;
          $destination=rand()."_".$_FILES["attachement_image_".$b]["name"];
          move_uploaded_file($_FILES["attachement_image_".$b]["tmp_name"], "./assets/images/attachements/".$destination);
          $database->insert_post_attachement($post_execute->insert_id,$_REQUEST["post_attachement_title_".$b],$destination);
        }
      }
      $blogs=$database->updateblogdata("InActive");
      $categories=$database->get_categories("InActive");
      addPost($blogs,$categories);
  }
  // update_post_data
  elseif(isset($_REQUEST["update_post_data"]) AND $_REQUEST["update_post_data"]=="true"){
    extract($_REQUEST);
    settype($id,"integer");
    settype($post_blog,"integer");
    settype($post_comment_mode,"integer");
    $dlt_category=$database->delete_categories($id);
    $cat_idees=substr($cat_idees,0,-1);
    $cat_idees_arr=explode(",",$cat_idees);
    for($a=0; $a<=sizeof($cat_idees_arr)-1; $a++){
      settype($cat_idees_arr[$a],"integer");
      $post_cat_updated=$database->insert_post_ategory($id,$cat_idees_arr[$a]);
    }
    if(isset($_FILES["post_image"])){
      $old_featured_image=rand()."_".$_FILES["post_image"]["name"];
      move_uploaded_file($_FILES["post_image"]["tmp_name"],"./assets/images/posts/$old_featured_image");
    }
    echo $database->update_post($post_blog,$post_title,$post_summary,$post_description,$old_featured_image,$post_comment_mode,$id);
  }
  // update_attachement
  elseif(isset($_REQUEST["update_attachement"]) AND $_REQUEST["update_attachement"]=="true"){
    settype($_REQUEST["id"],"integer");
    echo $update_att=$database->update_attachement($_REQUEST["status"],$_REQUEST["id"]);
  }
  // view comments
  elseif(isset($_REQUEST["view_comments"]) AND $_REQUEST["view_comments"]==="true"){
    $query="SELECT U.`first_name`,U.`last_name`,U.`user_image`,P.`post_id`,
    PC.`comment`,PC.`post_comment_id`,PC.`is_active`,PC.`created_at` FROM `post_comment` PC INNER JOIN `post` P INNER JOIN `user` U ON PC.`post_id`=P.`post_id` AND PC.`user_id` = U.`user_id` ORDER BY 
    PC.`post_comment_id` DESC";
    $comments=$database->get_comments($query);
    view_comments($comments);
  }
  // show comments
  elseif(isset($_REQUEST["show_comments"]) && $_REQUEST["show_comments"]==="true"){
    $query="SELECT U.`first_name`,U.`last_name`,U.`user_image`,
    P.`post_id`,PC.`comment`,PC.`post_comment_id`,PC.`is_active`,PC.`created_at` FROM `post_comment` PC INNER JOIN `post` P INNER JOIN `user` U ON PC.`post_id`=P.`post_id` AND PC.`user_id` = U.`user_id` WHERE P.`post_id`=".$_REQUEST["id"]." 
    ORDER BY  PC.`post_comment_id`  ASC";
    $comments_data=$database->get_comments($query);
    show_comments($comments_data);
  }
  // Insert Comments
  elseif (isset($_REQUEST["comments"]) AND $_REQUEST["comments"]==="true") {
    $flag=true;
    if(!$_REQUEST["comment"])
      $flag=false;
    if($flag){
      settype($_REQUEST["post_id"], "integer");
      settype($_REQUEST["user_id"], "integer");
      $insert=$database->inser_comments($_REQUEST["post_id"],$_REQUEST["user_id"],$_REQUEST["comment"]);
      if($insert){
        echo "comment inserted";
      }
    }
    else echo "Kindly Insert Comment";
  }
  // update_comment
  elseif(isset($_REQUEST["update_comment"]) AND $_REQUEST["update_comment"]=="true"){
    settype($_REQUEST["id"],"integer");
    echo $update=$database->update_comment($_REQUEST["status"],$_REQUEST["id"]);
  }
  // index_posts
  elseif(isset($_REQUEST["index_posts"]) AND $_REQUEST["index_posts"]==="true"){
    $posts=$database->post_search();
    if($posts->num_rows) index_posts($posts);
    else echo "<h1 class='text-center'>No Post Found</h1>";
  }
  //show post index
  // search_post
  elseif(isset($_REQUEST["search_post"]) AND $_REQUEST["search_post"]==="true"){
    $posts=$database->post_search($_REQUEST["value"]);
    if($posts->num_rows)  index_posts($posts);
    else echo "<h1 class='text-center'>No Post Found With ".$_REQUEST['value']."</h1>";
  }
  //show_post_with_blogs
  elseif (isset($_REQUEST["show_post_with_blogs"]) AND $_REQUEST["show_post_with_blogs"]==="true") {
    extract($_REQUEST);
    $data=$database->show_post_with_blogs($post_idees,$post_per_page);
    if($data->num_rows) show_with_blogs($data,$post_per_page,$blog_following_id);
    else echo "<h1 class='text-center'>No Post on this Blog</h1>";
  }
  // get_with_cat
  elseif (isset($_REQUEST["get_with_cat"]) AND $_REQUEST["get_with_cat"]=="true") {
    $data=$database->show_post_with_blogs($_REQUEST["post_idees"],$_REQUEST["post_per_page"],0,$_REQUEST["cat_title"]);
    if($data->num_rows) show_with_blogs($data,$_REQUEST["post_per_page"],$_REQUEST["blog_following_id"]);
    else echo "<h1 class='text-center'>No Post on this Blog</h1>";
  }
  // blog_pagination
  elseif (isset($_REQUEST["blog_pagination"]) AND $_REQUEST["blog_pagination"]=="true") {
    extract($_REQUEST);
    $data=$database->show_post_with_blogs($post_idees,$post_per_page,($start_val*$post_per_page)-1);
    if($data->num_rows) show_with_blogs($data,$_REQUEST["post_per_page"],$_REQUEST["blog_following_id"],$start_val);
    else echo "<h1 class='text-center'>No Post on this Blog</h1>";
  }
  ?>
