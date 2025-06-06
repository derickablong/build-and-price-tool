<?php

namespace GO_BPT;

trait GO_BPT_Database
{
    public function create_table()
    {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        # BPT table for quote submition        
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_bpt} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,            
            token tinytext NOT NULL,
            model tinytext,
            products text,
            shipping VARCHAR(50),
            shipping_details text,
            date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        $this->generate($sql);

        # BTP table for models       
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_model} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,            
            sub_title VARCHAR(200) DEFAULT NULL,
            title VARCHAR(200) NOT NULL,
            image VARCHAR(50) NOT NULL DEFAULT 0,
            descriptions text DEFAULT NULL,
            price VARCHAR(100) DEFAULT 0,
            url tinytext DEFAULT NULL,
            date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        $this->generate($sql);

        # BTP table for model steps        
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_model_category} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            model_id mediumint(9) NOT NULL DEFAULT 0,            
            parent_category INT(5) NOT NULL DEFAULT 0,
            front_attachment VARCHAR(50),
            rear_attachment VARCHAR(50),
            upgrade VARCHAR(50),
            date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        $this->generate($sql);

        # BTP table for product attachments
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_attachment} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            model_id mediumint(9) NOT NULL DEFAULT 0,
            products VARCHAR(200),
            requirement mediumint(9) NOT NULL DEFAULT 0,
            date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        $this->generate($sql);
        
    }

    /**
     * Generate database table
     * @param string $sql
     * @return void
     */
    private function generate($sql)
    {
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

        $data = [
            'token'            => stripslashes($token),
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
                $this->table_bpt,
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

        return $wpdb->update(
            $this->table_bpt,
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
        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_bpt} WHERE token=%s",
                $token
            )
        );
    }
}