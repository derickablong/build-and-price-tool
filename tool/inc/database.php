<?php

namespace GO_BPT;

trait GO_BPT_Database
{
    public function create_table()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'bpt';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,            
            token tinytext NOT NULL,
            quote_details text NOT NULL,
            date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }

    /**
     * Record quote details
     * @param array $quote_details
     * @return boolean
     */
    public function record($quote_details)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bpt';
        $token      = bin2hex(random_bytes(30));
        $wpdb->insert(
            $table_name,
            [
                'token'         => $token,
                'quote_details' => json_encode($quote_details)
            ],
            [
                '%s',
                '%s'
            ]
        );

        return $token;
    }
}