<div class="col-sm-10 profileCard mb-5 table-responsive">
    <div class="profileCard-heading text-center mn-3">Slider list</div>

    <table class="table table-sm table-striped table-bordered reports">
        <thead class="thead-dark mb-2">
        <tr>
            <th scope="col">Title</th>
            <th class="text-center" scope="col">Description</th>
            <th width="50" class="text-center" scope="col">Data</th>
            <th class="text-center" scope="col">Image</th>
            <th class="text-center" scope="col">Created</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
        </thead>
        <thead class="thead-light">
        <tbody>

        <?php
        if(is_array($data['slides'])) :
            foreach($data['slides'] as $sl) :
              if(!empty($sl->sl_data)) : $msg = "Has data"; else: $msg = ""; endif;
                ?>
                <tr class="smaller-font">
                    <th class="text-center text-md-left" scope="col"><?php echo $sl->sl_title; ?></th>
                    <th class="text-center text-md-left" scope="col"><?php echo $sl->sl_desc; ?></th>
                    <th width="50" class="text-center text-md-left" scope="col"><?php echo $msg; ?></th>
                    <th class="text-center text-md-left" scope="col"><img class="img-fluid" src="<?php echo URLROOT . '/sliderImg/mobile/' . $sl->sl_img; ?>" alt="<?php echo $sl->sl_img; ?>"></th>
                    <th class="text-center text-md-left" scope="col"><?php echo infoDate($sl->sl_created); ?></th>
                    <th class="text-center p-1" scope="col"><a href="<?php echo URLROOT . '/admins/editSlide/' . $sl->sl_id; ?>" class="btn btn-block btn-light btn-sm btn-block-xs"><i class="far fa-edit"></i></a></th>
                    <th class="text-center p-1" scope="col">
                        <form action="<?php echo URLROOT . '/admins/deleteSlide/' . $sl->sl_id; ?>" method="post">
                            <input type="hidden" name="returnUrl" value="<?php echo $_GET['url']; ?>">
                            <input type="hidden" name="file" value="<?php echo $sl->sl_img; ?>">
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