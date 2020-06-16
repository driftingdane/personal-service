<div class="card card-body bg-light mb-5">
    <?php
    if (empty($data['postById']->ps_img)) {$setImg = "nologo.png";
    } else {$setImg = $data['postById']->ps_img;}
    ?>
    <?php echo flash('resume_message'); ?>
<form action="<?php echo URLROOT . '/admins/uploadImg/' . $data['postById']->ps_slug; ?>" class="icon-form process"
      enctype="multipart/form-data" method="post" novalidate>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <input type="hidden" name="psId" value="<?php echo $data['postById']->ps_id; ?>">
    <input type="hidden" name="returnUrl" value="<?php echo basename($_SERVER['REQUEST_URI']) ?>">
    <input type="hidden" name="sameFile" value="<?php echo $data['postById']->ps_img; ?>">
    <input type="hidden" name="noFile" value="">
    <div class="form-row">
    <div class="col-md-6">
    <?php if (!empty($data['postById']->ps_img)) : ?>
        <label for="sameFile"><i class="fab fa-wordpress formIcons mt-3"></i> <span class="inline-span"><strong>Featured image: </strong></span></label>
        <div class="userAvatar mt-1">
            <img class="img-fluid mx-auto d-block" src="<?php echo URLROOT; ?>/storyImg/<?php echo $setImg; ?>">
        </div>
    <?php else: echo "Add featured image"; ?>
        <div class="userAvatar mt-1">
            <i class="far fa-image fa-10x text-muted"></i>
        </div>
       <?php endif; ?>
    </div>

<div class="col-md-6 mb-3 mt-5">
    <?php if (!empty($data['postById']->ps_img)) : ?>
    <div class="custom-control custom-checkbox">
        <input id="removeLogo" class="custom-control-input" type="checkbox" value="1" name="noImg">
        <label for="removeLogo" class="custom-control-label" for="customCheck">Remove image</label>
    </div>
    <?php endif; ?>
    <div class="custom-file form-control-lg mb-2" id="customFile" lang="en">
        <label class="custom-file-label" for="exampleInputFile">
            <small>Update image...</small>
        </label>
        <input name="post_img" type="file"
               class="custom-file-input <?php echo (!empty($data['img_err'])) ? 'is-invalid' : ''; ?>"
               aria-describedby="fileHelp">
        <span class="invalid-feedback"><?php echo $data['img_err']; ?></span>
    </div>
    <div class="form-group mt-1 mb-3">
        <input type="submit" value="Update" class="btn btn-primary btn-block">
    </div>
    <a class="btn btn-outline-secondary" target="_blank" href="<?php echo URLROOT . '/stories/show/' . $data['postById']->ps_slug . '/' . cleanerUrl($data['postById']->ps_title . ' ' . $data['postById']->ps_sub_title); ?>">See post live</a>
</div>
    </div>
</form>

</div>