<?php
use Hashids\Hashids;

class Image
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

//// INSERT FUNCTIONS (RESUME) /////////////////////////////////////////////////////////////////////////////

    public function saveImage($data, $new_name)
    {
        $this->db->query('INSERT INTO pd_images (gl_title, gl_desc, gl_img, fk_cat_id) VALUES (:glTitle, :glDesc, :glImg, :glCat)');

        $this->db->bind(':glTitle', $data['glTitle']);
        $this->db->bind(':glDesc', $data['glDesc']);
        $this->db->bind(':glImg', $new_name);
        $this->db->bind(':glCat', $data['glCat']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    ///// GET FUNCTIONS ///////////////////////////////////////////////////////////////////////////


    public function getImageById($id)
    {
        $this->db->query('SELECT * FROM pd_images LEFT JOIN pd_galleries ON gl_cat_id = fk_cat_id WHERE gl_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }


    public function getAllImages()
    {
        $this->db->query('SELECT * FROM pd_images LEFT JOIN pd_galleries ON pd_galleries.gl_cat_id = pd_images.fk_cat_id
                               ORDER BY pd_images.gl_created DESC');
        $result = $this->db->resultSet();
        return $result;
    }


    public function getGalleryCategories() {
        $this->db->query('SELECT *, ( SELECT COUNT(*) FROM pd_images WHERE fk_cat_id = gl_cat_id) AS img_count FROM pd_galleries
                                          LEFT JOIN pd_images ON pd_images.fk_cat_id = pd_galleries.gl_cat_id GROUP BY gl_cat_id ORDER BY gl_id DESC');
        $result = $this->db->resultSet();
        return $result;
    }

    public function getGalleryImages($id) {
        $this->db->query('SELECT * FROM pd_galleries 
                              LEFT JOIN pd_images ON pd_images.fk_cat_id = pd_galleries.gl_cat_id
                              WHERE :catId = fk_cat_id ORDER BY gl_id DESC');

        $this->db->bind(':catId', $id);
        $result = $this->db->resultSet();
        return $result;
    }



    public function getSelectedImg($id)
    {

        $this->db->query("SELECT gl_img, gl_folder FROM pd_images LEFT JOIN pd_galleries ON 
                                gl_cat_id = fk_cat_id WHERE gl_id IN ($id)");
        $this->db->bind(':id', $id);
        $results = $this->db->resultSet();
        return $results;

    }



    /////////  UPDATE FUNCTIONS //////////////////////////////////////////////////////////

    public function updateImage($data, $new_name){

        $this->db->query('UPDATE pd_images SET gl_title = :glTitle, gl_desc = :glDesc. gl_img = :glImg, fk_cat_id = :glCat WHERE gl_id = :glId');
        // Bind values
        $this->db->bind(':glId', $data['glId']);
        $this->db->bind(':glTitle', $data['glTitle']);
        $this->db->bind(':glDesc', $data['glDesc']);
        $this->db->bind(':glCat', $data['glCat']);
        $this->db->bind(':glImg', $new_name);


        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    ///////// COUNT FUNCTIONS /////////////////////////////////////////////////////////


    public function countImages()
    {
        $this->db->query('SELECT COUNT(*) AS im 
                               FROM pd_images WHERE gl_created');
        $results = $this->db->resultSet();
        return $results;

    }


    ////// DELETE FUNCTIONS ///////////////////////////////////////////////////////////

    public function delImage($id) {

        $this->db->query("DELETE FROM pd_images WHERE gl_id IN ($id)");
        $this->db->bind(':id', $id);

        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


}