<?php
interface DBDriver{
  public function custom_query($query);
  public function get_users();
  public function register_user($role_id,$fname,$lname,$email,$password,$genger,$date_of_birth,$user_image,$address,$is_approved,$is_active);
  public function user_role();
  public function manage_user($search_value="",$approved_status);
  public function update_user_status($value,$user_id);
  public function edit_user($fname,$lname,$email,$password,$gender,$edit_img,$address,$is_active,$is_approved,$dob,$id);
  // Blogs
  public function view_blogs($status="");
  public function updateblogdata($status="");
  public function add_blog($user_id,$blog_title,$blog_per_page,$blog_attachement,$active_status);
  public function update_blog_status($status,$id);
  public function edit_blog_data($blog_title,$post_per_page,$bg_img,$id);
  public function following_blogs();
  public function post_following_blogs($follower_id,$blog_following_id,$status="Followed");
  public function update_following_blogs($status,$follow_id);
  // categories
  public function get_categories($status="");
  public function insert_category($category_title,$category_description,$category_status="Active");
  // delete categories
  public function delete_categories($id);
  public function update_cat_status($status,$id);
  public function update_category($title,$description,$id);
  // get posts
  public function get_posts($query);
  // update_post_status
    public function update_post_status($status,$id);
  // posts
  public function insert_post($blog_id,$post_title,$post_summary,$post_description,$featured_image,$post_status,$is_comment_allowed);
  // update post
  public function update_post($blog_id,$post_title,$post_summary
    ,$post_description,$featured_image,$is_comment_allowed,$post_id);
  // post_Category
  public function insert_post_ategory($post_id,$category_id);
  // post_Attachement
  public function insert_post_attachement($post_id,$post_attachment_title,$post_attachment_path,$is_active="Active");
  // get post attachmnets
  public function get_attachment($post_id);
  //  update_post_Attacehment
  public function update_attachement($status,$id);
  // Get Comments
  public function get_comments($query);
  // Insert Comments
  public function inser_comments($post_id,$user_id,$comment,$status="Active");
  // update comments
  public function update_comment($status,$id);
  // blog_post
  public function blog_post();
  // get post categories
  public function  get_post_categories($idees);
  //show post categories
  public function show_post_categories();
  // Feedback Insert
  public function insert_feedback($user_id,$user_name,$user_email,$feedback);
  // Feedback Insert
  public function get_feedback();
  // show post with blog
  public function show_post_with_blogs($idees,$limit,$start=0,$cat_title="");
}
  class Database implements DBDriver{
    public $host_name=null;
    public $user_name=null;
    public $password=null;
    public $db_name=null;
    public $connection=null;
    public $db_errno=null;
    public $db_err_msg=null;
    public $users=null;
    public $register_query=null;
    // Setter and getter method
    private function set_host_name($host_name){
      $this->host_name=$host_name;
    }
    public function get_host_name(){
      return $this->host_name;
    }
    private function set_user_name($user_name){
      $this->user_name=$user_name;
    }
    public function get_user_name(){
      return $this->user_name;
    }
    private function set_password($password){
      $this->password=$password;
    }
    public function get_password(){
      return $this->password;
    }
    private function set_db_name($db_name){
      $this->db_name=$db_name;
    }
    public function get_db_name(){
      return $this->db_name;
    }
    // Setter and getter method ends
    
    // connection
    function __construct($host_name,$user_name,$password,$db_name) {
      mysqli_report(MYSQLI_REPORT_OFF);
      $this->set_host_name($host_name);
      $this->set_user_name($user_name);
      $this->set_password($password);
      $this->set_db_name($db_name);
      $this->connection=mysqli_connect($this->get_host_name(),$this->get_user_name(),$this->get_password(),$this->get_db_name());
      if(mysqli_connect_errno()){
        $this->db_errno=mysqli_connect_errno();
        $this->db_err_msg=mysqli_connect_error();
        echo "<h1>Error Msg: " .$this->db_err_msg  ."</h1>";
        echo "<h1>Error Msg No: " .$this->db_errno  ."</h1>";
        die("Connection Failed!!!!....");
      }
    }
    public function custom_query($query){
      $data=mysqli_query($this->connection,$query);
      return $data;
    }
    public function get_users(){
      $result=$this->custom_query("SELECT * FROM user");
      return $result;
    }
      // regiser user
    public function register_user($role_id,$fname,$lname,$email,$password,$genger,$date_of_birth,$user_image,$address,$is_approved,$is_active){
      $this->register_query="INSERT INTO `user`
      (`role_id`,`first_name`,`last_name`,`email`,`password`,`gender`,`date_of_birth`,`user_image`,
      `address`,`is_approved`,`is_active`)
      VALUES
      (?,?,?,?,?,?,?,?,?,?,?)";
      $prepare_stmt=mysqli_prepare($this->connection,$this->register_query);
      $bind_process=mysqli_stmt_bind_param($prepare_stmt,"issssssssss",$role_id,$fname,$lname,$email,$password,$genger,$date_of_birth,$user_image,$address,$is_approved,$is_active);
      $stmt_execute=mysqli_execute($prepare_stmt);
      return $stmt_execute;
    }
      // user_role
    public function user_role(){
      $query="SELECT R.`role_type`,R.`is_active`,U.* FROM `role` R 
      INNER JOIN `user` U ON R.`role_id`= U.`role_id`";
      $result=$this->custom_query($query);
      return $result;
    }
      // manage_user
    public function manage_user($search_value="",$approved_status){
      $query="SELECT * FROM role R 
      INNER JOIN `user` U 
      ON R.`role_id`= U.`role_id`
      WHERE 
      U.`is_approved` = '".$approved_status."'
      AND
      (U.`user_id` REGEXP '".$search_value."'
      OR R.`role_type` REGEXP '".$search_value."'
      OR U.`first_name` REGEXP '".$search_value."'
      OR U.`last_name` REGEXP '".$search_value."'
      OR U.`email` REGEXP '".$search_value."'
      OR U.`password` REGEXP '".$search_value."'
      OR U.`gender` REGEXP '".$search_value."' 
      OR U.`address` REGEXP '".$search_value."'
      OR U.`is_approved` REGEXP '".$search_value."'
      OR U.`is_active` REGEXP '".$search_value."'
      OR U.`date_of_birth` REGEXP '".$search_value."')
      ORDER BY U.`user_id` DESC";
      $result=$this->custom_query($query);
      return $result;
    }
    // update user_status
    public function update_user_status($value,$user_id){
      $query="UPDATE `user` SET `is_active`= ?,`updated_at` = NOW()
      WHERE `user_id`=?";
      $prepare_stmt=mysqli_prepare($this->connection,$query);
      $bind_process=mysqli_stmt_bind_param($prepare_stmt,"si",$value,$user_id);
      $stmt_execute=mysqli_execute($prepare_stmt);
      return $stmt_execute;
    }
    // edit_user
    public function edit_user($fname,$lname,$email,$password,$gender,$edit_img,$address,$is_active,$is_approved,$dob,$id){
      $query="UPDATE `user` SET `first_name`= ?,`last_name`= ?,`email`= ?,`password`= ?,
      `gender` = ?,`user_image`=?,`address` = ?,`is_active` = ?,`is_approved` = ?,`date_of_birth` = ?,`updated_at` = NOW() WHERE `user_id`= ?";
      $update_stmt=mysqli_prepare($this->connection,$query);
      $update_bind_stmt=mysqli_stmt_bind_param($update_stmt,"ssssssssssi",$fname,$lname,$email,$password,$gender,$edit_img,$address,$is_active,$is_approved,$dob,$id);
      $stmt_execute=mysqli_execute($update_stmt);
      return $stmt_execute;
    }
    // View Blogs
    public function view_blogs($status=""){
      $query="SELECT B.*,U.`role_id`,U.`first_name`,U.`last_name`,U.`gender`, U.`is_approved`,U.`user_image`
      FROM `blog` B INNER JOIN `user` U ON U.`user_id` = B.`user_id` WHERE B.`blog_status`<>'".$status."' ORDER BY `blog_id` DESC";
      $result=$this->custom_query($query);
      return $result;
    }

    // update blog data
    public function updateblogdata($status=""){
      $result=$this->custom_query("SELECT * FROM `blog` WHERE `blog_status` <> '".$status."' ORDER BY `blog_id` DESC");
      return $result;
    }
    // Add Blog
    public function add_blog($user_id,$blog_title,$blog_per_page,$blog_attachement,$active_status){
      $query="INSERT INTO `blog`
      (`user_id`,`blog_title`,`post_per_page`,`blog_background_image`,
      `blog_status`)
      VALUES
      (?,?,?,?,?)";
      $blg_stmt=mysqli_prepare($this->connection,$query);
      $blog_bing_process=mysqli_stmt_bind_param($blg_stmt,"isiss",$user_id,$blog_title,$blog_per_page,$blog_attachement,$active_status);
      $blog_execute=mysqli_execute($blg_stmt);
      return $blog_execute;
    }
    // Update Blog Status
    public function update_blog_status($status,$id){
      $query="UPDATE `blog` SET `blog_status`=?,`updated_at`=NOW() WHERE blog_id = ?";
      $status_prepare=mysqli_prepare($this->connection,$query);
      $status_bind_process=mysqli_stmt_bind_param($status_prepare,"si",$status,$id);
      $status_execute=mysqli_execute($status_prepare);
      return $status_execute;
    }
    // Edit Blog Data
    public function edit_blog_data($blog_title,$post_per_page,$bg_img,$id){
      $query="UPDATE `blog`  SET `blog_title`=?,`post_per_page`=?,
        `blog_background_image`=?,`updated_at`=NOW() WHERE `blog_id`= ?";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"sisi",$blog_title,$post_per_page,$bg_img,$id);
      $query_exetute=mysqli_execute($query_stmt);
      return $query_exetute;
    } 
    // get following blogs
    public function following_blogs(){
      return $reult=$this->custom_query("SELECT * FROM `following_blog`");
    } 
    // insert following blogs
    public function post_following_blogs($follower_id,$blog_following_id,$status="Followed"){
      $query="INSERT INTO `following_blog`(`follower_id`,`blog_following_id`,`status`) VALUES(?,?,?)";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"iis",$follower_id,$blog_following_id,$status);
      $query_execute=mysqli_execute($query_stmt);
      return $query_execute;
    }
    // update following blogs
    public function update_following_blogs($status,$follow_id){
      $query="UPDATE `following_blog` SET `status`=?,`updated_at`= NOW() 
      WHERE `follow_id`=?";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"si",$status,$follow_id);
      $query_execution=mysqli_execute($query_stmt);
      return $query_execution;
    }
    // Get Categories
    public function get_categories($status=""){
      return $query=$this->custom_query("SELECT * FROM `category` WHERE `category_status` <> '".$status."' ORDER BY `category_id` DESC");
    }
    // Add Category
    public function insert_category($category_title,$category_description,$category_status="Active"){
      $query="INSERT INTO `category`(`category_title`,`category_description`,`category_status`)
      VALUES (?,?,?)";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"sss",$category_title,$category_description,$category_status);
      $query_execute=mysqli_execute($query_stmt);
      return $query_stmt;
    }
    // delete categories
    public function delete_categories($id){
      $query="DELETE FROM `post_category` WHERE `post_id` = ?";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"i",$id);
      return $query_execute=mysqli_execute($query_stmt);
    }
    // update category status
    public function update_cat_status($status,$id){
      $query="UPDATE `category` SET `category_status`=?,
      `updated_at`=NOW() WHERE `category_id` = ?";
      $update_stmt=mysqli_prepare($this->connection,$query);
      $update_binding=mysqli_stmt_bind_param($update_stmt,"si",$status,$id);
      return $update_execute=mysqli_execute($update_stmt);
    }
    // update category
    public function update_category($title,$description,$id){
      $query="UPDATE `category` SET `category_title`=?,`category_description`=?, `updated_at`=NOW() WHERE `category_id` = ?";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"ssi",$title,$description,$id);
      return $query_execute=mysqli_execute($query_stmt);
    }
    // get posts
    public function get_posts($query){
      return $result=$this->custom_query($query);
    }
    // update_post_status
    public function update_post_status($status,$id){
      $query="UPDATE `post` SET `post_status`=? WHERE `post_id`= ?";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"si",$status,$id);
      return $query_execute=mysqli_execute($query_stmt);
    }
    // posts
    public function insert_post($blog_id,$post_title,$post_summary,$post_description,$featured_image,$post_status,$is_comment_allowed){
      $query="INSERT INTO `post`(`blog_id`,`post_title`,`post_summary`,`post_description`,
      `featured_image`,`post_status`,`is_comment_allowed`) VALUES(?,?,?,?,?,?,?)";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"isssssi",$blog_id,$post_title,$post_summary,$post_description,$featured_image,$post_status,$is_comment_allowed);
      $query_execute=mysqli_execute($query_stmt);
      return $query_stmt;
    }
    // update post
    public function update_post($blog_id,$post_title,$post_summary
    ,$post_description,$featured_image,$is_comment_allowed,$post_id){
      $query="UPDATE `post` SET `blog_id` = ?,`post_title`=?,
      `post_summary`=?,`post_description`=?,`featured_image`=?,
      `is_comment_allowed`=? WHERE `post_id` = ?";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"issssii",$blog_id,$post_title,$post_summary,$post_description,$featured_image,$is_comment_allowed,$post_id);
      return $query_execute=mysqli_execute($query_stmt);
    }
    // post_Category
    public function insert_post_ategory($post_id,$category_id){
      $query="INSERT INTO `post_category` (`post_id`,`category_id`) VALUES (?,?)";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"ii",$post_id,$category_id);
      return $query_execute=mysqli_execute($query_stmt);
    }
    // post_Attachement
    public function insert_post_attachement($post_id,$post_attachment_title,$post_attachment_path,$is_active="Active"){
      $query="INSERT INTO `post_atachment`(`post_id`,`post_attachment_title`,`post_attachment_path`,`is_active`)
      VALUES(?,?,?,?)";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"isss",$post_id,$post_attachment_title,$post_attachment_path,$is_active);
      return $query_execute=mysqli_execute($query_stmt);
    }
    // get post Attachements
    public function get_attachment($post_id){
      return $result=$this->custom_query("SELECT * FROM `post_atachment` WHERE `post_id` = $post_id");
    }
    //  update_post_Attacehment
    public function update_attachement($status,$id){
      $query="UPDATE `post_atachment` SET `is_active`=? WHERE `post_atachment_id` = ?";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"si",$status,$id);
      return $query_execute=mysqli_execute($query_stmt);
    }
    // get comments
    public function get_comments($query){
      return $result=$this->custom_query($query);
    }
    // insert_comments
    public function inser_comments($post_id,$user_id,$comment,$status="Active"){
      $query="INSERT INTO `post_comment`(`post_id`,`user_id`,`comment`,`is_active`) VALUES (?,?,?,?)";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"iiss",$post_id,$user_id,$comment,$status);
      return $query_execute=mysqli_execute($query_stmt);
    }
    // update comment status
    public function update_comment($status,$id){
      $query="UPDATE `post_comment` SET `is_active`= ? WHERE `post_comment_id` =?";
      $query_stmt=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_stmt,"si",$status,$id);
      return $query_execute=mysqli_execute($query_stmt);
    }
    // blog_post
    public function blog_post(){
      return $query=$this->custom_query("SELECT P.* FROM `blog` B INNER JOIN `post` P ON B.`blog_id`= P.`blog_id`");
    }
    // get post categories
    public function  get_post_categories($idees){
      return $query=$this->custom_query("SELECT DISTINCT(C.`category_title`),C.`category_status` FROM `post` P INNER JOIN `post_category` PC 
      INNER JOIN `category` C ON P.`post_id`= PC.`post_id` AND C.`category_id`=PC.`category_id` WHERE P.`post_id` IN($idees) 
      AND C.`category_status`='Active'");
    }
    //post_Search
    public function post_search($search_value=""){
      $query="SELECT U.`first_name`, U.`last_name`,B.`blog_title`,P.* FROM `post` P INNER JOIN `blog` B INNER JOIN `user` U ON U.`user_id`=B.`user_id` AND P.`blog_id` = B.`blog_id` WHERE P.`post_status`='Active' AND
      (P.`post_title` REGEXP '".$search_value."' OR U.`first_name` REGEXP '".$search_value."' OR U.`last_name` REGEXP '".$search_value."' OR
      B.`blog_title` REGEXP '".$search_value."' OR P.`post_description` REGEXP '".$search_value."') ORDER BY  P.`post_id` DESC"; 
      return $result=$this->custom_query($query);
    }
    //show get categories
    public function show_post_categories(){
      $query="SELECT PC.`post_id`,C.`category_status`,C.`category_title` FROM `category` C INNER JOIN `post_category` PC ON C.`category_id` = PC.`category_id`";
      return $result=$this->custom_query($query);
    }
    // Feedback Insert
    public function insert_feedback($user_id,$user_name,$user_email,$feedback){
      $query="INSERT INTO `user_feedback`(`user_id`,`user_name`,`user_email`,`feedback`) VALUES (?,?,?,?)";
      $query_prepare=mysqli_prepare($this->connection,$query);
      $query_binding=mysqli_stmt_bind_param($query_prepare,"ssss",$user_id,$user_name,$user_email,$feedback);
      return $query_execute=mysqli_execute($query_prepare);
    }
    // Feedback Insert
    public function get_feedback(){
      return $query=$this->custom_query("SELECT * FROM `user_feedback` ORDER BY `feedback_id` DESC");
    }
    // show post with blog
    public function show_post_with_blogs($idees,$limit,$start=0,$cat_title=""){
      return $query=$this->custom_query("SELECT P.`post_id`,C.`category_title`,P.`post_title`,P.`post_description`,P.`post_status`,
        P.`featured_image` FROM `post` P INNER JOIN `post_category` PC  INNER JOIN `category` C ON P.`post_id` = PC.`post_id` AND 
        C.`category_id` = PC.`category_id` HAVING P.`post_id` IN ($idees) AND C.`category_title` REGEXP '".$cat_title."' 
        LIMIT $start,$limit");
    }
}
  define("host_name","localhost");
  define("user_name","root");
  define("password","");
  define("db_name","16412_ahsan_jawed");
  $database=new Database(host_name,user_name,password,db_name);
?>
