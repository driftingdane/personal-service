<div id="page-content"><!-- Needed for sticky footer-->
    <main role="main">
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card card-body bg-light">
                            <?php
                            flash('resume_message');
                            flash('mail_error');
                            ?>
                            <h2>Add <span class="text-info">email</span></h2>
                            <p>Please fill in all fields with <sub>*</sub></p>
                            <form class="icon-form" action="<?php echo URLROOT; ?>/admins/addEmail"
                                  method="post">
                                <div class="form-group">
                                    <label for="email"><p><i class="fas fa-at formIcons"></i> Email <sub>*</sub></p></label>
                                    <input type="text" name="email"
                                           class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>"
                                           value="<?php echo $data['email']; ?>" required>
                                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-outline-success btn-block"><i
                                                    class="fas fa-sign-in-alt"></i> Add
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-8 profileCard mb-5 mt-5 table-responsive">
                <div class="profileCard-heading text-center">Email list</div>
                <table class="table table-sm">
                    <thead class="thead-dark mb-2">
                    <tr>
                        <th class="text-center" scope="col">Email</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <thead class="thead-light">
                    <tbody>
                    <?php

                    if (is_array($data['emails'])) :
                        foreach ($data['emails'] as $email) :

                        ?>
                            <tr>
                                <th class="text-center" scope="col"><?php echo $email->email; ?></th>
                                <th class="text-center p-1" scope="col">
                                    <form action="<?php echo URLROOT . '/admins/deleteEmail/' . $email->em_id; ?>"
                                          method="post">
                                        <input type="hidden" name="returnUrl" value="<?php echo $_GET['url']; ?>">
                                        <button type="submit"
                                                class="btn btn-sm btn-danger delete_with_icon btn-block btn-block-xs"><i
                                                    class="far fa-trash-alt"></i></button>
                                    </form>
                                </th>
                            </tr>
                        <?php
                        endforeach;
                    endif;
                    ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </section>
    </main>
</div>


