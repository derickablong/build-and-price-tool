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
            model tinytext,
            products text,
            shipping VARCHAR(50),
            shipping_details text,
            date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }

    /**
     * Record quote details
     * @param string $token
     * @param array $model
     * @param array $products
     * @param string $shipping_method
     * @param array $shipping_details
     * @return string
     */
    public function record($token = '', $model = array(), $products = array(), $shipping_method = '', $shipping_details = array())
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bpt';        
        $wpdb->insert(
            $table_name,
            [
                'token'            => $token,
                'model'            => json_encode($model),
                'products'         => json_encode($products),
                'shipping'         => $shipping_method,
                'shipping_details' => json_encode($shipping_details)
            ],
            [
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            ]
        );        

        return $token;
    }
}