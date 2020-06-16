<?php
//
use Hashids\Hashids;
class User {
   private $db;

   public function __construct()
   {
       $this->db = new Database();
   }

   public function register($data){

       $this->db->query('INSERT INTO users (us_first, us_last, us_email, us_pass, us_token, us_lang) VALUES (:first, :last, :email, :password, :tokenKey, :country) ');
       // Bind values
       $this->db->bind(':first', $data['first']);
       $this->db->bind(':last', $data['last']);
       $this->db->bind(':email', $data['email']);
       $this->db->bind(':password', $data['password']);
       $this->db->bind(':tokenKey', $data['token']);
       $this->db->bind(':country', $data['country']);
       //$this->db->bind(':hasAccess', $data['hasAccess']);

       if($this->db->execute()) {
           $hashme = new Hashids('', 5);
           $lastid = $this->db->lastId();
           $urlHash = $hashme->encode($lastid);

           $this->db->query('UPDATE users SET us_slug = :urlHash WHERE us_id = :lastid');
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



    public function getCitizenship(){
        $this->db->query('SELECT * FROM citizenship ORDER BY num_code ASC');
        // Bind values
        $row = $this->db-> resultSet();
        return $row;

    }


   // Find user by email
    public function findUserByEmail($email){
       $this->db->query('SELECT * FROM users WHERE us_email = :email');
       // Bind values
       $this->db->bind(':email', $email);
       $row = $this->db->single();
       // Check row returned
        if($this->db->rowCount() > 0) {
           return $row;
        } else {
            return false;
        }
    }

    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE us_email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        $hashed_password = $row->us_pass;
        if (password_verify($password, $hashed_password)) {
            return $row;
        } else {
            return false;
        }
    }


    // Find user by id
    public function getUserById($id){
        $this->db->query('SELECT * FROM users WHERE us_id = :id');
        // Bind values
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;

      }

    // Confirm user from email
    public function getConfirmUser($tokenKey){
        $this->db->query('SELECT * FROM users WHERE us_token = :tokenKey');
        // Bind values
        $this->db->bind(':tokenKey', $tokenKey);
        $row = $this->db->single();
        return $row;
    }


    // If account activated, update user status
    public function setUserStatus($us_id, $status){
        $this->db->query('UPDATE users SET us_status = :status WHERE us_id = :us_id');
        // Bind values
        $this->db->bind(':us_id',  $us_id);
        $this->db->bind(':status',  $status);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Change password
    public function changePassword($data){
        $this->db->query('UPDATE users SET us_pass = :pass WHERE us_email = :mail');
        // Bind values
        $this->db->bind(':pass',  $data['password']);
        $this->db->bind(':mail',  $data['email']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }



    public function swift_mail($data)
    {
        $message = '<html lang="en"><body>';
        $message .= '';
        $message .= '<table cellpadding="20">';
        $message .= "<tr><td>Hello, " . $data['first'] . "! welcome to ".SITENAME."</td></tr>";
        $message .= "<tr><td>To complete your registration, click below link. Thanks.</td></tr>";
        $message .= "<tr><td><a href=". URLROOT . '/users/confirm_reg?token='.$data['token'].">Confirm and activate your account</a></td></tr>";
        $message .= "</table>";
        $message .= "</body></html>";
        // Create the Transport
        // Sendmail
        //$transport = new Swift_SendmailTransport('/usr/sbin/sendmail -bs');
        $transport = (new Swift_SmtpTransport('localhost', 25));
        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        // Create a message
        $swift_message = (new Swift_Message('New mail from ' . SITENAME))
            // Set the To addresses with an associative array
            ->setFrom(array('profengbrazil@gmail.com' => SITENAME))
            ->setTo(array($data['email'] => 'Password link'))
            ->setBcc('profengbrazil@gmail.com')
            ->addBcc('profengbrazil@gmail.com')
            ->setBody($message, "text/html");
            // Add alternative parts with addPart()
            $swift_message->addPart($message, 'text/plain');
            $mailer->send($swift_message);

    }

    public function forgotPassMail($data)
    {
        $message = '<html lang="en"><body>';
        $message .= '';
        $message .= '<table cellpadding="20">';
        $message .= "<tr><td>Hello, " . $data['email'] . "!</td></tr>";
        $message .= "<tr><td>A request was made, using this email, to reset your password. If you did not request this, no action is required.</td></tr>";
        $message .= "<tr><td>To reset your password, click below link. Thanks.</td></tr>";
        $message .= "<tr><td><a href=". URLROOT . '/users/reset_password?token='.$data['reset_token'].">Reset your password</a></td></tr>";
        $message .= "</table>";
        $message .= "</body></html>";
        // Create the Transport
        // Sendmail
        //$transport = new Swift_SendmailTransport('/usr/sbin/sendmail -bs');
        $transport = (new Swift_SmtpTransport('localhost', 25));
        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        // Create a message
        $swift_message = (new Swift_Message('New mail from ' . SITENAME))
            // Set the To addresses with an associative array
            ->setFrom(array('profengbrazil@gmail.com' => SITENAME))
            ->setTo(array($data['email'] => 'Password link'))
            //->setBcc('profengbrazil@gmail.com')
            //->addBcc('profengbrazil@gmail.com')
            ->setBody($message, "text/html");
        // Add alternative parts with addPart()
        $swift_message->addPart($message, 'text/plain');
        if($result = $mailer->send($swift_message)) {
            // Email sent
        } else {
            flash('mail_error', 'Failed to send the link');
        }

    }



}
