<?php
//Mikhail Senatorov 300407626

class Page{
    static private $title="Assignment 2";
    static private $studentName="Mikhail Senatorov";
    static private $studentID="300407626";

    // This static function set the HTML header including the title and display the student name and ID
    static function getHeader(){
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="author" content="">
            <title><?=self::$title?></title>        
            <link href="css/styles.css" rel="stylesheet">
        </head>
        <body>
            <header>
                <h1><?= self::$title?>: Form Processing by <?= self::$studentName?> (<?= self::$studentID?>)</h1>
            </header>
            <article>
                <section class="main">
        <?php
    }

    // This static function close all the HTML tags at the bottom of the document
    static function getFooter(){
        ?>
                </article>                
            </body>

        </html>
        <?php
        
    }

    // This static function display the form. It gets the information of the valid input 
    // that can be part of the $validation status array from the Validate class
    // Note: The correct post data will be displayed within the HTML input control object
    static function showForm($valid_status){
        ?>
        <div class="form">
                    <form action="" method="post">
                        <fieldset id="form">
                            <legend>Douglas Custom Build Order Page</legend>
                            <div>                                
                                <label for="fullName">Full Name</label>
                                <input type="text" name="fullName" id="fullName" value="<?= htmlspecialchars($valid_status['fullName'] ?? '') ?>" placeholder="First and last name">
                            </div>
                            <div>                                
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" value="<?= htmlspecialchars($valid_status['email'] ?? '') ?>" placeholder="someone@here.ca">
                            </div>                              
                            <div>
                                <label for="phoneNumber">Phone Number</label>
                                <input type="text" name="phoneNumber" id="phoneNumber" value="<?= htmlspecialchars($valid_status['phoneNumber'] ?? '') ?>"  placeholder="(nnn) nnn nnnn">
                            </div>                                                          
                            <div>
                                <label for="productAmount">Product Amount</label>
                                <input type="text" name="productAmount" id="productAmount" value="<?= htmlspecialchars($valid_status['productAmount'] ?? '') ?>" placeholder="number of product less than 7">
                            </div>                                                
                            <div>
                                <label for="giftWrap">Gift wrap?</label>
                                <span>
                                <input type="radio" name="giftWrap" id="giftWrapYes" value="yes"
                                    <?= (isset($_POST['giftWrap']) && $_POST['giftWrap'] === 'yes') ? 'checked' : '' ?>> Yes
                                <input type="radio" name="giftWrap" id="giftWrapNo" value="no"
                                    <?= (isset($_POST['giftWrap']) && $_POST['giftWrap'] === 'no') ? 'checked' : '' ?>> No
                                </span>
                            </div>
                            <div>
                                <label for="shipping">Shipping Priority</label>
                                <select name="shipping">
                                    <option value="Select..." <?= (!isset($_POST['shipping']) || $_POST['shipping'] === 'Select...') ? 'selected' : '' ?>>Please select one option</option>
                                    <option value="regular" <?= (isset($_POST['shipping']) && $_POST['shipping'] === 'regular') ? 'selected' : '' ?>>Regular - $6</option>
                                    <option value="express" <?= (isset($_POST['shipping']) && $_POST['shipping'] === 'express') ? 'selected' : '' ?>>Express - $15</option>
                                    <option value="priority" <?= (isset($_POST['shipping']) && $_POST['shipping'] === 'priority') ? 'selected' : '' ?>>Priority - $25</option>
                                </select>
                            </div>                            
                            <div>
                                <input type="submit" name="submit" value="Submit Order">
                                <input type="submit" name="reset" value="Clear Data">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </section> 
            <section class="sidebar">
        <?php
    }

    // This static function read the validation status property of the Validate class 
    // and display the error messages or submission notification
    static function ShowNotification($valid_status){
        ?>
        <div class="highlight">
                    <p>Please fix the following errors:</p>
                    <ul>
                        <?php
                        foreach($valid_status as $error){
                            echo "<li>$error</li>";
                        }
                        ?>
                    </ul>                                        
                </div>     
        <?php
    }

    // This static function display the submitted data. The shipping cost variable is the 
    // shipping cost associative array declared in config.inc.php
    // Make sure to calculate the total cost
    static function showData($shippingCost){
        ?>
                    <div class="data">
                        <div class="highlight">
                            <b>Thank you for your order!</b>
                        </div>
                    
                    <b>Entered data is:</b>
                    <table>
                        
                        <tr>
                            <th>Name</th>
                            <td><?php echo htmlspecialchars($_POST['fullName'])?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?php echo htmlspecialchars($_POST['email'])?></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><?php echo htmlspecialchars($_POST['phoneNumber'])?></td>
                        </tr>
                        <tr>
                            <th>Product Amount</th>
                            <td><?php echo htmlspecialchars($_POST['productAmount'])?></td>
                        </tr>                        
                        <tr>
                            <th>Gift Wrap?</th>
                            <td><?php echo htmlspecialchars($_POST['giftWrap'])?></td>
                        </tr>
                        <tr>                            
                            <th>Shipping</th>                        
                            <td><?php echo htmlspecialchars($_POST['shipping'])?></td>                        
                        </tr>
                        <tr>                            
                            <th>Total Cost</th>                        
                            <td><?php
                            $totalCost = 0;
                            $subTotal = ITEM_COST * (int)$_POST['productAmount'];
                            if($subTotal > 100){
                                $subTotal -= $subTotal * DISCOUNT; 
                            }
                            if(isset($_POST['giftWrap']) && $_POST['giftWrap'] === 'yes'){
                                $subTotal += WRAP_COST;
                            }
                            if(isset($_POST['shipping']) && array_key_exists($_POST['shipping'], $shippingCost)){
                                $subTotal += $shippingCost[$_POST['shipping']];
                            }
                            $totalCost = $subTotal + ($subTotal * TAX); 
                            echo number_format($totalCost, 2, '.', ''); 
                            ?></td>                        
                        </tr>
                    </table>
                </div>
            </section>
        <?php
    }
}
?>