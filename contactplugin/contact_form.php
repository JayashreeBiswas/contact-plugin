<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 1/23/2019
 * Time: 11:54 AM
 */

//echo "Admin Page Test";

//function contact_form_page()
//{
    ?>
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <script>
            //function go()
            //{
            //    var ajaxurl = '<?php //echo admin_url('admin-ajax.php');?>//';
            //    console.log(ajaxurl);
            //    jQuery.ajax({
            //        type: 'post',
            //        url : ajaxurl,
            //        data : {
            //                action:'contact_form',
            //        }
            //
            //        });
            //
            //}
            function go() {
                // alert("test");
                $('#contact_form').submit(function (e) {
                    e.preventDefault();
                    // alert("hello test");
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php');?>';
                    // alert(ajaxurl);
                    var name = $("#name").val();
                    // alert(name);
                    var contact = $("#contact").val();
                    // alert(contact);
                    var email = $("#email").val();
                    // alert(email);
                    var message = $("#message").val();
                    // alert(message);
                    $.ajax({
                        type: 'post',
                        url: ajaxurl,
                        // dataType: 'json',
                        data: {
                            action: 'contact_form',
                            name: name,
                            contact: contact,
                            email: email,
                            message: message

                        },

                        success: function ($data) {
                            // console.log(data); //should print out the name since you sent it along
                            // alert($data);
                            // alert("success");
                            $('#success').html('<div style="background-color:limegreen;"><h1><strong>Successful!</strong></h1></div>' +
                                '<div><p><strong>  Thank you for your concern, our representative will get back to you.\n</strong></p></div>')
                            // $('#contact_form').hide();

                        },
                        error: function (error) {
                            console.log('AJAX error callback....');
                            console.log(error);
                        }
                        // error : function($data){
                        //     alert("sorry")
                        // }
                    });

                });
            }
        </script>
        <style>
            .error {color: #FF0000;}
        </style>
    </head>
    <body>
<?php
//// define variables and set to empty values
//$nameErr = $emailErr = $genderErr = $websiteErr = "";
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    if (empty($_POST["name"])) {
//        $nameErr = "Name is required";
//    }
//    if (empty($_POST["contact"])) {
//        $nameErr = "Name is required";
//    }
//    if (empty($_POST["email"])) {
//        $nameErr = "Name is required";
//    }
//    if (empty($_POST["message"])) {
//        $nameErr = "Name is required";
//    }
//}
//?>
    <div class="container">
        <div class="container-fluid">
            <h1>Contact Form</h1>
        </div>
        <div id="success"></div>
        <div class="container-fluid">
            <p><span class="error">* required field</span></p>
            <form name="contact_form" id="contact_form" method="post" action="">
                <label for="name">Name:<strong class="error">*</strong></label></br>
                <input type="text" class="form-control" name="name" id="name" required pattern="[A-Za-z -]{3,15}">
                <span class="error">* <?php echo $nameErr;?></span>

                <label for="contact">Contact:<strong class="error">*</strong></label></br>
                <input type="tel" class="form-control" name="contact" id="contact" required pattern="^\d{3}\d{3}\d{4}$">
<!--                <span class="error">* --><?php //echo $nameErr;?><!--</span>-->

                <label for="email">Email ID:<strong class="error">*</strong></label></br>
                <input type="email" class="form-control" name="email" id="email" required >
<!--                <span class="error">* --><?php //echo $nameErr;?><!--</span>-->

                <label for="message">Message:<strong class="error">*</strong></label></br>
                <textarea rows="6" col="70" class="form-control" name="message" id="message" required></textarea>
<!--                <span class="error">* --><?php //echo $nameErr;?><!--</span>-->

                <button type="submit" class="btn btn-success" name="submit" id="submit" onclick="go(this);">Submit
                </button>
            </form>
        </div>
    </div>
    </body>
    <?php
//}
//add_shortcode('contact_form_shortcut','contact_form_page');
?>