<?php

namespace Model;

class User extends ActiveRecord {
    protected static $tabla = 'users';
    protected static $columnsDB = ['id', 'name', 'surname', 'email', 'password', 'confirmed', 'token', 'admin'];
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? '';
        $this->surname = $args['surname'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->confirmed = $args['confirmed'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->admin = $args['admin'] ?? 0;
    }

    // Validar el Login de Usuarios
    public function validateLogin() {
        if(!$this->email) {
            self::$alerts['error'][] = 'El e-mail del usuario es obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'E-mail no válido';
        }
        if(!$this->password) {
            self::$alerts['error'][] = 'El campo &laquo;Contraseña&raquo; no puede ir vacío';
        }
        return self::$alerts;

    }

    // Validación para cuentas nuevas
    public function validate_account() {
        if(!$this->name) {
            self::$alerts['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->surname) {
            self::$alerts['error'][] = 'El apellido es obligatorio';
        }
        if(!$this->email) {
            self::$alerts['error'][] = 'El e-mail es obligatorio';
        }
        if(!$this->password) {
            self::$alerts['error'][] = 'El campo &laquo;Contraseña&raquo; no puede ir vacío';
        }
        if(strlen($this->password) < 6) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2) {
            self::$alerts['error'][] = 'Las contraseñas no coinciden';
        }
        return self::$alerts;
    }

    // Valida un email
    public function validateEmail() {
        if(!$this->email) {
            self::$alerts['error'][] = 'El e-mail es obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'E-mail no válido';
        }
        return self::$alerts;
    }
}