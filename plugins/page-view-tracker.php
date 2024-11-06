<?php
/*
Plugin Name: Page View Tracker
Description: Tracks page views and saves them to a custom database table.
Version: 1.0
Author: Ansis
*/

function create_page_view_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'page_views';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id bigint(20) UNSIGNED NULL,
        page_url text NOT NULL,
        timestamp datetime NOT NULL,
        user_ip varchar(100),
        browser_info text,
        device_info varchar(20),
        referrer text,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

register_activation_hook(__FILE__, 'create_page_view_table');

function record_page_view()
{
    if (current_user_can('administrator')) {
        return; // Do not log if the user is an admin
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'page_views';

    $user_id = get_user_id_from_cookie() ?: null;
    $page_url = esc_url_raw($_SERVER['REQUEST_URI']);
    $timestamp = current_time('mysql');
    $user_ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
    $browser_info = sanitize_text_field($_SERVER['HTTP_USER_AGENT']);
    $device_info = wp_is_mobile() ? 'Mobile' : 'Desktop';
    $referrer = isset($_SERVER['HTTP_REFERER']) ? esc_url_raw($_SERVER['HTTP_REFERER']) : null;

    $wpdb->insert(
        $table_name,
        [
            'user_id' => $user_id,
            'page_url' => $page_url,
            'timestamp' => $timestamp,
            'user_ip' => $user_ip,
            'browser_info' => $browser_info,
            'device_info' => $device_info,
            'referrer' => $referrer,
        ],
        [
            '%d',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
        ]
    );
}
add_action('wp', 'record_page_view');

function display_page_view_stats_page()
{
    global $wpdb;

    $items_per_page = 20;

    $current_page = isset($_GET['paged']) ? intval($_GET['paged']) : 1;

    $offset = ($current_page - 1) * $items_per_page;

    $total_views = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}page_views");

    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}page_views ORDER BY timestamp DESC LIMIT %d OFFSET %d",
            $items_per_page,
            $offset
        )
    );

    echo '<div class="wrap"><h1>Page View Stats</h1>';

    if ($results) {
        echo '<table class="widefat fixed" cellspacing="0">';
        echo '<thead>
                <tr>
                    <th class="manage-column column-columnname" scope="col">User ID</th>
                    <th class="manage-column column-columnname" scope="col">Referrer</th>
                    <th class="manage-column column-columnname" scope="col">Page URL</th>
                    <th class="manage-column column-columnname" scope="col">Timestamp</th>
                    <th class="manage-column column-columnname" scope="col">Browser</th>
                    <th class="manage-column column-columnname" scope="col">Device</th>
                    <th class="manage-column column-columnname" scope="col">User IP</th>
                </tr>
              </thead>';
        echo '<tbody>';

        foreach ($results as $view) {
            echo '<tr>';
            echo '<td>' . esc_html($view->user_id) . '</td>';
            echo '<td>' . esc_html($view->referrer) . '</td>';
            echo '<td>' . esc_html($view->page_url) . '</td>';
            echo '<td>' . esc_html($view->timestamp) . '</td>';
            echo '<td>' . esc_html($view->browser_info) . '</td>';
            echo '<td>' . esc_html($view->device_info) . '</td>';
            echo '<td>' . esc_html($view->user_ip) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        $total_pages = ceil($total_views / $items_per_page);
        $pagination = paginate_links([
            'total' => $total_pages,
            'current' => $current_page,
            'base' => add_query_arg('paged', '%#%'),
            'format' => '',
            'prev_text' => '&laquo; Previous',
            'next_text' => 'Next &raquo;',
        ]);

        echo '<div class="pagination">' . $pagination . '</div>';
    } else {
        echo '<p>No page views recorded.</p>';
    }

    echo '</div>';
}

function register_page_view_stats_menu()
{
    add_menu_page(
        'Page View Stats',
        'Page View Stats',
        'manage_options',
        'page-view-stats',
        'display_page_view_stats_page',
        'dashicons-visibility',
        26
    );
}
add_action('admin_menu', 'register_page_view_stats_menu');

function get_user_id_from_cookie()
{
    if (isset($_COOKIE['user_id'])) {
        return $_COOKIE['user_id'];
    }
    global $wpdb;
    $highest_id = $wpdb->get_var("SELECT MAX(user_id) FROM {$wpdb->prefix}page_views");

    $user_id = $highest_id ? intval($highest_id) + 1 : 1;

    setcookie('user_id', $user_id, time() + 365 * 24 * 60 * 60, COOKIEPATH, COOKIE_DOMAIN); // 1 year
    return $user_id;
}
