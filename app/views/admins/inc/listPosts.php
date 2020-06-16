<div class="col-sm-10 profileCard mb-5 table-responsive">
    <div class="profileCard-heading text-center mn-3">Posts list
        <?php
        foreach ($data['countPosts'] as $count) : ?>
            <span class="text-primary">(Last 7 days <?php echo $count->rs; ?>)</span>
        <?php
        endforeach;
        ?>
    </div>

    <table class="table table-sm table-striped table-bordered reports">
        <thead class="thead-dark mb-2">
        <tr>
            <th scope="col">Category</th>
            <th scope="col">Title</th>
            <th scope="col">Sub Title</th>
            <th class="text-center" scope="col">User</th>
            <th class="text-center" scope="col">Created</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
        </thead>
        <thead class="thead-light">
        <tbody>

        <?php
        if(is_array($data['posts'])) :
            foreach($data['posts'] as $ps) : ?>
                <tr class="smaller-font">
                    <th class="text-center text-md-left" scope="col"><?php echo $ps->ps_cat_name; ?></th>
                    <th class="text-center text-md-left" scope="col"><?php echo $ps->ps_title; ?></th>
                    <th class="text-center text-md-left" scope="col"><?php echo $ps->ps_sub_title; ?></th>
                    <th class="text-center text-md-left" scope="col"><?php echo $ps->us_first; ?></th>
                    <th class="text-center text-md-left" scope="col"><?php echo infoDate($ps->ps_created); ?></th>

                    <th class="text-center p-1" scope="col"><a href="<?php echo URLROOT . '/admins/editPost/' . $ps->ps_slug; ?>" class="btn btn-block btn-light btn-sm btn-block-xs"><i class="far fa-edit"></i></a></th>
                    <th class="text-center p-1" scope="col">
                        <form action="<?php echo URLROOT . '/admins/deletePost/' . $ps->ps_id; ?>" method="post">
                            <input type="hidden" name="returnUrl" value="<?php echo $_GET['url']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger delete_with_icon btn-block btn-block-xs"><i class="far fa-trash-alt"></i></button>
                        </form>
                    </th>
                </tr>
            <?php endforeach;
        endif;
        ?>
        </tbody>
        </thead>
    </table>
</div>