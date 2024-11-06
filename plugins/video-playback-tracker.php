<?php
/*
Plugin Name: Video Playback Tracker
Description: Tracks video playback and save it to a custom database table.
Version: 1.0
Author: Ansis
*/

function create_video_playback_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'video_playback';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        video_url TEXT NOT NULL,
        start_time FLOAT NOT NULL,
        end_time FLOAT NOT NULL,
        referrer VARCHAR(255),
        user_id VARCHAR(255) NOT NULL,
        timestamp DATETIME NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

register_activation_hook(__FILE__, 'create_video_playback_table');

function add_video_playback_menu()
{
    add_menu_page(
        'Video Playback Tracker',
        'Video Playback Tracker',
        'manage_options',
        'video-playback-tracker',
        'display_video_playback_table',
        'dashicons-video-alt3',
        6
    );
}

add_action('admin_menu', 'add_video_playback_menu');

function display_video_playback_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'video_playback';

    $items_per_page = 20;

    $current_page = isset($_GET['paged']) ? absint($_GET['paged']) : 1;

    $offset = ($current_page - 1) * $items_per_page;

    $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY timestamp DESC LIMIT %d OFFSET %d", $items_per_page, $offset));

    $total_pages = ceil($total_items / $items_per_page);

    echo '<div class="wrap">';
    echo '<h1>Video Playback Tracker</h1>';

    if ($results) {
        echo '<table class="widefat fixed" cellspacing="0">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>User ID</th>';
        echo '<th>Start Time (sec)</th>';
        echo '<th>End Time (sec)</th>';
        echo '<th>Video URL</th>';
        echo '<th>Referrer</th>';
        echo '<th>Timestamp</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($results as $row) {
            echo '<tr>';
            echo '<td>' . esc_html($row->user_id) . '</td>';
            echo '<td>' . esc_html($row->start_time) . '</td>';
            echo '<td>' . esc_html($row->end_time) . '</td>';
            echo '<td>' . esc_html($row->video_url) . '</td>';
            echo '<td>' . esc_html($row->referrer) . '</td>';
            echo '<td>' . esc_html($row->timestamp) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '<div class="tablenav"><div class="tablenav-pages">';

        if ($total_pages > 1) {
            $page_links = paginate_links([
                'base' => add_query_arg('paged', '%#%'),
                'format' => '',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;',
                'type' => 'plain'
            ]);

            echo $page_links;
        }

        echo '</div></div>';
    } else {
        echo '<p>No video playback data found.</p>';
    }

    echo '</div>';
}

// Custom admin CSS for the table
function video_playback_admin_styles()
{
    echo '<style>
        .widefat {
            width: 100%;
            border: 1px solid #ccc;
            border-collapse: collapse;
        }
        .widefat th, .widefat td {
            padding: 10px;
            text-align: left;
        }
        .widefat th {
            background-color: #f9f9f9;
        }
        .widefat td {
            border-top: 1px solid #ddd;
        }
    </style>';
}
add_action('admin_head', 'video_playback_admin_styles');

add_action('wp_ajax_track_video_playback', 'handle_video_playback_data');

function handle_video_playback_data()
{
    $video_url = isset($_POST['video_url']) ? sanitize_text_field($_POST['video_url']) : '';
    $start_time = isset($_POST['start_time']) ? floatval($_POST['start_time']) : 0;
    $end_time = isset($_POST['end_time']) ? floatval($_POST['end_time']) : 0;
    $referrer = isset($_POST['referrer']) ? sanitize_text_field($_POST['referrer']) : '';
    $user_id = isset($_POST['user_id']) ? sanitize_text_field($_POST['user_id']) : '';

    if ($start_time === 0 && $end_time === 0) {
        wp_send_json_error('Invalid video playback times');
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'video_playback';

    $wpdb->insert(
        $table_name,
        [
            'video_url' => $video_url,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'referrer' => $referrer,
            'user_id' => $user_id,
            'timestamp' => current_time('mysql'),
        ],
        [
            '%s',
            '%f',
            '%f',
            '%s',
            '%s',
            '%s',
        ]
    );

    echo 'Video playback data received successfully';
    wp_die();
}

function enqueue_video_tracking_script()
{
    wp_enqueue_script('video-tracking', get_template_directory_uri() . '/dist/video-tracking.min.js', ['jquery'], null, true);
    wp_localize_script('video-tracking', 'ajaxurl', admin_url('admin-ajax.php'));
}

add_action('wp_enqueue_scripts', 'enqueue_video_tracking_script');
