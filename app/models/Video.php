<?php

class Video
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

//// INSERT FUNCTIONS (RESUME) /////////////////////////////////////////////////////////////////////////////


    public function saveVideo($data) {
        $this->db->query('INSERT INTO pd_videos (vd_title, vd_desc, vd_embed, fk_vid_cat_id) VALUES (:vdTitle, :vdDesc, :vdEmbed, :vdCat)');

        $this->db->bind(':vdTitle', $data['vdTitle']);
        $this->db->bind(':vdDesc', $data['vdDesc']);
        $this->db->bind(':vdEmbed', $data['vdEmbed']);
        $this->db->bind(':vdCat', $data['vdCat']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    ///// GET FUNCTIONS ///////////////////////////////////////////////////////////////////////////

    public function getVideoById($id){
        $this->db->query('SELECT * FROM pd_videos LEFT JOIN pd_vid_categories ON pd_vid_categories.vd_cat_id = pd_videos.fk_vid_cat_id WHERE vd_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function getAllVideos(){
        $this->db->query('SELECT * FROM pd_videos
                               LEFT JOIN pd_vid_categories ON pd_vid_categories.vd_cat_id = pd_videos.fk_vid_cat_id
                               ORDER BY pd_videos.vd_created DESC');

        $results = $this->db->resultSet();
        return $results;
    }



    public function getVideoCategories() {
        $this->db->query('SELECT *, ( SELECT COUNT(*) FROM pd_videos WHERE fk_vid_cat_id = vd_cat_id) AS vid_count FROM pd_vid_categories
                               LEFT JOIN pd_videos ON pd_videos.fk_vid_cat_id = pd_vid_categories.vd_cat_id GROUP BY vd_cat_id ORDER BY vd_id DESC');
        $result = $this->db->resultSet();
        return $result;
    }

    public function getVideosByCategory($id) {
        $this->db->query('SELECT * FROM pd_vid_categories 
                              LEFT JOIN pd_videos ON pd_videos.fk_vid_cat_id = pd_vid_categories.vd_cat_id
                              WHERE :catId = fk_vid_cat_id ORDER BY vd_id DESC');

        $this->db->bind(':catId', $id);
        $result = $this->db->resultSet();
        return $result;
    }


    /////////  UPDATE FUNCTIONS //////////////////////////////////////////////////////////


    public function updateVideo($data){

        $this->db->query('UPDATE pd_videos SET vd_title = :vdTitle, vd_desc = :vdDesc. vd_embed = :vdEmbed, fk_vid_cat_id = :vdCat WHERE vd_id = :vdId');
        // Bind values
        $this->db->bind(':vdId', $data['vdId']);
        $this->db->bind(':vdTitle', $data['vdTitle']);
        $this->db->bind(':vdDesc', $data['vdDesc']);
        $this->db->bind(':vdCat', $data['vdCat']);
        $this->db->bind(':vdEmbed', $data['vdEmbed']);


        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
    ///////// COUNT FUNCTIONS /////////////////////////////////////////////////////////

    public function countVideos(){
        $this->db->query('SELECT COUNT(*) AS vi 
                               FROM pd_videos WHERE vd_created');
        $results = $this->db->resultSet();
        return $results;

    }

    ////// DELETE FUNCTIONS ///////////////////////////////////////////////////////////

    public function delVideo($id) {

        $this->db->query('DELETE FROM pd_videos WHERE vd_id = :id');
        $this->db->bind(':id', $id);

        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }






} ///// CLASS ENDS ////////////////////////////////////////////////////////////////