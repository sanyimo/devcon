<?php
namespace Model;

#[\AllowDynamicProperties]
class ActiveRecord {
    public mixed $id;
    public mixed $name;
    public mixed $hour_id;
    public mixed $day_id;
    public mixed $category_id;
    public mixed $speaker_id;
    public mixed $availables;
    public mixed $user_id;
    public mixed $pack_id;
    public mixed $social_networks;
    public mixed $image;
    public mixed $email;
    public mixed $confirmed;
    public mixed $phone;
    public mixed $surname;
    public mixed $password;
    public mixed $password2;
    public mixed $current_password;
    public mixed $new_password;
    public mixed $repeat_password;
    public mixed $token;
    public mixed $admin;
    public mixed $current_image;
    public mixed $new_image;
    public mixed $new_image_2;
    
    // Base DE DATOS
    protected static \mysqli $db;
    protected static $tabla = '';
    protected static $columnsDB = [];

    // Alertas y Mensajes
    protected static $alerts = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB(\mysqli $database) {
        self::$db = $database;
    }

    // Setear un tipo de Alerta
    public static function setAlert(string $type, string $message): void {
        static::$alerts[$type][] = $message;
    }

    // Obtener las alertas
    public static function getAlerts() {
        return static::$alerts;
    }

    // Validación que se hereda en modelos
    public function validate() {
        static::$alerts = [];
        return static::$alerts;
    }

    // Consulta SQL para crear un objeto en Memoria (Active Record)
    public static function consultSQL(string $query): array {
        // Consultar la base de datos
        $result = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($record = $result->fetch_assoc()) {
            $array[] = static::createObject($record);
        }

        // liberar la memoria
        $result->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function createObject(array $record): static {
        $object = new static;

        foreach($record as $key => $value ) {
            if(property_exists($object, $key  )) {
                $object->$key = $value;
            }
        }
        return $object;
    }

    // Identificar y unir los atributos de la BD
    public function attributes() {
        $attributes = [];
        foreach(static::$columnsDB as $column) {
            if($column === 'id') continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizeAttributes():array{
        $attributes = $this->attributes();
        $sanitizado = [];
        foreach($attributes as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function syncronize($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    public function save() {
        $result = '';
        if(!is_null($this->id)) {
            // update
            $result = $this->update();
        } else {
            // Creando un nuevo registro
            $result = $this->create();
        }
        return $result;
    }

    // Obtener todos los Registros
    public static function all($orden = 'DESC') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id $orden";
        $result = self::consultSQL($query);
        return $result;
    }

    // Busca un registro por su id
    public static function find(int|string $id): ?static {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = $id";
        $result = self::consultSQL($query);
        return array_shift($result);
    }

    // Obtener Registros con cierta cantidad
    public static function get(int $limite): array {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT $limite ";
        $result = self::consultSQL($query);
        return $result;
    }
    // Paginar los registros
    public static function paginate(int $per_page, int $offset): array {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT $per_page OFFSET $offset ";
        $result = self::consultSQL($query);
        return $result;
    }

    // Busqueda Where con Columna 
    public static function where(string $column, mixed $value): ?static {
        $query = "SELECT * FROM " . static::$tabla . " WHERE $column = '$value'";
        $result = self::consultSQL($query);
        return array_shift($result);
    }

    // Retornar los registros por un orden
    public static function order(string $column, string $orden): array {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY $column $orden "; 
        $result = self::consultSQL($query);
        return $result;
    }
    // Retornar por orden y con un limite
    public static function orderLimit(string $column, string $orden, int $limite): array {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY $column $orden LIMIT $limite "; 
        $result = self::consultSQL($query);
        return $result;
    }

    // Busqueda Where con Múltiples opciones
    public static function whereArray($array = []) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ";
        foreach($array as $key => $value) {
            if($key == array_key_last($array)) {
                $query .= " $key = '$value'";
            } else {
                $query .= " $key = '$value' AND ";
            }
        }
        $result = self::consultSQL($query);
        return $result;
    }
    
    // Traer un total de registros
    public static function total($column = '', $value = '') {
        $query = "SELECT COUNT(*) FROM " . static::$tabla;
        if($column) {
            $query .= " WHERE $column = $value";
        }
        $result = self::$db->query($query);
        $total = $result->fetch_array();

        return array_shift($total);
    }

    // Total de Registros con un Array Where
    public static function totalArray($array = []) {
        $query = "SELECT COUNT(*) FROM " . static::$tabla . " WHERE ";
        foreach($array as $key => $value) {
            if($key == array_key_last($array)) {
                $query .= " $key = '$value' ";
            } else {
                $query .= " $key = '$value' AND ";
            }
        }
        $result = self::$db->query($query);
        $total = $result->fetch_array();
        return array_shift($total);
    }

    // crea un nuevo registro
    public function create(): array {
        // Sanitizar los datos
        $attributes = $this->sanitizeAttributes();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($attributes));
        $query .= " ') ";

        // debuguear($query); // Descomentar si no te funciona algo

        // Resultado de la consulta
        $result = self::$db->query($query);
        return [
           'result' =>  $result,
           'id' => self::$db->insert_id
        ];
    }

    // update registry
    public function update() {
        // Sanitizar los datos
        $attributes = $this->sanitizeAttributes();

        // Iterar para ir agregando cada campo de la BD
        $valuees = [];
        foreach($attributes as $key => $value) {
            $valuees[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valuees );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // update BD
        $result = self::$db->query($query);
        return $result;
    }

    // delete a Record por su ID
    public function delete() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $result = self::$db->query($query);
        return $result;
    }
    // Comprobar el password
    public function check_password(): bool
    {
        return password_verify($this->current_password, $this->password);
    }

    // Hashea el password
    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function createToken(): void
    {
        $this->token = md5(uniqid());
    }
    // Valida el Password 
    public function validatePassword()
    {
        if (!$this->password) {
            self::$alerts['error'][] = 'El campo &laquo;Contraseña&raquo; no puede ir vacío';
        }
        if (strlen($this->password) < 6) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        }
        return self::$alerts;
    }

    public function new_password(): array
    {
        if (!$this->current_password) {
            self::$alerts['error'][] = 'El campo &laquo;Contraseña actual&raquo; no puede ir vacío';
        }
        if (!$this->new_password) {
            self::$alerts['error'][] = 'El campo &laquo;Nueva contraseña&raquo; no puede ir vacío';
        }
        if (strlen($this->new_password) < 6) {
            self::$alerts['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        }
        return self::$alerts;
    }
}