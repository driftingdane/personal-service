<div id="page-content"><!-- Needed for sticky footer-->
    <main role="main">
        <div style="height: 150px;"></div>
        <section>
            <div class="container-fluid">
                <h1 class="text-center text-uppercase mt-3 mb-5"><i class="fas fa-wave-square fa-rotate-180 "></i>
                    <?php
                    $lastPart = basename($_GET['url']);
                    $cat_title = cleanerUrlTitle($lastPart);
                    echo ucwords($cat_title);
                    ?> <i class="fas fa-wave-square fa-rotate-180 color-orange-text"></i></h1>
                <div class="text-center mb-4"><a class="btn-sm btn-sm-outline color-orange" onclick="history.go(-1)" href="#">Back</a></div>
                <?php
                require APPROOT . '/views/inc/galleryImages.php';
                ?>
            </div>
        </section>
    </main>
</div><!-- Page id ends sticky footer-->
