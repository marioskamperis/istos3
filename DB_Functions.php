<?php
error_reporting(E_ERROR | E_PARSE);
class DB_Functions
{

    private $db;
    private $con;

    //put your code here
    // constructor
    function __construct()
    {
        require_once 'DB_Connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->con=$this->db->connect();

    }

    // destructor
    function __destruct()
    {

    }

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($email, $password, $name)
    {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password

        $salt = $hash["salt"]; // salt
        $result = mysqli_query("INSERT INTO users(unique_id, name, email, encrypted_password, salt, created_at) VALUES('$uuid', '$name', '$email', '$encrypted_password', '$salt', NOW())");
        // check for successful store
        if ($result) {
            // get user details 
            $id = mysqli_insert_id(); // last inserted id
            $result = mysqli_query("SELECT * FROM users WHERE id = $id");
            // return user details
            return mysqli_fetch_array($result);
        } else {
            return false;
        }
    }

    public function loginUser($user_id,$ip,$browser)
    {

        $result = mysqli_query("INSERT INTO user_info(login_at,loggout_at,user_id,heartbeat,ip_adress,is_alive,browser)
                              VALUES(NOW(),NULL,$user_id,NOW(),'$ip',NOW(),'$browser')");


        $id = mysqli_insert_id();; // Initializing Session
        $user = mysqli_query("SELECT * FROM user_info WHERE id = $id");

        // check for successful store
        if (!empty($user)) {
            return mysqli_fetch_array($user);
        } else {
            return false;
        }
    }
    public function isAlive($user_id,$ip,$browser)
    {
        $result = mysqli_query("INSERT INTO user_info(login_at,loggout_at,user_id,ip_adress,) VALUES(NOW(),NULL,$user_id,$ip,$browsero)");
        $_SESSION['logid'] = mysqli_insert_id();; // Initializing Session

        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function logoutUser($id)
    {
        $id=$_SESSION['user_info']['id'];
        $ok=mysqli_query("UPDATE user_info SET loggout_at = NOW() WHERE id = $id;");
        
        $result=mysqli_query("SELECT loggout_at FROM user_info
                        WHERE $id=$id
                        ORDER BY loggout_at DESC
                        LIMIT 1;");
        // // check for successful store

        // echo($id); 
        
        // $smt=mysqli_fetch_array($result);
        // echo(print_r($smt,true));
        // echo(" doihduo".$smt['loggout_at']);
       
        // //$_SESSION['user_info']['loggout_at']=mysqli_fetch_array($result['loggout_at']);
        // //echo($_SESSION['user_info']['loggout_at']);
         //die();
        if (!empty($smt)) {
            return $smt['loggout_at'];
        } else {
            return false;
        }
    }
    public function getUsers(){
        $all_users = mysqli_query("SELECT * FROM users");
        return mysqli_fetch_array($all_users);

    }
    public function getUserInfo($id){
        $user_info = mysqli_query("SELECT * FROM user_info WHERE user_id='$id'");
        $return=mysqli_fetch_array($user_info);

    }
    /**
     * Get user by email and password
     */
    public function getUserByEmailAndPassword($email, $password)
    {

        $query="SELECT * FROM users WHERE email = '$email'";


        $result = mysqli_query($this->con,$query);
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $no_of_rows = mysqli_num_rows($result);

        if ($no_of_rows > 0) {

            $result = mysqli_fetch_array($result);

            $salt = $result['salt'];
            $encrypted_password = $result['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);

            // check for password equality
            //echo(print_r($result,true));
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $result;
            }
        } else {

            // user not found
            return false;
        }
    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($email)
    {
        $result = mysqli_query("SELECT email from users WHERE email = '$email'");
        $no_of_rows = mysqli_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password)
    {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt , password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password)
    {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }


    function sec_session_start()
    {
        $session_name = 'sec_session_id';   // Set a custom session name
        $secure = SECURE;
        // This stops JavaScript being able to access the session id.
        $httponly = true;
        // Forces sessions to only use cookies.
        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
            exit();
        }
        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"],
            $cookieParams["path"],
            $cookieParams["domain"],
            $secure,
            $httponly);
        // Sets the session name to the one set above.
        session_name($session_name);
        session_start();            // Start the PHP session
        session_regenerate_id(true);    // regenerated the session, delete the old one.
    }

    function checkbrute($user_id, $mysqli)
    {
        // Get timestamp of current time
        $now = time();

        // All login attempts are counted from the past 2 hours.
        $valid_attempts = $now - (2 * 60 * 60);

        if ($stmt = $mysqli->prepare("SELECT time
								 FROM login_attempts 
								 WHERE user_id = ? 
								AND time > '$valid_attempts'")
        ) {
            $stmt->bind_param('i', $user_id);

            // Execute the prepared query.
            $stmt->execute();
            $stmt->store_result();

            // If there have been more than 5 failed logins
            if ($stmt->num_rows > 5) {
                return true;
            } else {
                return false;
            }
        }
    }

//	function login_check($mysqli) {
//		// Check if all session variables are set
//		if (isset($_SESSION['user_id'],
//							$_SESSION['username'],
//							$_SESSION['login_string'])) {
//
//			$user_id = $_SESSION['user_id'];
//			$login_string = $_SESSION['login_string'];
//			$username = $_SESSION['username'];
//
//			// Get the user-agent string of the user.
//			$user_browser = $_SERVER['HTTP_USER_AGENT'];
//
//			if ($stmt = $mysqli->prepare("SELECT password
//										  FROM members
//										  WHERE id = ? LIMIT 1")) {
//				// Bind "$user_id" to parameter.
//				$stmt->bind_param('i', $user_id);
//				$stmt->execute();   // Execute the prepared query.
//				$stmt->store_result();
//
//				if ($stmt->num_rows == 1) {
//					// If the user exists get variables from result.
//					$stmt->bind_result($password);
//					$stmt->fetch();
//					$login_check = hash('sha512', $password . $user_browser);
//
//					if ($login_check == $login_string) {
//						// Logged In!!!!
//						return true;
//					} else {
//						// Not logged in
//						return false;
//					}
//				} else {
//					// Not logged in
//					return false;
//				}
//			} else {
//				// Not logged in
//				return false;
//			}
//		} else {
//			// Not logged in
//			return false;
//		}
//	}
    function esc_url($url)
    {

        if ('' == $url) {
            return $url;
        }

        $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

        $strip = array('%0d', '%0a', '%0D', '%0A');
        $url = (string)$url;

        $count = 1;
        while ($count) {
            $url = str_replace($strip, '', $url, $count);
        }

        $url = str_replace(';//', '://', $url);

        $url = htmlentities($url);

        $url = str_replace('&amp;', '&#038;', $url);
        $url = str_replace("'", '&#039;', $url);

        if ($url[0] !== '/') {
            // We're only interested in relative links from $_SERVER['PHP_SELF']
            return '';
        } else {
            return $url;
        }
    }
}

?>