<?php
//Mikhail Senatorov 300407626
require_once('inc/config.inc.php');
require_once('inc/Page.class.MSe07626.php');
require_once('inc/Validate.class.MSe07626.php');


// Make sure to call all your include files


// if the form was posted, validate the input and to update the valid status

//Show the header
Page::getHeader();

if(isset($_POST['submit'])){
    $valid_status = Validate::validateForm();
    if(empty($valid_status)){
        Page::showForm($_POST);
        Page::showData($shippingCost);
    } else {
        Page::showForm($_POST);
        Page::ShowNotification($valid_status);
        
    }
} else if (isset($_POST['reset'])) {
    Page::showForm($valid_status = []);

} else {
    Page::showForm($valid_status = []);
}

// If there was post data and there were errors
// display the error messages and the form
// Note that the correct entry needs to be printed in the form's inputs
    
// If there was post data and there were no errors...
// Display thank you message
// Display the data
    
// Other than that, display the form


// Show the footer
Page::getFooter();

?>