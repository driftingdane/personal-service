<div id="page-content"><!-- Needed for sticky footer-->
    <main role="main">
        <section class="bg-banner clip-ellipse">
            <div class="mx-auto d-block text-center">
                <img src="<?php echo URLROOT . '/storyImg/' . $data['post']->ps_img; ?>"
                     alt="<?php echo $data['post']->ps_img; ?>">
            </div>
        </section>

        <section>
            <!-- Start post-content Area -->
            <div class="offset-lg-9 col-lg-3">
                <a href="#">
                    <div class="yt-subscribe">
                        <img width="150" class="img-fluid rounded-circle userAvatar-img userAvatar-white" src="<?php echo URLROOT; ?>/all_img/img/me.jpg" alt="Drifting Dane">
                    </div><!-- .yt-subscribe -->
                </a>
            </div><!-- .col -->

            <div class="consult-postDetail">
                <div class="container">
                    <div class="consult-postDetail__main">
                        <!-- social-01 -->
                        <div class="social-01 social-01__style-02"><div class="text-center mb-4"><a class="btn-sm btn-sm-outline color-orange" onclick="history.go(-1)" href="#">Back</a></div>
                            <nav class="social-01__navSocial">
                                <a title="Share on Facebook" class="customer share social-01__item" href="http://www.facebook.com/sharer.php?u=<?php echo URLROOT . '/' . $_GET['url']; ?>"><i class="fab fa-facebook-f fa-fw"></i></a>
                                <a title="Share on Linkedin" class="customer share social-01__item" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo URLROOT . '/' . $_GET['url']; ?>&title="><i class="fab fa-linkedin-in fa-fw"></i></a>
                                <a title="Share on WhatsApp" class="customer share social-01__item" href=" https://wa.me/?text=<?php echo URLROOT . '/' . $_GET['url']; ?>"><strong><i class="fab fa-whatsapp fa-fw"></i></strong></a>
                                </br>
                                <div class="fb-like" data-href="https://www.facebook.com/driftingDane/" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="false"></div>
                            </nav>
                        </div><!-- End / social-01 -->

                        <div class="row">
                            <div class="col-lg-10 col-xl-8 offset-0 offset-sm-0 offset-md-0 offset-lg-1 offset-xl-2 ">
                                <div class="consult-postDetail__content">
                                    <div class="row">
                                        <div class="col-xl-11 offset-0 offset-sm-0 offset-md-0 offset-lg-0 offset-xl-1 ">
                                            <h1><?php echo $data['post']->ps_title; ?></h1>
                                            <ul id="meta-icons" class="consult-postDetail__meta">
                                                <li><i class="fa fa-user"
                                                       aria-hidden="true"></i> <?php echo ucwords($data['post']->us_first . '&nbsp;' . $data['post']->us_last); ?>
                                                </li>
                                                <li><i class="fa fa-tags"
                                                       aria-hidden="true"></i><?php echo $data['post']->ps_cat_name; ?>
                                                </li>
                                                <li><i class="fa fa-calendar"
                                                       aria-hidden="true"></i><?php echo infoDate($data['post']->ps_created); ?>
                                                </li>
                                                <li>
                                                    <i class="fas fa-pen-alt"></i><?php echo infoDate($data['post']->ps_updated); ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div id="fitvids" class="col-xl-11 offset-0 offset-sm-0 offset-md-0 offset-lg-0 offset-xl-1 ">
                                            <p class="text"><?php echo $data['post']->ps_entry; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Related Posts-->

            <!-- End post-content Area -->

        </section>
    </main>
</div><!-- Page id ends sticky footer-->




