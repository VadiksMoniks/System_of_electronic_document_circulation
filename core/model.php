<?php
    require  'E:/xampp/htdocs/System_of_electronic_document_circulation/vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class Model{

        protected $pdo;
        protected $answer = array();

        public function __construct(){       
            $host = "localhost";
            $userLog = "root";
            $passwordUser = "";
            $dbname = "document circulating system";
            $dsn = 'mysql:host='.$host.';dbname='.$dbname;
            $this->pdo = new PDO($dsn, $userLog, $passwordUser);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            //return $this->pdo;
        }

        protected function sendMail($address,$header, $body)
        {
            $mail = new PHPMailer();

            try{
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->IsHTML(true);
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'andr26012k191@gmail.com';
                $mail->Password = 'qprocihdjvzclkbw';
                $mail->SMTPSecure = 'tls';
                $mail ->CharSet = 'UTF-8';
                $mail->Port = '587';
                $mail->Subject = $header;
                $mail->setFrom('andr26012k191@gmail.com', 'INFIZ');
                $mail->Body = $body."This is no-reply message!";
                $mail->addAddress($address); 
                $mail->send();
                $mail->smtpClose();
                
                
            }
            catch (Exception $e){
                echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            }

        }

       /* protected function connection(){
            $host = "localhost";
            $userLog = "root";
            $passwordUser = "";
            $dbname = "document circulating system";
            $dsn = 'mysql:host='.$host.';dbname='.$dbname;
            $this->pdo = new PDO($dsn, $userLog, $passwordUser);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            return $this->pdo;
        }

        public function get_data($param=null){

        }*/

    }

?>