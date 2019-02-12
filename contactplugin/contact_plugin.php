<?php
/**
 * Plugin Name: Contact Form Plugin
 * Description: This is a custom plugin for creating contact form.
 **/

    global $jal_db_version;
    $jal_db_version = '1.0';
    function jal_contact()
    {
        global $wpdb;
        global $jal_db_version;

        $table_name = $wpdb->prefix . 'contact_form';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		name varchar (400) NOT NULL ,
		contact varchar (20) NOT NULL ,
		email_id varchar (400) NOT NULL ,
		message varchar (4000) NOT NULL ,
		ip_address varchar (400) NOT NULL ,
		date_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";


        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

//    $table = $wpdb->prefix . 'contact_form_setting';
//
//    $charset_collate = $wpdb->get_charset_collate();
//
//    $setting_sql = "CREATE TABLE $table (
//		id mediumint(9) NOT NULL AUTO_INCREMENT,
//		api_key varchar (400) NOT NULL ,
//		api_url varchar (400) NOT NULL ,
//		PRIMARY KEY  (id)
//	) $charset_collate;";
//
//
//    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//    dbDelta( $setting_sql );

        add_option('jal_db_version', $jal_db_version);
    }

    register_activation_hook(__FILE__, 'jal_contact');

    function contact_page()
    {
        echo '<div class="container" style="background-color: aliceblue">
        <h3>Shortcode for the contact plugin - [contact_form]</h3>
<!--        <div class="container" style="width: auto;">-->
<!--            <p><b>[contact_form]</b></p>-->
<!--        </div>-->
    </div>';
        include ('contact_form.php');

//        return null;
    }

    function contact_page_shortcode()
    {
        ob_start();
        get_template_part( 'contact_form.php', TRUE, FALSE );
        include ('contact_form.php');
        return ob_get_clean();
    }

    function register_custom_menu_page()
    {
        add_menu_page('contact form', 'Contact Form', 'add_users', 'custom_contact_page', 'contact_page', null, 20);
//    add_submenu_page('custom_contact_page','contact form','settings','api_setting','edit_pages','contact_setting');

    }

    add_action('admin_menu', 'register_custom_menu_page');


    add_action('wp', 'contact_form');

    function register_custom_submenu_page()
    {
        add_menu_page('contact setting', 'Contact Setting', 'add_users', 'custom_contact_setting', 'contact_setting', null, 22);
    }

    add_action('admin_menu', 'register_custom_submenu_page');
//    add_action('wp', 'contact_setting');


    function contact_setting()
    {
        include('contact_setting.php');
//        echo "hello test";


    }
add_action('wp_ajax_contact_form','contact_form');
add_action('wp_ajax_nopriv_contact_form','contact_form');
//add_action( 'init', 'contact_form' );

