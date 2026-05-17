<?php
function stars_html(int $n): string {
    $out = '<div class="stars">';
    for ($i = 1; $i <= 5; $i++) {
        $fill = $i <= $n ? '#C9614A' : '#D4D4D4';
        $out .= '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 22 21" fill="'.$fill.'"><path d="M10.318 0.319C10.365 0.223 10.439 0.143 10.53 0.086C10.621 0.03 10.725 0 10.832 0C10.939 0 11.044 0.03 11.135 0.086C11.226 0.143 11.299 0.223 11.347 0.319L13.849 5.387C14.014 5.721 14.257 6.009 14.558 6.228C14.859 6.447 15.208 6.589 15.576 6.643L21.171 7.462C21.277 7.477 21.377 7.522 21.459 7.591C21.541 7.66 21.602 7.751 21.635 7.853C21.668 7.955 21.672 8.064 21.646 8.168C21.621 8.272 21.566 8.366 21.49 8.441L17.443 12.381C17.177 12.641 16.977 12.962 16.862 13.317C16.746 13.671 16.719 14.048 16.782 14.415L17.737 19.982C17.756 20.088 17.744 20.197 17.704 20.297C17.664 20.397 17.596 20.483 17.509 20.546C17.422 20.61 17.319 20.647 17.211 20.655C17.104 20.662 16.997 20.639 16.902 20.589L11.9 17.959C11.571 17.786 11.204 17.696 10.832 17.696C10.46 17.696 10.093 17.786 9.763 17.959L4.763 20.589C4.668 20.639 4.561 20.661 4.454 20.654C4.347 20.646 4.244 20.609 4.157 20.546C4.07 20.482 4.003 20.396 3.962 20.296C3.922 20.197 3.911 20.088 3.929 19.982L4.883 14.416C4.946 14.049 4.919 13.672 4.804 13.317C4.688 12.963 4.489 12.641 4.222 12.381L0.175 8.442C0.098 8.368 0.043 8.273 0.017 8.168C-0.009 8.064 -0.005 7.955 0.028 7.852C0.061 7.75 0.122 7.659 0.205 7.59C0.287 7.521 0.387 7.476 0.494 7.461L6.088 6.643C6.456 6.589 6.806 6.447 7.107 6.228C7.409 6.009 7.652 5.721 7.817 5.387L10.318 0.319Z"/></svg>';
    }
    return $out . '</div>';
}
?>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">Отзывы</h1>
    </div>

    <?php if (empty($reviews_list)): ?>
        <div class="catalog-empty"><p>Пока нет отзывов. Будьте первым!</p></div>
    <?php else: ?>
        <div class="cards-grid">
            <?php foreach ($reviews_list as $r): ?>
            <div class="main-review-card">
                <?= stars_html((int)$r['assessment']) ?>
                <p class="main-review-card__text">"<?= htmlspecialchars($r['comment']) ?>"</p>
                <div class="main-review-card__author">
                    <div class="main-review-card__avatar">
                        <?php if (!empty($r['user_img'])): ?>
                            <img src="<?= htmlspecialchars($r['user_img']) ?>" alt="">
                        <?php else: ?>
                            <?= mb_strtoupper(mb_substr($r['user_name'], 0, 1)) ?>
                        <?php endif ?>
                    </div>
                    <span class="main-review-card__name"><?= htmlspecialchars($r['user_name']) ?></span>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>
