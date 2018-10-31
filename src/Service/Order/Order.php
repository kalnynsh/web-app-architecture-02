<?php

declare(strict_types = 1);

namespace Service\Order;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Order
{
    /**
     * Сессионный ключ списка всех продуктов корзины
     */
    private const BASKET_DATA_KEY = 'basket';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Добавляем товар в заказ
     *
     * @param int $product
     *
     * @return void
     */
    public function addProduct(int $product): void
    {
        $basket = $this->session->get(static::BASKET_DATA_KEY, []);
        if (!in_array($product, $basket, true)) {
            $basket[] = $product;
            $this->session->set(static::BASKET_DATA_KEY, $basket);
        }
    }

    /**
     * Получаем список id товаров корзины
     *
     * @return array
     */
    public function getProducts(): array
    {
        return $this->session->get(static::BASKET_DATA_KEY, []);
    }

    /**
     * Проверяем, лежит ли продукт в корзине или нет
     *
     * @param int $productId
     *
     * @return bool
     */
    public function isProductInBasket(int $productId): bool
    {
        return in_array($productId, $this->getProducts(), true);
    }

    public function getTotalPrice()
    {
    }
}
