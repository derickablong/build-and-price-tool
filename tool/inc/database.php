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

        $data = [
            'token'            => $token,
            'model'            => json_encode($model),
            'products'         => json_encode($products),
            'shipping'         => $shipping_method,
            'shipping_details' => json_encode($shipping_details)
        ];
        $format = [
            '%s',
            '%s',
            '%s',
            '%s',
            '%s'
        ];

        $update = $this->update(
            $data, ['token' => $token], $format, ['%s']
        );

        if ($update === FALSE || $update < 1) {
            $wpdb->insert(
                $table_name,
                $data,
                $format
            );        
        }

        return $token;
    }

    /**
     * Update
     * @param array $data
     * @param array $where
     * @param array $format
     * @param array $con_format
     */
    public function update($data, $where, $format, $con_format)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bpt';        

        return $wpdb->update(
            $table_name,
            $data,
            $where,
            $format,
            $con_format
        );
    }

    /**
     * Get record
     * @param object $token
     */
    public function get($token)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'bpt';
        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$table_name} WHERE token=%s",
                $token
            )
        );
    }
}