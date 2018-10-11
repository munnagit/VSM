
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Login Form</title>

	<link rel="stylesheet" href="assets/demo.css">
	<link rel="stylesheet" href="assets/form-login.css">

</head>
  <header>
 </header>

  <ul>
  </ul>


<?php
// Include config file && User class
require_once 'gpConfig.php';
require_once 'User.class.php';

if (isset($_GET['code'])) {
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
    $gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
    // Get user profile data from google
    $gpUserProfile = $google_oauthV2->userinfo->get();

    // Initialize User class
    $user = new User();

    // Getting user profile info
    $gpUserData = array();
    $gpUserData['oauth_uid']  = !empty($gpUserProfile['id'])?$gpUserProfile['id']:'';
    $gpUserData['first_name'] = !empty($gpUserProfile['given_name'])?$gpUserProfile['given_name']:'';
    $gpUserData['last_name']  = !empty($gpUserProfile['family_name'])?$gpUserProfile['family_name']:'';
    $gpUserData['email']      = !empty($gpUserProfile['email'])?$gpUserProfile['email']:'';
    $gpUserData['gender']     = !empty($gpUserProfile['gender'])?$gpUserProfile['gender']:'';
    $gpUserData['locale']     = !empty($gpUserProfile['locale'])?$gpUserProfile['locale']:'';
    $gpUserData['picture']    = !empty($gpUserProfile['picture'])?$gpUserProfile['picture']:'';
    $gpUserData['link']       = !empty($gpUserProfile['link'])?$gpUserProfile['link']:'';

    // Insert or update user data to the database
    $gpUserData['oauth_provider'] = 'google';
    $userData = $user->checkUser($gpUserData);

    // Storing user data in the session
    $_SESSION['userData'] = $userData;

    // Render user profile data
    if (!empty($userData)) {
        $output = '<h2>Google+ Profile Details </h2>';
        $output .= '<img src="'.$userData['picture'].'">';
        $output .= '<p>Google ID : ' . $userData['oauth_uid'].'</p>';
        $output .= '<p>Name : ' . $userData['first_name'].' '.$userData['last_name'].'</p>';
        $output .= '<p>Email : ' . $userData['email'].'</p>';
        $output .= '<p>Gender : ' . $userData['gender'].'</p>';
        $output .= '<p>Locale : ' . $userData['locale'].'</p>';
        $output .= '<p>Logged in with : Google</p>';
        $output .= '<p><a href="'.$userData['link'].'" target="_blank">Click to visit Google+</a></p>';
        $output .= '<p>Logout from <a href="logout.php">Google</a></p>';
    } else {
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }
} else {
    // Get login url
    $authUrl = $gClient->createAuthUrl();

    // Render google login button
    //$output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/google-sign-in-btn.png" alt=""/></a>';

    //Login page html code converted to php

    echo '<div class="main-content">';
      echo '';
      echo '<!-- You only need this form and the form-login.css -->';
      echo '<form class="form-login" method="post" action="#">';
      echo '<div class="form-log-in-with-email">';
      echo '<div class="form-white-background">';
      echo '<div class="form-title-row">';
      echo '<h1>Log in</h1>';
      echo '</div>';
      echo '';
      echo '<div class="form-row">';
      echo '<label>';
      echo '<span>Email</span>';
      echo '<input type="email" name="email">';
      echo '</label>';
      echo '</div>';
      echo '';
      echo '<div class="form-row">';
      echo '<label>';
      echo '<span>Password</span>';
      echo '<input type="password" name="password">';
      echo '</label>';
      echo '</div>';
      echo '';
      echo '<div class="form-row">';
      echo '<button type="submit">Log in</button>';
      echo '</div>';
      echo '';
      echo '</div>';
      echo '';
      echo '<a href="#" class="form-forgotten-password">Forgotten password &middot;</a>';
      echo '<a href="#" class="form-create-an-account">Create an account &rarr;</a>';
      echo '';
      echo '</div>';
      echo '';
      echo '<div class="form-sign-in-with-social">';
      echo '';
      echo '<div class="form-row form-title-row">';
      echo '<span class="form-title">Sign in with</span>';
      echo '</div>';
      echo '';
      //$output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'" "'class="form-google-button">Google</a>'';
      echo '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'" class="form-google-button">Google</a>';
      //$output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="images/google-sign-in-btn.png" alt=""/></a>';
      echo '';
      echo '</div>';
      echo '</form>';
      echo '</div>';
      echo '</body>';
      echo '</html>';
}
?>

<div class="container">
    <!-- Display login button / Google profile information -->
    <?php echo $output; ?>
</div>
