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
    
    // Database
    protected static \mysqli $db;
    protected static $tabla = '';
    protected static $columnsDB = [];

    // Alerts and messages
    protected static $alerts = [];
    
    // Set the database connection - includes/database.php
    public static function setDB(\mysqli $database) {
        self::$db = $database;
    }

    // Set an alert type
    public static function setAlert(string $type, string $message): void {
        static::$alerts[$type][] = $message;
    }

    // Get the alerts
    public static function getAlerts() {
        return static::$alerts;
    }

    // Validation inherited by models
    public function validate() {
        static::$alerts = [];
        return static::$alerts;
    }

    // SQL query to create an object in memory (Active Record)
    public static function consultSQL(string $query): array {
        // Query the database
        $result = self::$db->query($query);

        // Iterate over the results
        $array = [];
        while($record = $result->fetch_assoc()) {
            $array[] = static::createObject($record);
        }

        // Free the memory
        $result->free();

        // Return the results
        return $array;
    }

    // Create an in-memory object matching the database record
    protected static function createObject(array $record): static {
        $object = new static;

        foreach($record as $key => $value ) {
            if(property_exists($object, $key  )) {
                $object->$key = $value;
            }
        }
        return $object;
    }

    // Identify and collect database attributes
    public function attributes() {
        $attributes = [];
        foreach(static::$columnsDB as $column) {
            if($column === 'id') continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    // Sanitize data before saving it to the database
    public function sanitizeAttributes():array{
        $attributes = $this->attributes();
        $sanitizado = [];
        foreach($attributes as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Synchronize the database with in-memory objects
    public function syncronize($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Records - CRUD
    public function save() {
        $result = '';
        if(!is_null($this->id)) {
            // update
            $result = $this->update();
        } else {
            // Create a new record
            $result = $this->create();
        }
        return $result;
    }

    // Get all records
    public static function all($orden = 'DESC') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id $orden";
        $result = self::consultSQL($query);
        return $result;
    }

    // Find a record by its ID
    public static function find(int|string $id): ?static {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = $id";
        $result = self::consultSQL($query);
        return array_shift($result);
    }

    // Get a limited number of records
    public static function get(int $limite): array {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT $limite ";
        $result = self::consultSQL($query);
        return $result;
    }
    // Paginate records
    public static function paginate(int $per_page, int $offset): array {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT $per_page OFFSET $offset ";
        $result = self::consultSQL($query);
        return $result;
    }

    // Find by a column 
    public static function where(string $column, mixed $value): ?static {
        $query = "SELECT * FROM " . static::$tabla . " WHERE $column = '$value'";
        $result = self::consultSQL($query);
        return array_shift($result);
    }

    // Return records ordered by a column
    public static function order(string $column, string $orden): array {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY $column $orden "; 
        $result = self::consultSQL($query);
        return $result;
    }
    // Return records ordered with a limit
    public static function orderLimit(string $column, string $orden, int $limite): array {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY $column $orden LIMIT $limite "; 
        $result = self::consultSQL($query);
        return $result;
    }

    // Find by multiple conditions
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
    
    // Get the total number of records
    public static function total($column = '', $value = '') {
        $query = "SELECT COUNT(*) FROM " . static::$tabla;
        if($column) {
            $query .= " WHERE $column = $value";
        }
        $result = self::$db->query($query);
        $total = $result->fetch_array();

        return array_shift($total);
    }

    // Total records with multiple conditions
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

    // Create a new record
    public function create(): array {
        // Sanitize the data
        $attributes = $this->sanitizeAttributes();

        // Insert into the database
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($attributes));
        $query .= " ') ";

        // debug($query);

        // Query result
        $result = self::$db->query($query);
        return [
           'result' =>  $result,
           'id' => self::$db->insert_id
        ];
    }

    // Update record
    public function update() {
        // Sanitize the data
        $attributes = $this->sanitizeAttributes();

        // Iterate through each database field
        $valuees = [];
        foreach($attributes as $key => $value) {
            $valuees[] = "{$key}='{$value}'";
        }

        // SQL query
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valuees );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // Update the database
        $result = self::$db->query($query);
        return $result;
    }

    // Delete a record by its ID
    public function delete() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $result = self::$db->query($query);
        return $result;
    }
    // Check the password
    public function check_password(): bool
    {
        return password_verify($this->current_password, $this->password);
    }

    // Hash the password
    public function hashPassword(): void
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generate a token
    public function createToken(): void
    {
        $this->token = md5(uniqid());
    }
    // Validate the password 
    public function validatePassword()
    {
        if (!$this->password) {
            self::$alerts['error'][] = t('El campo &laquo;Contraseña&raquo; no puede ir vacío');
        }
        if (strlen($this->password) < 6) {
            self::$alerts['error'][] = t('La contraseña debe contener al menos 6 caracteres');
        }
        return self::$alerts;
    }

    public function new_password(): array
    {
        if (!$this->current_password) {
            self::$alerts['error'][] = t('El campo &laquo;Contraseña actual&raquo; no puede ir vacío');
        }
        if (!$this->new_password) {
            self::$alerts['error'][] = t('El campo &laquo;Nueva contraseña&raquo; no puede ir vacío');
        }
        if (strlen($this->new_password) < 6) {
            self::$alerts['error'][] = t('La contraseña debe contener al menos 6 caracteres');
        }
        return self::$alerts;
    }
}