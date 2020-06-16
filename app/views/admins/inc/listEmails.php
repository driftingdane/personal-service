<div class="col-sm-8 profileCard mb-5 table-responsive">
    <div class="profileCard-heading text-center mn-3">Email list
      <?php
        foreach ($data['countEmails'] as $count) : ?>
            <span class="text-primary">(Last 7 days <?php echo $count->em; ?>)</span>
       <?php
        endforeach;
       ?>
    </div>

    <table class="table table-sm reports">
        <thead class="thead-dark mb-2">
        <tr>
            <th class="text-center" scope="col">Email</th>
            <th class="text-center" scope="col">Created</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <thead class="thead-light">
        <tbody>

        <?php
        if(is_array($data['emails'])) :
            foreach($data['emails'] as $e) : ?>
                <tr class="smaller-font">
                    <th class="text-center" scope="col"><?php echo $e->email; ?></th>
                    <th class="text-center" scope="col"><?php echo infoDate($e->em_created); ?></th>
                    <th class="text-center p-1" scope="col">
                        <form action="<?php echo URLROOT . '/admins/deleteEmail/' . $e->em_id; ?>" method="post">
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