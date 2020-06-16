<div id="page-content"><!-- Needed for sticky footer-->
    <main role="main">
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-5">
                            <?php $data['_err'] = 'Please fill in required details'; ?>
                            <div class="profileCard-heading text-center"><?php echo $data['title']; ?></div>
                            <div class="tagGroup-wrapper">
                                <div class="tag">
                                    <div class="tag-experience">
                                    </div>
                                    <div class="">
                                        <div class="tag-label mb-1 font-weight-bold"><span>Site</span></div>
                                        <div class="userPosition mb-3">
                                            <span>
                                             <?php echo $data['siteName']; ?>
                                            </span>
                                            <?php if (empty($data['siteName'])) : ?>
                                            <span class="text-danger"><?php echo $data['siteName_err']; ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>Description</span></div>
                                        <div class="userPosition mb-3"><span><?php echo $data['siteDesc']; ?></span>
                                            <?php if (empty($data['siteDesc'])) : ?>
                                                <span class="text-danger"><?php echo $data['siteDesc_err']; ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>About</span></div>
                                        <div class="userPosition mb-3"><span><?php echo $data['siteAbout']; ?></span>
                                        </div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>Welcome</span></div>
                                        <div class="userPosition mb-3"><span><?php echo $data['siteWelcome']; ?></span>
                                        </div>


                                        <div class="tag-label mb-1 font-weight-bold"><span>Keywords</span></div>
                                        <div class="userPosition mb-3">
                                            <span><?php echo $data['siteKeywords']; ?></span></div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>Contact Name</span></div>
                                        <div class="userPosition mb-3">
                                            <span><?php echo $data['siteContactName']; ?></span>
                                        </div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>Contact Mail</span></div>
                                        <div class="userPosition mb-3">
                                            <span><?php echo $data['siteContactMail']; ?></span>
                                            <?php if (empty($data['siteContactMail'])) : ?>
                                            <span class="text-danger"><?php echo $data['siteContactMail_err']; ?></span>]
                                            <?php endif; ?>
                                        </div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>Contact Address</span></div>
                                        <div class="userPosition mb-3">
                                            <span><?php echo $data['siteContactAdd']; ?></span>
                                        </div>


                                        <div class="tag-label mb-1 font-weight-bold"><span>Contact Number</span></div>
                                        <div class="userPosition mb-3">
                                            <span><?php echo $data['siteContactNum']; ?></span>
                                        </div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>Contact Info</span></div>
                                        <div class="userPosition mb-3">
                                            <span><?php echo $data['siteContactInfo']; ?></span>
                                        </div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>Logo</span></div>
                                        <div class="userPosition mb-3">
                                            <?php
                                            if(empty($data['siteLogo'])) { $setImg = "nologo.png"; } else { $setImg = $data['siteLogo']; }
                                            if (empty($data['siteLogo'])) : ?>
                                                <span class="text-danger"><?php echo $data['siteLogo_err']; ?></span>
                                            <?php endif; ?>
                                            <div class="userAvatar mt-3">
                                                <img width="100" class="mx-auto d-block"
                                                     src="<?php echo URLROOT; ?>/img/<?php echo $setImg; ?>">
                                            </div>
                                        </div>
                                        <div class="tag-label  mb-1 font-weight-bold"><span>Last updated</span></div>
                                        <div class="userPosition mb-3">
                                            <span><?php echo infoDate($data['siteCreated']); ?></span></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card card-body bg-light mb-5"><?php echo flash('resume_message'); ?>
                            <h2><span class="text-info">Edit</span> site</h2>
                            <p>Please fill in all fields with <sub>*</sub></p>
                            <form class="icon-form" action="<?php echo URLROOT; ?>/admins/site" enctype="multipart/form-data" method="post">
                                <input type="hidden" name="site_id" value="<?php echo $data['siteId']; ?>">
                                <div class="form-group">
                                    <label for="site_name">
                                        <i class="far fa-copyright formIcons"></i> <span class="inline-span">Site: <sub>*</sub></span></label>
                                    <input type="text" name="site_name"
                                           class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?> "
                                           value="<?php echo $data['siteName']; ?>" placeholder="Site name" required>
                                    <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="site_desc">
                                        <i class="far fa-question-circle formIcons"></i> <span class="inline-span">Description: (SEO purposes only) <sub>*</sub></span></label>
                                    <textarea type="text" name="site_desc" placeholder="Description"
                                           class="form-control form-control-lg profile_form_bio <?php echo (!empty($data['desc_err'])) ? 'is-invalid' : ''; ?> " required><?php echo $data['siteDesc']; ?></textarea>
                                    <span class="invalid-feedback"><?php echo $data['desc_err']; ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="site_about">
                                        <i class="far fa-question-circle formIcons"></i> <span class="inline-span">About: (About page)</span></label>
                                    <textarea type="text" name="site_about" placeholder="About" class="form-control form-control-lg profile_form_bio"><?php echo $data['siteAbout']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="site_welcome">
                                        <i class="fas fa-signature formIcons"></i> <span class="inline-span">Welcome: (Front page)</span></label>
                                    <textarea type="text" name="site_welcome" placeholder="Welcome" class="form-control form-control-lg profile_form_bio"><?php echo $data['siteWelcome']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="site_keywords">
                                        <i class="fas fa-signature formIcons"></i> <span class="inline-span">Keywords: (SEO purposes only)</span></label>
                                    <textarea type="text" name="site_keywords" placeholder="Keywords" class="form-control form-control-lg profile_form_bio"><?php echo $data['siteKeywords']; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="site_contact_name">
                                        <i class="far fa-id-badge formIcons"></i> <span class="inline-span">Contact Name: </span></label>
                                    <input type="text" name="site_contact_name" placeholder="Contact name" class="form-control form-control-lg"
                                           value="<?php echo $data['siteContactName']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="site_contact_num">
                                        <i class="fas fa-at formIcons"></i> <span class="inline-span">Contact Mail: <sub>*</sub></span></label>
                                    <input type="text" name="site_contact_mail" class="form-control form-control-lg <?php echo (!empty($data['mail_err'])) ? 'is-invalid' : ''; ?>"
                                           value="<?php echo $data['siteContactMail']; ?>" placeholder="Contact mail" required>
                                    <span class="invalid-feedback"><?php echo $data['mail_err']; ?></span>
                                </div>

                                <div class="form-group">
                                    <label for="site_contact_num">
                                        <i class="fab fa-whatsapp formIcons"></i> <span class="inline-span">Contact number: </span></label>
                                    <input type="text" name="site_contact_num" class="form-control form-control-lg"
                                           value="<?php echo $data['siteContactNum']; ?>" placeholder="Contact number">
                                </div>

                                <div class="form-group">
                                    <label for="site_contact_info">
                                        <i class="fas fa-info formIcons"></i> <span class="inline-span">Contact Info: </span></label>
                                    <input type="text" name="site_contact_info" placeholder="contact text" class="form-control form-control-lg"
                                           value="<?php echo $data['siteContactInfo']; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="site_contact_add">
                                        <i class="far fa-address-book formIcons"></i> <span class="inline-span">Contact Address: </span></label>
                                    <input type="text" name="site_contact_add" class="form-control form-control-lg"
                                           value="<?php echo $data['siteContactAdd']; ?>" placeholder="Contact address">
                                </div>

                                <label for="sameFile">
                                    <i class="fab fa-wordpress formIcons mt-3"></i> <span class="inline-span">Logo: </span></label>
                                <input type="hidden" name="sameFile" value="<?php echo $data['siteLogo']; ?>">
                                <input type="hidden" name="noFile" value="">
                                <div class="custom-file form-control-lg mb-2" id="customFile" lang="en">
                                    <label class="custom-file-label" for="exampleInputFile">
                                        <small>Upload logo...</small>
                                    </label>

                                    <input name="site_logo" type="file"
                                           class="custom-file-input <?php echo (!empty($data['logo_err'])) ? 'is-invalid' : ''; ?>"
                                           aria-describedby="fileHelp">
                                    <span class="invalid-feedback"><?php echo $data['logo_err']; ?></span>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <?php if (!empty($data['siteLogo'])) : ?>
                                            <input id="removeLogo" class="custom-control-input" type="checkbox" value="1" name="noImg">
                                            <label for="removeLogo" class="custom-control-label" for="customCheck">Remove logo</label>
                                    <?php endif;
                                    if(empty($data['siteLogo'])) { $setImg = "nologo.png"; } else { $setImg = $data['siteLogo']; }
                                    ?>
                                </div>
                                <?php if (!empty($data['siteLogo'])) : ?>
                                    <div class="userAvatar mt-3">
                                        <img width="100" class="mx-auto d-block"
                                             src="<?php echo URLROOT; ?>/img/<?php echo $setImg; ?>">
                                    </div>
                                <?php endif; ?>

                                <div class="form-group mt-4">
                                    <input type="submit" value="Update" class="btn btn-info btn-block">
                                </div>

                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </section>
    </main>
</div>