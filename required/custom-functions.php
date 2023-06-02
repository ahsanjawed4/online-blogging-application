<?php
require_once("./required/months.php");
require_once("./required/database-class.php");
function error_modal($error_msg){
?>
<div class="container-fluid mt-3" id="error_container">
  <div class="row d-flex justify-content-center">
    <div class="col-md-4 col-10 alert alert-warning alert-dismissible fade show mb-0 text-center" role="alert">
      <strong class="text-danger"><?php echo $error_msg ?></strong>.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="close_login()"></button>
    </div>  
  </div>
</div>
<?php
}
// User Table
function user_table($users){
?>
<div class="panel-body table-responsive">
  <table class="table table-hover table-bordered" data-ordering="false">
    <thead>
      <tr>
        <th>ID</th>
        <th>Profile</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Gender</th>
        <th>Status</th>
        <th>Active</th>
        <th>Approved</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $counter=0;
      while($record=mysqli_fetch_object($users)){
        ?>
        <tr>
          <td><?php echo $record->user_id ?></td>
          <td><img src="./assets/images/users/<?php echo $record->user_image ?>" alt="" style="height: 50px; width: 50px; border-radius: 50%"></td>
          <td><?php echo ucwords($record->first_name ." " .$record->last_name) ?></td>
          <td><?php echo $record->email ?></td>
          <td class='fw-bold fs-5 <?php if($record->role_type==="admin") echo "text-success"; else echo "text-warning" ?>'>
            <?php echo $record->role_type ?>
          </td>
          <td><?php echo $record->gender ?></td>
          <td>
            <button class='btn btn-sm btn-success mb-md-0 mb-1'
            <?php
            if($record->role_id!=1 AND ($record->is_approved==="Pending" OR $record->is_approved==="Approved")){
              ?>
              onclick="user_status(this,<?php echo $record->user_id ?>)" value="Active" 
              <?php
            }else echo "disabled"
            ?>
            >Active</button>
            <button class='btn btn-sm btn-danger'
            <?php
            if($record->role_id!=1 AND ($record->is_approved==="Pending" OR $record->is_approved==="Approved")){
              ?>
              onclick="user_status(this,<?php echo $record->user_id ?>)" value="InActive" 
              <?php
            }else echo "disabled";
            ?>
            >InActive</button>
          </td>
          <td>
            <i class='<?php echo $record->is_active==="Active" ?  "fa-solid fa-check-double text-success" :"fa-solid fa-square-xmark  text-danger"?> fa-xl'></i>
          </td>
          <td><?php echo $record->is_approved ?></td>
          <td>
            <ul class="action-list">
              <li>
                <i class="fas fa-eye text-primary" onclick="view_user('<?php echo $record->user_id ?>')" title="View User"></i>
              </li>
              <?php 
              if($record->role_id!=1 AND ($record->is_approved==="Pending" OR $record->is_approved==="Approved")){
                ?>
                <li>
                  <i class="fas fa-pencil-alt text-warning" title="Edit User" onclick="edit_user('<?php echo $record->user_id ?>')">
                  </i>
                </li>
                <?php
              }
              ?>
            </ul>
          </td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>
<?php
}
// View User
function view_user($data){
  GLOBAL $months;
?>
  <div class="col-md-4">
    <img alt="" class="img-circle img-thumbnail" 
    src="./assets/images/users/<?php echo $data->user_image ?>" style="width:500px;height:420px"/>
  </div>
    <div class="col-md-6">
      <div class="table-responsive">
        <table class="table table-user-information" id="table_data">
          <tbody>
            <tr>
              <td><h5>Full Name</h5></td>
              <td><?php echo ucwords($data->first_name ." " .$data->last_name) ?></td>
            </tr>
            <tr>
              <td><h5>Email</h5></td>
              <td><?php echo $data->email ?></td>
            </tr>
            <tr>
              <td><h5>Password</h5></td>
              <td><?php echo $data->password ?></td>
            </tr>
            <tr>
              <td><h5>Gender</h5></td>
              <td><?php echo $data->gender ?></td>
            </tr>
            <tr>
              <td><h5>Date Of Birdh</h5></td>
              <td><?php echo $data->date_of_birth ?></td>
            </tr>
            <tr>
              <td><h5>Account</h5></td>
              <td>
                <?php echo $data->role_id=="1" ?
                "<span class='btn btn-sm btn-success fw-bold'>Admin</span>" :
                "<span class='btn btn-sm btn-warning fw-bold'>User</span>" ?>
              </td>
            </tr>
            <tr>
              <td>
                <h5>Approval</h5>
              </td>
              <td><?php echo $data->is_approved ?></td>
            </tr>
            <tr>
              <td><h5>Active Status</h5></td>
              <td><?php echo $data->is_active ?></td>
            </tr>
            <tr>
              <td><h5>Address</h5></td>
              <td><?php echo $data->address ?></td>
            </tr>
            <tr>
              <td><h5>Created At:</h5></td>
              <?php
                $create=explode(" ",$data->created_at);
                $date=explode("-",$create[0]);
              ?>
              <td>
                <?php echo $date[2] ."-" .$months[$date[1]-1] ."-" .$date[0] ?>
              </td>
            </tr>
          </tbody>
        </table>
        </div>
        <button class="btn btn-warning btn-md fw-bold"
      onclick="close_form('view_user')">Close</button>
      </div>
  <?php
}
// edit User
function edit_user($record){
?>
<div class="col-md-8 col-10 py-3 px-5 border" id="edit_user_col">
  <div class="row d-flex justify-content-center">
    <div class="col-10">
      <img class="w-100" src='<?php echo "./assets/images/users/".$record->user_image ?>' alt="">
      <?php
      $img=explode("_",$record->user_image);
      echo "<p class='fw-bold'>".$img[1] ."</p>";
      ?>
    </div>
  </div>
  <h1 class="text-center fw-bold fs-1 mb-4" id="update_success"></h1>
  <h1 class="text-center fw-bold fs-1" id='account'>Edit Account:</h1>
  <div class="mb-3">
    <div class="form-group">
      <div class="row d-flex">
        <div class="col-md-6 col-10 mb-md-0 mb-2">
          <h4>First Name</h4>
          <input type="text" class="form-control fw-bold" id="edit_fname" value="<?php echo $record->first_name ?>"/>
        </div>
        <div class="col-md-6 col-10 mb-md-0 mb-2">
          <h4>Last Name</h4>
          <input type="text" class="form-control fw-bold" id="edit_lname" value="<?php echo $record->last_name ?>"/>
        </div>
        <div class="col-md-6 col-10 mb-md-0 mb-2">
          <h4>Email ID</h4>
          <input type="email" class="form-control fw-bold"   id="edit_email" value="<?php echo $record->email ?>" <?php if($_SESSION["user"]->user_id!==$record->user_id) echo "disabled" ?>/>
        </div>
        <div class="col-md-6 col-10 mb-md-0 mb-2">
          <h4>Password</h4>
          <input type="text" class="form-control fw-bold"  id="edit_password" value="<?php echo $record->password ?>" <?php if($_SESSION["user"]->user_id!==$record->user_id) echo "disabled" ?>/>
        </div>
        <div class="col-md-6 col-10 mb-md-0 mb-2">
          <h4>Gender</h4>
          <select class="form-control" id="edit_gender">
            <option value="Male" <?php echo $record->gender==="Male" ? "selected"  :"" ?>>Male</option>
            <option value="Female" <?php echo $record->gender==="Female" ? "selected"  :"" ?>>Female</option>
            <option value="Other" <?php echo $record->gender==="Other" ? "selected"  :"" ?>>Other</option>
          </select>
        </div>
        <div class="col-md-6 col-10 mb-md-0 mb-2">
          <h4>Address</h4>
          <textarea id="edit_address" rows="1"  class="form-control  fw-bold"><?php echo $record->address ?></textarea>
        </div>
        <div class="col-md-6 col-10 mb-md-0 mb-2">
          <h4>Status</h4>
          <select class="form-control" id="edit_status" <?php if($_SESSION["user"]->role_id!="1") echo "disabled" ?>>
            <option value="Active" <?php echo $record->is_active==="Active" ? "selected"  :"" ?>>Active</option>
            <?php
            if($_SESSION["user"]->user_id != $record->user_id){
              ?>
              <option value="InActive" <?php echo $record->is_active==="InActive" ? "selected"  :""?>>InActive</option>
              <?php
            }
            ?>
          </select>
        </div>
        <div class="col-md-6 col-10 mb-md-0 mb-2">
          <h4>Approved</h4>
          <select class="form-control" id="edit_approved" <?php if($_SESSION["user"]->role_id!="1") echo "disabled" ?>>
            <option value="Approved" <?php echo $record->is_approved==="Approved" ? "selected"  :"" ?>>Approved</option>
            <?php 
            if($_SESSION["user"]->user_id != $record->user_id AND $record->is_approved!="Approved" ){
              ?>
              <option value="Pending" <?php echo $record->is_approved==="Pending" ? "selected"  :"" ?>>Pending</option>
              <option value="Rejected" <?php echo $record->is_approved==="Rejected" ? "selected"  :"" ?>>Rejected</option>
              <?php                      
            } ?>
          </select>
        </div>
        <div class="col-md-6 col-10 mb-md-0 mb-2">
          <h4>Date Of Birth</h4>
          <input type="date" class="form-control" id="edit_dob" value="<?php echo $record->date_of_birth ?>" />
        </div> 
        <div class="col-md-6 col-10 mb-md-0 mb-2">
          <h4>Edit Image</h6>
            <input type="file" class="form-control fw-bold"
            id="edit_image" value="<?php echo $record->user_image ?>"/>
          </div>
          <div class="col-12 mt-4">
            <button class="btn btn-primary btn-md fw-bold" onclick="edit_account('<?php echo $record->user_id ?>','<?php echo $record->user_image ?>')">Edit User</button>
            <button class="btn btn-warning btn-md fw-bold" 
            onclick="close_form('view_user')">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php
}
// add user
function add_user(){
  ?>
  <div class="col-md-8 col-10 py-3 px-5 border" id="edit_user_col">
    <div class="row d-flex justify-content-center">
    </div>
    <h1 class="text-center fw-bold fs-1 mb-4 text-danger" id="add_error"></h1>
    <h1 class="text-center fw-bold fs-1 mb-4" id="add_success"></h1>
    <h1 class="text-center fw-bold fs-1" id='account'>Add User:</h1>
    <div class="mb-3">
      <div class="form-group">
        <div class="row d-flex">
          <div class="col-md-6 col-10 mb-md-0 mb-2">
            <h4>First Name<span class="text-danger">*</span></h4>
            <input type="text" class="form-control fw-bold" placeholder="First Name" id="fname"/>
          </div>
          <div class="col-md-6 col-10 mb-md-0 mb-2">
            <h4>Last Name<span class="text-danger">*</span></h4>
            <input type="text" class="form-control fw-bold"   placeholder="Last Name"
            id="lname"/>
          </div>
          <div class="col-md-6 col-10 mb-md-0 mb-2">
            <h4>Email<span class="text-danger">*</span></h4>
            <input type="email" class="form-control fw-bold"
            placeholder="Email Address"
            id="email"
            />
          </div>
          <div class="col-md-6 col-10 mb-md-0 mb-2">
            <h4>Password<span class="text-danger">*</span></h4>
            <input type="text" class="form-control fw-bold"  placeholder="Password"
            id="password"/>
          </div>
          <div class="col-md-6 col-10 mb-md-0 mb-2">
            <h4>Edit Image<span class="text-danger">*</span></h6>
              <input type="file" class="form-control fw-bold"
              id="user_image"/>
            </div>
            <div class="col-md-6 col-10 mb-md-0 mb-2">
              <h4>Date Of Birth<span class="text-danger">*</span></h4>
              <input type="date" class="form-control" 
              id="date_of_birth"/>
            </div> 
            <div class="col-md-6 col-10 mb-md-0 mb-2">
              <h4>Address<span class="text-danger">*</span></h4>
              <textarea rows="1"  class="form-control  fw-bold"  id="addrress" placeholder="House#32 Street#9 Madrid"></textarea>
            </div>
            <div class="col-md-6 col-10 mb-md-0 mb-2">
              <h4>Gender<span class="text-danger">*</span></h4>
              <label><b>Male</b></label>
              <input class="form-check-input" type="radio" 
              name="gender" id="male" value="male" /><br/>
              <label><b>Female</b></label>
              <input class="form-check-input" type="radio" 
              name="gender" id="female" value="female"/><br/>
              <label><b>Other</b></label>
              <input class="form-check-input" type="radio" name="gender" id="other" value="other"/><br/>
            </div>
            <div class="col-12 mt-4">
              <button class="btn btn-primary btn-md fw-bold" onclick="add()">Add User</button>
              <button class="btn btn-warning btn-md fw-bold" 
              onclick="close_form('view_user')">Close</button>
              <button class="btn btn-dark text-light btn-md fw-bold" onclick="resetData()">Reset</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
}
  // View Blogs
function our_blogs($record){
    ?>
    <table id="example" class="display table table-hover" style="width:100%" data-ordering="false">
      <thead>
        <tr>
          <th>S:No</th>
          <th>Title</th>
          <th>Post</th>
          <th>Active</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $counter=0;
        while($entity=mysqli_fetch_object($record)){
          ?>
          <tr class="border <?php echo $entity->blog_status==="Active" ? 'table-success' : 'table-danger' ?>">
            <td class="text-dark fw-bold"><?php echo ++$counter ?></td>
            <td class="text-dark fw-bold"><?php echo ucfirst($entity->blog_title) ?></td>
            <td class="text-dark fw-bold"><?php echo $entity->post_per_page ?></td>
            <td class="text-dark fw-bold">
              <div class="form-check form-switch row d-flex justify-content-center">
                <input class="form-check-input" type="checkbox"
                <?php
                if($entity->user_id==$_SESSION["user"]->user_id){
                  ?>
                  onclick="blogStatus('<?php echo $entity->blog_status ?>',this)"
                  <?php
                }
                ?>
                id="flexSwitchCheckChecked" <?php echo $entity->blog_status==="Active" ? "checked":"" ?> value="<?php echo $entity->blog_id ?>" <?php echo $entity->user_id!=$_SESSION["user"]->user_id ? "disabled" :"title='you can't edit this"?>/>
              </div>
            </td>
            <td class="text-dark fw-bold">
              <?php 
              if($entity->blog_status==="Active"){
                ?>
                <a href="./blog.php?id=<?php echo $entity->blog_id ?>" target="_blank">
                  <?php
                }
                ?>
                <i class="<?php  
                if($entity->blog_status==="Active"){
                  echo 'fas fa-eye';
                }else{
                  echo 'fa-sharp fa-solid fa-eye-slash';
                }
                ?> 
                text-dark" title="View User"></i></a>
                &nbsp;&nbsp;
                <?php
                if($entity->user_id==$_SESSION["user"]->user_id){
                  ?>
                  <i class="fas fa-pencil-alt text-dark" title="Edit User" onclick="update_data_blog('<?php echo $entity->blog_id ?>')" style="cursor:pointer"></i>
                  <?php
                }
                ?>
              </td>
              <?php
            }
            ?>
          </tr>
        </tbody>
      </table>
      <?php
}
// View Categories
function our_categories($data){
      ?>
      <table id="example" class="display table table-hover" style="width:100%" data-ordering="false">
        <thead>
          <tr>
            <th>Title</th>
            <th>Summary</th>
            <th>Active</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while($record=mysqli_fetch_object($data)){
            ?>
            <tr class="text-dark fw-bold <?php echo $record->category_status==='Active' ? 'table-success' : 'table-danger' ?>">
             <td><?php echo ucwords($record->category_title) ?></td>
             <td>
              <?php echo 
              strlen($record->category_description)>15 ? substr($record->category_description,0,15) ."..." : $record->category_description ?> 
            </td>
            <td>
              <div class="form-check form-switch row d-flex justify-content-center">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" 
                <?php echo $record->category_status==="Active" ? "checked" : "" ?> 
                onclick="update_cat_status('<?php echo $record->category_id ?>','<?php echo $record->category_status ?>')"/>
              </div>
            </td>
            <td>
              <i class="fas fa-pencil-alt" title="Edit Category" style="cursor:pointer" 
              onclick="updateCategory('<?php echo $record->category_title ?>','<?php echo $record->category_description ?>','<?php echo $record->category_id?>')"></i>
            </td>
            <?php
          }?>
        </tr>
      </tbody>
    </table>
    <?php
}
// cat_update_function
function cat_update($title,$description,$id){
    ?>
    <div class="col-md-6 col-10">
      <h1 class="text-center">Update Category</h1>
      <div class="form-group mb-4">
        <h5>Category Title</h5>
        <input type="text" class="form-control" id="update_cat_title" value="<?php echo $title ?>"/>
      </div>
      <div class="form-group">
        <h5>Category Description</h5>
        <textarea class="form-control" rows="2" id="update_cat_description"><?php echo $description ?></textarea>
      </div>
      <button class="btn btn-primary btn-md mt-4" onclick="updated('<?php echo $id ?>')">Update</button>
    </div>
    <?php
}
// view posts
function our_posts($data){
    ?>
    <table id="example" class="display table table-hover" style="width:100%" data-ordering="false">
      <thead>
        <tr>
          <th>Title</th>
          <th>Summary</th>
          <th>Active</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($record=mysqli_fetch_object($data)){
          ?>
          <tr class="text-dark fw-bold <?php echo $record->post_status==="Active" ? 'table-success' : 'table-danger' ?>">
           <td><?php echo ucwords($record->post_title) ?></td>
           <td>
            <?php 
            echo  strlen($record->post_summary)>15 ? substr($record->post_summary, 0,12) ."..." : $record->post_summary ?> 
          </td>
          <td>
            <div class="form-check form-switch row d-flex justify-content-center">
              <input class="form-check-input" <?php echo $record->post_status==="Active" ? "checked" :""  ?> type="checkbox" id="flexSwitchCheckChecked" <?php echo $_SESSION["user"]->user_id!=$record->user_id ? "disabled" : "" ?>
              onclick="update_post_status('<?php echo $record->post_status ?>',this)" value="<?php echo $record->post_id ?>"/>
            </div>
          </td>
          <td>
            <?php
              if($record->post_status=="Active"){
                ?>
                <a href="./post.php?id=<?php echo $record->post_id ?>" target="_blank">
                   <i class="fas fa-eye" title="View Post" style="cursor:pointer"></i>
                </a>
                <?php
              }else{
                ?>
                <i class="fa-sharp fa-solid fa-eye-slash" title="View Post"></i>
                <?php
              }
            ?>
            <?php
              if($record->user_id==$_SESSION["user"]->user_id){
                ?>
                  <i class="fas fa-pencil-alt" title="Edit Post" style="cursor:pointer" 
                  onclick="update_post('<?php echo $record->post_id ?>')"></i>
                <?php
              }
            ?>
          </td>
          <?php
        }?>
      </tr>
    </tbody>
  </table>
  <?php
}
// update posts
function update_posts($id,$blogs,$categories){
  GLOBAL $database;
  $data=null;
  $posts=$database->get_posts("SELECT * FROM `post`");
  $multi_cat=$database->get_posts("SELECT P.`post_id`,C.`category_id`,C.`category_title` FROM `category` C INNER JOIN `post_category` PC
  INNER JOIN `post` P ON C.`category_id` = PC.`category_id` AND P.`post_id` = PC.`post_id` WHERE P.`post_id`= $id");
  $attachements=$database->get_attachment($id);
    $selected=null;
    while($check_cat=mysqli_fetch_object($multi_cat))
      $selected.=$check_cat->category_id .",";
    $selected=substr($selected, 0,-1);
    $selected=explode(",", $selected);
  while($post=mysqli_fetch_object($posts)){
    if($post->post_id==$id) $data=$post;
  } 
  ?>
  <input type="hidden" id="old_featured_image" value="<?php echo $data->featured_image ?>">
  <div class="form-container">
    <div class="col-12">
      <h3 class="text-center">Edit Post</h3>
      <div class="row d-flex justify-content-center">
        <div class="col-md-8">
          <center>
            <img src="./assets/images/posts/<?php echo $data->featured_image ?>" alt="no-img" class='w-100' style="height: 300px">
            <h6>
              <?php 
              $image_title=strpos($data->featured_image,"_");
              echo substr($data->featured_image,$image_title+1);
              ?> 
            </h6>
          </center>
        </div>
      </div>
    </div>
    <div class="form-horizontal">
        <div class="form-group">
          <label>Post Title</label>
          <input type="text" class="form-control" value="<?php echo $data->post_title ?>" id="update_post_title"/>
        </div>
        <div class="form-group">
          <label>Featured Image</label>
          <input type="file" class="form-control" id="update_post_image"/>
        </div>
        <div class="form-group">
          <label>Post Summary</label>
          <textarea class="form-control" rows="5" id="update_post_summary"><?php echo $data->post_summary ?></textarea>
        </div>
        <div class="form-group">
          <label>Post Description</label>
          <textarea class="form-control" rows="5" id="update_post_description"><?php echo $data->post_description ?></textarea>
        </div>
        <div class="form-group">
          <label>Select Blog<span class="text-danger fs-5">*</span></label>
          <select class="form-control fw-normal" id="update_post_blog">
            <option value="">--Select Blog--</option>                                
            <?php
                while($blog=mysqli_fetch_object($blogs)){
                  if($blog->user_id==$_SESSION["user"]->user_id){
                    ?>
                    <option value="<?php echo $blog->blog_id ?>" <?php echo $blog->blog_id==$data->blog_id ? "selected" : ""?>>
                      <?php echo $blog->blog_title ?>
                    </option>                  
                    <?php
                  }
                } 
            ?>
          </select>
        </div>
        <div class="form-group">
          <label>Comment Allowed<span class="text-danger fs-5">*</span></label>
          <select class="form-control fw-normal" id="update_post_comment_mode">
            <option value="">--Comment Mode--</option>
            <option value="1" <?php echo $data->is_comment_allowed ? "selected" :"" ?>>Allowed</option>
            <option value="0" <?php echo !$data->is_comment_allowed ? "selected" :"" ?>>Not Allowed</option>
          </select>
        </div>
        <div class="form-group w-100" style="height:100px; overflow-y: auto;">
          <label class="mb-2">Post Categories<span class="text-danger fs-5">*</span></label><br/>
          <?php
            while($cat=mysqli_fetch_object($categories)){
              $checked=null;
              foreach ($selected as $value) if($value==$cat->category_id) $checked="checked";
              ?>
               <label><?php echo ucwords($cat->category_title) ?>&nbsp;&nbsp;</label>
                <input type="checkbox" class="update_post_category" value="<?php  echo $cat->category_id ?>" 
                <?php echo $checked ? $checked : "" ?>/>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <?php
            }
          ?>
        </div>
    </div>
    <?php
        if($attachements->num_rows){
            ?>
            <div class="col-12">
              <h3 class="text-center">Attachements</h3>
              <div class="row d-flex justify-content-center">
              <?php
              while($attachement=mysqli_fetch_object($attachements)){
                ?>
                  <div class="col-md-4 mb-1 form-group mb-2">
                  <h4><?php echo $attachement->post_attachment_title ?></h4>
                  <img src="./assets/images/attachements/<?php echo $attachement->post_attachment_path ?>" alt="no-img" class='w-100' style="height: 300px"/>
                  <button class="btn mt-1 btn-sm <?php echo $attachement->is_active=="Active" ?  "btn-primary": "btn-danger"?>" onclick="update_attachement('<?php echo $attachement->is_active ?>',this)" 
                  value="<?php echo $attachement->post_atachment_id ?>"><?php echo $attachement->is_active=="Active" ?"InActive" : "Active" ?></button>
                </div>
              <?php
              }
              ?>
            </div>
            <input type="hidden" id="post_iddd" value="<?php echo  $id ?>">
          </div>
          <?php
        }
      ?>
      <button class="btn btn-outline-light" onclick="updated_data('<?php echo $id ?>')">Update</button>
      <button class="btn btn-outline-light" onclick="close_post()">Close</button>
  </div>
  <?php
}
// View Comments
function view_comments($data){
  GLOBAL $months;
  ?>
    <table class="panel-body table-responsive table table-hover table-bordered" data-ordering="false" id="example">
        <thead>
          <tr>
            <th>Name</th>
            <th>Time</th>
            <th>Status</th>
            <th>Comment</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($comment=mysqli_fetch_object($data)){
            ?>
              <tr>
                <td>
                    <img src="./assets/images/users/<?php echo $comment->user_image ?>" alt="no-img" style="width:70px; height:70px; border-radius: 50%">
                    <?php
                      if($comment->is_active=="Active"){
                        ?>
                        <span class="fw-bold text-primary">
                          <?php echo ucwords($comment->first_name ." " .$comment->last_name) ?>
                        </span>
                        <?php
                      } else{
                        ?>
                        <span class="fw-bold text-danger">
                          <del>
                            <?php echo ucwords($comment->first_name ." " .$comment->last_name) ?>
                          </del>
                        </span>
                        <?php
                      }
                    ?>
                </td>
                <td class="pt-4">
                <?php
                  $time=explode(" ",$comment->created_at);
                  $date=explode("-",$time[0]);
                  $time_two=explode(":",$time[1]);
                  $month=$date[1];
                ?>
                <span class="text-primary">
                  <?php echo "".$date[2]."-".$months[$month-1]."-".$date[0]."" ?>
                </span>
                <span class="text-primary">
                  <?php 
                    echo $time_two[0].":".$time_two[1] .":".$time_two[2] 
                  ?>
                </span>
                <span class="text-primary">
                  <?php echo $time_two[0]>=12 ? "PM":"AM" ?>
                </span>
                </td>
                <td>
                  <button class="btn mt-3 btn-sm <?php echo $comment->is_active=="Active" ? "btn-success" : "btn-danger" ?>" onclick="update_comment('<?php echo $comment->is_active ?>',this)" value="<?php echo $comment->post_comment_id ?>">
                    <?php echo $comment->is_active=="Active" ? "InActive" : "Active"?>
                </button>
                </td>
                <td class="pt-4">
                  <?php echo $comment->comment ?>
                </td>
              </tr>
            <?php
          }
          ?>
      </tbody>
    </table>
  <?php
}
// Show Comments
function show_comments($data){
  GLOBAL $months;
  $InActive=true;
  if($data->num_rows){
    while($comment=mysqli_fetch_object($data)){
      if($comment->is_active!="InActive"){
        ?>
          <div class="card-body">
            <div class="d-flex flex-start align-items-center">
              <img class="rounded-circle shadow-1-strong me-3"
                src="./assets/images/users/<?php echo $comment->user_image ?>" alt="avatar" width="60"
                height="60"/>
              <div>
                <h6 class="fw-bold mb-1"><?php echo ucwords($comment->first_name. " " .$comment->last_name) ?></h6>
                <?php 
                  $time=explode(" ",$comment->created_at);
                  $date=explode("-", $time[0]);
                  $time_two=explode(":",$time[1]);
                ?>
                <span class="text-primary"><?php echo "".$date[2]."-".$months[$date[1]-1]."-".$date[0]." " ?></span>
                <span class="text-primary"><?php echo $time_two[0].":".$time_two[1] .":".$time_two[2]?></span>
                <span class="text-primary"><?php echo $time_two[0]<12 ? "AM" : ""?></span>
              </div>
            </div>
            <p class="mt-3 mb-4 pb-2 comment_content text-justify">
              <?php echo $comment->comment ?>
            </p>
          </div>
        <?php
      }
    }
  }else echo "<h3>No Comments on this post</h3>";
  ?>
  <?php
}
// index posts
function index_posts($data){
  GLOBAL $database;
    while($post=mysqli_fetch_object($data)){
      ?>
      <div class="col-lg-6 col-10 mb-4">
        <div class="card">
          <a href="./post.php?id=<?php echo $post->post_id ?>" target="new">
          <img class="card-img-top" src="./assets/images/posts/<?php echo $post->featured_image ?>" alt="Card image cap" style="height: 300px;">
          <div class="card-body">
          <h3 class="card-title post_title">
            <?php echo $post->post_title ?>
          </h3>
          <p class="card-text post_content px-2">
            <?php echo strlen($post->post_description)>244 ? substr($post->post_description,0,244) ."..." : $post->post_description ?>
          </p>
          <p class="card-text card-creator">
            <small class="text-creator">
              <i class="far fa-user"></i><?php echo ucwords($post->first_name ." " .$post->last_name) ?>
              <i class="fa-brands fa-blogger-b"></i><?php echo $post->blog_title ?><br/>
              <?php
                $categories=$database->show_post_categories();
                $cat_title="";
                while($cat=mysqli_fetch_object($categories)){
                  if($cat->post_id==$post->post_id AND $cat->category_status !=='InActive'){
                    $cat_title.=$cat->category_title ." | ";
                  }
                }
              ?>
               <i class="fa-sharp fa-solid fa-sitemap"></i>
               <?php echo substr($cat_title,0,strlen($cat_title) -1 - 1) ?>
            </small>
          </p>
          </div>
          </a>
        </div>
      </div>
    <?php
    }
}
//show_post_with_blogs
function show_with_blogs($data,$post_per_page,$blog_following_id,$start_val=0){
  GLOBAL $database;
  $array=array();
  $total_posts=0;
  $postsss=$database->get_posts("SELECT * FROM `post` ORDER BY `post_id` DESC");
  while($post_counter=mysqli_fetch_object($postsss)){
    if($post_counter->blog_id==$blog_following_id AND $post_counter->post_status=="Active") $total_posts++;
  }
  while($post=mysqli_fetch_object($data)){
    if($post->post_status=="Active"){
      foreach ($array as $value)
      if($value==$post->post_id) continue 2;
    $array[]=$post->post_id;
    ?>
    <div class="col-md-4">
      <div class="card">
        <a href="./post.php?id=<?php echo $post->post_id ?>" target="new">
          <img class="card-img-top" src="./assets/images/posts/<?php echo $post->featured_image ?>" alt="Card image cap" style="height: 300px;">
          <div class="card-body">
            <?php
              $cat_name="";
              $categories=$database->show_post_categories();
              while($category=mysqli_fetch_object($categories)){
                if($post->post_id==$category->post_id AND $category->category_status=="Active") $cat_name.=$category->category_title ." | ";
              }
            ?>
          <h3 class="card-title post_title">
            <?php echo $post->post_title ?>
          </h3>
          <span class="card-title post_title"><?php echo substr($cat_name, 0,-1-1) ?></span>
          <h2 class="post_title">Description:</h2>
          <p class="card-text  text-justify post_content px-2 mt-2">
            <?php echo strlen($post->post_description)>244 ? substr($post->post_description,0,244) ."..." : $post->post_description ?>
          </p>
          </div>
          </a>
        </div>
    </div>
    <?php
    }
  }
  $pagination=ceil($total_posts/$post_per_page);
  if($pagination>1){
    ?>
    <div class="col-12 d-flex justify-content-md-end my-4">
      <div class="col-md-4">
    <center>
        <?php
          if($start_val>1){
            ?>
            <button class="btn btn-sm btn-outline-light" onclick="post_limit('<?php echo $start_val - 1 ?>')">Previous</button>
            <?php
          }
          for($a=1; $a<=$pagination; $a++){
            ?>
              <button class="btn btn-sm btn-outline-light mx-0" onclick="post_limit('<?php echo $a ?>')"><?php echo $a ?></button>
            <?php
          }
          if($start_val!=$a-1){
            ?>
            <button class="btn btn-sm btn-outline-light mx-0" onclick="post_limit('<?php echo $start_val + 1 ?>')">Next</button>
            <?php
          }
        ?>
    </center>
    </div>
  </div>
    <?php
  }
  ?>
  <?php
}
?>
