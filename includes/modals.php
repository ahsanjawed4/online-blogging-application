<?php 
  function forgetModal(){
    ?>
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title forget_title fw-bold" id="exampleModalLabel">Forget Password?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-container">
                  <label for="recipient-name" class="col-form-label forget_label fw-bold">Enter Email:</label>
                <div class="mb-3">
                  <div class="form-group">
                    <h6 class="modal-title forget_title fw-bold mb-1">Email ID</h6>
                    <input type="email" class="form-control" placeholder="Enter Email" name="forget_email" id="forget_email"/>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
              <input name="forget_password" class="btn btn-outline-light" value="Send Email"/>
            </div>
          </div>
        </div>
      </div>
    <?php
  }
  // category modal
  function categoryModal(){
    ?>
      <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title forget_title fw-bold" id="exampleModalLabel">Add Category</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body form-container">
                <div class="form-group w-100">
                  <h6>Category Title:</h6>
                  <input type="text" class="form-control" placeholder="Category Title" id="category_title"/>
                </div>
                <div class="form-group w-100 my-4">
                  <h6>Category Description:</h6>
                <textarea class="form-control" id="category_description" placeholder="Sports is life"></textarea>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
              <button class="btn btn-outline-light" id="add_category" data-bs-dismiss="modal" onclick="addCategory()">Add Category<button>
            </div>
          </div>
        </div>
      </div>
    <?php
  }
  // Update Category Model
  ?>