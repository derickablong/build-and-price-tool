<?php $models = $this->models(); ?>
<div class="step step-1">
    <?php 
    foreach ($models as $model): 
        $image_url = wp_get_attachment_image_url( $model->image, 'medium' );
    ?>

	<div class="model-item model-<?php echo sanitize_title($model->title) ?>">
        <div class="pic">
            <img src="<?php echo $image_url ?>" alt="">
        </div>
        
        <div class="description">
            <h2>
                <?php if ($model->sub_title): ?>
                <span><?php echo $model->sub_title ?></span>
                <?php endif; ?>
                <?php echo $model->title ?>
            </h2>
            <p><?php echo trim($model->descriptions) ?></p>
        </div>
        <div class="cta">
            <h3>Prices Starting From <span class="start-price num">$<?php echo $model->price ?></span></h3>

            <?php 
            do_action('bpt-model-attachments', $model);

            do_action(
                'bpt-model-cta', 
                $model->url, 
                $model->title,
                str_replace(',', '', $model->price),
                0
            ); 
            ?>
        </div>
    </div>

    <?php endforeach; ?>
</div>