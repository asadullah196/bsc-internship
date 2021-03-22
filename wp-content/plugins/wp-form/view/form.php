<br><br>

<!DOCTYPE html>
<html>
    <head>
        <?php

            global $wpdb;

            if(isset($_POST['SubmitButton'])){
                $namef = $_POST['firstname'];
                $namel = $_POST['lastname'];

                $userPassword = $_POST['password'];
                $userPasswordRe = $_POST['re-password'];

                $userPhone = $_POST['phone'];
                $userEmail = $_POST['email'];

                $userAddress1 = $_POST['address1'];
                $userAddress2 = $_POST['address2'];

                $zipCode = $_POST['zipcode'];
                $userCity = $_POST['city'];

                $userState = $_POST['state'];
                $userCountry = $_POST['country'];

                // Check the variable value
                //echo "First Name == " . $namef . "<br><br>";
                //echo "Last Name == " . $namel . "<br><br>";

                $wpdb->insert(
                    "wp_custom_table1",
                    array(
                        'fnam'=> $namef,
                        'lnam'=> $namel
                    )
                );
            }
        ?>
    </head>            
    <body>
        <section class="body-area">
            <div class="form-btn">
                
                <h1><?php echo PLUGIN_DIR_PATH.'view/form.php';?></h1><br/>

                <a href="/wordpressform/wp-content/plugins/wp-form/view/form2.php">
                    <button type="button">Registration</button>
                </a>
            </div>
            <div class="registration-form">
                <h4>Registration Form</h4>
				<p>Please eneter your personal details below</p><hr>
                <div class="registration-input">
                    <form action="" method="post">
                        <label>Enter Your Name:</label><br><br>
                        <input type="text" id="fname" name="firstname" placeholder="First Name" required>
                        <input type="text" id="lname" name="lastname" placeholder="Last Name"><br><br>

                        <label>Enter your phone and email</label><br>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <input type="password" id="re-password" name="re-password" placeholder="Confirm Password" required><br><br>

                        <label>Enter your phone and email</label><br>
                        <input type="number" id="phone" name="phone" placeholder="Phone number">
                        <input type="email" id="email" name="email" placeholder="Email address" required><br><br>

                        <label>Enter your address</label><br>
                        <input type="text" id="address1" name="address1" placeholder="Address line 1">
                        <input type="text" id="address2" name="address2" placeholder="Address line 2"><br><br>

                        <input type="text" id="zipcode" name="zipcode" placeholder="zip code">
                        <input type="text" id="city" name="city" placeholder="City"><br><br>

                        <input type="text" id="state" name="state" placeholder="State">
                        <input type="text" id="country" name="country" placeholder="Country"><br><br>

                        <input type="submit" value="Submit" name="SubmitButton">
                    </form> 
                </div>
            </div>
        </section>
    </body>
</html>