<div class="col-sm-10 profileCard mb-5 table-responsive">
    <div class="profileCard-heading text-center mn-3">Video list
        <?php
        foreach ($data['countVideos'] as $count) : ?>
           <span class="text-primary">(<?php echo $count->vi; ?>)</span>
        <?php
        endforeach;
        ?>
    </div>

    <table class="table table-sm table-striped table-bordered reports">
        <thead class="thead-dark mb-2">
        <tr>
            <th scope="col">Category</th>
            <th scope="col">Title</th>
            <th class="text-center" scope="col">Description</th>
            <th class="text-center" scope="col">Code</th>
            <th class="text-center" scope="col">Created</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
        </thead>
        <thead class="thead-light">
        <tbody>

        <?php
        if(is_array($data['videos'])) :
            foreach($data['videos'] as $vd) : ?>
                <tr class="smaller-font">
                    <th class="text-center text-md-left" scope="col"><?php echo $vd->vd_cat_title; ?></th>
                    <th class="text-center text-md-left" scope="col"><?php echo $vd->vd_title; ?></th>
                    <th class="text-center text-md-left" scope="col"><?php echo $vd->vd_desc; ?></th>
                    <th class="text-center text-md-left" scope="col"><?php echo $vd->vd_embed; ?></th>
                    <th class="text-center text-md-left" scope="col"><?php echo infoDate($vd->vd_created); ?></th>
                    <th class="text-center p-1" scope="col"><a href="<?php echo URLROOT . '/admins/editVideo/' . $vd->vd_id; ?>" class="btn btn-block btn-light btn-sm btn-block-xs"><i class="far fa-edit"></i></a></th>
                    <th class="text-center p-1" scope="col">
                        <form action="<?php echo URLROOT . '/admins/deleteVideo/' . $vd->vd_id; ?>" method="post">
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