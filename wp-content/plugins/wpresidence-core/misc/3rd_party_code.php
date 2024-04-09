<?php
function wpestate_core_add_to_footer(){
    $ga =esc_html(wpresidence_get_option('wp_estate_google_analytics_code', ''));
    if ($ga != '') { ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '<?php echo esc_html($ga); ?>');
        </script>

    <?php } 
}

