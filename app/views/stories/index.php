 <div id="page-content"><!-- Needed for sticky footer-->
     <main role="main">
         <?php require APPROOT . '/views/inc/slider.php'; ?>
                      <h1 class="text-center text-uppercase mt-5"><i class="fas fa-wave-square color-orange-text fa-rotate-180"></i> Sto<span class="color-orange-text">ries</span> <i class="fas fa-wave-square fa-rotate-90"></i></h1>

                        <?php flash('resume_message'); ?>
                            <!-- Content-->

                            <div class="md-content">
                                <!-- Section -->
                                <section class="md-section">
                                    <div class="container">

                                        <!-- layout-blog sidebar-left -->
                                        <div class="layout-blog sidebar-left">
                                            <div class="layout-blog__content">
                                              <?php foreach($data['posts'] as $post) :?>
                                                <!--  -->
                                                <div class="post-01__style-02 md-text-center">
                                                    <div class="post-01__media"><a href="<?php echo URLROOT . '/stories/show/' . $post->ps_slug . '/' . cleanerUrl($post->ps_title . ' ' . $post->ps_sub_title); ?>"><img class="img-fluid" src="<?php echo URLROOT . '/storyImg/feat/' . $post->ps_img; ?>" alt="<?php echo $post->ps_img; ?>"></a>
                                                    </div>
                                                    <div>
                                                        <ul class="post-01__categories">
                                                            <li><a href="<?php echo URLROOT . '/categories/' . $post->ps_cat_slug . '/' . cleanerUrl($post->ps_cat_name); ?>"><?php echo $post->ps_cat_name; ?></a></li>
                                                        </ul>
                                                        <h2 class="post-01__title"><a href="<?php echo URLROOT . '/stories/show/' . $post->ps_slug . '/' . cleanerUrl($post->ps_title . ' ' . $post->ps_sub_title); ?>"><?php echo $post->ps_title. ' | '. $post->ps_sub_title; ?></a></h2>
                                                        <div class="post-01__time">Written:</div>
                                                        <div class="post-01__note"><?php echo infoDate($post->ps_created); ?>.</div>
                                                        <div class="post-01__time">&nbsp;Updated:</div>
                                                        <div class="post-01__note"><?php echo infoDate($post->ps_updated); ?>.</div>
                                                        <div class="post-01__time">&nbsp;By:</div>
                                                        <div class="post-01__note"><?php echo ucwords($post->us_first . '&nbsp;' . $post->us_last); ?></div>
                                                    </div>
                                                </div><!-- End /  -->
                                                <?php endforeach; ?>

                                                <!-- pagination -->
                                                <ul class="pagination"><a class="pagination__item" href="#">1</a><a class="pagination__item" href="#">2</a><a class="pagination__item" href="#">3</a><span class="pagination__item active">4</span>
                                                </ul><!-- End / pagination -->

                                            </div>


                                            <?php require APPROOT . '/views/stories/inc/sidebar.php'; ?>


                                        </div><!-- End / layout-blog sidebar-left -->

                                    </div>
                                </section>
                                <!-- End / Section -->
                            </div>
                            <!-- End / Content-->

        </main>
    </div><!-- Page id ends sticky footer-->


