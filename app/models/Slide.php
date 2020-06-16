<?php

class Slide
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

//// INSERT FUNCTIONS (RESUME) /////////////////////////////////////////////////////////////////////////////


    public function saveSlide($data, $new_name) {
        $this->db->query('INSERT INTO pd_slides (sl_title, sl_desc, sl_img, sl_data) VALUES (:slTitle, :slDesc, :slImg, :slData)');

        $this->db->bind(':slTitle', $data['slTitle']);
        $this->db->bind(':slDesc', $data['slDesc']);
        $this->db->bind(':slImg', $new_name);
        $this->db->bind(':slData', $data['slData']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }



    ///// GET FUNCTIONS ///////////////////////////////////////////////////////////////////////////

    public function getSlideById($id){
        $this->db->query('SELECT * FROM pd_slides WHERE sl_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }


    public function getAllSlides(){
        $this->db->query('SELECT * FROM pd_slides ORDER BY pd_slides.sl_created DESC');

        $results = $this->db->resultSet();
        return $results;
    }

    public function getFlex() {
        $this->db->query('SELECT * FROM pd_slides ORDER BY RAND() LIMIT 0, 4');
        $result = $this->db->resultSet();
        return $result;
    }



    /////////  UPDATE FUNCTIONS //////////////////////////////////////////////////////////

    public function updateSlide($data, $new_name){

        $this->db->query('UPDATE pd_slides SET sl_title = :slTitle, sl_desc = :slDesc. sl_img = :slImg, sl_data = :slData WHERE sl_id = :slId');
        // Bind values
        $this->db->bind(':slId', $data['slId']);
        $this->db->bind(':slTitle', $data['slTitle']);
        $this->db->bind(':slDesc', $data['slDesc']);
        $this->db->bind(':slData', $data['slData']);
        $this->db->bind(':slImg', $new_name);


        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }


    ///////// COUNT FUNCTIONS /////////////////////////////////////////////////////////







    ////// DELETE FUNCTIONS ///////////////////////////////////////////////////////////


    public function delSlide($id) {

        $this->db->query('DELETE FROM pd_slides WHERE sl_id = :id');
        $this->db->bind(':id', $id);

        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

}