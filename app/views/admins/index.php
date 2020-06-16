<div id="page-content"><!-- Needed for sticky footer-->
    <main role="main">
        <!-- Counts Section -->
        <section class="dashboard-counts m-5">
            <?php flash('report_msg'); ?>
            <div class="container-fluid">
                <h2 class="text-center"><i class="fas fa-tablets text-github-alt"></i>
                    <span class="text-info"><?php echo $data['title']; ?>
                        <i class="fas fa-tablets text-github-alt"></i>
                </h2>
                <div class="row">
                    <!-- Count item widget-->
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <div class="wrapper count-title d-flex align-items-center justify-content-center">
                            <div class="icon"><i class="fas fa-mail-bulk"></i></div>
                            <div class="name"><strong class="text-uppercase">New <span class="text-info">Subscribers</span></strong><span>Last 7 days</span>
                                <div class="count-number">
                                    <?php
                                    foreach ($data['countEmails'] as $count) :
                                        echo $count->em;
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Count item widget-->
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <div class="wrapper count-title d-flex align-items-center justify-content-center">
                            <div class="icon"><i class="fas fa-theater-masks"></i></div>
                            <div class="name"><strong class="text-uppercase">New <span class="text-info">Resumes</span></strong><span>Last 7 days</span>
                                <div class="count-number">
                                    <?php
                                    foreach ($data['countResumes'] as $count) :
                                        echo $count->rs;
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Count item widget-->
                    <div class="col-xl-4 col-md-4 col-sm-4 mt-5">
                        <div class="wrapper count-title d-flex align-items-center justify-content-center">
                            <div class="icon"><i class="fas fa-chart-pie"></i></div>
                            <div class="name"><strong class="text-uppercase">Page <span class="text-info">visits</span></strong><span>Last 7 days</span>
                                <div class="count-number">
                                    <?php
                                    //require APPROOT . '/views/admins/analytics.php';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
</div><!-- Page id ends sticky footer-->