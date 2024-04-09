<form method="post" name="cleanup_options" action="">
<?php
$mlsimport->admin->setting_up();
$old_data   =   get_option('mlsimport_cron_logs');
print '<h1> Property Update logs</h1>';
global $wp_filesystem;
if (empty($wp_filesystem)) {
    require_once (ABSPATH . '/wp-admin/includes/file.php');
    WP_Filesystem();
}
$path = WP_PLUGIN_DIR . "/mlsimport/logs/cron_logs.log";
$file_size=filesize($path);


print 'Cron Log File Size is '.$file_size.' bytes</br></br>';
if($file_size<3000000){
    $myfile = fopen($path, "r") or die("Unable to open file!");
    if($file_size>0)    echo fread($myfile,$file_size);
    fclose($myfile);
}else{
    Print' The file is too large to be displayed. You can read it in mlsimport/logs/cron_logs.log';
}
?>      

</form>