<div class="col-sm-6 mx-auto text-center mb-5">
    <p class="text-primary">Preview your newsletter before sending</p>
    <span class="font-weight-bold"><-- EMAIL NEWSLETTER BEGIN --></span>
    <p><small><strong>Created:</strong> <?php echo $data['latest']->ns_created; ?></small></p>
</div>
<?php echo $data['latest']->ns_msg; ?>
<div class="col-sm-6 mx-auto mb-5 mt-5 text-center"><span class="font-weight-bold"><-- EMAIL NEWSLETTER END --></span></div>
<form action="<?php URLROOT; ?>/admins/sendNewsBulk" method="post">
    <div class="form-group">
        <input type="submit" value="Send" class="btn color-dark-green btn-block">
    </div>
</form>

