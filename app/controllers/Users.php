<?php
class Users extends Base
{
    public function __construct()
    {
        // Inherents from base constructor
        parent::__construct();
    }


    public function register()
    {
        $nation = $this->userModel->getCitizenship();
        // Init data
        $data = [
            'first' => '',
            'last' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
            'nation' => $nation,
            'has_access' => ''
        ];
        // Process form
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process submitted form
            // Send a token for validating user later by email
            $tokenKey = bin2hex(random_bytes(32));

            // CHECK FOR CSRF ATTACK
            if(validateToken() === false) {
                //// SHOW ERRORS
                flash_error('token_error', 'Token mismatch!');
                redirect('users/register');
            }

            // Init data
            $data = [
                'first' => trim($_POST['first']),
                'last' => trim($_POST['last']),
                'email' => trim($_POST['email']),
                'country' => trim($_POST['country']),
                //'hasAccess' => trim($_POST['hasAccess']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'token' => $tokenKey,
                'nation' => $nation,
                'first_err' => '',
                'last_err' => '',
                'email_err' => '',
                'nation_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];


            $clean = array
            (
                'first' => FILTER_SANITIZE_STRING,
                'last' => FILTER_SANITIZE_STRING,
                'email' => FILTER_SANITIZE_EMAIL,
                'country' => FILTER_SANITIZE_STRING,
                'password' => FILTER_SANITIZE_STRING,
                'confirm_password' => FILTER_SANITIZE_STRING
            );
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, $clean);

            // Validate the input fields
            if (empty($data['first'])) {
                $data['first_err'] = 'Please enter first name';
            }
            if (empty($data['last'])) {
                $data['last_err'] = 'Please enter last name';
            }
            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }

