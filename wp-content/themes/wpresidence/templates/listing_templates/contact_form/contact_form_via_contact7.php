<?php
if (basename(get_page_template()) == 'contact_page.php') {
    echo do_shortcode($contact_form_7_contact);
} else {
    wp_reset_query();
    echo do_shortcode($contact_form_7_agent);
}
?>