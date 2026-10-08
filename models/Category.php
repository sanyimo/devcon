<?php

namespace Model;

class Category extends ActiveRecord {
    protected static $tabla = 'categories';
    protected static $columnsDB = ['id', 'name'];

    public mixed $id;
    public mixed $name;
}