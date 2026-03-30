<?php

function generateLink($url, $label, $class) {
    echo '<a href="' . $url . '" class="' . $class . '">' . $label . '</a>';
}

function outputStars($rating) {
    for ($i = 0; $i < $rating; $i++) {
        echo '<img src="images/star-gold.svg" width="16" />';
    }

    for ($i = $rating; $i < 5; $i++) {
        echo '<img src="images/star-white.svg" width="16" />';
    }
}

function outputPostRow($post) {
    echo '<div class="row">';
        echo '<div class="col-md-4">';
            generateLink(
                'post.php?id=' . $post['postId'],
                '<img src="images/' . $post['thumb'] . '" alt="' . $post['title'] . '" class="img-responsive"/>',
                ''
            );
        echo '</div>';

        echo '<div class="col-md-8">';
            echo '<h2>' . $post['title'] . '</h2>';

            echo '<div class="details">';
                echo 'Posted by ';
                generateLink(
                    'user.php?id=' . $post['userId'],
                    $post['userName'],
                    ''
                );

                echo '<span class="pull-right">' . $post['date'] . '</span>';

                echo '<p class="ratings">';
                    outputStars($post['reviewsRating']);
                    echo ' ' . $post['reviewsNum'] . ' Reviews';
                echo '</p>';
            echo '</div>';

            echo '<p class="excerpt">';
                echo $post['excerpt'];
            echo '</p>';

            echo '<p class="pull-right">';
                generateLink(
                    'post.php?id=' . $post['postId'],
                    'Read more',
                    'btn btn-primary btn-sm'
                );
            echo '</p>';
        echo '</div>';
    echo '</div>';
    echo '<hr/>';
}

?>