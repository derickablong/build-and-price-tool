<?php $models = $this->models(); ?>
<?php foreach ($models as $model): ?>

    <div class="bpt-metabox-field">
        <span>
            <input type="checkbox" id="bpt_rear_mount_options_<?php echo $model->id ?>" name="bpt_rear_mount_options[]" value="<?php echo $model->title ?>" <?php echo in_array($model->title, $selected) ? 'checked':'' ?>>
        </span>
        <label for="bpt_rear_mount_options_1">
            <?php _e( $model->title, 'go-bpt' ); ?>
        </label>
    </div>

<?php endforeach; ?>

<style>
    .bpt-metabox-field {
        display: grid;
        grid-template-columns: 23px 1fr;
    }            
</style>