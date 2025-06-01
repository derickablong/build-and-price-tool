<script>
var temp_attachment = [];
<?php 
foreach ($attachments as $attachment) {

    $products = unserialize($attachment->products);    

    echo 'temp_attachment.push({ID: '.$attachment->requirement.', group:'. json_encode($products) .'});';
}
?>
BPT_ATTACHMENTS.push({    
    model : '<?php echo $model->title ?>',
    attachments: temp_attachment
});
</script>