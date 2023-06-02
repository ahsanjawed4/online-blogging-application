<?php
  function addPost($blogs,$categories){
    ?>
    <div class="form-container mb-3">
      <h3 class="text-center text-danger" id="post_error"></h3>
      <h3 class="text-center text-danger" id="post_success"></h3>
      <h3 class="title">Add Post</h3>
      <div class="form-horizontal">
        <div class="form-group">
          <label>Post Title<span class="text-danger fs-5">*</span></label>
          <input type="text" class="form-control" placeholder="Post Title" id="post_title"/>
        </div>
        <div class="form-group">
          <label>Featured Image<span class="text-danger fs-5">*</span></label>
          <input type="file" class="form-control" id="post_image"/>
        </div>
        <div class="form-group">
          <label>Post Summary<span class="text-danger fs-5">*</span></label><br/>
          <textarea class="form-control" rows="5" id="post_summary" placeholder="This is post summary"></textarea>
        </div>
        <div class="form-group">
          <label>Post Description<span class="text-danger fs-5">*</span></label><br />
          <textarea class="form-control fw-normal" rows="5" id="post_description" placeholder="This is post description"></textarea>
        </div>
        <div class="form-group">
          <label>Select Blog<span class="text-danger fs-5">*</span></label>
          <select class="form-control fw-normal" id="post_blog">
            <option value="">--Select Blog--</option>                  
            <?php
                while($data=mysqli_fetch_object($blogs)){
                  if($data->user_id==$_SESSION["user"]->user_id){
                    ?>
                    <option value="<?php echo $data->blog_id ?>"><?php echo $data->blog_title ?></option>                  
                    <?php
                  }
                } 
            ?>
          </select>
        </div>
        <div class="form-group">
          <label>Comment Allowed<span class="text-danger fs-5">*</span></label>
          <select class="form-control fw-normal" id="post_comment_mode">
            <option value="">--Comment Mode--</option>
            <option value="1">Allowed</option>
            <option value="0">Not Allowed</option>
          </select>
        </div>
        <div class="form-group w-100" style="height:100px; overflow-y: auto;">
          <label class="mb-2">Post Categories<span class="text-danger fs-5">*</span></label><br/>
          <?php
            while($cat=mysqli_fetch_object($categories)){
              ?>
                <label><?php echo ucwords($cat->category_title) ?>&nbsp;&nbsp;</label>
                <input type="checkbox" class="post_category" value="<?php  echo $cat->category_id ?>">
                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
              <?php
            }
          ?>
        </div>
        <div id="post_att_div"></div>
        <br />
        <center>
          <button class="btn btn-outline-light mt-3" onclick="addAttachment()">Add Attachement&nbsp;&nbsp;&nbsp;<i class=" mt-1 fa-solid fa-square-plus"></i></button><br/>
        </center>
        <button class="btn btn-outline-light"  onclick="add_post()">Create</button>
    </div>
    <?php
  }
?>