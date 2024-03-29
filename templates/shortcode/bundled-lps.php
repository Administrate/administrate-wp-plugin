<div id='amwpp-bundled-lps' class="admwpp-bundled-lps row justify-content-center">
    <?php
    if ($bundledLps['bundledLps']) {
        ?>
        <div class="col-auto table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th scope="col"><?php echo __("Bundle", "admwpp"); ?></th>
                        <th scope="col"><?php echo __("Objectives", "admwpp"); ?></th>
                        <th scope="col"><?php echo __("Language", "admwpp"); ?></th>
                        <th scope="col"><?php echo __("Date", "admwpp"); ?></th>
                        <th scope="col"><?php echo __("Time", "admwpp"); ?></th>
                        <th scope="col"><?php echo __("Price*", "admwpp"); ?></th>
                        <?php if ($showAddToCart): ?>
                            <th scope="col"></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php include('bundled-lps-rows.php'); ?>
                </tbody>
            </table>
            <?php
            if ($bundledLps['hasNextPage']) {
                ?>
                <div class="col-md-12 text-center">
                    <a class='admwpp-button admwpp-bundled-loadmore-btn btn btn-lg btn-secondary' data-container='amwpp-bundled-lps' <?php echo $data_attr; ?>><?php _e('Load More', 'admwpp'); ?> <div class='admwpp-loader fa-3x text-center'><i class='fas fa-circle-notch fa-spin'></i></div></a>
                </div>
                <?php
            } ?>
        </div>
        <?php
    } else {
        echo __("No Bundles yet to be listed.", "admwpp");
    }
    ?>
</div>
