<?php
class Stories extends Base
{
    public function __construct()
    {
        parent::__construct();

    }

    //////////// SHOW ALL (RESUMES)
    public function index()
    {
        $posts = $this->postModel->getPosts();
        $categories = $this->postModel->getCategories();
        $galleries = $this->imageModel->getGalleryCategories();

        $data =
            [
                'title' => 'List of stories',
                'posts' => $posts,
                'categories' => $categories,
                'galleries' => $galleries,
                'siteName' => $this->site->site_name,
                'siteDesc' => $this->site->site_desc,
                'siteWelcome' => $this->site->site_welcome,
                'siteImg' => $this->site->site_logo,
                'creator' => $this->site->site_contact_name,
                'slider' => $this->slider,
                'flex' => $this->flex,
                'ogImg' => 'index-stories.png',
            ];

        $this->standardHeader($data);
        $this->standardNav();
        $this->view('stories/index', $data);
        $this->standardFooter();
    }


    //////////// SHOW BY ID (RESUME)
    public function show($id = '')
    {
        // Collecting all our info from all our tables for the show view
        $post = $this->postModel->getPostById($id);
        // No ID redirect
        if (empty($id)) {
            redirect('Stories');
        }
        $data =
            [
                'title' => $post->ps_title . ' | ' . $post->ps_sub_title . ' | Stories',
                'siteName' => $this->site->site_name,
                'siteDesc' => $post->site->site_desc,
                'siteWelcome' => $this->site->site_welcome,
                'siteImg' => $this->site->site_logo,
                'creator' => $this->site->site_contact_name,
                'ogImg' =>  $post->ps_img,
                'post' => $post,
                'slider' => $this->slider,
                'flex' => $this->flex,
                'social' => $this->socials
            ];


        $this->standardHeader($data);
        $this->standardNav();
        $this->view('stories/show', $data);
        $this->standardFooter();
    }


///// DELETE FUNCTIONS ////////////////////////////////////////////////////////

    public function deletePost($id)
    {
        if (!isLoggedIn()) {
            flash('resume_message', 'You need to login or register');
            redirect('users/login');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $returnUrl = $_POST['returnUrl'];
            // Get existing resume from model
            $resume = $this->resumeModel->getResumeById($id);
            // Check for ownership
            if ($resume->user_id != $_SESSION['user_id']) {
                redirect('Posts');
            }
            if ($this->resumeModel->delExp($id)) {
                flash('resume_message', 'Experience deleted');
                redirect('clients/addExperience/' . $returnUrl);

            } else {
                exit('Something went wrong');
            }

        } else {
            redirect('Posts');
        }
    }


}