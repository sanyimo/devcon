<?php

namespace Model;

class Gift extends ActiveRecord {
    protected static $tabla = 'gifts';
    protected static $columnsDB = ['id', 'name', 'quantity'];
    public mixed $id;
    public mixed $name;
    public mixed $quantity;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->quantity = $args['quantity'] ?? 0;
    }

    public static function reservations (int $gift_id): int {
        $query = "SELECT COUNT(*) FROM records WHERE gift_id = $gift_id";
        $result = self::$db->query($query);
        $total = $result->fetch_array();

        return (int) array_shift($total);
    }
}