function contact_form()
    {
//echo "<script>alert('hello contact form');</script>";
        global $wpdb, $nameErr;
//        echo "heeeelllloooooooooooooooooooooooooooo";
//        foreach ($_POST as $data){
//            echo $data;
//        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

//            echo 'Hello WOrk';
//            echo $_POST;
            if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
            {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
                $date_time = date("Y-m-d H:i:s");
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
            {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                $date_time = date("Y-m-d H:i:s");
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
                $date_time = date("Y-m-d H:i:s");
            }
//    echo $ip;
//    echo $date_time;
            $name = $_POST['name'];
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Only letters and white space allowed";
            }
            $contact = $_POST['contact'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            $data = array(
                'name' => $name,
                'contact' => $contact,
                'email_id' => $email,
                'message' => $message,
                'ip_address' => $ip,
                'date_time' => $date_time);
            // Debugging: Lets see what we're trying to save
//        var_dump($data);


//        $name = $_POST['name'];
//        $contact = $_POST['contact'];
//        $email = $_POST['email'];
//        $message = $_POST['message'];

            $table_name = $wpdb->prefix . "contact_form";
//        $wpdb->insert($table_name, array('name' => $name, 'contact' => $contact, 'email' => $email, 'message' => $message,
//            'ip_address' => $ip, 'date_time' => $date_time));
// Debugging: Turn on error reporting for db to see if there's a database error
//        $wpdb->show_errors();
            // Actually attempt to insert the data
            if ($wpdb->insert($table_name, $data)) {
//            echo "<script>alert('Your message has been sent successfully');</script>";
//            echo '<div class="alert">
//                <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
//                <strong>Successful!</strong> Thank you for your concern, our representative will get back to you.
//                </div>';
                //sending mail to the user.
                //the message

//            function isa_mailchimp_api_request( $endpoint, $type = 'POST', $body = '' ) {
//
//                // Configure --------------------------------------
//
//                $api_key = '0f3758c249685cb095d8c2e53d91215e-us20';
//
//                // STOP Configuring -------------------------------
//
//                $core_api_endpoint = 'https://<dc>.api.mailchimp.com/3.0/';
//                list(, $datacenter) = explode( '-', $api_key );
//                $core_api_endpoint = str_replace( '<dc>', $datacenter, $core_api_endpoint );
//
//                $url = $core_api_endpoint . $endpoint;
//
//                $request_args = array(
//                    'method'      => $type,
//                    'timeout'     => 20,
//                    'headers'     => array(
//                        'Content-Type' => 'application/json',
//                        'Authorization' => 'apikey ' . $api_key
//                    )
//                );
//
//                if ( $body ) {
//                    $request_args['body'] = json_encode( $body );
//                }
//
//                $request = wp_remote_post( $url, $request_args );
//                $response = is_wp_error( $request ) ? false : json_decode( wp_remote_retrieve_body( $request ) );
//
//                return $response;
//            }
//
//            /**
//             * Create a MailChimp campaign with MailChimp API v3
//             *
//             * @param $list_id string Your List ID for this campaign
//             * @param $subject string The email subject line for this campaign
//             * @return mixed The campaign ID if it was successfully created, otherwise false.
//             */
//
//            function isa_create_mailchimp_campaign( $list_id, $subject ) {
//
//                // Configure --------------------------------------
//
//                $reply_to   = 'biswas.jayasree111@gmail.com';
//                $from_name  = 'Company';
//
//                // STOP Configuring -------------------------------
//
//                $campaign_id = '';
//
//                $body = array(
//                    'recipients'    => array('list_id' => $list_id),
//                    'type'          => 'regular',
//                    'settings'      => array('subject_line' => $subject,
//                        'reply_to'      => $reply_to,
//                        'from_name'     => $from_name
//                    )
//                );
//
//                $create_campaign = isa_mailchimp_api_request( 'campaigns', 'POST', $body );
//
//                if ( $create_campaign ) {
//                    if ( ! empty( $create_campaign->id ) && isset( $create_campaign->status ) && 'save' == $create_campaign->status ) {
//                        // The campaign id:
//                        $campaign_id = $create_campaign->id;
//                    }
//                }
//
//                return $campaign_id ? $campaign_id : false;
//
//            }
//
//            /**
//             * Set the HTML content for MailChimp campaign, given template sections, with MailChimp API v3
//             *
//             * @param $campaign_id string The Campaign ID
//             * @param $template_content array Template Content including the Template ID and Sections
//             *
//             * @return bool True if the content was set, otherwise false.
//             */
//
//            function isa_set_mail_campaign_content( $campaign_id, $template_content ) {
//                $set_content = '';
//                $set_campaign_content = isa_mailchimp_api_request( "campaigns/$campaign_id/content", 'PUT', $template_content );
//
//                if ( $set_campaign_content ) {
//                    if ( ! empty( $set_campaign_content->html ) ) {
//                        $set_content = true;
//                    }
//                }
//                return $set_content ? true : false;
//            }

//            require 'vendor/autoload.php';
//            use Mailgun\Mailgun;


                function send_simple_message()
                {
                    $ch = curl_init();
                    $api_key = get_option('api_key');
//                echo "api".$api_key;
                    $api_base_url = get_option('api_base_url');
//                echo "base url". $api_base_url;
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $api_key);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_URL,
                        $api_base_url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,
                        array('from' => get_option('admin_email'),
                            'to' => sanitize_email($_POST['email']),
                            'subject' => 'Thank you for contacting us.',
                            'text' => 'Your message is received and registered with us, soon our representative will get back to you.'));
                    $result = curl_exec($ch);
                    curl_close($ch);
                    return $result;
                }

                send_simple_message();

                function send_message()
                {
                    $ch = curl_init();
                    $api_key = get_option('api_key');
//                echo "admin api".$api_key;
                    $api_base_url = get_option('api_base_url');
//                echo "admin base url".$api_base_url;
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $api_key);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_URL,
                        $api_base_url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,
                        array('from' => 'Jayashree Biswas <jayshree.cumint@gmail.com>',
                            'to' => get_option('admin_email'),
                            'subject' => 'You got a new message',
                            'text' => 'We got a new message from customers.'));
                    $result = curl_exec($ch);
                    curl_close($ch);
                    return $result;
                }

                send_message();