            if (empty($data['country'])) {
                $data['country_err'] = 'Please enter nationality';
            }
            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            // Validate password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Password do not match';
                }
            }
            // Check for user/email
            if ($this->userModel->findUserByEmail($data['email'])) {
                // User already exists with the email
                $data['email_err'] = 'An account is already registered with this email';
            } else {
                // email not registered
            }
            // Make sure errors are empty
            if (empty($data['first_err']) and empty($data['last_err']) and empty($data['email_err']) and empty($data['country_err'])
                and empty($data['password_err']) and empty($data['confirm_password_err'])) {
                // Validated
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                // Register user
                if ($this->userModel->register($data)) {
                    // Validate email with token
                    $this->userModel->getConfirmUser($tokenKey);
                    // No errors we call the mail function and send the token
                    $this->userModel->swift_mail($data);

                    // If no errors redirect
                    flash('register_success', 'Email activation link sent. Please check your email and spam folders');
                    redirect('users/login');

                } else {
                    exit('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->adminHeader();
                flash_error('resume_errors', 'Please correct the error(s)');
                $this->view('users/register', $data);

            }

        } else {

            // Load view
            $this->adminHeader();
            $this->view('users/register', $data);

        }
    }

    public function login()
    {
        // Process form
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // CHECK FOR CSRF ATTACK
            if(validateToken() === false) {
                //// SHOW ERRORS
                flash_error('token_error', 'Token mismatch!');
                redirect('users/login');
            }

            // Init data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }
            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            $clean = array
            (
                'email' => FILTER_SANITIZE_EMAIL,
                'password' => FILTER_SANITIZE_STRING
            );

            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, $clean);

            // Check for user/email
            $ac = $this->userModel->findUserByEmail($data['email']);
            if ($ac) {
                // User found
            } else {
                $data['email_err'] = 'No email found';
            }
            // Make sure errors are empty
            if (empty($data['email_err']) and empty($data['password_err'])) {
                // Validated
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                // Get user status
                $active = $ac->us_status;
                $has_access = $ac->has_access;
                // Get user id
                $userId = $ac->us_id;
                // Check if user account is active
                if($active === 'Y') {
                    // User account valid
                } else {
                    flash('inactive_message', 'The account has not been activated');
                    redirect('users/login');
                }
                if ($loggedInUser) {
                    // Check if logged in user already has reports
                    $userHasP = $this->postModel->UserHasPosts($userId);
                    $userHasPost = $userHasP->user_id;
                    $userHasPostSlug = $userHasP->ps_slug;
                    $userHasPostName = $userHasP->rs_name;
                    // Set a session
                    $_SESSION['userHasPost'] = $userHasPost;
                    $_SESSION['slug'] = $userHasPostSlug;
                    $_SESSION['postName'] = $userHasPostName;
                    // Check if logged in user already has reports
                    $userName = $loggedInUser->us_first;
                    // Create user session
                    $this->createUserSession($loggedInUser);
                    switch ($has_access) {
                        case "is_admin":
                            flash('report_msg', 'Login successful! You are logged in as ' . ucfirst($userName));
                            redirect('admins');
                            break;
                        default:
                            flash('report_msg', 'Login successful! You are logged in as ' . ucfirst($userName));
                            redirect('clients');
                    }

                } else {
                    // Load view with errors
                    $this->adminHeader();
                    flash_error('access_msg', 'Username or password is incorrect');
                    $this->view('users/login', $data);
                }

            } else {
                // Load view with errors
                $this->adminHeader();
                $this->view('users/login', $data);

            }
            // Process submitted form
        } else {
            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            // Load view
            $this->adminHeader();
            $this->view('users/login', $data);

        }
    }

    public function reset_password()
    {
        // Process form
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process submitted form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            // Init data
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Validate the input fields
            // Validate email
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            }
            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            // Validate password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Password do not match';
                }
            }
            // Check for user/email
            if ($this->userModel->findUserByEmail($data['email'])) {
                // User found
            } else {
                $data['email_err'] = 'No email found';
            }
            // Make sure errors are empty
            if (empty($data['email_err']) and empty($data['password_err']) and empty($data['confirm_password_err'])) {
                // Validated
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Update the the password
                if($this->userModel->changePassword($data)) {
                    // If no errors redirect
                    flash('register_success', 'Password changed. You can now login');
                    redirect('users/reset_password');

                } else {
                    echo 'Something went wrong. Unable to update password';
                }
               } else {
                // Load view with errors
                $this->adminHeader();
                $this->view('users/reset_password', $data);

            }
          } else {

            // Init data
            $data = [
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            // Load view
            $this->adminHeader();
            $this->view('users/reset_password', $data);

        }
    }

    public function confirm_reg()
    {
        // Get the token from the URL
        $token = $_GET['token'];
        // Validate it with the token from our user model
        $valid_token = $this->userModel->getConfirmUser($token);
        // Retrieve the info and store for later use
        $us_token = $valid_token->us_token;
        $us_status = $valid_token->us_status;
        $us_id = $valid_token->us_id;
        $access = $valid_token->has_access;

        // Reusable for setting user status Y/N
        if ($us_status == 'Y') {
            $status = 'N';
        } else {
            $status = 'Y';
        }
        // Validate
        if(empty($token)) {
             redirect('users/login');
        }
        if ($token == $us_token and $us_status === 'N') {

            flash('token_success', 'Account is now active and you can login');
            // Load view
            $this->adminHeader();
            $this->view('users/confirm_reg');

         }
        if ($token != $us_token or $us_status === 'Y') {
            flash_error('token_error', 'Token is invalid or account is already activated');
            // Load view
            $this->adminHeader();
            $this->view('users/confirm_reg');


        } else {
        // Validated the token, proceed with updating user status
        if ($this->userModel->setUserStatus($us_id, $status)) {
            // Table updated
        } else {
            echo "Status update went wrong";
        }
        // Load view
            $this->adminHeader();
            $this->view('users/confirm_reg');


    }
}


// Confirm password reset
    public function confirm_reset()
    {
       if($_SERVER['REQUEST_METHOD'] == "POST") {
           // Process submitted form
           // Sanitize POST data
           $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

          $reset_token = bin2hex(random_bytes(32));

          $data =
            [
                'email' => trim($_POST['email']),
                'reset_token' => $reset_token,
                'email_err' => ''
            ];

           // Check for user/email
           if ($this->userModel->findUserByEmail($data['email'])) {
               // User found
           } else {
               $data['email_err'] = 'No email found in our records';
           }

           // Validate email
           if (empty($data['email'])) {
               $data['email_err'] = 'Please enter email';
           }

       if(empty($data['email_err'])){
              // Validated proceed
           $this->userModel->forgotPassMail($data);

               flash('reset_success', 'Email reset link sent. Please check your email and spam folders');
               redirect('users/confirm_reset');

       } else {
           // Load view with errors
           $this->adminHeader();
           $this->view('users/confirm_reset', $data);

       }
    } else {

           // Init data
           $data = [
               'email' => '',
               'email_err' => ''
           ];
           // Load view
           $this->adminHeader();
           $this->view('users/confirm_reset', $data);

     }
}

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->us_id;
        $_SESSION['user_email'] = $user->us_email;
        $_SESSION['user_name'] = $user->us_first;
        $_SESSION['user_slug'] = $user->us_slug;
        $_SESSION['has_access'] = $user->has_access;

    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_slug']);
        unset($_SESSION['has_access']);
        session_destroy();
        redirect('users/login');
    }

}