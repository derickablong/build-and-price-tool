<div class="row-attachment group loading" data-group="<?php echo $index ?>">
    <div class="col">       
        <div class="title"></div>         
        <select name="attachment-require[a][]" class="attachment-require" multiple="multiple">                       
            <?php 
            $group = !empty($group) ? unserialize($group->attachment) : [];
            
            foreach ($attachments as $product_id => $product): ?>
                <option <?php echo in_array($product_id, $group) ? 'selected' : '' ?> value="<?php echo $product_id ?>"><?php echo $product ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col buttons">
        <div class="cta">
            <a href="#" class="remove">
                <svg height="30px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="30px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M256,32C132.3,32,32,132.3,32,256s100.3,224,224,224s224-100.3,224-224S379.7,32,256,32z M384,272H128v-32h256V272z"/></g></svg>
            </a>
            <a href="#" class="add">
                <svg height="30px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="30px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M256,32C132.3,32,32,132.3,32,256s100.3,224,224,224s224-100.3,224-224S379.7,32,256,32z M384,272H272v112h-32V272H128v-32   h112V128h32v112h112V272z"/></g></svg>
            </a>
        </div>
    </div>
</div>