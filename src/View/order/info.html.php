<?php

/** @var \Model\Entity\Product[] $productList */
$body = function () use ($productList) {
    ?>
    <form method="post">
        <table cellpadding="10">
            <tr>
                <td colspan="3" align="center">Корзина</td>
            </tr>
<?php
    $totalPrice = 0;
    $n = 1;
    foreach ($productList as $product) {
        ?>
            <tr>
                <td><?= $n++ ?>.</td>
                <td><?= $product->getName() ?></td>
                <td><?= $product->getPrice() ?> руб</td>
                <td><input type="button" value="Удалить" /></td>
            </tr>
<?php
        $totalPrice += $product->getPrice();
    } ?>
            <tr>
                <td colspan="3" align="right">Итого: <?= $totalPrice ?> рублей</td>
            </tr>
        </table>
    </form>
    <?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Корзина',
        'body' => $body,
    ]
);
