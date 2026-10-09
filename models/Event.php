<?php
namespace Model;

class Event extends ActiveRecord {
    protected static $tabla = 'events';
    protected static $columnsDB = ['id', 'name_es', 'name_en', 'description_es', 'description_en', 'availables', 'category_id', 'day_id', 'hour_id', 'speaker_id'];

    public mixed $id;
    public mixed $name_es;
    public mixed $name_en;
    public mixed $description_es;
    public mixed $description_en;
    public mixed $availables;
    public mixed $category_id;
    public mixed $day_id;
    public mixed $hour_id;
    public mixed $speaker_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name_es = $args['name_es'] ?? '';
        $this->name_en = $args['name_en'] ?? '';
        $this->description_es = $args['description_es'] ?? '';
        $this->description_en = $args['description_en'] ?? '';
        $this->availables = $args['availables'] ?? '';
        $this->category_id = $args['category_id'] ?? '';
        $this->day_id = $args['day_id'] ?? '';
        $this->hour_id = $args['hour_id'] ?? '';
        $this->speaker_id = $args['speaker_id'] ?? '';
    }

    // Validation messages for event creation
    public function validate() {
        if(!$this->name_es) {
            self::$alerts['error'][] = t('El nombre en español es obligatorio');
        }
        if(!$this->name_en) {
            self::$alerts['error'][] = t('El nombre en inglés es obligatorio');
        }
        if(!$this->description_es) {
            self::$alerts['error'][] = t('La descripción en español es obligatoria');
        }
        if(!$this->description_en) {
            self::$alerts['error'][] = t('La descripción en inglés es obligatoria');
        }
        if(!$this->category_id  || !filter_var($this->category_id, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = t('Elige una categoría');
        }
        if(!$this->day_id  || !filter_var($this->day_id, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = t('Elige el día del evento');
        }
        if(!$this->hour_id  || !filter_var($this->hour_id, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = t('Elige la hora del evento');
        }
        if(!$this->availables  || !filter_var($this->availables, FILTER_VALIDATE_INT)) {
            self::$alerts['error'][] = t('Añade una cantidad de cupos disponibles');
        }
        if(!$this->speaker_id || !filter_var($this->speaker_id, FILTER_VALIDATE_INT) ) {
            self::$alerts['error'][] = t('Selecciona la persona encargada del evento');
        }

        return self::$alerts;
    }
}
