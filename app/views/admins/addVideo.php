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
                            <form action="<?php echo URLROOT; ?>/admins/addVideo" class="icon-form process" enctype="multipart/form-data" method="post" novalidate>
                                <input type="hidden" name="token" value="<?php echo createToken(); ?>">
                                <div class="col-md-12 mb-3">
                                    <label for="vdCat"><i class="far fa-flag formIcons"></i> Category: <sub>*</sub></label>
                                    <select id="vdCat" name="vdCat" class="custom-select custom-select-lg mb-3 <?php echo (!empty($data['vdCat_err'])) ? 'is-invalid' : ''; ?>" required>
                                        <option value="" selected>Select category</option>
                                        <?php
                                        if(is_array($data['categories'])) :
                                            foreach ($data['categories'] as $cat) : ?>
                                                <option value="<?php echo $cat->vd_cat_id; ?>"><?php echo $cat->vd_cat_title; ?></option>
                                            <?php endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    <span class="invalid-feedback"><?php echo $data['vdCat_err']; ?></span>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="vdTitle"><i class="fas fa-heading formIcons"></i>
                                        <span class="inline-span"> Title: <sub>*</sub></span></label>
                                    <input id="vdTitle" maxlength="100"
                                           class="form-control form-control-lg <?php echo (!empty($data['vdTitle_err'])) ? 'is-invalid' : ''; ?>"
                                           name="vdTitle"
                                           required
                                           type="text" value="<?php echo $data['vdTitle']; ?>">
                                    <span class="invalid-feedback"><?php echo $data['vdTitle_err']; ?></span>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="vdDesc"><i class="fas fa-signature formIcons"></i>
                                        <span class="inline-span"> Description: </span></label>
                                    <input id="vdDesc" maxlength="100"
                                           class="form-control form-control-lg"
                                           name="vdDesc"
                                           type="text" value="<?php echo $data['vdDesc']; ?>">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="vdEmbed"><i class="fab fa-youtube formIcons"></i>
                                        <span class="inline-span"> Video code: <sub>*</sub></span></label>
                                    <input id="vdEmbed" maxlength="11"
                                           class="form-control form-control-lg <?php echo (!empty($data['vdEmbed_err'])) ? 'is-invalid' : ''; ?>"
                                           name="vdEmbed"
                                           required
                                           type="text" value="<?php echo $data['vdEmbed']; ?>">
                                    <span class="invalid-feedback"><?php echo $data['vdEmbed_err']; ?></span>
                                </div>



                                <div class="col-md-12 mb-3">
                                    <div class="form-group mt-4 mb-3">
                                        <input type="submit" value="Add" class="btn btn-primary btn-block">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php require APPROOT . '/views/admins/inc/listVideos.php'; ?>
            </div>
        </section>

    </main>
</div><!-- Page id ends sticky footer-->

