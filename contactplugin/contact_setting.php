<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2/9/2019
 * Time: 12:04 PM
 */
//echo "test setting";
if ($_POST['contact_setting_hidden'] == 'Y') {
    //Form data sent

    $api_key = $_POST['api_key'];
    update_option('api_key', $api_key);

    $api_base_url = $_POST['api_base_url'];
    update_option('api_base_url', $api_base_url);



    ?>
    <div class="updated"><p><strong><?php _e('Options saved.'); ?></strong></p></div>
    <?php

} else {
    //Normal page display

    $api_key = get_option('api_key');
    $api_base_url = get_option('api_base_url');

}

// update_option('page_id', 2);
//if (isset($_POST['pageArray'])) {
//
//    // Create an empty array. This is the one we'll eventually store.
//    $arr_store_me = array();
//
//    // Create a "whitelist" of posted values (field names) you'd like in your array.
//    // The $_POST array may contain all kinds of junk you don't want to store in
//    // your option, so this helps sort that out.
//    // Note that these should be the names of the fields in your form.
//
//    $page_inputs = $_POST['pageArray'];
//    // Loop through the $_POST array, and look for items that match our whitelist
//    foreach ($page_inputs as $key => $value) {
//
//        if (in_array($value, $page_inputs)) {
//
//            if ($value != 0) {
//                $arr_store_me[$key] = $value;
//            }
//        }
//
//    }
//
//    // Now we have a final array we can store (or use however you want)!
//    // Update option accepts arrays--no need
//    // to do any other formatting here. The values will be automatically serialized.
//
//    update_option('pg_id_cumint', $arr_store_me);
//
//}

?>
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<div class="wrap">
    <?php echo "<h2>" . __('Contact Form Setting', 'hotel') . "</h2>"; ?>

    <form name="setting_form" id="setting_form" method="post"
          action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="contact_setting_hidden" value="Y">
        <?php echo "<h4>" . __('Contact Form Email Settings', 'hotel') . "</h4>"; ?>
        <p><?php _e("API Key: "); ?><input type="text" name="api_key" value="<?php echo $api_key; ?>"
                                           style="width: 400px;"><?php _e(" ex: f929f85........0c6-bbfdd25b"); ?></p>
        <p><?php _e("API Base URL: "); ?><input type="text" name="api_base_url" value="<?php echo $api_base_url; ?>"
            style="width: 600px;"><?php _e(" ex: https://api.mailgun.net/v3/sandbo......a81.mailgun.org/messages"); ?></p>
<p><b>Note:</b>In the API base Url at the end of the url you will have to add "/messages" only then it will work.</p>

        <hr/>


        <p class="submit">
            <input type="submit" name="Submit" id="submit" value="<?php _e('Save Changes', 'hotel') ?>"/>
        </p>
    </form>
</div>