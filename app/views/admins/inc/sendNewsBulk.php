<div id="page-content"><!-- Needed for sticky footer-->
    <main role="main">
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 mx-auto">
                        <h6 class="profileCard-heading mb-5">Newsletter successfully sent to <span class="badge badge-success"><?php echo $_SESSION['n']; ?></span> recipients</h6>
                        <?php echo $data['news']->ns_msg; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div><!-- Page id ends sticky footer-->