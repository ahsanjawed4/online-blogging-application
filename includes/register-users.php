<h1 class="admin-heading">Add User</h1>
<div class="form-container mb-3">
  <h3 class="title">Register</h3>
  <form
    class="form-horizontal"
    method="POST"
    action="form.php"
    enctype="multipart/form-data"
  >
    <div class="form-group">
      <label>First Name <span class="text-danger">*</span></label>
      <input
        type="text"
        class="form-control"
        placeholder="First Name"
        name="fname"
        id="fname"
      />
      <span class="text-danger" id="fname_error"></span>
    </div>
    <div class="form-group">
      <label>Last Name <span class="text-danger">*</span></label>
      <input
        type="text"
        class="form-control"
        placeholder="Last Name"
        name="lname"
        id="lname"
      />
      <span class="text-danger" id="lname_error"></span>
    </div>
    <div class="form-group">
      <label>Email ID <span class="text-danger">*</span></label>
      <input
        type="email"
        class="form-control"
        placeholder="Email Address"
        name="email"
        id="email"
      />
      <span class="text-danger" id="email_error"></span>
    </div>
    <div class="form-group">
      <label>Confirm Email <span class="text-danger">*</span></label>
      <input
        type="email"
        class="form-control"
        placeholder="Confirm Email"
        name="confirm_email"
        id="confirm_email"
      />
      <span class="text-danger" id="confirm_email_error"></span>
    </div>
    <div class="form-group">
      <label>Password <span class="text-danger">*</span></label>
      <input
        type="password"
        class="form-control"
        placeholder="Password"
        name="password"
        id="password"
      />
      <span class="text-danger" id="password_error">password atleast 8 characaters long</span>
    </div>
    <div class="form-group">
      <label>Confirm Password <span class="text-danger">*</span></label>
      <input
        type="password"
        class="form-control"
        placeholder="Confirm Password"
        name="confirm_password"
        id="confirm_password"
      />
      <span class="text-danger" id="confirm_password_error"></span>
    </div>
    <div class="form-group">
      <label>Profile Image <span class="text-danger">*</span></label>
      <input
        type="file"
        class="form-control"
        name="profile_image"
        id="user_image"
      />
      <span class="text-danger" id="profile_img_error"></span>
    </div>
    <div class="form-group">
      <label>Date Of Birth <span class="text-danger">*</span></label>
      <input
        type="date"
        class="form-control"
        name="date_of_birth"
        id="date_of_birth"
      />
      <span class="text-danger" id="dob_error"></span>
    </div>
    <div class="form-group">
      <label>Gender <span class="text-danger">*</span></label>
      <span class="text-danger" id="gender_error"></span>
      <ul class="radio-list">
        <li class="radio-button">
          <input type="radio" name="gender" id="male" value="male" />
          <label for="male">Male</label>
        </li>
        <li class="radio-button">
          <input type="radio" name="gender" id="female" value="female" />
          <label for="female">Female</label>
        </li>
        <li class="radio-button">
          <input type="radio" name="gender" id="other" value="other" />
          <label for="other">Other</label>
        </li>
      </ul>
    </div>
    <br />
    <div class="form-group" style="margin-top: -50px">
      <label>Address <span class="text-danger">*</span></label
      ><br />
      <textarea
        class="form-control"
        rows="5"
        name="address"
        id="address"
        placeholder="House#32 Street#9 Madrid"
      ></textarea>
      <span class="text-danger" id="adress_error"></span>
    </div>
    <br />
    <input
      type="submit"
      class="btn btn-outline-light"
      name="register_user"
      value="Create Account"
      onclick="return registerUser()"
    />
    <br />
    <span class="signin-link mt-2"
      >Already have an account? Click here to
      <a href="./login.php" class="mt-xs-0 mt-1 d-inline-block">Login</a></span
    >
  </form>
  <button class="btn btn-outline-light" onclick="resetUser()" id="ahsan jawed">
    Reset
  </button>
</div>
