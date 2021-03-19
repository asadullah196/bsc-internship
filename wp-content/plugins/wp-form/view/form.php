<br><br><br><br>

<!DOCTYPE html>
<html>
    <head>
         <!-- INSERT INTO `wp_custom_table1` (`Id`, `fnam`, `lnam`) VALUES (NULL, 'asad', 'ullah'); -->

    <?php
    global $wpdb;

    if(isset($_POST['SubmitButton'])){
        $namef = $_POST['firstname'];
        $namel = $_POST['lastname'];
                
        echo $namef." == first name<br><br>";
        echo $namel." == name last";

        $table_name = $wpdb->prefix . 'wp_custom_table1';

        $wpdb->insert( 
            $table_name, 
            array( 
                'fnam' => $namef, 
                'lnam' => $namel,
            )
        );
    }
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