<?php

    namespace Core;

    include './core/validator.php'; 
    require  'E:/xampp/htdocs/System_of_electronic_document_circulation/vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    //use Validator\Validator;

    class Model{

        const USER = 'user';
        const ADMIN = 'admin';
        const DIRECTORATE = 'directorate';

        private $validator;
        protected $pdo;
        protected $answer = array();

        public function __construct(){ 
            
            $this->validator = new Validator\Validator();

            $host = "localhost";
            $userLog = "root";
            $passwordUser = "";
            $dbname = "document circulating system";
            $dsn = 'mysql:host='.$host.';dbname='.$dbname;
            $this->pdo = new \PDO($dsn, $userLog, $passwordUser);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            //return $this->pdo;
        }

        public function signOut($mode)
        {
            if(isset($_SESSION[$mode])){
                session_start();
                unset($_SESSION[$mode]); // или $_SESSION = array() для очистки всех данных сессии
                session_destroy();

                if($mode == 'user'){
                    $link = 'http://localhost/System_of_electronic_document_circulation/index.php';
                }
                else if($mode == 'admin'){
                    $link = 'http://localhost/System_of_electronic_document_circulation/index.php/admin/authorization';
                }
                else if($mode == 'directorate'){
                    $link = 'http://localhost/System_of_electronic_document_circulation/index.php/directorate/signIn';
                }

                header('Location:'.$link);
            }
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

        public function validateMail($data, $language)
        {
            return $this->validator->validateMail($data, $language);
        }

        public function validateByLanguage(array $data, string $language)
        {
            return $this->validator->validateByLanguage($data, $language);
        }

        public function checkEmptity(array $data, string $language)
        {
            return $this->validator->checkEmptity($data, $language);
        }

    }

?>