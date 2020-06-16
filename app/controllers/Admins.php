<?php
use Gumlet\ImageResize;

class Admins extends Base
{
    public function __construct()
    {
        parent::__construct();

        if (!isLoggedIn()) {
            redirect('users/login');
        }

        if (isLoggedIn() and !adminAut()) {
            flash_error('access_msg', 'You need Admin rights to access');
            redirect('users/login');
        }

    }

    public function socials()
    {
        $data =
            [
                'socials' => $this->socials
            ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data =
                [
                    'scId' => $_POST['scId'],
                    'socials' => $this->socials,
                    'scFacebook' => trim($_POST['scFacebook']),
                    'scLinkedin' => trim($_POST['scLinkedin']),
                    'scGoogle' => trim($_POST['scGoogle']),
                    'scTwitter' => trim($_POST['scTwitter']),
                    'scInstagram' => trim($_POST['scInstagram']),
                    'scQuora' => trim($_POST['scQuora']),
                    'scYoutube' => trim($_POST['scYoutube']),

                ];

            if ($this->adminModel->updateSocials($data)) {
                flash('message', 'Data updated');
                redirect('admins/socials');
                exit();
            } else {
                echo "Something went wrong";
            }

            $this->adminHeader();
            $this->adminNav();
            $this->view('admins/socials', $data);
            $this->adminFooter();

        } else {

            $this->adminHeader();
            $this->adminNav();
            $this->view('admins/socials', $data);
            $this->adminFooter();
        }
    }


    public function site()
    {

        $data =
            [
                'title' => 'Site info',
                'siteName' => $this->site->site_name,
                'siteDesc' => $this->site->site_desc,
                'siteAbout' => $this->site->site_about,
                'siteWelcome' => $this->site->site_welcome,
                'siteKeywords' => $this->site->site_keywords,
                'siteLogo' => $this->site->site_logo,
                'siteContactName' => $this->site->site_contact_name,
                'siteContactMail' => $this->site->site_contact_mail,
                'siteContactAdd' => $this->site->site_contact_add,
                'siteContactNum' => $this->site->site_contact_num,
                'siteContactInfo' => $this->site->site_contact_info,
                'siteId' => $this->site->site_id,
                'siteCreated' => $this->site->site_created

            ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data =
                [

                    'site_id' => $_POST['site_id'],
                    'site_name' => trim($_POST['site_name']),
                    'site_desc' => trim($_POST['site_desc']),
                    'site_about' => trim($_POST['site_about']),
                    'site_welcome' => trim($_POST['site_welcome']),
                    'site_keywords' => trim($_POST['site_keywords']),
                    'site_contact_name' => trim($_POST['site_contact_name']),
                    'site_contact_mail' => trim($_POST['site_contact_mail']),
                    'site_contact_num' => trim($_POST['site_contact_num']),
                    'site_contact_add' => trim($_POST['site_contact_add']),
                    'site_contact_info' => trim($_POST['site_contact_info']),
                    'site_logo' => trim($_FILES['site_logo']['name']),
                    'noImg' => trim($_POST['noImg']),
                    'sameFile' => trim($_POST['sameFile']),
                    // Error values
                    'name_err' => '',
                    'desc_err' => '',
                    'mail_err' => ''

                ];


            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


            if (empty($data['name_err']) and empty($data['desc_err']) and empty($data['mail_err'])) {
                // Check the file upload
                //pass the file name to our mime type helper and check the type
                if ($_FILES['site_logo']['error'] == 0) {
                    $type = (get_mime($_FILES['site_logo']['tmp_name']));
                    if ($type == 'image/jpeg' or $type == 'image/jpg' or $type == 'image/png') {
                        // File is excepted
                    } else {
                        $data['logo_err'] = 'Sorry! Only jpg/jpeg/png files are allowed';
                    }

                    $size = $_FILES['site_logo']['size'];
                    if ($size > 31457280) {
                        $data['tcImg_err'] = 'Sorry! Max size is 30MB. Select a smaller file';
                    }
                    // Set the upload directory
                    $directory = $_SERVER['DOCUMENT_ROOT'] . '/public/img/';
                    // If no folder create one with permissions
                    if (!file_exists($directory)) {
                        mkdir($directory, 755, true);
                    }
                    // Rename filename
                    $new_name = round(microtime(true)) . "_" . strtolower($_FILES['site_logo']['name']);
                    // Check if file exist and add write permissions
                    $path = $directory . basename($new_name);
                    if (file_exists($path)) {
                        chmod($path, 755);
                    }

                    if (move_uploaded_file($_FILES['site_logo']['tmp_name'], strtolower($path))) {
                        // File uploaded
                    } else {
                        echo 'Failed to upload your image';
                        exit();
                    }
                    // Resize the image
                    $image = new ImageResize($path);
                    $image->crop(120, 120);
                    $image->save($path);

                } elseif ($_FILES['site_logo']['size'][0] == 0 and $_FILES['site_logo']['tmp_name'][0] === '' and $data['noImg'] == 1) {

                    $new_name = null;

                } else {
                    // If no new file set the current DATABASE VALUE AS DEFAULT
                    $new_name = $data['sameFile'];
                }

                if ($this->adminModel->updateSite($data, $new_name)) {
                    flash('resume_message', 'Data updated');
                    redirect('admins/site');
                    exit();

                }
            } /// IF no errors
            else {
                echo "Could not update data";
            }

        } else {

            /// SHOW view with errors
            $this->adminHeader();
            $this->adminNav();
            $this->view('admins/site', $data);
            $this->adminFooter();

        }
        /// SHOW view
        $this->adminHeader();
        $this->adminNav();
        $this->view('admins/site', $data);
        $this->adminFooter();

    }


