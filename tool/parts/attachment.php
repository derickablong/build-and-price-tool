<script>
var temp_attachment = [];
<?php 
foreach ($attachments as $attachment) {

    $details = unserialize($attachment->attachment);    

    echo 'temp_attachment.push('. json_encode($details) .');';
}
?>
BPT_ATTACHMENTS.push({
    model : '<?php echo $model->title ?>',
    attachments: temp_attachment
});
</script>