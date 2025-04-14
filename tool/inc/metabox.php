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
				__( 'Build and Price Tool', 'go-bpt' ),
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
		?>		
        <div class="bpt-metabox-field">
            <span>
                <input type="checkbox" id="bpt_rear_mount_options" name="bpt_rear_mount_options" value="1" <?php echo $selected ? 'checked':'' ?>>
            </span>
            <label for="bpt_rear_mount_options">
                <?php _e( 'Show product on Front/Rear Mounting Options', 'go-bpt' ); ?>
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