<?php

declare(strict_types = 1);

namespace Controller;

use Framework\Render;
use Service\Order\Order;
use Service\Product\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController
{
    use Render;

    /**
     * Корзина
     *
     * @param Request $request
     * @return Response
     */
    public function infoAction(Request $request): Response
    {
        $productIds = (new Order($request->getSession()))->getProducts();
        $productList = (new Product())->getCollection($productIds);

        return $this->render('order/info.html.php', ['productList' => $productList]);
    }
}