//            require_once "PEAR/Mail.php";
//            $host = "smtp.mailgun.org";
//            echo $host;
//            $mgClient = new Mail('f929f856e700c6368207005a73704562-060550c6-bbfdd25b');
//            $domain = "sandbox372d13c48ee64adc81122892941aea81.mailgun.org";
//            $username = "postmaster@sandbox372d13c48ee64adc81122892941aea81.mailgun.org";
//            $password = "ea7e75284725ff38ec773b5bdefb6ddb-060550c6-56a5b97b";
//            $port = "587";
//            $recipients = sanitize_email($_POST['email']);
//            $email_from = "biswas.jayasree111@gmail.com";
//            echo $email_from;
//            $subject = "Awesome Subject line" ;
//            $body = "This is the message body" ;
//            $email_address = "jagpreet.singh@cuminttech.com";
//            echo $email_address;
//            $content = "text/html; charset=utf-8";
//            $mime = "1.0";
//            $headers = array ('From' => "jayashree".$email_from,
//                'To' => $recipients,
//                'Subject' => $subject,
//                'Reply-To' => $email_address,
//                'MIME-Version' => $mime,
//                'Content-type' => $content,
//                'Date'  => date("r"));
//            $params = array  ('debug'=>true,
//                'host' => $host,
//                'port' => $port,
//                'auth' => true,
//                'username' => $username,
//                'password' => $password);
//            $smtp = Mail::factory ('smtp', $params);
////            echo $smtp;
//            $mail = $smtp->send($recipients, $headers, $body);
//            echo $mail;
//            if (PEAR::isError($mail)) {
//                echo("<p>" . $mail->getMessage() . "</p>");
//            } else {
//                echo("<p>Message sent successfully!</p>");
//            }
//# Issue the call to the client.
//            $result = $mgClient->get("$domain/log", array(
//                'limit' => 5,
//                'skip'  => 10
//            ));
//echo $result;

//            echo "<script>alert('Your message has been sent successfully');</script>";
                echo '<div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                <strong>Successful!</strong> Thank you for your concern, our representative will get back to you.
                </div>';
//            add_filter ("wp_mail_content_type", "my_awesome_mail_content_type");
//            function my_awesome_mail_content_type() {
//                return "text/html";
//            }
//            $to = sanitize_email($_POST['email']); //sendto@example.com
//            echo $to;
//            $subject = 'The subject';
//            $body = 'The email body content';
//            $headers = array('Content-Type: text/html; charset=UTF-8');
////            wp_mail( $to, $subject, $body, $headers );
//            $mail_sent = wp_mail( $to, $subject, $body, $headers );
//            if ($mail_sent)
//            {
//                echo "<script>alert('sent')</script>";
//            }
//            else
//                echo "<script>alert('something went wrong.')</script>";
//            //To send email to admin
//            $to = get_option('admin_email');
//            echo $to;
//            $subject = 'The subject';
//            $message = 'The email body content';
//            $headers = array('Content-Type: text/html; charset=UTF-8');
//            wp_mail( $to, $subject, $message, '', array( '' ) );

// show wp_mail() errors
//            add_action( 'wp_mail_failed', 'onMailError', 10, 1 );
//            function onMailError( $wp_error ) {
//                echo "<pre>";
//                print_r($wp_error);
//                echo "</pre>";
//            }
            }

        }
        ?>
<!--        <head>-->
<!--            <title>Bootstrap Example</title>-->
<!--            <meta charset="utf-8">-->
<!--            <meta name="viewport" content="width=device-width, initial-scale=1">-->
<!--            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">-->
<!--            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<!--            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>-->
<!--            <meta name="viewport" content="width=device-width, initial-scale=1">-->
<!--            <style>-->
<!--                .alert {-->
<!--                    padding: 20px;-->
<!--                    background-color: #4CAF50;-->
<!--                    color: white;-->
<!--                }-->
<!---->
<!--                .closebtn {-->
<!--                    margin-left: 15px;-->
<!--                    color: white;-->
<!--                    font-weight: bold;-->
<!--                    float: right;-->
<!--                    font-size: 22px;-->
<!--                    line-height: 20px;-->
<!--                    cursor: pointer;-->
<!--                    transition: 0.3s;-->
<!--                }-->
<!---->
<!--                .closebtn:hover {-->
<!--                    color: black;-->
<!--                }-->
<!--            </style>-->
<!--        </head>-->
<!--        <body>-->
<!--        <div class="container">-->
<!--            <div class="container-fluid">-->
<!--                <h1>Contact Form hello</h1>-->
<!--            </div>-->
<!--            <div class="container-fluid">-->
<!--                <form name="contact_form" id="contact_form" method="post"-->
<!--                      action="--><?php //echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?><!--">-->
<!--                    <label for="name">Name:<strong>*</strong></label></br>-->
<!--                    <input type="text" class="form-control" name="name" id="name">-->
<!---->
<!--                    <label for="contact">Contact:<strong>*</strong></label></br>-->
<!--                    <input type="text" class="form-control" name="contact" id="contact">-->
<!---->
<!--                    <label for="email">Email ID:<strong>*</strong></label></br>-->
<!--                    <input type="text" class="form-control" name="email" id="email">-->
<!---->
<!--                    <label for="message">Message:<strong>*</strong></label></br>-->
<!--                    <textarea rows="6" col="70" class="form-control" name="message" id="message"></textarea>-->
<!---->
<!--                    <button type="submit" class="btn btn-success" name="submit" id="submit">Submit</button>-->
<!--                </form>-->
<!--            </div>-->
<!--        </div>-->
<!--        </body>-->
        <?php
    }
add_action( 'init', 'register_shortcodes');
    function register_shortcodes()
    {
        add_shortcode('contact_form', 'contact_page_shortcode');
    }


?>
