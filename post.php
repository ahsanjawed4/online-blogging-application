<?php
  session_start();
  if(isset($_REQUEST["id"])){
    require_once("./required/database-class.php");
    $post=$database->get_posts("SELECT U.`first_name`,U.`last_name`,B.`blog_title`,P.* FROM `post` P INNER JOIN `blog` B INNER JOIN `user` U ON P.`blog_id`= B.`blog_id` AND B.`user_id`= U.`user_id` WHERE P.`post_status` <> 'InActive' 
      AND B.`blog_status` <> 'InActive'  ORDER BY `post_id` DESC");
    $data=null;
    while($record=mysqli_fetch_object($post))
      if($record->post_id==$_REQUEST["id"]) $data=$record;
      include_once("./includes/header.php");
    if($data){
      ?>
        <div class="container posts my-5">
          <div class="row">
            <div class="col-lg-8 col-md-12">
              <h1 class="px-lg-0 px-5">Posts</h1>
              <div class="row d-flex justify-content-center">
                <div class="col-12 mb-4">
                  <div class="card">
                    <img class="card-img-top" src="./assets/images/posts/<?php echo $data->featured_image ?>" alt="No img" style="height:450px">
                    <div class="card-body">
                    <h1 class="card-title post_title"><?php echo ucwords($data->post_title) ?></h1>
                    <p class="card-text post_content px-2">
                   
                    </p>
                    <p class="card-text card-creator">
                      <small class="text-creator">
                        <i class="far fa-user"></i><?php echo ucwords($data->first_name) ?>
                        <i class="fa-solid fa-file"></i><?php echo ucwords($data->blog_title) ?>
                        <?php
                          $create=explode(" ", $data->created_at);
                        ?>
                        <i class="fas fa-calendar-alt"></i><?php echo $create[0] ?>
                        <i class="fa-solid fa-clock"></i><?php echo $create[1] ?>
                      </small>
                    </p>
                    <h2 class="post_title">Summary:-</h2>
                    <p><?php echo $data->post_summary ?></p>
                     <h2 class="post_title">Description:-</h2>
                    <p><?php echo $data->post_description ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-12 mb-5">
              <h1 class="px-4 text-md-start text-center">Comments</h1>
              <div class="row d-flex justify-content-center">
                <div class="col-10 mb-4 comment_section">
                  <div class="card" id="show_comments">
                </div>
              </div>
                <div class="col-10">
                  <?php
                    if($data->is_comment_allowed){
                      ?>
                      <h6>Leave Comment</h6>
                      <textarea class="form-control" id="comment_text" rows="4"></textarea>
                      <div class="float-end mt-2 pt-1">
                        <a class="btn btn-primary btn-sm" <?php echo isset($_SESSION["user"]) ? 
                        "onclick=add_comment(".$_REQUEST['id'].",".$_SESSION["user"]->user_id.")" : "href=./login.php?comments=true" ?>>Post comment</a>
                        <button type="button" class="btn btn-outline-primary btn-sm">Cancel</button>
                      </div>
                      <?php
                    }else echo "<h3 class='text-center my-3 text-danger'>Comments Are turned off</h3>";
                  ?>
                </div>
              </div>
            </div>
            <?php  
              $attachments=$database->get_attachment($_REQUEST["id"]);
              if($attachments->num_rows){
                ?>
                <h1>Attachments</h1>
                <div class="col-12 row d-flex">
                <?php
                  while($attachment=mysqli_fetch_object($attachments)){
                    if($attachment->is_active=="Active"){
                    ?>
                      <div class="col-md-4">
                        <img src="./assets/images/attachements/<?php echo $attachment->post_attachment_path ?>" 
                        alt="no-img" class="w-100" style="height:400px"/>
                        <h2 class="post_title"><?php echo $attachment->post_attachment_title ?></h2>
                      </div>
                    <?php
                    }
                  }
            ?>
            </div>
                <?php
              }
            ?>
          </div>
        </div>
        <input type="hidden" id="post_id" value="<?php echo $_REQUEST['id'] ?>">
        <script>
          setInterval(()=>{
            show_comments();
          },2000);
          function show_comments(){
            var obj;
            var id=document.querySelector("#post_id").value;
            if(window.XMLHttpRequest) obj=new XMLHttpRequest();
            else obj=new ActiveXObject("Microsoft.XMLHTTP");
            obj.onreadystatechange=function(){
              if(obj.readyState==4 && obj.status==200 && obj.statusText=="OK"){
                document.querySelector("#show_comments").innerHTML=obj.responseText;
              }
            }
            obj.open("GET","actions.php?show_comments=true&id="+id);
            obj.send();
          }
          show_comments();
          // insert comments
          function add_comment(post_id,user_id){
            var flag=true
            var comment=document.querySelector("#comment_text");
            if(!comment.value){flag=false};
            if(flag){
              var obj;
              if(window.XMLHttpRequest) obj=new XMLHttpRequest();
              else obj=new ActiveXObject("Microsoft.XMLHTTP");
              obj.onreadystatechange=function(){
                if(obj.readyState==4 && obj.status==200 && obj.statusText=="OK"){
                  show_comments();
                  comment.value="";
                }
              }
              obj.open("POST","actions.php");
              obj.setRequestHeader("content-type","application/x-www-form-urlencoded");
              obj.send("comments=true&post_id="+post_id+"&user_id="+user_id+"&comment="+comment.value);
            }else 
              alert("Kindly insert comments");
          }
        </script>
      <?php
    }
    else {echo "<h1 class='text-center my-5 text-danger'>No Blog is found Or Blog is InActive</h1>";}
    include_once("./includes/footer.php");
    custom_footer();
  }
  else header("location:./index.php");
  ?>