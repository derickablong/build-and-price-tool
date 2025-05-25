<?php

namespace GO_BPT;

trait GO_BPT_Metabox
{
    public function metabox()
    {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post', array( $this, 'save_metabox') );
    }

    public function add_meta_box( $post_type ) {		
		if ( $post_type == 'product' ) {
			add_meta_box(
				'bpt_metabox',
				__( 'Front/Rear Mounting Options', 'go-bpt' ),
				array( $this, 'render_meta_box_content' ),
				$post_type,
				'advanced',
				'high'
			);
		}
	}

    public function render_meta_box_content( $post ) {		
		wp_nonce_field( 'bpt_custom_metabox', 'bpt_custom_metabox_nonce' );
		
		$selected = get_post_meta( $post->ID, $this->meta_box_key, true );		
		if (!is_array($selected)) {
			$selected = [];
		}
		?>		
        <div class="bpt-metabox-field">
            <span>
                <input type="checkbox" id="bpt_rear_mount_options_1" name="bpt_rear_mount_options[]" value="B-SERIES" <?php echo in_array('B-SERIES', $selected) ? 'checked':'' ?>>
            </span>
            <label for="bpt_rear_mount_options_1">
                <?php _e( 'B-SERIES', 'go-bpt' ); ?>
            </label>
        </div>
        <div class="bpt-metabox-field">
            <span>
                <input type="checkbox" id="bpt_rear_mount_options_2" name="bpt_rear_mount_options[]" value="S-SERIES" <?php echo in_array('S-SERIES', $selected) ? 'checked':'' ?>>
            </span>
            <label for="bpt_rear_mount_options_2">
                <?php _e( 'S-SERIES', 'go-bpt' ); ?>
            </label>
        </div>
		<div class="bpt-metabox-field">
            <span>
                <input type="checkbox" id="bpt_rear_mount_options_3" name="bpt_rear_mount_options[]" value="MH4900" <?php echo in_array('MH4900', $selected) ? 'checked':'' ?>>
            </span>
            <label for="bpt_rear_mount_options_3">
                <?php _e( 'MH4900', 'go-bpt' ); ?>
            </label>
        </div>
		<div class="bpt-metabox-field">
            <span>
                <input type="checkbox" id="bpt_rear_mount_options_4" name="bpt_rear_mount_options[]" value="MH8500" <?php echo in_array('MH8500', $selected) ? 'checked':'' ?>>
            </span>
            <label for="bpt_rear_mount_options_4">
                <?php _e( 'MH8500', 'go-bpt' ); ?>
            </label>
        </div>
        <style>
            .bpt-metabox-field {
                display: grid;
                grid-template-columns: 23px 1fr;
            }            
        </style>
		<?php
	}

    public function save_metabox( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['bpt_custom_metabox_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['bpt_custom_metabox_nonce'];
		
		if ( ! wp_verify_nonce( $nonce, 'bpt_custom_metabox' ) ) {
			return $post_id;
		}		
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}				
		
		$data = $_POST['bpt_rear_mount_options'];
		
		update_post_meta( $post_id, $this->meta_box_key, $data );
	}
}