<?php

namespace Model;

class Pack extends ActiveRecord {
    protected static $tabla = 'packs';
    protected static $columnsDB = ['id', 'name'];

    public mixed $id;
    public mixed  $name;
}