    public function index()
    {
        $countEmails = $this->adminModel->countEmails();
        $countPosts = $this->postModel->countPosts();

        $data = [

            'title' => 'Admins',
            'siteName' => $this->site->site_name,
            'siteDesc' => $this->site->site_desc,
            'countEmails' => $countEmails,
            'countResumes' => $countPosts,
        ];

        $this->adminHeader();
        $this->adminNav();
        $this->view('admins/index', $data);
        $this->adminFooter();

    }


    public function addEmail()
    {

        $emails = $this->adminModel->getAllEmails();

        $data =
            [
                'emails' => $emails
            ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // Send a token for validating user later by email
            $hash = bin2hex(random_bytes(32));
            $data =
                [
                    'emails' => $emails,
                    'hash' => $hash,
                    'email' => trim($_POST['email']),
                    'email_err' => ''

                ];

            if (empty($data['email'])) {
                $data['email_err'] = 'Please add a valid email';
            }

            if (empty($data['email_err'])) {

                if ($this->adminModel->saveEmail($data)) {

                    flash('resume_message', 'Email added');
                    redirect('admins/addEmail');
                    exit();

                } else {

                    echo "Unable to save data";
                }
            } else {

                // SHOW ERRORS
                $this->adminHeader();
                $this->adminNav();
                $this->view('admins/addEmail', $data);
                $this->adminFooter();

            }
        }

        /// SHOW DEFAULT VIEW
        $this->adminHeader();
        $this->adminNav();
        $this->view('admins/addEmail', $data);
        $this->adminFooter();

    }


    public function addNews()
    {

        $news = $this->adminModel->getAllNews();
        $latest = $this->pageModel->getNews();
        $allEmails = $this->adminModel->getAllEmails();
        $countEmails = $this->adminModel->countEmails();

        $data =
            [
                'news' => $news,
                'latest' => $latest,
                'emails' => $allEmails,
                'countEmails' => $countEmails

            ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data =
                [
                    'nTitle' => trim($_POST['nTitle']),
                    'nDesc' => $_POST['nDesc'],
                    'news' => $news,
                    'latest' => $latest,
                    'emails' => $allEmails,
                    'countEmails' => $countEmails,
                    'nTitle_err' => '',
                    'nDesc_err' => ''

                ];

            if (empty($data['nTitle'])) {
                $data['nTitle_err'] = 'Please add a title';
            }

            if (empty($data['nDesc'])) {
                $data['nDesc_err'] = 'Please write some news';
            }

            if (empty($data['nTitle_err']) and empty($data['nDesc_err'])) {

                if ($this->adminModel->saveNews($data)) {

                    flash('resume_message', 'Newsletter created');
                    redirect('admins/addNews');
                    exit();

                } else {

                    echo "Unable to save data";
                }
            } else {

                // SHOW ERRORS
                $this->adminHeader();
                $this->adminNav();
                $this->view('admins/addNews', $data);
                $this->adminFooter();

            }
        }

        /// SHOW DEFAULT VIEW
        $this->adminHeader();
        $this->adminNav();
        $this->view('admins/addNews', $data);
        $this->adminFooter();

    }


    public function editNews($id = '')
    {

        $news = $this->adminModel->getAllNews();
        $onenews = $this->adminModel->getNewsById($id);
        // Check for ID
        if (empty($id)) {
            redirect('admins');
        }
        // Load page data
        $data =
            [
                'news' => $news,
                'onenews' => $onenews

            ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $returnUrl = $_POST['returnUrl'];

            // Because we are submitting html from our editor we disable filter input array.
            //$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data =
                [
                    'nsId' => $id,
                    'nsTitle' => trim($_POST['nsTitle']),
                    'nsMsg' => trim($_POST['nsMsg']),
                    'news' => $news,
                    'onenews' => $onenews,
                    'nsTitle_err' => '',
                    'nsMsg_err' => ''

                ];

            if (empty($data['nsTitle'])) {
                $data['nsTitle_err'] = 'Please add a title';
            }

            if (empty($data['nsMsg'])) {
                $data['nsMsg_err'] = 'Please write some news';
            }

            if (empty($data['nsTitle_err']) and empty($data['nsMsg_err'])) {

                if ($this->adminModel->updateNews($data)) {

                    flash('resume_message', 'Newsletter updated');
                    redirect($returnUrl);
                    exit();

                } else {

                    echo "Unable to save data";
                }
            } else {

                // SHOW ERRORS
                $this->adminHeader();
                $this->adminNav();
                $this->view('admins/editNews', $data);
                $this->adminFooter();

            }
        }

        /// SHOW DEFAULT VIEW
        $this->adminHeader();
        $this->adminNav();
        $this->view('admins/editNews', $data);
        $this->adminFooter();

    }


