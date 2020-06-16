<div id="page-content"><!-- Needed for sticky footer-->
    <main role="main">
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card card-body bg-light mb-5">
                    <?php echo flash('resume_message'); ?>
                    <h2>Add post</h2>
                    <?php echo flash_error('resume_errors'); ?>
                    <p>Please fill in all fields with <sub>*</sub></p>
                    <form action="<?php echo URLROOT; ?>/admins/addPost" class="icon-form process" enctype="multipart/form-data" method="post" novalidate>
                        <input type="hidden" name="token" value="<?php echo createToken(); ?>">
                        <div class="col-md-12 mb-3">
                            <label for="catId"><i class="far fa-flag formIcons"></i> Category: <sub>*</sub></label>
                            <select id="catId" name="catId" class="custom-select custom-select-lg mb-3 <?php echo (!empty($data['cat_err'])) ? 'is-invalid' : ''; ?>" required>
                                <option value="" selected>Select category</option>
                                <?php
                                if(is_array($data['categories'])) :
                                    foreach ($data['categories'] as $cat) : ?>
                                        <option value="<?php echo $cat->ps_cat_id; ?>"><?php echo $cat->ps_cat_name; ?></option>
                                    <?php endforeach;
                                endif;
                                ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $data['cat_err']; ?></span>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="psTitle"><i class="fas fa-signature formIcons"></i>
                                <span class="inline-span"> Title: <sub>*</sub></span></label>
                            <input id="psTitle" maxlength="100"
                                   class="form-control form-control-lg <?php echo (!empty($data['psTitle_err'])) ? 'is-invalid' : ''; ?>"
                                   name="psTitle"
                                   required
                                   type="text" value="<?php echo $data['psTitle']; ?>">
                            <span class="invalid-feedback"><?php echo $data['psTitle_err']; ?></span>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="psSubTitle"><i class="fas fa-signature formIcons"></i>
                                <span class="inline-span"> Sub Title: </span></label>
                            <input id="psSubTitle" maxlength="100"
                                   class="form-control form-control-lg"
                                   name="psSubTitle"
                                   type="text" value="<?php echo $data['psTitle']; ?>">
                        </div>

                          <div class="col-md-12 mb-3">
                              <label for="psPost"><i class="fas fa-user-secret formIcons"></i>
                                  <span class="inline-span eppMe"> Bio: (Minimum 100) <sub>*</sub></span></label>
                              <textarea id="psPost" name="psPost"
                                        class="form-control form-control-lg profile_form_bio addTinymce <?php echo (!empty($data['psPost_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['psPost']; ?></textarea>
                              <span class="invalid-feedback"><?php echo $data['psPost_err']; ?></span>
                          </div>
                            <?php
                            if (empty($data['postById']->ps_img)) {$setImg = "nologo.png";
                            } else {$setImg = $data['postById']->ps_img;}
                            ?>
                                <div class="col-md-12 mb-3">
                                    <?php if (!empty($data['postById']->ps_img)) : ?>
                                        <label for="sameFile"><i class="fab fa-wordpress formIcons mt-3"></i> <span class="inline-span">Feat. image: </span></label>
                                        <div class="userAvatar mt-3">
                                            <div class="custom-control custom-checkbox">
                                                <input id="removeLogo" class="custom-control-input" type="checkbox" value="1" name="noImg">
                                                <label for="removeLogo" class="custom-control-label" for="customCheck">Remove image</label>
                                            </div>
                                            <img class="img-fluid mx-auto d-block"
                                                 src="<?php echo URLROOT; ?>/storyImg/<?php echo $setImg; ?>">
                                        </div>
                                    <?php else: echo "Add featured image"; endif; ?>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="custom-file form-control-lg mb-2" id="customFile" lang="en">
                                        <label class="custom-file-label" for="exampleInputFile">
                                            <small>Upload image...</small>
                                        </label>
                                        <input name="post_img" type="file"
                                               class="custom-file-input <?php echo (!empty($data['img_err'])) ? 'is-invalid' : ''; ?>"
                                               aria-describedby="fileHelp">
                                        <span class="invalid-feedback"><?php echo $data['img_err']; ?></span>
                                    </div>

                                    <div class="form-group mt-4 mb-3">
                                        <input type="submit" value="Add" class="btn btn-primary btn-block">
                                    </div>
                                </div>
                    </form>
                </div>
            </div>
        </div>
        <?php require APPROOT . '/views/admins/inc/listPosts.php'; ?>
    </div>
</section>

    </main>
</div><!-- Page id ends sticky footer-->

