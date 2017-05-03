<?php 
class User{
	
	private $pdo;

	public function __construct($pdo){
		$this->pdo = $pdo;
	}

    public function login(){

        if (isset($_POST['username']) &&
            isset($_POST['password'])){

            $username = $_POST['username'];
            $password = $_POST['password'];
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");

            $stmt->execute([':username' => $username]);

            $row = $stmt->fetchAll();
             
            if(!empty($row)) {

                if(password_verify($password, $row[0]['Password'])){
                    
                    echo "HEJ !";
                    session_start();            
                    $_SESSION['username'] = $row[0]['Username'];
                    //echo $_SESSION['username'];
                } 
                else{
                    echo "Invalid username/password"; 
                    header('refresh:2; url=../index.php');
                }
            }
            else{
                echo "Invalid username/password"; 
                header('refresh:2; url=../index.php');
            }


        }
    }










	public function signup(){
		$username = $_POST['username'];
		$password = $_POST['password'];

		$pwhash = password_hash($password, PASSWORD_DEFAULT);

		$stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");

		$stmt->execute([':username' => $username]
			);

 		$row = $stmt->fetchAll();
 
            if(!empty($row)) {

                if($row[0]['Username'] == $username) {
                    echo "The username " . $username . " not available";
                    echo "Use a difference username or try <a href='index.php'>logging in</a>";
                //header('Location: index.php');
                }
            
            } else {
                $stmt = $this->pdo->prepare("INSERT INTO users (username, password) values (:username, :password)");
      
                $stmt->execute(array(
                ':username' => $username,
                ':password' => $pwhash,
                )); 
                header('Location: ../includes/registercomplete.php');
            }      
        }		
 
}