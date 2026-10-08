<?php 

namespace Model;

class Record extends ActiveRecord {
    protected static $tabla = 'records';
    protected static $columnsDB = ['id', 'pack_id', 'payment_id', 'token', 'user_id', 'gift_id'];

    public mixed $id;
    public mixed $pack_id;
    public mixed $payment_id;
    public mixed $token;
    public mixed $user_id;
    public mixed $gift_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->pack_id = $args['pack_id'] ?? '';
        $this->payment_id = $args['payment_id'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->user_id = $args['user_id'] ?? '';
        $this->gift_id = $args['gift_id'] ?? 1;
    }

}