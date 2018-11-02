<?php

declare(strict_types = 1);

namespace Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Service\Sorting\PriceSorter;
use Service\Sorting\NameSorter;
use Service\Product\Product as ProductService;
use Service\Order\Order as OrderService;
use Framework\Render;

class ProductController
{
    use Render;

    /**
     * Информация о продукте
     *
     * @param Request $request
     * @param string $id
     * @return Response
     */
    public function infoAction(Request $request, $id): Response
    {
        $product = new ProductService();
        if ($request->isMethod(Request::METHOD_POST)) {
            (new OrderService($request->getSession()))->addProduct((int)$request->request->get('product'));
        }

        $productInfo = $product->getOne((int)$id);

        if ($productInfo === null) {
            return $this->render('error404.html.php');
        }

        $isInBasket = (new OrderService($request->getSession()))->isProductInBasket($productInfo->getId());

        return $this->render(
            'product/info.html.php',
            [
                'productInfo' => $productInfo,
                'isInBasket' => $isInBasket
        ]);
    }

    /**
     * Список всех продуктов
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        // Урок 4. Применить паттерн Стратегия
        // $request->query->get('sort') // 'price' - cортировка по цене
        // $request->query->get('sort') // 'name' - cортировка по имени

        $productService = new ProductService();
        $productsList = $productService->getAll();

        $sortingParam = $request->query->get('sort') ?? 'name';
        $sorter = ($sortingParam === 'price') ? (new PriceSorter()) : (new NameSorter());

        $productsSorted = $productService->sort($sorter, $productsList);

        return $this->render('product/list.html.php', ['productList' => $productsSorted]);
    }
}
