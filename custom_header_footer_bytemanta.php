<?php
/*
  Plugin Name: Custom Header Footer By ByteMantra
  Version:     1.0
  Plugin URI:  http://bytemantra.com/custom-header-footer-content-wordpress-plugin/
  Description: It helps you to customize the footer of your theme. Its very easy to use.
  Author:      Kunal Pawar
  Author URI:  http://bytemantra.com/
 */

if (!defined('ABSPATH'))
    die("You don't have access.");

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
    exit;
}

// add a menu in admin
add_action('admin_menu', 'bytemantra_custom_header_footer_admin');

function bytemantra_custom_header_footer_admin() {
    add_submenu_page('options-general.php', 'Custom Footer', 'Custom Header Footer Content', 'manage_options', 'custom_header_footer_bytemantra', 'admin_custom_header_footer_bytemantra');
}

function admin_custom_header_footer_bytemantra() {
    include_once 'style.php';
    $msg = '';
    if (isset($_POST['submit-header-footer'])) {
        $content_footer = $_POST['custom_footer_content'];
        $content_header = $_POST['custom_header_content'];

        $status_header = $_POST['custom_header_content_status'];
        $status_footer = $_POST['custom_footer_content_status'];

        $priority_header = $_POST['custom_header_content_priority'];
        $priority_footer = $_POST['custom_footer_content_priority'];

        $nonce = $_POST['nonce'];
        if (wp_verify_nonce($nonce, 'custom-footer-content')) {
            update_option('custom_header_content_bytemantra', $content_header);
            update_option('custom_footer_content_bytemantra', $content_footer);
            update_option('custom_header_content_status_bytemantra', $status_header);
            update_option('custom_footer_content_status_bytemantra', $status_footer);
            update_option('custom_header_content_priority_bytemantra', $priority_header);
            update_option('custom_footer_content_priority_bytemantra', $priority_footer);

            $msg = 'Settings have been saved.';
        }
    }

    $content_header = get_option('custom_header_content_bytemantra');
    $status_header = get_option('custom_header_content_status_bytemantra');
    $priority_header = get_option('custom_header_content_priority_bytemantra');

    $content_footer = get_option('custom_footer_content_bytemantra');
    $status_footer = get_option('custom_footer_content_status_bytemantra');
    $priority_footer = get_option('custom_footer_content_priority_bytemantra');
   
    if ($status_header == '1') {
        $enable_header = 'checked';
    } else {
        $enable_header = '';
    }

    if ($status_footer == '1') {
        $enable_footer = 'checked';
    } else {
        $enable_footer = '';
    }

    $nonce = wp_create_nonce('custom-footer-content');
    ?>
    <div id="btmntra_custom_hf">
        <div class="left">
            <p class="welcome"> Welcome to Custom Header Footer Content by ByteMantra</p>
    <?php if (!empty($msg)): ?>
                <div class="msg"><?php echo $msg; ?></div>
    <?php endif; ?>
            <div class="form">
                <form method='post'>

                    <p class="head">Header Content Settings</p>
                    <input type="hidden" name="nonce" value="<?php echo $nonce; ?>">
                    <div class="input-div">
                        <label>Enable</label><input type="checkbox" value="1"name="custom_header_content_status" <?php echo $enable_header; ?>>
                    </div>
                    <div class="input-div"><label>Content Priority </label><input type="text" name="custom_header_content_priority" value="<?php echo $priority_header; ?>">
                        <span>* Higher the number lower will be the priority. Means if you want this content to be appended in the last then enter the bigger integer. (Default = 100).</span>
                    </div>
                    <div class="input-div">
                        <label>Header Content</label>
                     </div>   
                    
                    <div class="input-div">
                        <textarea class="wp-editor-area" name="custom_header_content"><?php echo $content_header; ?></textarea>
                    </div>
                   
                    <p class="head">Footer Content Settings</p>
                    <div class="input-div">
                        <label>Enable</label><input type="checkbox" value="1"name="custom_footer_content_status" <?php echo $enable_footer; ?>>
                    </div> 
                    <div class="input-div">
                        <label>Content Priority </label><input type="text" name="custom_footer_content_priority" value="<?php echo $priority_footer; ?>">
                        <span>* Higher the number lower will be the priority. Means if you want this content to be appended in the last then enter the bigger integer. (Default = 100).</span>   
                    </div> 
                    <div class="input-div">
                        <label>Footer Content</label>
                    </div>
                    <div class="input-div">
                        <textarea class="wp-editor-area" name="custom_footer_content"><?php echo $content_footer; ?></textarea>
                    </div>
                    <div class="input-div">
                        <input class="submit"type="submit" name="submit-header-footer" value="Save Settings">
                    </div>
                </form>
            </div>      

        </div>


        <div class="right">

        </div>   


    </div> 
    <?php
}

// add content to head
$priority_header = get_option('custom_header_content_priority_bytemantra');
if (!ctype_digit($priority_header)) {
    $priority_header = '100';
}

add_action('wp_head', 'bytemantra_custom_header', $priority_header);

function bytemantra_custom_header() {
    $status_header = get_option('custom_header_content_status_bytemantra');
    if ($status_header == '1') {
        echo get_option('custom_header_content_bytemantra');
    }
}

// add content to footer
$priority_footer = get_option('custom_footer_content_priority_bytemantra');
if (!ctype_digit($priority_footer)) {
    $priority_footer = '100';
}
add_action('wp_footer', 'bytemantra_custom_footer', $priority_footer);

function bytemantra_custom_footer() {
    $status_footer = get_option('custom_footer_content_status_bytemantra');
    if ($status_footer == '1') {
        $content = get_option('custom_footer_content_bytemantra');
        echo $content;
    }
}