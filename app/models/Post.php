<?php
//
use Hashids\Hashids;

class Post {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

//// INSERT FUNCTIONS (RESUME) /////////////////////////////////////////////////////////////////////////////



    public function savePost($data, $new_name)
    {
        $this->db->query('INSERT INTO pd_blog 
                                (ps_title, ps_sub_title, ps_entry, ps_img, fk_cat_id, user_id) 
                                 VALUES (:psTitle, :psSubTitle, :psPost, :post_img, :catId, :userId)');
        // Bind values
        $this->db->bind(':psTitle', $data['psTitle']);
        $this->db->bind(':psSubTitle', $data['psSubTitle']);
        $this->db->bind(':psPost', $data['psPost']);
        $this->db->bind(':post_img', $new_name);
        $this->db->bind(':catId', $data['catId']);
        $this->db->bind(':userId', $data['userId']);

        if ($this->db->execute()) {
            $hashme = new Hashids('', 5);
            $lastid = $this->db->lastId();
            $urlHash = $hashme->encode($lastid);

            $this->db->query('UPDATE pd_blog SET ps_slug = :urlHash WHERE ps_id = :lastid');
            // Bind values
            $this->db->bind(':lastid', $lastid);
            $this->db->bind(':urlHash', $urlHash);

            if ($this->db->execute()) {

                return true;

            } else {

                return false;

            }
        }
    }

    ///// GET FUNCTIONS ///////////////////////////////////////////////////////////////////////////

    public function getPosts(){
        $this->db->query('SELECT *,
                               pd_blog.ps_id as postId,
                               users.us_id as userId FROM pd_blog
                               LEFT JOIN users ON pd_blog.user_id = users.us_id
                               LEFT JOIN pd_blog_cat ON pd_blog_cat.ps_cat_id = pd_blog.fk_cat_id
                               ORDER BY pd_blog.ps_created DESC');

        $results = $this->db->resultSet();
        return $results;
    }

    public function getPostsByCategory(){
        $this->db->query('SELECT *,
                               pd_blog.ps_id as postId,
                               users.us_id as userId FROM pd_blog
                               LEFT JOIN users ON pd_blog.user_id = users.us_id
                               LEFT JOIN pd_blog_cat ON pd_blog_cat.ps_cat_id = pd_blog.fk_cat_id
                               WHERE :psCatId = ps_cat_id ORDER BY pd_blog.ps_created DESC');

        $results = $this->db->resultSet();
        return $results;
    }


    public function getCategories(){
        $this->db->query('SELECT *, ( SELECT COUNT(*) FROM pd_blog WHERE fk_cat_id = ps_cat_id) AS post_count FROM pd_blog_cat 
                              LEFT JOIN pd_blog ON pd_blog.fk_cat_id = pd_blog_cat.ps_cat_id GROUP BY ps_cat_id ORDER BY cat_created DESC');
        $results = $this->db->resultSet();
        return $results;
    }



    public function getLangCode(){
        $this->db->query('SELECT * FROM pd_lang WHERE percentage >= 50 ORDER BY Language ASC');
        // Bind values
        $result = $this->db-> resultSet();
        return $result;

    }

    //// UPDATE FUNCTIONS


    public function getPostById($id){
        $this->db->query('SELECT * FROM pd_blog 
                              LEFT JOIN users ON pd_blog.user_id = users.us_id
                              LEFT JOIN pd_blog_cat ON pd_blog_cat.ps_cat_id = pd_blog.fk_cat_id
                              WHERE ps_slug = :id ORDER BY ps_id DESC');
        // Bind values
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;

    }


    /////////  UPDATE FUNCTIONS //////////////////////////////////////////////////////////

    public function updatePost($data){

        $this->db->query('UPDATE pd_blog SET ps_title = :psTitle, ps_sub_title = :psSubTitle, ps_entry = :psPost, fk_cat_id = :catId WHERE ps_id = :psId');
        // Bind values
        $this->db->bind(':psTitle', $data['psTitle']);
        $this->db->bind(':psSubTitle', $data['psSubTitle']);
        $this->db->bind(':psPost', $data['psPost']);
        $this->db->bind(':catId', $data['catId']);
        $this->db->bind(':psId', $data['psId']);


        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function updateImg($data, $new_name){

        $this->db->query('UPDATE pd_blog SET ps_img = :post_img WHERE ps_id = :psId');
        // Bind values
        $this->db->bind(':post_img', $new_name);
        $this->db->bind(':psId', $data['psId']);


        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }



    public function UserHasPosts($userId) {

        $this->db->query('SELECT * FROM pd_blog WHERE user_id = :userId');
        // Bind values
        $this->db->bind(':userId', $userId);
        $row = $this->db->single();
        // Check row returned
        if($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }


    public function delPost($id) {

        $this->db->query('DELETE FROM pd_blog WHERE ps_id = :id');
        $this->db->bind(':id', $id);

        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /////////////////// COUNT ///////////////////////////////////////////////

    public function countPosts(){
        $this->db->query('SELECT COUNT(*) AS rs 
                               FROM pd_blog WHERE ps_created >= DATE(NOW()) + INTERVAL -7 DAY');
        $results = $this->db->resultSet();
        return $results;

    }


} //// POST CLASS ENDS
