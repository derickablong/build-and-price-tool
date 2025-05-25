<?php

namespace GO_BPT;

trait GO_BPT_Admin 
{

    private function create_admin()
    {
        add_action(
            'admin_menu', [$this, 'admin_menu']
        );
        $this->submit_model();
        $this->submit_model_setup();
        $this->submit_attachments();
    }


    public function admin_menu()
    {
        add_menu_page(
            __( 'Build and Price Tool', 'go-bpt' ),
            __( 'Build and Price Tool', 'go-bpt' ),
            'manage_options',
            'bpt',
            [$this, 'admin_page'],
            'dashicons-admin-settings',
            2
        );
    }

    
    private function models()
    {
        global $wpdb;        
        return $wpdb->get_results("SELECT * FROM {$this->table_model}");
    }
    
    private function get_model($model_id)
    {
        global $wpdb;
        return $wpdb->get_row(
                $wpdb->prepare("SELECT * FROM {$this->table_model} WHERE id=%d", [$model_id]),
                ARRAY_A
            );
    }

    private function models_steps()
    {
        $setup  = [];
        $models = $this->models();
        foreach ($models as $model) {

            $model_item = $this->model_categories( $model->id );
            $setup[$model->title] = [
                'step-2' => [],
                'step-3' => $model_item['front_attachment'],
                'step-4' => $model_item['rear_attachment'],
                'step-5' => $model_item['upgrade']
            ];

        }

        return $setup;
    }

    public function admin_page()
    {
        global $wpdb;
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
        wp_enqueue_style('go-bpt-admin-css');
        wp_enqueue_script('go-bpt-admin-script');        

        $models = $wpdb->get_results("SELECT * FROM {$this->table_model}");
        $models = !is_array($models) ? [$models] : $models;

        $default_model = [
            'id'           => 0,
            'sub_title'    => '',
            'title'        => '',
            'descriptions' => '',
            'price'        => '',
            'url'          => '',
            'image'        => ''
        ];

        $edit_model         = isset($_GET['model']) ? $this->get_model($_GET['model']) : $default_model;
        $manage_model       = isset($_GET['manage-model']) ? $this->get_model($_GET['manage-model']) : $default_model;
        $product_attachment = isset($_GET['product-attachment']) ? $this->get_model($_GET['product-attachment']) : $default_model;

        do_action('bpt-admin', $models, $edit_model, $manage_model, $product_attachment);
    }


    private function model_categories($model)
    {
        global $wpdb;
        
        $model_id = is_array($model) ? $model['id'] : $model;

        $model_details = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_model_category} WHERE model_id=%d",
                [$model_id]
            ),
            ARRAY_A
        );        
        

        $parent_category = is_array($model_details) ? $model_details['parent_category'] : 0;
        $parent_category = isset($_GET['parent']) ? $_GET['parent'] : $parent_category;

        $all_terms = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => false ) );
        
        if ($parent_category == 0) {            
            foreach ($all_terms as $term) {
                if ($term->name == $model['title']) {
                    $parent_category = $term->term_id;
                    break;
                }
            }
        }
        
        $model_terms = get_terms( array( 'taxonomy' => 'product_cat', 'parent' => $parent_category, 'hide_empty' => false ) );

        $front_attachment = is_array($model_details) ? unserialize($model_details['front_attachment']) : [];
        $rear_attachment  = is_array($model_details) ? unserialize($model_details['rear_attachment']) : [];
        $upgrade          = is_array($model_details) ? unserialize($model_details['upgrade']) : [];

        return [
            'parent_category'  => $parent_category,
            'model_details'    => $model_details,
            'model_terms'      => $model_terms,
            'terms'            => $all_terms,
            'front_attachment' => $front_attachment,
            'rear_attachment'  => $rear_attachment,
            'upgrade'          => $upgrade
        ];
    }

    private function attachments($model)
    {
        global $wpdb;
        return $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$this->table_attachment} WHERE model_id=%d",
                [$model]
            )
        );
    }    

    private function has_attachment($model_id = 0)
    {
        global $wpdb;
        return is_array(
            $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT * FROM {$this->table_model_category} WHERE model_id=%d",
                    [$model_id]
                ),
                ARRAY_A
            )
        );
    }

    private function submit_model()
    {
        global $wpdb;
        if ((defined('DOING_AJAX') && DOING_AJAX)) return;
        if (!isset($_POST['model'])) return;

        $model = $_POST['model'];

        if (isset($_GET['model'])) {
            $wpdb->update(
                $this->table_model,
                $model,
                [
                    'id' => $_GET['model']
                ],
                [
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                ]
            );
            \wp_redirect( admin_url('/admin.php?page=bpt') );
            exit;
        } else {
            $wpdb->insert(
                $this->table_model,
                $model,
                [
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                ]
            );
        }        
    }

    private function submit_model_setup()
    {
        global $wpdb;

        if ((defined('DOING_AJAX') && DOING_AJAX)) return;
        if (!isset($_POST['manage-model'])) return;

        $model_id         = $_POST['manage-model'];
        $parent_category  = $_POST['parent-category'];
        $front_attachment = $_POST['front_attachment'];
        $rear_attachment  = $_POST['rear_attachment'];
        $upgrade          = $_POST['upgrade'];

        $model = [
            'model_id'         => $model_id,
            'parent_category'  => $parent_category,
            'front_attachment' => serialize($front_attachment),
            'rear_attachment'  => serialize($rear_attachment),
            'upgrade'          => serialize($upgrade)
        ];
        $format = ['%d', '%d', '%s', '%s', '%s'];
        
        $update = $wpdb->update(
            $this->table_model_category,
            $model,
            [
                'model_id' => $model_id
            ],
            $format
        );

        if (!$update) {
            $wpdb->insert(
                $this->table_model_category,
                $model,
                $format
            );
        }
    }

    private function submit_attachments()
    {
        global $wpdb;

        if ((defined('DOING_AJAX') && DOING_AJAX)) return;
        if (!isset($_POST['model-attachment'])) return;

        $model       = $_POST['model-attachment'];
        $attachments = $_POST['attachment-require'];

        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$this->table_attachment} WHERE model_id=%d",
                [$model]
            )
        );

        foreach ($attachments as $attachment) {

            $data = [
                'model_id' => $model,
                'attachment' => serialize($attachment)
            ];
            $format = ['%d', '%s'];

            $wpdb->insert(
                $this->table_attachment,
                $data,            
                $format
            );           

        }
    }

}