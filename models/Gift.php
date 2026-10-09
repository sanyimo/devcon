<?php

namespace Model;

class Gift extends ActiveRecord {
    protected static $tabla = 'gifts';
    protected static $columnsDB = ['id', 'name_es', 'name_en', 'quantity'];
    public mixed $id;
    public mixed $name_es;
    public mixed $name_en;
    public mixed $quantity;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->name_es = $args['name_es'] ?? '';
        $this->name_en = $args['name_en'] ?? '';
        $this->quantity = $args['quantity'] ?? 0;
    }

    public static function reservations (int $gift_id): int {
        $query = "SELECT COUNT(*) FROM records WHERE gift_id = $gift_id";
        $result = self::$db->query($query);
        $total = $result->fetch_array();

        return (int) array_shift($total);
    }

    // Validation messages for event creation
    public function validate(): array
    {
        self::$alerts = [];

        if (trim((string) $this->name_es) === '') {
            self::$alerts['error'][] = t('El nombre en español es obligatorio');
        }

        if (trim((string) $this->name_en) === '') {
            self::$alerts['error'][] = t('El nombre en inglés es obligatorio');
        }

        if ($this->quantity === '' || $this->quantity === null || !is_numeric($this->quantity) || (int) $this->quantity < 1) {
            self::$alerts['error'][] = t('La cantidad debe ser mayor que cero');
        }

        return self::$alerts;
    }
}