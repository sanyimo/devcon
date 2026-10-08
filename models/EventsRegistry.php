<?php

namespace Model;

class EventsRegistry extends ActiveRecord {
    protected static $tabla = 'events_records';
    protected static $columnsDB = ['id', 'event_id', 'record_id'];

    public mixed $id;
    public ?int $event_id;
    public ?int $record_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->event_id = $args['event_id'] ?? null;
        $this->record_id = $args['record_id'] ?? null;
    }
}