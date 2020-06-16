<div class="col-sm-10 profileCard mb-5 table-responsive">
    <div class="profileCard-heading text-center mn-3">Photo list
        <?php
        foreach ($data['countImages'] as $count) : ?>
        <span class="text-primary">(<?php echo $count->im; ?>)</span>
        <?php
         endforeach;
        ?>
    </div>

    <form action="<?php echo URLROOT; ?>/admins/deleteImage" method="post">
    <table class="table table-sm table-striped table-bordered reports">

        <thead class="thead-dark mb-2">
        <tr>
            <th class="text-center" scope="col"><span class="inline-span">ID:<input type="checkbox" id="gallery_all" /></span></th>
            <th scope="col">Category</th>
            <th scope="col">Title</th>
            <th class="text-center" scope="col">Description</th>
            <th class="text-center" scope="col">Img</th>
            <th class="text-center" scope="col">Created</th>
            <th class="text-center" scope="col"><button type="submit" name="bulk_delete" class="btn btn-sm btn-danger delete_with_icon btn-block btn-block-xs"><i class="far fa-trash-alt"></i></button></th>

        </tr>
        </thead>
        <thead class="thead-light">
        <tbody>

        <?php
        if(is_array($data['images'])) :
            foreach($data['images'] as $gl) : ?>
                <tr class="smaller-font">
                    <th class=""><input type="checkbox" name="files[]" id="delete_image" class="checkbox" value="<?php echo $gl->gl_id; ?>"></th>
                    <th class="text-center text-md-left" scope="col"><?php echo $gl->gl_cat_title; ?></th>
                    <th class="text-center text-md-left" scope="col"><?php echo $gl->gl_title; ?></th>
                    <th class="text-center text-md-left" scope="col"><?php echo $gl->gl_desc; ?></th>
                    <th class="text-center text-md-left" scope="col"><img class="img-fluid" src="<?php echo URLROOT . '/photoImg/thumbs/' . $gl->gl_img; ?>" alt="<?php echo $gl->gl_img; ?>"></th>
                    <th class="text-center text-md-left" scope="col"><?php echo infoDate($gl->gl_created); ?></th>
                    <th class="text-center p-1" scope="col"><a href="<?php echo URLROOT . '/admins/editImage/' . $gl->gl_id; ?>" class="btn btn-block btn-light btn-sm btn-block-xs"><i class="far fa-edit"></i></a></th>
                </tr>

            <?php endforeach;
        endif;
        ?>
        </tbody>
        </thead>

    </table>
    </form>
</div>