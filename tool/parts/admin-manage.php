<?php $parent_category = $categories['parent_category']; ?>
<div class="wrap">    
    <h1>Manage <?php echo $model['title'] ?></h1>
    <div class="model-setup">
        <form method="post" action="">
            <input type="hidden" name="manage-model" value="<?php echo $model['id'] ?>">
            <input type="hidden" name="parent-category" value="<?php echo $parent_category ?>">
            <div class="parent-categoy">        
                <select id="parent-categories">
                    <option value="">----</option>
                    <?php foreach ($categories['terms'] as $term): ?>
                        <option <?php echo ($parent_category==$term->term_id ? 'selected' : '') ?> value="<?php echo admin_url('/admin.php?page=bpt&manage-model='.$model['id'].'&parent='.$term->term_id) ?>"><?php echo $term->name ?></option>
                    <?php endforeach; ?>
                </select>        
            </div>

            <div class="steps-categories con-w">

                <div class="col">
                    <div class="title">Front/Rear Mounting Options</div>

                    <div class="terms">
                        <div class="notes">The front/rear mounting options has a special setup. Click to see how to manage <a href="<?php echo $this->url ?>/tool/img/manage.jpg" target="_blank">here</a>.</div>
                    </div>
                </div>

                <div class="col">
                    <div class="title">Front Attachment</div>
                    
                    <div class="terms">
                    <?php foreach ($categories['model_terms'] as $term): ?>
                    <div class="term-item">
                        <div class="term-input">
                            <input type="checkbox" <?php echo in_array($term->term_id, $categories['front_attachment']) ? 'checked' : '' ?> name="front_attachment[]" value="<?php echo $term->term_id ?>" id="front_attachment-<?php echo $term->term_id ?>">
                        </div>
                        <label for="front_attachment-<?php echo $term->term_id ?>"><?php echo $term->name ?></label>
                    </div>
                    <?php endforeach; ?>
                    </div>

                </div>

                <div class="col">
                    <div class="title">Rear Attachment</div>

                    <div class="terms">
                    <?php foreach ($categories['model_terms'] as $term): ?>
                    <div class="term-item">
                        <div class="term-input">
                            <input type="checkbox" <?php echo in_array($term->term_id, $categories['rear_attachment']) ? 'checked' : '' ?> name="rear_attachment[]" value="<?php echo $term->term_id ?>" id="rear_attachment-<?php echo $term->term_id ?>">
                        </div>
                        <label for="rear_attachment-<?php echo $term->term_id ?>"><?php echo $term->name ?></label>
                    </div>
                    <?php endforeach; ?>
                    </div>
                </div>

                <div class="col">
                    <div class="title">Upgrade</div>

                    <div class="terms">
                    <?php foreach ($categories['model_terms'] as $term): ?>
                    <div class="term-item">
                        <div class="term-input">
                            <input type="checkbox" <?php echo in_array($term->term_id, $categories['upgrade']) ? 'checked' : '' ?> name="upgrade[]" value="<?php echo $term->term_id ?>" id="upgrade-<?php echo $term->term_id ?>">
                        </div>
                        <label for="upgrade-<?php echo $term->term_id ?>"><?php echo $term->name ?></label>
                    </div>
                    <?php endforeach; ?>
                    </div>
                </div>


            </div>

            <div class="cta con-w">
                <a href="<?php echo admin_url('/admin.php?page=bpt') ?>" class="button black">Back</a>
                <button class="button">Save Settings</button>
            </div>
        </form>
    </div>    
</div>
<script>
jQuery(document).ready(function($) {
    function checkbox() {
        $('.term-item').each(function() {
            $term = $(this);
            if ($term.find('input').is(':checked')) {
                $term.addClass('selected');
            } else {
                $term.removeClass('selected');
            }
        });
    }

    $('#parent-categories').on('change', function() {
        window.location = this.value;
    });

    $('.term-item input').on('change', checkbox);
    checkbox();
    
});
</script>