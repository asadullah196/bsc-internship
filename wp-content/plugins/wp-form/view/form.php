<br><br>

<!DOCTYPE html>
<html>
    <head>
        <?php

            global $wpdb;

            if(isset($_POST['SubmitButton'])){
                $namef = $_POST['firstname'];
                $namel = $_POST['lastname'];

                echo "First Name == " . $namef . "<br><br>";
                echo "Last Name == " . $namel . "<br><br>";

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
            <div class="registration-form">
                <div class="registration-input">
                    <form action="" method="post">
                        <label>Enter Your Name:</label><br><br>
                        <input type="text" id="fname" name="firstname" placeholder="First Name" required>
                        <input type="text" id="lname" name="lastname" placeholder="Last Name" required><br><br>

                        <input type="submit" value="Submit" name="SubmitButton">
                    </form> 
                </div>
            </div>
        </section>
    </body>
</html>