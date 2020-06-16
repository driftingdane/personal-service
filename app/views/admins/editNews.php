<div id="page-content"><!-- Needed for sticky footer-->
    <main role="main">
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-8 mx-auto">
                        <div class="card card-body bg-light mb-5">
                            <?php echo flash('resume_message'); ?>
                            <h2><span class="text-info">Edit</span> newsletter</h2>
                            <p>Please fill in all fields with <sub>*</sub></p>
                            <form class="icon-form" action="<?php echo URLROOT; ?>/admins/editNews/<?php echo $data['onenews']->ns_id; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" value="<?php echo $_GET['url']; ?>" name="returnUrl">
                                <div class="form-group">
                                    <label for="nsTitle">
                                        <p><i class="fas fa-heading formIcons"></i> Title: <sub>*</sub></p></label>
                                    <input name="nsTitle"
                                           class="form-control form-control-lg <?php echo (!empty($data['nsTitle_err'])) ? 'is-invalid' : ''; ?>"
                                           value="<?php echo $data['onenews']->ns_title; ?>" required>
                                    <span class="invalid-feedback"><?php echo $data['nsTitle_err']; ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="nsMsg">
                                        <p><i class="fas fa-comments formIcons"></i> News: <sub>*</sub></p></label>
                                    <textarea name="nsMsg"
                                              class="form-control form-control-lg addTinymce <?php echo (!empty($data['nsMsg_err'])) ? 'is-invalid' : ''; ?>"
                                              required><?php echo $data['onenews']->ns_msg; ?></textarea>
                                    <span class="invalid-feedback"><?php echo $data['nsMsg_err']; ?></span>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="Update" class="btn color-dark-green btn-block">
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <?php require APPROOT . '/views/admins/inc/listNews.php'; ?>
            </div>
</div>
</section>


</main>
</div><!-- Page id ends sticky footer-->