    /**
     * @param $id
     * @throws Exception
     */
    public function editPost($id)
    {

        $categories = $this->postModel->getCategories();
        $posts = $this->postModel->getPosts();
        $postById = $this->postModel->getPostById($id);

        $data =
            [
                'categories' => $categories,
                'posts' => $posts,
                'postById' => $postById,

            ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Bring our return url
            $returnUrl = $_POST['returnUrl'];

            // CHECK FOR CSRF ATTACK
            if (validateToken() === false) {
                //// SHOW ERRORS
                flash_error('token_error', 'Token mismatch!');
                redirect('admins/editPost/' . $returnUrl);
            }

            $data =
                [
                    'categories' => $categories,
                    'posts' => $posts,
                    'psId' => $_POST['psId'],
                    'psTitle' => trim($_POST['psTitle']),
                    'psSubTitle' => trim($_POST['psSubTitle']),
                    'psPost' => trim($_POST['psPost']),
                    'catId' => $_POST['catId'],
                    'cat_err' => '',
                    'psTitle_err' => '',
                    'psPost_err' => '',
                ];

            $args = array(
                'psTitle' => FILTER_SANITIZE_STRING,
            );

            $_POST = filter_input_array(INPUT_POST, $args);

            // Validate data
            if (empty($data['catId'])) {
                $data['cat_err'] = 'Please select category for post';
            }
            if (empty($data['psTitle'])) {
                $data['psTitle_err'] = 'Please enter name';
            }
            if (empty($data['psPost'])) {
                $data['psPost_err'] = 'Please write a story';
            }

            // Make sure no errors
            if (empty($data['psTitle_err']) and empty($data['psPost_err']) and empty($data['cat_err'])) {
                // Validated
                if ($this->postModel->updatePost($data)) {

                    flash('resume_message', 'Post updated');
                    redirect('admins/editPost/' . $returnUrl);
                } else {
                    exit('Something went wrong');
                }
            } else {

                // Show errors
                $this->adminHeader($data);
                $this->adminNav();
                //flash_error('resume_errors', 'Please correct the error(s)');
                $this->view('admins/editPost', $data);
                $this->adminFooter();

            }

        } else {

            // SHow our view with all the required data before any POST
            $this->adminHeader($data);
            $this->adminNav();
            $this->view('admins/editPost', $data);
            $this->adminFooter();
        }

    }

    /////// INSERT FUNCTIONS
    public function addPost()
    {

        $categories = $this->postModel->getCategories();
        $posts = $this->postModel->getPosts();

        $data =
            [
                'psTitle' => '',
                'psSubTitle' => '',
                'psPost' => '',
                'cat_err' => '',
                'categories' => $categories,
                'posts' => $posts

            ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // CHECK FOR CSRF ATTACK
            if (validateToken() === false) {
                //// SHOW ERRORS
                flash_error('token_error', 'Token mismatch!');
            }

            $data =
                [
                    'categories' => $categories,
                    'posts' => $posts,
                    'psTitle' => trim($_POST['psTitle']),
                    'psSubTitle' => trim($_POST['psSubTitle']),
                    'psPost' => trim($_POST['psPost']),
                    'catId' => trim($_POST['catId']),
                    'userId' => $_SESSION['user_id'],
                    'cat_err' => '',
                    'psTitle_err' => '',
                    'psPost_err' => '',
                ];


            $args = array(
                'psTitle' => FILTER_SANITIZE_STRING,
            );

            $_POST = filter_input_array(INPUT_POST, $args);

            // Validate data
            if (empty($data['catId'])) {
                $data['cat_err'] = 'Please select category for post';
            }
            if (empty($data['psTitle'])) {
                $data['psTitle_err'] = 'Please enter name';
            }
            if (empty($data['psPost'])) {
                $data['psPost_err'] = 'Please write a story';
            }

            // Make sure no errors
            if (empty($data['psTitle_err']) and empty($data['psPost_err']) and empty($data['cat_err'])) {
                // Validated
                // Check the file upload
                //pass the file name to our mime type helper and check the type
                if ($_FILES['post_img']['error'] == 0) {
                    $type = (get_mime($_FILES['post_img']['tmp_name']));
                    if ($type == 'image/jpeg' or $type == 'image/jpg' or $type == 'image/png') {
                        // File is excepted
                    } else {
                        $data['img_err'] = 'Sorry! Only jpg/jpeg/png files are allowed';
                    }

                    $size = $_FILES['post_img']['size'];
                    if ($size > 31457280) {
                        $data['img_err'] = 'Sorry! Max size is 30MB. Select a smaller file';
                    }
                    // Set the upload directory
                    $directory = $_SERVER['DOCUMENT_ROOT'] . '/public/storyImg/';
                    $directory2 = $_SERVER['DOCUMENT_ROOT'] . '/public/storyImg/feat/';
                    // If no folder create one with permissions
                    if (!file_exists($directory)) {
                        mkdir($directory, 755, true);
                    }
                    // Rename filename
                    $new_name = round(microtime(true)) . "_" . strtolower($_FILES['post_img']['name']);
                    // Check if file exist and add write permissions
                    $path = $directory . basename($new_name);
                    $path2 = $directory2 . basename($new_name);

                    if (file_exists($path)) {
                        chmod($path, 755);
                    }
                    if (move_uploaded_file($_FILES['post_img']['tmp_name'], strtolower($path))) {
                        // File uploaded
                    } else {
                        echo 'Failed to upload your image';
                        exit();
                    }
                    // Resize the image
                    $image = new ImageResize($path);
                    $image->gamma(false);
                    $image->quality_jpg = 90;
                    $image->interlace = 0;
                    $image
                        ->crop(1200, 400, true, ImageResize::CROPCENTER)
                        ->save($path)
                        ->resizeToWidth(600)
                        ->save($path2);

                } elseif ($_FILES['post_img']['size'][0] == 0 and $_FILES['post_img']['tmp_name'][0] === '' and $data['noImg'] == 1) {

                    $new_name = null;

                } else {
                    // If no new file set the current DATABASE VALUE AS DEFAULT
                    $new_name = $data['sameFile'];
                }
                if ($this->postModel->savePost($data, $new_name)) {

                    flash('resume_message', 'Post added');
                    redirect('admins/addPost');
                } else {
                    exit('Something went wrong');
                }
            } else {

                // Show errors
                $this->adminHeader($data);
                $this->adminNav();
                //flash_error('resume_errors', 'Please correct the error(s)');
                $this->view('admins/addPost', $data);
                $this->adminFooter();

            }

        } else {

            // SHow our view with all the required data before any POST
            $this->adminHeader($data);
            $this->adminNav();
            $this->view('admins/addPost', $data);
            $this->adminFooter();
        }

    }

