<?php

declare(strict_types = 1);

namespace Service\Product;

use Model;

class Product
{
    /**
     * Получаем конкретный продукт
     *
     * @param int $id
     * @return Model\Entity\Product|null
     */
    public function getOne(int $id): ?Model\Entity\Product
    {
        $product = $this->getProductRepository()->search([$id]);
        return count($product) ? $product[0] : null;
    }

    /**
     * Получаем коллекцию продуктов
     *
     * @param int[] $ids
     * @return Model\Entity\Product[]
     */
    public function getCollection(array $ids): array
    {
        return $this->getProductRepository()->search($ids);
    }

    /**
     * Получаем все продукты
     *
     * @return Model\Entity\Product[]
     */
    public function getAll(): array
    {
        return $this->getProductRepository()->fetchAll();
    }

    /**
     * Фабричный метод для репозитория Product
     *
     * @return Model\Repository\Product
     */
    protected function getProductRepository(): Model\Repository\Product
    {
        return new Model\Repository\Product();
    }
}
