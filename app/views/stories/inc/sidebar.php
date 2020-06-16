<aside class="layout-blog__sidebar">
        <!-- widget-text__widget -->
        <section class="widget-text__widget widget-text__style-02 widget">
            <h3 class="widget-title text-black-50"><span class="color-orange-text">Cate</span>gories</h3>
            <div class="widget-text__content">
                <ul>
                    <?php foreach ($data['categories'] as $category) : ?>
                        <li><a class="eppMe"
                               href="<?php echo URLROOT . '/categories/' . $category->ps_cat_slug . '/' . cleanerUrl($category->ps_cat_name); ?>"><i
                                        class="fas fa-chevron-right"></i> <?php echo $category->ps_cat_name; ?><span class="badge"> (<?php echo $category->post_count; ?>)</span></a>
                            <small><?php echo $category->ps_cat_desc; ?></small></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section><!-- End / widget-text__widget -->


    <!-- widget-text__widget -->
    <section class="widget-text__widget widget-text__style-02 widget">
        <h3 class="widget-title text-black-50">Gal<span class="color-orange-text">leries</span></h3>
        <div class="widget-text__content">
            <ul>
                <?php foreach ($data['galleries'] as $gal) : ?>
                    <li><a class="eppMe"
                           href="<?php echo URLROOT . '/galleries/show/' . $gal->gl_cat_id . '/' . cleanerUrl($gal->gl_cat_title); ?>"><i
                                    class="fas fa-chevron-right"></i> <?php echo $gal->gl_cat_title; ?><span class="badge"> (<?php echo $gal->img_count; ?>)</span></a>
                        <small><?php echo $gal->gl_cat_desc; ?></small></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section><!-- End / widget-text__widget -->

</aside>