    public function uploadImg()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Bring our return url
            $returnUrl = $_POST['returnUrl'];
            // CHECK FOR CSRF ATTACK
            if (validateToken() === false) {
                //// SHOW ERRORS
                flash_error('token_error', 'Token mismatch!');
                redirect('admins/editPost/' . $returnUrl);
            }
            $data =
                [
                    'post_img' => $_FILES['post_img']['name'],
                    'psId' => $_POST['psId']
                ];

            $args = array(
                'post_img' => FILTER_SANITIZE_STRING,
            );

            $_POST = filter_input_array(INPUT_POST, $args);
            // Check the file upload
            //pass the file name to our mime type helper and check the type
            if ($_FILES['post_img']['error'] == 0) {
                $type = (get_mime($_FILES['post_img']['tmp_name']));
                if ($type == 'image/jpeg' or $type == 'image/jpg' or $type == 'image/png') {
                    // File is excepted
                } else {
                    $data['img_err'] = 'Sorry! Only jpg/jpeg/png files are allowed';
                }

                $size = $_FILES['post_img']['size'];
                if ($size > 31457280) {
                    $data['img_err'] = 'Sorry! Max size is 30MB. Select a smaller file';
                }
                // Set the upload directory
                $directory = $_SERVER['DOCUMENT_ROOT'] . '/public/storyImg/';
                $directory2 = $_SERVER['DOCUMENT_ROOT'] . '/public/storyImg/feat/';
                // If no folder create one with permissions
                if (!file_exists($directory)) {
                    mkdir($directory, 755, true);
                }
                if (!file_exists($directory2)) {
                    mkdir($directory2, 755, true);
                }
                // Rename filename
                $new_name = round(microtime(true)) . "_" . strtolower($_FILES['post_img']['name']);
                // Check if file exist and add write permissions
                $path = $directory . basename($new_name);
                $path2 = $directory2 . basename($new_name);

                if (file_exists($path)) {
                    chmod($path, 755);
                }
                if (move_uploaded_file($_FILES['post_img']['tmp_name'], strtolower($path))) {
                    // File uploaded
                } else {
                    echo 'Failed to upload your image';
                    exit();
                }
                // Resize the image
                $image = new ImageResize($path);
                $image->gamma(false);
                $image->quality_jpg = 90;
                $image->interlace = 0;
                $image
                    ->crop(1200, 400, true, ImageResize::CROPCENTER)
                    ->save($path)
                    ->resizeToWidth(600)
                    ->save($path2);

            } elseif ($_FILES['post_img']['size'][0] == 0 and $_FILES['post_img']['tmp_name'][0] === '' and $data['noImg'] == 1) {

                $new_name = null;

            } else {
                // If no new file set the current DATABASE VALUE AS DEFAULT
                $new_name = $data['sameFile'];
            }

