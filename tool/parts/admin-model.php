<?php $image_url = wp_get_attachment_image_url( $model->image, 'medium' ); ?>
<div class="model-item">
    <div class="col">
        <?php if ((int)$model->image): ?>
            <div class="photo">
                <img src="<?php echo $image_url ?>" alt="">
            </div>
        <?php endif; ?>
    </div>
    <div class="col">
        <?php if (!empty(trim($model->sub_title))): ?>
        <div class="sub-title"><?php echo trim($model->sub_title) ?></div>
        <?php endif; ?>
        <div class="title">
            <a href="<?php echo $model->url ?>" target="_blank"><?php echo $model->title ?></a>
        </div>
    </div>
    <div class="col">
        <div class="description">
            <span class="text"><?php echo trim($model->descriptions) ?></span> <a href="#" class="see-more">See more</a>
        </div>
    </div>
    <div class="col">
        <div class="price">$<?php echo trim($model->price) ?></div>
        <div class="cta">                        
            <a href="<?php echo admin_url('/admin.php?page=bpt&manage-model='.$model->id) ?>" class="button">Product Attachments</a>
            <a href="<?php echo admin_url('/admin.php?page=bpt&manage-model='.$model->id) ?>" class="button">Manage Steps</a>                        
            <a href="<?php echo admin_url('/admin.php?page=bpt&model='.$model->id) ?>" class="button">Edit Model</a>
        </div>
    </div>
</div>