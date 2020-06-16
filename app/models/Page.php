<?php
class Page
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    public function getHomePage() {

        $this->db->query('SELECT * FROM pd_site');

        $row = $this->db->single();

        return $row;
    }

    public function getSocials() {
        $this->db->query('SELECT * FROM pd_socials');

        $row = $this->db->single();

        return $row;
    }

    public function getLinks() {
        $this->db->query('SELECT * FROM pd_links');
        $row = $this->db->resultSet();
        return $row;
    }

    public function getMenu() {
        $this->db->query('SELECT * FROM pd_nav');
        $result = $this->db->resultSet();
        return $result;
    }

    public function getNews(){
        $this->db->query('SELECT * FROM pd_news ORDER BY ns_created DESC LIMIT 1');
        $row = $this->db->single();
        return $row;
    }


    public function contact_mail($data)
    {
        $message = '<html><body>';
        $message .= '';
        $message .= '<table rules="all" cellpadding="20">';
        $message .= "<tr><td>Hello Admin of ".SITENAME." You have received mail from ".$data['ctName']."</td></tr>";
        $message .= "<tr><td>".$data['ctName']."</td></tr>";
        $message .= "<tr><td>".$data['ctEmail']."</td></tr>";
        $message .= "<tr><td>".$data['ctMsg']."</td></tr>";
        $message .= "</table>";
        $message .= "</body></html>";
        // Create the Transport
        // Sendmail
        //$transport = new Swift_SendmailTransport('/usr/sbin/sendmail -bs');
        $transport = (new Swift_SmtpTransport('websmtp.simply.com', 587))
            ->setUsername('hello@wtrekker.com')
            ->setPassword('Fluency76');

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        // Create a message
        $swift_message = (new Swift_Message('New mail from ' . SITENAME))
            // Set the To addresses with an associative array
            ->setFrom(array($data['mail'] => SITENAME))
            ->setTo(array($data['mail'] => 'New mail'))
            ->setBody($message, "text/html");
        // Add alternative parts with addPart()
        $swift_message->addPart($message, 'text/plain');
        $mailer->send($swift_message);


    }


    /////// DELETE FUNCTIONS
    public function unsEmail($san_email) {

        $this->db->query('DELETE FROM email_list WHERE email = :san_email');
        $this->db->bind(':san_email', $san_email);

        // Execute
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


}