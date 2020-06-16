<!-- APP BUTTONS -->
<div class="d-flex flex-column flex-md-row align-items-center">
    <div class="mx-auto">
        <div class="tag">
            <div class="btn-group-vertical">
                <?php if (isLoggedIn()) : ?>
                        <div class="tag mb-2">
                        <div class="userPosition pl-4 pr-4"><span>Hello, <?php echo nameToUpper(); ?></span></div>
                        </div>
                <?php
                    // Check access and include the links based on user status
                    checkAccessLinks();
                 ?>
                    <a href="<?php echo URLROOT; ?>/users/logout" class="btn btn-sm btn-light mt-2 mb-2"><i class="fas fa-sign-out-alt"></i> Logout</a>

                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
