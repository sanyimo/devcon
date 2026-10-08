<?php 

namespace Model;

class Speaker extends ActiveRecord {
    protected static $tabla = 'speakers';
    protected static $columnsDB = ['id', 'name', 'surname', 'city', 'country', 'image', 'tags', 'social_networks'];

    public mixed $id;
    public mixed $name;
    public mixed $surname;
    public string $city;
    public string $country;
    public mixed $image;
    public string $tags;
    public mixed $social_networks;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->surname = $args['surname'] ?? '';
        $this->city = $args['city'] ?? '';
        $this->country = $args['country'] ?? '';
        $this->image = $args['image'] ?? '';
        $this->tags = $args['tags'] ?? '';
        $this->social_networks = $args['social_networks'] ?? '';
    }
    public function validate() {
        if(!$this->name) {
            self::$alerts['error'][] = 'El nombre es necesario';
        }
        if(!$this->surname) {
            self::$alerts['error'][] = '&laquo; Apellido &raquo; es necesario';
        }
        if(!$this->city) {
            self::$alerts['error'][] = '&laquo; Ciudad &raquo; es necesario';
        }
        if(!$this->country) {
            self::$alerts['error'][] = '&laquo; País &raquo; es necesario';
        }
        if(!$this->image) {
            self::$alerts['error'][] = 'La imagen es necesaria';
        }
        if(!$this->tags) {
            self::$alerts['error'][] = '&laquo; Áreas &raquo; es necesario';
        }
        return self::$alerts;
    }
}