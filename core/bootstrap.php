<?php
//error_reporting(E_ALL); // E_ALL mostra tutti gli errori | in produzione passare 0 al parametro e utilizzare le eccezioni
//ini_set('display_errors', 1);

require_once 'db/DBPDO.php';      

require_once 'db/DbFactory.php';    

require_once 'app/Controllers/Controller.php'; 

require_once 'app/Controllers/HomeController.php'; 

require_once 'app/Controllers/PostController.php';  

require_once 'app/Controllers/AuthController.php';  

require_once 'app/Controllers/SigninController.php';

require_once 'app/Controllers/SignupController.php';

require_once 'app/Controllers/PasswordController.php';  

require_once 'app/Controllers/ProfileController.php';  

require_once 'app/models/Validate.php'; 

require_once 'app/models/Auth.php'; 

require_once 'app/models/Signin.php'; 

require_once 'app/models/Signup.php'; 

require_once 'app/models/Password.php';  

require_once 'app/models/Profile.php';  

require_once 'app/models/Email.php';  

require_once 'app/models/EmailLink.php';  

require_once 'app/models/Post.php';

require_once 'app/models/Image.php'; 

require_once 'app/models/Comment.php'; 

require_once 'helpers/functions.php'; 

require_once 'core/Router.php'; 
