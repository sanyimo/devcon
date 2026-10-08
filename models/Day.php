<?php

namespace Model;

class Day extends ActiveRecord {
    protected static $tabla = 'days';
    protected static $columnsDB = ['id', 'name'];

    public mixed $id;
    public mixed $name;
}