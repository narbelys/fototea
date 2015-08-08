<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rreimi
 * Date: 6/16/14
 * Time: 3:03 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Fototea\Models;

class Cart {

    const CART_SESSION_KEY = 'fototea-session-key-eQ3wfxi5';
    private $session;

    public function __construct(\Fototea\App\SessionHandler $session) {
        $this->session = $session;
    }

    /**
     * Add new product to cart
     *
     * @param $productId
     * @param $productPrice
     * @param $productData
     */
    public function addItem($productId, $productPrice, $productData) {
        $data = $this->getCartData();
        $item = new \stdClass();
        $item->id = $productId;
        $item->price = $productPrice;
        $item->data = $productData;
        $data->items[] = $item;
    }

    /**
     * Get car totals
     *
     * @return float
     */
    public function getSubtotal() {
        $total = 0.0;

        foreach ($this->getItems() as $item) {
            $total += (float) $item->price;
        }

        return $total;
    }

    /**
     * Return array of items in the cart
     */
    public function getItems() {
        $data = $this->getCartData();
        return $data->items;
    }

    public function isEmpty() {
        $data = $this->getCartData();
        if (!empty($data->items)) {
            return false;
        }
        return true;
    }

    /**
     * Clear cart
     */
    public function clear() {
        $this->session->remove(self::CART_SESSION_KEY);
    }

    private function getCartData() {
        $data = $this->session->get(self::CART_SESSION_KEY);

        if (!isset($data)){
            $data = new \stdClass();
            $data->items = array();
            $this->setCartData($data);
            return $data;
        }

        return $data;
    }

    private function setCartData($data) {
        $this->session->set(self::CART_SESSION_KEY, $data);
    }
}