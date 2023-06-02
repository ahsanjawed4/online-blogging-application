<?php
  function add_update_blog(){
      ?>
      <h1 class="text-center fw-bold fs-1" id='blog-heading'>Add Blog</h1>
      <div class="mb-3">
        <div class="form-group">
          <div class="row d-flex">
            <div class="col-md-6 col-12 mb-md-0 mb-2">
              <h4>Blog Title<span class="text-danger">*</span></h4>
              <input type="text" class="form-control fw-bold" placeholder="Blog Title" id="blog_title" value=""/>
            </div>
            <div class="col-md-6 col-12 mb-md-0 mb-2">
              <h4>Post Per Page<span class="text-danger">*</span></h4>
              <input type="text" class="form-control fw-bold"   placeholder="Post Per Page"
              id="post_per_page" value=""/>
            </div>
            <div class="col-md-6 col-12 mb-md-0 mb-2 mt-3">
              <h4>Blog Cover Image<span class="text-danger">*</span></h6>
                <input type="file" class="form-control fw-bold"
                id="blog_cover_image"/>
              </div>
              <div class="col-12 mt-4">
                    <button class="btn btn-primary btn-sm fw-bold" onclick="create_blog()">Create Blog</button> 
                <button class="btn btn-warning btn-sm fw-bold" 
                onclick="close_form('manage_blog_id')">Close</button>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
      // update blog data
  function update_blog_data($id,$blog_title,$post_per_page,$blog_background_image){
    ?>
    <?php 
      if($blog_background_image){
        ?>
          <div class="row d-flex justify-content-center">
            <?php $bg_title=explode("_", $blog_background_image)?>
            <img src="./assets/images/blogs/<?php echo $blog_background_image ?>" style="height: 300px" class="border w-100"/>
            <h4><?php echo $bg_title[1] ?></h4>
          </div>
      <?php
    }
    ?>
    <h1 class="text-center fw-bold fs-1" id='blog-heading'>Edit Blog</h1>
    <div class="mb-3">
      <div class="form-group">
        <div class="row d-flex">
          <div class="col-md-6 col-12 mb-md-0 mb-2">
            <h4>Blog Title<span class="text-danger">*</span></h4>
            <input type="text" class="form-control fw-bold" placeholder="Blog Title" id="edit_blog_title" value="<?php echo $blog_title ?>"/>
          </div>
          <div class="col-md-6 col-12 mb-md-0 mb-2">
            <h4>Post Per Page<span class="text-danger">*</span></h4>
            <input type="text" class="form-control fw-bold" placeholder="Post Per Page" id="edit_post_per_page" value="<?php echo $post_per_page ?>"/>
          </div>
          <div class="col-md-6 col-12 mb-md-0 mb-2 mt-3">
            <h4>Blog Cover Image<span class="text-danger">*</span></h6>
            <input type="file" class="form-control fw-bold" id="edit_img"/>
            </div>
            <div class="col-12 mt-4">
            <button class="btn btn-primary btn-sm fw-bold" onclick="edit_blog_data('<?php echo $blog_background_image ?>','<?php echo $id ?>')">
            update Blog</button> 
            <button class="btn btn-warning btn-sm fw-bold" 
            onclick="close_form('manage_blog_id')">Close</button>
          </div>
        </div>
      </div>
    </div>
  <?php
  }
?>
