<div id="page-content"><!-- Needed for sticky footer-->
    <main role="main">
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-5">
                            <div class="profileCard-heading text-center">Socials</div>
                            <div class="tagGroup-wrapper">
                                <div class="tag">
                                    <div class="tag-experience">
                                    </div>
                                    <div class="">
                                        <div class="tag-label mb-1 font-weight-bold"><span>Facebook</span></div>
                                        <div class="userPosition mb-3">
                                            <span><?php echo $data['socials']->facebook_so; ?></span>
                                        </div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>Twitter</span></div>
                                        <div class="userPosition mb-3"><span><?php echo $data['socials']->twitter_so; ?></span>
                                        </div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>Linkedin</span></div>
                                        <div class="userPosition mb-3"><span><?php echo $data['socials']->linkedin_so; ?></span>
                                        </div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>Google</span></div>
                                        <div class="userPosition mb-3"><span><?php echo $data['socials']->google_so; ?></span>
                                        </div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>Youtube</span></div>
                                        <div class="userPosition mb-3"><span><?php echo $data['socials']->youtube_so; ?></span>
                                        </div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>Instagram</span></div>
                                        <div class="userPosition mb-3">
                                            <span><?php echo $data['socials']->instagram_so; ?></span>
                                        </div>

                                        <div class="tag-label mb-1 font-weight-bold"><span>Quora</span></div>
                                        <div class="userPosition mb-3">
                                            <span><?php echo $data['socials']->quora_so; ?></span>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 ">
                        <div class="card card-body bg-light mb-5 footer-social-icon"><?php echo flash('message'); ?>
                            <h2><span class="text-info">Edit</span> socials</h2>
                            <form class="icon-form" action="<?php echo URLROOT; ?>/admins/socials" method="post">
                                <input type="hidden" name="scId" value="<?php echo $data['socials']->so_id; ?>">
                                <div class="form-group">
                                    <label for="scFacebook">
                                        <span class="inline-span"><i class="fab fa-facebook formIcons"></i> Facebook: </span></label>
                                    <input type="text" name="scFacebook" class="form-control form-control-lg" placeholder="Facebook page" value="<?php echo $data['socials']->facebook_so; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="scTwitter">
                                        <span class="inline-span"><i class="fab fa-twitter formIcons"></i> Twitter: </span></label>
                                    <input type="text" name="scTwitter" class="form-control form-control-lg" placeholder="Twitter page" value="<?php echo $data['socials']->twitter_so; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="scLinkedin">
                                        <span class="inline-span"><i class="fab fa-linkedin-in formIcons"></i> Linkedin: </span></label>
                                    <input type="text" name="scLinkedin" class="form-control form-control-lg" placeholder="Linkedin page" value="<?php echo $data['socials']->linkedin_so; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="scGoogle">
                                        <span class="inline-span"><i class="fab fa-google formIcons"></i> Google: </span></label>
                                    <input type="text" name="scGoogle" class="form-control form-control-lg" placeholder="Google page" value="<?php echo $data['socials']->google_so; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="scYoutube">
                                        <span class="inline-span"><i class="fab fa-youtube formIcons"></i> Youtube: </span></label>
                                    <input type="text" name="scYoutube" class="form-control form-control-lg" placeholder="Youtube page" value="<?php echo $data['socials']->youtube_so; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="scInstagram">
                                        <span class="inline-span"><i class="fab fa-instagram formIcons"></i> Instagram: </span></label>
                                    <input type="text" name="scInstagram" class="form-control form-control-lg" placeholder="Instagram page" value="<?php echo $data['socials']->instagram_so; ?>">
                                </div>


                                <div class="form-group">
                                    <label for="scQuora">
                                        <span class="inline-span"><i class="fab fa-quora formIcons"></i> Quora: </span></label>
                                    <input type="text" name="scQuora" class="form-control form-control-lg" placeholder="Quora page" value="<?php echo $data['socials']->quora_so; ?>">
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="Update" class="btn color-dark-green btn-block">
                                </div>

                            </form>
                        </div>
                    </div>


                </div>
            </div>
        </section>
    </main>
</div>