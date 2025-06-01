<script>
var temp_attachment = [];
var new_attachment = [];
<?php 
foreach ($attachments as $attachment) {
    $products = unserialize($attachment->products);    
    echo 'temp_attachment.push({ID: parseInt('.$attachment->requirement.'), group:'. json_encode($products) .'});';
}
?>

jQuery.each(temp_attachment, function(_index, _item) {
    var ID = _item.ID;
    var temp_group = _item.group;
    var group = temp_group.map(function(product) {
        return parseInt(product);
    });
    new_attachment.push({
        ID: ID,
        group:group
    });
});

BPT_ATTACHMENTS.push({    
    model      : '<?php echo $model->title ?>',
    attachments: new_attachment
});
</script>