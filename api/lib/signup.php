<?php
require_once('Database.class.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/api/lib/Database.class.php');
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';


class signup{

    private $username;
    private $password;
    private $email;

    private $db;


    public function __construct($username,$password,$email){

        $this->db = Database::getConnection();

        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        if($this->userExists()){
            throw new Exception("User already Exist");
        }
        $bytes = random_bytes(16);
        $token = bin2hex($bytes);
        $password = $this->hashPassword();



        $querry = "INSERT INTO `auth` (`username`, `email`, `password`, `active`,`tokan`) VALUES ('$username', '$email', '$password', '0', '$token')";

        if(!(mysqli_query($this->db , $querry))){
            throw new Exception("unable to login");
        } else
        {
           $this->id =  mysqli_insert_id($this->db);
           //$this->sendVerificationMail();
        }
    }

    public function getInsertId(){
        return $this->id;

    }

//     function sendVerificationMail(){        
        
//         $config_json = file_get_contents('../env.json');
//         $config = json_decode($config_json, true);
//         $email = new \SendGrid\Mail\Mail();
//         $email->setFrom("mail.com", "api for verification");
//         $email->setSubject("verify your account");
//         $email->addTo("$this->email", "$this->username");
//         $email->addContent("text/plain", "please verify your account with http://localhost/api/signup?token=$token");
//         $email->addContent(     
//     "text/html", "<strong><a href=http://localhost/api/signup?token=$token></strong>"
//         );
//         $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
//         try {       
//             $response = $sendgrid->send($email);
//             // print $response->statusCode() . "\n";
//             // print_r($response->headers());
//             // print $response->body() . "\n";
//         } catch (Exception $e) {
//             echo 'Caught exception: '. $e->getMessage() ."\n";
// }
//     }

    public function hashPassword($cost = 10){

        $options = [
            "cost" => $cost,
    ];
        
        return password_hash($this->password,PASSWORD_BCRYPT,$options);

    }

    public function userExists(){
        //TODO: Write the code to check if user exists.
        return false;
    }
    
//     public static function verifyAccount($token){
//         $query = "SELECT * FROM `auth` WHERE token='$token'";
//         $db = Database::getConnection();
//         $result = mysqli_query($db, $query);
//         if($result and mysqli_num_rows($result) == 1){
//             $data = mysqli_fetch_assoc($result);
//             if($data['active'] == 1){
//                 throw new Exception("Already Verified");
//             }
//             mysqli_query($db, "UPDATE `auth` SET `active` = '1' WHERE `auth`.`token` = '$token'");
//             return true;
//         } else {
//             return false;
//         }
//     }
 }
    

