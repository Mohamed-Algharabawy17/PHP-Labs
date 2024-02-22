<html>
    <head>
        <title> contact form </title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php 
            require_once("config.php");
            // echo print_r($_SERVER);

            $name = (isset($_POST["name"])) ? $_POST["name"] : "";
            $mail = (isset($_POST["email"])) ? $_POST["email"] : "";
            $user_message = (isset($_POST["message"])) ? $_POST["message"] : "";


            $data = array();
            $flag = 0;
            $flage_name=$flag_email=false;
            if(isset($_POST["submit"]))
            {
                //----------------- name validation condition -----------------
                if(empty($name))
                {
                    $name_error_message = "Name is required Please enter your name!";
                }elseif(strlen($name) > nameLength){
                    $name_error_message = "Sorry enter valid name with maximum 99 letter";
                }elseif(is_numeric($name)){
                    $name_error_message = "Sorry enter valid name with only string letter";
                }else{
                    $flage_name=true;
                }

                //----------------- mail validation condition -----------------
                if(empty($mail))
                {
                    $mail_error_message = "Email is required Please enter your email!";
                } elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL))
                {
                    $mail_error_message = "Please enter a valid email";
                }else{
                    $flag_email=true;
                }
                //----------------- message validation condition ---------------
                if(empty($user_message))
                {
                    $user_message_error = "Message is required Please enter your message!";
                } elseif(strlen($user_message) > messageLength || is_numeric($user_message)){
                    $user_message_error = "Your message must be maximum 254 letters only!";
                } elseif($flage_name && $flag_email) {
                    $data["Name"] = $name;
                    $data["Email"] = $mail;
                    $data["Message"] = $user_message;
                    $flag = 1;
                }
                // print_r($data);
                //--------------------------------------------------------------
            }

        if($flag == 1)
        {
            $thank_message = "Thank you for contacting us :)";
        ?>
        
        <h5 style="color:green">
            <b><?= $thank_message; ?></b>
        </h5>
        <div class="data_table">
            <?php 
                foreach ($data as $key => $value) 
                {
                    echo $key.": ".$value;
                    echo "<br/>";
                    echo '<hr>';
                }
            ?>
        </div>
        <?php } else { ?>
        <div class="form_container">
            <h3> Contact Form </h3>
            <form id="contact_form" method="POST" enctype="multipart/form-data">

            <div class="row">
                <label class="required" for="name">Your name:</label><br />
                <input id="name" class="input" name="name" type="text" value="<?= $name; ?>" size="30" /><br />
                <span><?= $name_error_message; ?></span>


            </div>
            <div class="row">
                <label class="required" for="email">Your email:</label><br />
                <input id="email" class="input" name="email" type="text" value="<?= $mail; ?>" size="30" /><br />
                <span><?= $mail_error_message; ?></span>

            </div>
            <div class="row">
                <label class="required" for="message">Your message:</label><br />
                <textarea id="message" class="input" name="message" rows="7" cols="30"></textarea><br />
                <span><?= $user_message_error; ?></span>

            </div>

            <input id="submit" name="submit" type="submit" value="Send email" />
            <input id="clear" name="clear" type="reset" value="clear form" />

            </form>
        </div>
        <?php 
        }
        if(isset($_POST["clear"]))
        {
            $name = $mail = $user_message = "";
        }
        
        ?>

        
    </body>

</html>