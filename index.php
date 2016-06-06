<?php
/*
Plugin Name: CallKeeper Widget for WordPress
Plugin URI: https://github.com/grubobeats/CallKeeper-plugin-for-Wordpress
Description: Integrate CallKeeper to WordPress
Author: Vladan Paunovic
Author URI: http://www.givemejobtoday.com/
Version: 1.0.0
*/
?>
<style>
    .ck_code {
        padding: 10px 10px;
        margin: 15px 0px;
        border: 1px solid black;
        width: 70%;
        background: #ffffff;
    }
    .ck_code_span {
        color: black;
        background: rgba(213, 78, 33, 0.25);
        padding: 1px 5px;
    }
    .ck_footer {
        text-align: right;
        padding: 0px 20px;
    }
    .ck_success {
        padding: 0 5px;
        background: #ADFFB3;
        width: 230px;
    }
</style>
<?php
add_action( 'admin_menu', 'my_plugin_menu' );
add_action( 'wp_footer', $function_to_add = 'add_callkeeper_to_footer', $priority = 10);

function add_callkeeper_to_footer(){
  $callkeeper_widget_hash = get_option( 'callkeeper_input' );
  if($callkeeper_widget_hash) {
      echo '<script type="text/javascript" src="//callkeeper.ru/modules/widget/db/?callkeeper_code=' . $callkeeper_widget_hash . '" charset="UTF-8"></script>
      <script type="text/javascript" src="//callkeeper.ru/modules/widget/callkeeper.js" charset="UTF-8"></script>';
  }
}

function my_plugin_menu() {
	add_options_page( 'CallKeeper Plugin Options', 'Callkeeper Plugin', 'manage_options', 'callkeeper-script', 'my_plugin_options' );
}

function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    $script_added_text = "";
    echo "<form method='POST' action='http://" . $_SERVER['SERVER_NAME'] . "/wp-admin/options-general.php?page=callkeeper-script'>";
	echo '<div class="wrap">';
	echo '<h3>CallKeeper Wordpress script plugin.</h3>';
	echo '</div>';
    ?>
    <p id="callkeeper-option">More about CallKeeper you can find <a href="http://callkeeper.ru">here</a></p>
    <p>Script can be found in your admin panel</p>
    <div class="ck_code">
        &lt;script&gt; type="text/javascript" src="//callkeeper.ru/modules/widget/db/?callkeeper_code=<span class="ck_code_span">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</span>" charset="UTF-8"&gt;&lt;/script&gt;<br>
&lt;script&gt; type="text/javascript" src="//callkeeper.ru/modules/widget/callkeeper.js" charset="UTF-8"&gt; &lt;/script&gt;
    </div>
    <?php $option = esc_html(get_option( 'callkeeper_input')); ?>
    <h3>Insert widget hash here: </h3>
    <input name="callkeeper_input" type="text" value="<?php echo $option ?>" size="80" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
    <input type="submit" value="Submit script" name="submit">
    <?php
    if (isset($_POST['submit'])) {
        update_option( 'callkeeper_input', $_POST['callkeeper_input']);
        $script_added_text = "Script successfully added to your site!";
    }
    echo "</form>";
    echo "<div class='ck_success'>" . $script_added_text . "</div>";
    ?>
    <hr>
    <p class="ck_footer">CallKeeper, All right reserved.</p>
    <?php
}
