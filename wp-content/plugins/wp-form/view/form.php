<br><br><br><br>

<!DOCTYPE html>
<html>
    <head>
         <!-- INSERT INTO `wp_custom_table1` (`Id`, `fnam`, `lnam`) VALUES (NULL, 'asad', 'ullah'); -->
        <?php 
            global $wpdb;

            $wpdb->insert(
                "wp_custom_table1",
                array(
                    "fnam"=> "sakib",
                    "lnam"=> "Rakib"
                )
            );
        ?>
    </head>            
    <body>
        <section class="body-area">
            <div class="registration-form">
                <div class="registration-input">
                    <form action="" method="post">

                        <label>Enter your name</label><br>
                        <input type="text" id="fname" name="firstname" placeholder="First Name">
                        <input type="text" id="lname" name="lastname" placeholder="Last Name"><br><br>

                        <input type="submit" value="Submit" name="SubmitButton">
                    </form> 
                </div>
            </div>
        </section>
    </body>
</html>