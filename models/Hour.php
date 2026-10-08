<?php

namespace Model;

class Hour extends ActiveRecord {
    protected static $tabla = 'hours';
    protected static $columnsDB = ['id', 'hour'];

    public mixed $id;
    public mixed $hour;
}