<div class="col-sm-8 profileCard mb-5 table-responsive">
    <div class="profileCard-heading text-center">News list</div>
    <table class="table table-sm">
        <thead class="thead-dark mb-2">
        <tr>
            <th class="text-center" scope="col">Title</th>
            <th class="text-center" scope="col">Template</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
        </thead>
        <thead class="thead-light">
        <tbody>
        <?php
        if(is_array($data['news'])) :
            foreach($data['news'] as $ns) :
               if(empty($data['news'])) :
               $content = "No news";
               else:
               $content = $ns->ns_title;
               endif; ?>
                <tr class="smaller-font">
                    <th class="text-center" scope="col"><?php echo $content; ?></th>
                    <th class="text-center" scope="col"><?php echo $ns->ns_type; ?></th>
                    <th class="text-center p-1" scope="col"><a href="<?php echo URLROOT . '/admins/editNews/' . $ns->ns_id; ?>" class="btn btn-block btn-light btn-sm btn-block-xs"><i class="far fa-edit"></i></a></th>
                    <th class="text-center p-1" scope="col">
                        <form action="<?php echo URLROOT . '/admins/deleteNews/' . $ns->ns_id; ?>" method="post">
                            <input type="hidden" name="returnUrl" value="<?php echo $_GET['url']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger delete_with_icon btn-block btn-block-xs"><i class="far fa-trash-alt"></i></button>
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