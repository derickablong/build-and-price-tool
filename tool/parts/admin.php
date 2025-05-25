<div class="wrap">
    <h1>Build and Price Tool Settings</h1>

    <div class="bpt-models con-w">
        <div class="model-form">
            <form method="post">                
                <div class="fields">
                    <div class="col">
                        <div class="field">
                            <span class="label">Photo</span>
                            <div class="photo">             
                                <?php if( $image = wp_get_attachment_image_url( $edit_model['image'], 'medium' ) ) : ?>    
                                <a href="#" class="rudr-upload">
                                    <img src="<?php echo esc_url( $image ) ?>" />
                                </a>
                                <a href="#" class="rudr-remove">Remove Photo</a>
                                <input type="hidden" name="model[image]" value="<?php echo absint( $edit_model['image'] ) ?>">
                                <?php else: ?>                            
                                <a href="#" class="button rudr-upload">Upload Photo</a>
                                <a href="#" class="rudr-remove" style="display:none">Remove Photo</a>
                                <input type="hidden" name="model[image]" value="">                            
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="field">
                            <span class="label">Sub Heading</span>
                            <input type="text" name="model[sub_title]" value="<?php echo trim($edit_model['sub_title']) ?>">
                        </div>
                        <div class="field">
                            <span class="label">Heading</span>
                            <input type="text" name="model[title]" value="<?php echo trim($edit_model['title']) ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="field description">
                            <span class="label">Description</span>
                            <textarea name="model[descriptions]"><?php echo trim($edit_model['descriptions']) ?></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="field">
                            <span class="label">Model URL</span>
                            <input type="text" name="model[url]" value="<?php echo trim($edit_model['url']) ?>">
                        </div>
                        <div class="field">
                            <span class="label">Price</span>
                            <input type="text" name="model[price]" value="<?php echo trim($edit_model['price']) ?>">
                        </div>
                    </div>
                </div>
                <div class="submit">
                    <div class="buttons">
                        <?php if (isset($_GET['model'])): ?> <a href="<?php echo admin_url('/admin.php?page=bpt') ?>" class="button black">Cancel</a> <?php endif; ?>
                        <button class="button"><?php echo isset($_GET['model']) ? 'Update Model' : 'Create Model' ?></button>
                    </div>
                </div>
            </form>
        </div>

        <?php if (!isset($_GET['model'])): ?>
        <div class="models">
            <?php 
            foreach ($models as $model):                                 
                do_action('bpt-admin-model', $model);
            endforeach; ?>
        </div>
        <?php endif; ?>

    </div>
</div>
<script>
jQuery(document).ready(function($) {
    $(document).on('click', '.see-more', function(e) {
        e.preventDefault();
        const $link = $(this);
        const $text = $link.prev();
        $text
            .addClass('text-collpse')
            .removeClass('text');
        $link
            .addClass('see-less')
            .removeClass('see-more')
            .text('See less');
    });
    $(document).on('click', '.see-less', function(e) {
        e.preventDefault();
        const $link = $(this);
        const $text = $link.prev();
        $text
            .addClass('text')
            .removeClass('text-collpse');
        $link
            .addClass('see-more')
            .removeClass('see-less')
            .text('See more');
    });
});
</script>