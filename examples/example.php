<?php
/**
 * LightOpenID example file.
 *
 * Simple form requesting input of OpenID URL and runs authentication against it.
 */

require 'openid.php';

try {
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID('localhost');
    if (!$openid->mode) {
        if (isset($_POST['openid_identifier'])) {
            $openid->identity = $_POST['openid_identifier'];
            # The following two lines request email, full name, and a nickname
            # from the provider. Remove them if you don't need that data.
            $openid->required = array('contact/email');
            $openid->optional = array('namePerson', 'namePerson/friendly');
            header('Location: ' . $openid->authUrl());
        }

        echo <<<HTML
<form action="" method="post">
    OpenID: <input type="text" name="openid_identifier"> <button>Submit</button>
</form>
HTML;

    } elseif ($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        echo 'User ' . ($openid->validate() ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
        print_r($openid->getAttributes());
    }
} catch (ErrorException $e) {
    echo $e->getMessage();
}