            if ($this->postModel->updateImg($data, $new_name)) {

                flash('resume_message', 'image updated');
                redirect('admins/editPost/' . $returnUrl);
                exit();

            } else {
                exit('Something went wrong');
            }
            // Show errors
            $this->adminHeader($data);
            $this->adminNav();
            flash_error('resume_errors', 'Please correct the error(s)');
            $this->view('admins/editPost', $data);
            $this->adminFooter();

        }
    }


    public function editImage($id)
    {

        $images = $this->imageModel->getAllImages();
        $imageById = $this->imageModel->getImageById($id);
        $categories = $this->imageModel->getGalleryCategories();
        $countImages = $this->imageModel->countImages();

        $data =
            [
                'images' => $images,
                'imageById' =>  $imageById,
                'categories' => $categories,
                'countImages' => $countImages
            ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data =
                [
                    'categories' => $categories,
                    'images' => $images,
                    'imageById' =>  $imageById,
                    'glId' =>  $id,
                    'glTitle' => trim($_POST['glTitle']),
                    'glDesc' => trim($_POST['glDesc']),
                    'glFolder' => trim($_POST['glFolder']),
                    'glImg' => $_FILES['glImg']['name'],
                    'glCat' => trim($_POST['glCat']),
                    'glTitle_err' => '',
                    'glImg_err' => '',
                    'glCat_err' => ''

                ];

            if (empty($data['glTitle'])) {
                $data['glTitle_err'] = 'Please add title';
            }
            if (empty($data['glImg'])) {
                $data['glImg_err'] = 'Please add images';
            }
            if (empty($data['glCat'])) {
                $data['glCat_err'] = 'Please select category';
            }

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $cat_folder = prettyUrl($data['glTitle']);

            if (empty($data['glTitle_err']) and empty($data['glImg_err']) and empty($data['glCat_err'])) {

                // $this->flexibleImgUpload($new_name);
                // Check the file upload
                //pass the file name to our mime type helper and check the type
                if ($_FILES['glImg']['error'] == 0) {
                    $type = (get_mime($_FILES['img']['tmp_name']));
                    if ($type == 'image/jpeg' or $type == 'image/jpg' or $type == 'image/png') {
                        // File is excepted
                    } else {
                        $data['glImg_err'] = 'Sorry! Only jpg/jpeg/png files are allowed';
                    }
                    $size = $_FILES['glImg']['size'];
                    if ($size > 31457280) {
                        $data['glImg_err'] = 'Sorry! Max size is 30MB. Select a smaller file';
                    }
                    // Set the upload directory
                    $directory = $_SERVER['DOCUMENT_ROOT'] . '/public/photoImg/' . $cat_folder;
                    $directory1 = $_SERVER['DOCUMENT_ROOT'] . '/public/photoImg/mobile';
                    $directory2 = $_SERVER['DOCUMENT_ROOT'] . '/public/photoImg/thumbs';
                    // If no folder create one with permissions
                    if (!file_exists($directory)) {
                        mkdir($directory, 755, true);
                    }
                    // Rename filename
                    $new_name = round(microtime(true)) . "_" . strtolower($_FILES['glImg']['name']);
                    // Check if file exist and add write permissions
                    $path = $directory . '/' . basename($new_name);
                    $path1 = $directory1 . '/' . basename($new_name);
                    $path2 = $directory2 . '/' . basename($new_name);

                    if (file_exists($path)) {
                        chmod($path, 755);
                    }
                    if (move_uploaded_file($_FILES['glImg']['tmp_name'], strtolower($path))) {
                        // File uploaded
                    } else {
                        echo 'Failed to upload your image';
                        exit();
                    }
                    // Resize the image
                    $image = new ImageResize($path);
                    $image->gamma(false);
                    $image->quality_jpg = 90;
                    $image->interlace = 0;
                    $image
                        ->resizeToWidth(1024)
                        ->save($path)

                        ->resizeToWidth(600)
                        ->save($path1)

                        ->resizeToWidth(200)
                        ->save($path2)
                    ;

                } else {
                    // If no new file set the current DATABASE VALUE AS DEFAULT
                    $new_name = $data['sameFile'];
                }


                if ($this->imageModel->updateImage($data, $new_name)) {

                    flash('resume_message', 'Image updated');
                    redirect('admins/editImage');
                    exit();

                } else {

                    echo "Unable to save data";
                }
            } else {

                // SHOW ERRORS
                $this->adminHeader();
                $this->adminNav();
                $this->view('admins/editImage', $data);
                $this->adminFooter();

            }
        }

        /// SHOW DEFAULT VIEW
        $this->adminHeader();
        $this->adminNav();
        $this->view('admins/editImage', $data);
        $this->adminFooter();

    }

    public function editSlide($id)
    {
        $slides = $this->slideModel->getAllSlides();
        $slideById = $this->slideModel->getSlideById($id);

        $data =
            [
                'slides' => $slides,
                'slideById' => $slideById,
            ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data =
                [
                    'slides' => $slides,
                    'slideById' => $slideById,
                    'slId' =>   $id,
                    'slTitle' => trim($_POST['slTitle']),
                    'slDesc' => trim($_POST['slDesc']),
                    'slData' => trim($_POST['slData']),
                    'slImg' => $_FILES['slImg']['name'],
                    'slImg_err' => ''
                ];


            if (empty($data['slImg'])) {
                $data['slImg_err'] = "Please select image";
            }

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (empty($data['slImg_err'])) {
                // Check the file upload
                //pass the file name to our mime type helper and check the type
                if ($_FILES['slImg']['error'] == 0) {
                    $type = (get_mime($_FILES['slImg']['tmp_name']));
                    if ($type == 'image/jpeg' or $type == 'image/jpg' or $type == 'image/png') {
                        // File is excepted
                    } else {
                        $data['slImg_err'] = 'Sorry! Only jpg/jpeg/png files are allowed';
                    }
                    $size = $_FILES['slImg']['size'];
                    if ($size > 31457280) {
                        $data['slImg_err'] = 'Sorry! Max size is 30MB. Select a smaller file';
                    }
                    // Set the upload directory
                    $directory = $_SERVER['DOCUMENT_ROOT'] . '/public/sliderImg';
                    $directory1 = $_SERVER['DOCUMENT_ROOT'] . '/public/sliderImg/mobile';

                    // If no folder create one with permissions
                    if (!file_exists($directory)) {
                        mkdir($directory, 755, true);
                    }
                    if (!file_exists($directory1)) {
                        mkdir($directory1, 755, true);
                    }
                    // Rename filename
                    $new_name = round(microtime(true)) . "_" . strtolower($_FILES['slImg']['name']);
                    // Check if file exist and add write permissions
                    $path = $directory . '/' . basename($new_name);
                    $path1 = $directory1 . '/' . basename($new_name);

                    if (file_exists($path)) {
                        chmod($path, 755);
                    }
                    if (move_uploaded_file($_FILES['slImg']['tmp_name'], strtolower($path))) {
                        // File uploaded
                    } else {
                        echo 'Failed to upload your slide';
                        exit();
                    }
                    // Resize the image
                    $image = new ImageResize($path);
                    $image->gamma(false);
                    $image->quality_jpg = 90;
                    $image->interlace = 0;
                    $image
                        ->crop(1350, 550)
                        ->save($path)
                        ->crop(650, 150)
                        ->save($path1);

                } else {
                    // If no new file set the current DATABASE VALUE AS DEFAULT
                    $new_name = $data['sameFile'];
                }

                if ($this->slideModel->updateSlide($data, $new_name)) {

                    flash('resume_message', 'Slide updated');
                    redirect('admins/editSlide');
                    exit();

                } else {
                    echo "Unable to save data";
                }
            } else {

                // SHOW ERRORS
                $this->adminHeader();
                $this->adminNav();
                $this->view('admins/editSlide', $data);
                $this->adminFooter();

            }
        }

        /// SHOW DEFAULT VIEW
        $this->adminHeader();
        $this->adminNav();
        $this->view('admins/editSlide', $data);
        $this->adminFooter();

    }

    public function editVideo($id)
    {

        $videos = $this->videoModel->getAllVideos();
        $videoById = $this->videoModel->getVideoById($id);
        $categories = $this->videoModel->getVideoCategories();
        $countVideos = $this->videoModel->countVideos();

        $data =
            [
                'videos' => $videos,
                'videoById' => $videoById,
                'categories' => $categories,
                'countVideos' => $countVideos
            ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data =
                [
                    'videos' => $videos,
                    'categories' => $categories,
                    'videoById' => $videoById,
                    'vdId' => $id,
                    'vdTitle' => trim($_POST['vdTitle']),
                    'vdDesc' => trim($_POST['vdDesc']),
                    'vdEmbed' => trim($_POST['vdEmbed']),
                    'vdCat' => trim($_POST['vdCat']),
                    'vdTitle_err' => '',
                    'vdEmbed_err' => '',
                    'vdCat_err' => ''

                ];

            if (empty($data['vdTitle'])) {
                $data['vdTitle_err'] = 'Please add title';
            }
            if (empty($data['vdEmbed'])) {
                $data['vdEmbed_err'] = 'Please add embed code';
            }
            if (empty($data['vdCat'])) {
                $data['vdCat_err'] = 'Please select category';
            }

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (empty($data['vdTitle_err']) and empty($data['vdEmbed_err']) and empty($data['vdCat_err'])) {

                if ($this->videoModel->updateVideo($data)) {

                    flash('resume_message', 'Video updated');
                    redirect('admins/editVideo');
                    exit();

                } else {

                    echo "Unable to save data";
                }
            } else {

                // SHOW ERRORS
                $this->adminHeader();
                $this->adminNav();
                $this->view('admins/editVideo', $data);
                $this->adminFooter();

            }
        }

        /// SHOW DEFAULT VIEW
        $this->adminHeader();
        $this->adminNav();
        $this->view('admins/editVideo', $data);
        $this->adminFooter();

    }





    public function addImage()
    {

        $images = $this->imageModel->getAllImages();
        $categories = $this->imageModel->getGalleryCategories();
        $countImages = $this->imageModel->countImages();

        $data =
            [
                'images' => $images,
                'categories' => $categories,
                'countImages' => $countImages,
                'glTitle_err' => '',
                'glImg_err' => '',
                'glCat_err' => ''
            ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data =
                [
                    'categories' => $categories,
                    'images' => $images,
                    'glTitle' => trim($_POST['glTitle']),
                    'glDesc' => trim($_POST['glDesc']),
                    'glFolder' => trim($_POST['glFolder']),
                    'glImg' => $_FILES['glImg']['name'],
                    'glCat' => trim($_POST['glCat']),
                    'glTitle_err' => '',
                    'glImg_err' => '',
                    'glCat_err' => ''

                ];

            if (empty($data['glTitle'])) {
                $data['glTitle_err'] = 'Please add title';
            }
            if (empty($data['glImg'])) {
                $data['glImg_err'] = 'Please add images';
            }
            if (empty($data['glCat'])) {
                $data['glCat_err'] = 'Please select category';
            }

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $cat_folder = prettyUrl($data['glFolder']);

            if (empty($data['glTitle_err']) and empty($data['glImg_err']) and empty($data['glCat_err'])) {

                foreach ($_FILES['glImg'] as $file) {

                    // Check the file upload
                    //pass the file name to our mime type helper and check the type
                    if ($_FILES['glImg']['error'] == 0) {
                        $type = (get_mime($_FILES['glImg']['tmp_name']));
                        if ($type == 'image/jpeg' or $type == 'image/jpg' or $type == 'image/png') {
                            // File is excepted
                        } else {
                            $data['glImg_err'] = 'Sorry! Only jpg/jpeg/png files are allowed';
                        }
                        $size = $_FILES['glImg']['size'];
                        if ($size > 31457280) {
                            $data['glImg_err'] = 'Sorry! Max size is 30MB. Select a smaller file';
                        }
                        // Set the upload directory
                        $directory = $_SERVER['DOCUMENT_ROOT'] . '/public/photoImg/' . $cat_folder;
                        $directory1 = $_SERVER['DOCUMENT_ROOT'] . '/public/photoImg/mobile';
                        $directory2 = $_SERVER['DOCUMENT_ROOT'] . '/public/photoImg/thumbs';

                        // If no folder create one with permissions
                        if (!file_exists($directory)) {
                            mkdir($directory, 755, true);
                        }
                        // Rename filename
                        $new_name = round(microtime(true)) . "_" . strtolower($file);
                        // Check if file exist and add write permissions
                        $path = $directory . '/' . basename($new_name);
                        $path1 = $directory1 . '/' . basename($new_name);
                        $path2 = $directory2 . '/' . basename($new_name);

                        if (file_exists($path)) {
                            chmod($path, 755);
                        }
                        if (move_uploaded_file($_FILES['glImg']['tmp_name'], strtolower($path))) {
                            // File uploaded
                        } else {
                            echo 'Failed to upload your image';
                            exit();
                        }
                        // Resize the image
                        $image = new ImageResize($path);
                        $image->gamma(false);
                        $image->quality_jpg = 90;
                        $image->interlace = 0;
                        $image
                            ->resizeToWidth(1024)
                            ->save($path)
                            ->resizeToWidth(600)
                            ->save($path1)
                            ->resizeToWidth(200)
                            ->save($path2);

                    }
                    else {
                        // If no new file set the current DATABASE VALUE AS DEFAULT
                        $new_name = $data['glImg'];
                    }

                if ($this->imageModel->saveImage($data, $new_name)) {

                    flash('resume_message', 'Image added');
                    redirect('admins/addImage');
                    exit();

                } else {

                    echo "Unable to save data";
                }
                } } else {

                // SHOW ERRORS
                $this->adminHeader();
                $this->adminNav();
                $this->view('admins/addImage', $data);
                $this->adminFooter();
            }
        }

        /// SHOW DEFAULT VIEW
        $this->adminHeader();
        $this->adminNav();
        $this->view('admins/addImage', $data);
        $this->adminFooter();

    }


    public function addVideo()
    {

        $videos = $this->videoModel->getAllVideos();
        $categories = $this->videoModel->getVideoCategories();
        $countVideos = $this->videoModel->countVideos();

        $data =
            [
                'videos' => $videos,
                'categories' => $categories,
                'countVideos' => $countVideos,
                'vdTitle_err' => '',
                'vdEmbed_err' => '',
                'vdCat_err' => ''
            ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data =
                [
                    'videos' => $videos,
                    'categories' => $categories,
                    'vdTitle' => trim($_POST['vdTitle']),
                    'vdDesc' => trim($_POST['vdDesc']),
                    'vdEmbed' => trim($_POST['vdEmbed']),
                    'vdCat' => trim($_POST['vdCat']),
                    'vdTitle_err' => '',
                    'vdEmbed_err' => '',
                    'vdCat_err' => ''

                ];

            if (empty($data['vdTitle'])) {
                $data['vdTitle_err'] = 'Please add title';
            }
            if (empty($data['vdEmbed'])) {
                $data['vdEmbed_err'] = 'Please add embed code';
            }
            if (empty($data['vdCat'])) {
                $data['vdCat_err'] = 'Please select category';
            }

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (empty($data['vdTitle_err']) and empty($data['vdEmbed_err']) and empty($data['vdCat_err'])) {

                if ($this->videoModel->saveVideo($data)) {

                    flash('resume_message', 'Video added');
                    redirect('admins/addVideo');
                    exit();

                } else {

                    echo "Unable to save data";
                }
            } else {

                // SHOW ERRORS
                $this->adminHeader();
                $this->adminNav();
                $this->view('admins/addVideo', $data);
                $this->adminFooter();

            }
        }

        /// SHOW DEFAULT VIEW
        $this->adminHeader();
        $this->adminNav();
        $this->view('admins/addVideo', $data);
        $this->adminFooter();

    }



    public function addSlide()
    {
        $slides = $this->slideModel->getAllSlides();
        $data =
            [
                'slides' => $slides,
                'slImg_err' => ''
            ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data =
                [
                    'slides' => $slides,
                    'slTitle' => trim($_POST['slTitle']),
                    'slDesc' => trim($_POST['slDesc']),
                    'slData' => trim($_POST['slData']),
                    'slImg' => $_FILES['slImg']['name'],
                    'slImg_err' => ''
                ];


            if (empty($data['slImg'])) {
                $data['slImg_err'] = "Please select image";
            }

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (empty($data['slImg_err'])) {
                // Check the file upload
                //pass the file name to our mime type helper and check the type
                if ($_FILES['slImg']['error'] == 0) {
                    $type = (get_mime($_FILES['slImg']['tmp_name']));
                    if ($type == 'image/jpeg' or $type == 'image/jpg' or $type == 'image/png') {
                        // File is excepted
                    } else {
                        $data['slImg_err'] = 'Sorry! Only jpg/jpeg/png files are allowed';
                    }
                    $size = $_FILES['slImg']['size'];
                    if ($size > 31457280) {
                        $data['slImg_err'] = 'Sorry! Max size is 30MB. Select a smaller file';
                    }
                    // Set the upload directory
                    $directory = $_SERVER['DOCUMENT_ROOT'] . '/public/sliderImg';
                    $directory1 = $_SERVER['DOCUMENT_ROOT'] . '/public/sliderImg/mobile';

                    // If no folder create one with permissions
                    if (!file_exists($directory)) {
                        mkdir($directory, 755, true);
                    }
                    if (!file_exists($directory1)) {
                        mkdir($directory1, 755, true);
                    }
                    // Rename filename
                    $new_name = round(microtime(true)) . "_" . strtolower($_FILES['slImg']['name']);
                    // Check if file exist and add write permissions
                    $path = $directory . '/' . basename($new_name);
                    $path1 = $directory1 . '/' . basename($new_name);

                    if (file_exists($path)) {
                        chmod($path, 755);
                    }
                    if (move_uploaded_file($_FILES['slImg']['tmp_name'], strtolower($path))) {
                        // File uploaded
                    } else {
                        echo 'Failed to upload your slide';
                        exit();
                    }
                    // Resize the image
                    $image = new ImageResize($path);
                    $image->gamma(false);
                    $image->quality_jpg = 90;
                    $image->interlace = 0;
                    $image
                        ->crop(1350, 550)
                        ->save($path)
                        ->crop(650, 150)
                        ->save($path1);

                } else {
                    // If no new file set the current DATABASE VALUE AS DEFAULT
                    $new_name = $data['sameFile'];
                }

                if ($this->slideModel->saveSlide($data, $new_name)) {

                    flash('resume_message', 'Slide added');
                    redirect('admins/addSlide');
                    exit();

                } else {
                    echo "Unable to save data";
                }
            } else {

                // SHOW ERRORS
                $this->adminHeader();
                $this->adminNav();
                $this->view('admins/addSlide', $data);
                $this->adminFooter();

            }
        }

        /// SHOW DEFAULT VIEW
        $this->adminHeader();
        $this->adminNav();
        $this->view('admins/addSlide', $data);
        $this->adminFooter();

    }


