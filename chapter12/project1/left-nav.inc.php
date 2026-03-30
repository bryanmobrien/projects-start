<aside class="col-md-2">
    <div class="panel panel-info">
        <div class="panel-heading">Continents</div>
        <ul class="list-group">
            <?php foreach ($continents as $continent) { ?>
                <li class="list-group-item">
                    <a href="#"><?php echo $continent; ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <!-- end continents panel -->

    <div class="panel panel-info">
        <div class="panel-heading">Popular</div>
        <ul class="list-group">
            <?php foreach ($countries as $code => $country) { ?>
                <li class="list-group-item">
                    <?php generateLink(
                        'photos.php?iso=' . $code,
                        $country,
                        ''
                    ); ?>
                </li>
            <?php } ?>
        </ul>
    </div>
    <!-- end continents panel -->
</aside>