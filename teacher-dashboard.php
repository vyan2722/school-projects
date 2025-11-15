<?php
/*
Plugin Name: Teacher Dashboard (Simple)
Description: A simple dashboard for teachers to view and manage their assigned classes.
Version: 1.2
Author: Your Name
*/

// Add menu page for teachers
add_action('admin_menu', function () {
    add_menu_page(
        'Teacher Dashboard',
        'Teacher Dashboard',
        'read',
        'teacher-dashboard',
        'teacher_dashboard_page',
        'dashicons-welcome-learn-more',
        3
    );
});

function teacher_dashboard_page() {
    $current_user = wp_get_current_user();
    echo "<div class='wrap'><h1>Teacher Dashboard</h1>";
    echo "<p>Welcome, {$current_user->display_name} (ID: {$current_user->ID})</p>";

    // Get classes assigned to this teacher (using ACF field)
    $args = array(
        'post_type' => 'classes',
        'posts_per_page' => -1,
        'meta_query' => array(
    array(
        'key' => 'assigned_teacher',
        'value' => $current_user->ID,
        'compare' => '='
    )
)

    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo "<h2>Your Classes:</h2><ul>";
        while ($query->have_posts()) {
            $query->the_post();
            echo "<li><strong>" . get_the_title() . "</strong></li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No classes assigned to you.</p>";
    }

    wp_reset_postdata();
    echo "</div>";
}