/////////// MAIL FUNCTIONS //////////////////////////////////////////////
    public function sendNewsBulk()
    {

        $news = $this->pageModel->getNews();
        $allEmails = $this->adminModel->getAllEmails();

        $data = [
            'news' => $news,
            'emails' => $allEmails
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                //'bulk_emails' => $_POST['bulk_emails'],
                'news' => $news,
                'emails' => $allEmails,
                'ownerEmail' => $this->site->site_contact_mail,
                'siteLogo' => $this->site->site_logo
            ];
            // collect all the emails for the newsletter
            $emails = array();
            foreach ($data['emails'] as $e) :

                $emails[] = $e->email;

                $sep_mails = implode(',', $emails);
                $send_to = array_map('trim', explode(',', $sep_mails));

            endforeach;

            /// SEND BULK NEWSLETTER
            $this->BulkNews($data, $send_to);

        }

        unset($_SESSION['n']);
        /// SHOW DEFAULT VIEW
        $this->adminHeader();
        $this->adminNav();
        $this->view('admins/inc/sendNewsBulk', $data);
        $this->adminFooter();
    }


    public function BulkNews($data, $send_to){

        try {
            // Create the Transport
           $transport = (new Swift_SmtpTransport('websmtp.simply.com', 587))
         ->setUsername('hello@wtrekker.com')
         ->setPassword('Fluency76');

            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);
            // Create a message
            $message = (new Swift_Message($data['news']->ns_title))->setFrom(array($data['ownerEmail']))->setTo(array($data['ownerEmail']))->setBody('
                         <html>
                         <body>' . $data['news']->ns_msg . '</body>
                         </html>', "text/html");
            // Add alternative parts with addPart()
            $message->addPart($data['news']->ns_msg, 'text/plain');
            $headers = $message->getHeaders();
            $headers->addTextHeader('List-Unsubscribe', "https://fluencyonlife.com/unsubscribe");

            //Send the message
            $failedRecipients = array();
            $numSent = 0;

            /// SEND_TO IS AND ARRAY WITH ALL THE EMAILS
            foreach ($send_to as $address => $name) {

                if (is_int($address)) {
                    $message->setTo($name);
                } else {
                    $message->setTo(array($address => $name));
                }

                $numSent += $mailer->send($message, $failedRecipients);
            }
            if ($mailer->send($message)) {
                $_SESSION['n'] = $numSent;
                // SHOW
                $this->adminHeader();
                $this->adminNav();
                $this->view('admins/inc/sendNewsBulk', $data);
                $this->adminFooter();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }



//////////////// DELETE FUNCTIONS //////////////////////////////////////////////


    public function deleteEmail($id)
    {
        $returnUrl = $_POST['returnUrl'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->delEmail($id)) {
                flash('resume_message', 'Email deleted');
                redirect($returnUrl);
            } else {
                exit('Something went wrong');
            }
        } else {
            redirect($returnUrl);
        }
    }


    public function deleteNews($id)
    {
        $returnUrl = $_POST['returnUrl'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->delNews($id)) {
                flash('resume_message', 'News deleted');
                redirect($returnUrl);
            } else {
                exit('Something went wrong');
            }
        } else {
            redirect($returnUrl);
        }
    }


    public function deleteVideo($id)
    {
        $returnUrl = $_POST['returnUrl'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->delVideo($id)) {
                flash('resume_message', 'Video deleted');
                redirect($returnUrl);
            } else {
                exit('Something went wrong');
            }
        } else {
            redirect($returnUrl);
        }
    }

    public function deleteImage()
    {
        // DELETING ALL THE ITEMS WITHIN THE ARRAY. NOTE: BULK DELETE SHOULD BE AVOIDED USING A FOREACH LOOP.
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ( isset( $_POST[ 'bulk_delete' ] ) ) {

            $del = $_POST['files'];
            $id = implode(',', $del);
            // GET ALL THE IMAGES FROM THE CHECKBOX IDS
            $get_img = $this->adminModel->getSelectedImg($id);
            // SET PATH TO DIRECTORIES
            $directory = $_SERVER['DOCUMENT_ROOT'] . '/public/photoImg';
            $directory1 = $_SERVER['DOCUMENT_ROOT'] . '/public/photoImg/mobile';
            $directory2 = $_SERVER['DOCUMENT_ROOT'] . '/public/photoImg/thumbs';

            if ($this->adminModel->delImage($id)) {
                // DELETING ALL THE ITEMS WITHIN THE ARRAY.
                foreach ($get_img as $key => $un) :
                  unlink( $directory . '/' . trim($un->gl_folder) . '/' . $un->gl_img );
                  unlink( $directory1 . '/' . $un->gl_img  );
                  unlink( $directory2 . '/' . $un->gl_img );
                 endforeach;

                flash('resume_message', 'Image(s) deleted');
                redirect('admins/addImage');

             } else { exit('Something went wrong'); }

            } else { redirect('admins/addImage');
        }
    }


    public function deleteSlide($id)
    {
        $returnUrl = $_POST['returnUrl'];
        $directory = $_SERVER['DOCUMENT_ROOT'] . '/public/sliderImg/' . $_POST['file'];
        $directory1 = $_SERVER['DOCUMENT_ROOT'] . '/public/sliderImg/mobile/' . '/' . $_POST['file'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->adminModel->delSlide($id)) {
                if(!unlink($directory)) : echo "File error, File not removed"; else:
                    unlink($directory);
                    unlink($directory1);
                endif;
                flash('resume_message', 'Slide deleted');
                redirect($returnUrl);
            } else {
                exit('Something went wrong');
            }
        } else {
            redirect($returnUrl);
        }
    }






}

