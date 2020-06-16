<div id="page-content"><!-- Needed for sticky footer-->
    <main role="main">
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-8 mx-auto">
                        <div class="card card-body bg-light mb-5">
                            <?php echo flash('resume_message'); ?>
                            <h2><span class="text-info">Create</span> newsletter</h2>
                            <p>Please fill in all fields with <sub>*</sub></p>
                            <form class="icon-form" action="<?php echo URLROOT; ?>/admins/addNews" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="nTitle">
                                        <p><i class="fas fa-heading formIcons"></i> Title: <sub>*</sub></p></label>
                                    <input name="nTitle"
                                           class="form-control form-control-lg <?php echo (!empty($data['nTitle_err'])) ? 'is-invalid' : ''; ?>"
                                           value="<?php echo $data['nTitle']; ?>" required>
                                    <span class="invalid-feedback"><?php echo $data['nTitle_err']; ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="nDesc">
                                        <p><i class="fas fa-comments formIcons"></i> News: <sub>*</sub></p></label>
                                    <textarea name="nDesc"
                                              class="form-control form-control-lg addTinymce <?php echo (!empty($data['nDesc_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['nDesc']; ?></textarea>
                                    <span class="invalid-feedback"><?php echo $data['nDesc_err']; ?></span>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="Add" class="btn color-dark-green btn-block">
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="col-sm-8 mx-auto mb-5">
                        <?php require APPROOT . '/views/admins/inc/newsPreview.php'; ?>
                    </div>
                </div>
                <?php require APPROOT . '/views/admins/inc/listEmails.php'; ?>
                <?php require APPROOT . '/views/admins/inc/listNews.php'; ?>
            </div>
</div>
</section>


</main>
</div><!-- Page id ends sticky footer-->

