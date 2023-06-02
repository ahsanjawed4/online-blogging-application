<h1 class="admin-heading">Add Post Attachment</h1>
<div class="form-container mb-3">
  <h3 class="title">Add Post Attachment</h3>
  <form
    class="form-horizontal"
    method="POST"
    action="form.php"
    enctype="multipart/form-data"
  >
    <div class="form-group">
      <label>Attachment Title</label>
      <input
        type="text"
        class="form-control"
        placeholder="Attachment Title"
        name="attachment_title"
        id="attachment_title"
      />
    </div>
    <div class="form-group">
      <label>Attachment Image</label>
      <input
        type="file"
        class="form-control"
        name="attachment_image"
        id="attachment_image"
      />
    </div>
    <div class="form-group">
      <label>Post</label>
      <select class="form-control" name="role" id="role">
        <option value="">Select Post</option>
        <option value="1">Post 1</option>
        <option value="2">Post 2</option>
      </select>
    </div>
    <br />
    <br />
    <input
      type="submit"
      class="btn btn-outline-light"
      name="add_attachment"
      value="Add Attachment"
    />
  </form>
</div>
