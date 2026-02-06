<?php

namespace RactStudio\FrameStudio\Database;

use RactStudio\FrameStudio\Support\Str;

abstract class Model implements \JsonSerializable
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be independently timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The model's original attributes.
     *
     * @var array
     */
    protected $original = [];

    /**
     * Indicates if the model exists.
     *
     * @var bool
     */
    public $exists = false;

    /**
     * Create a new model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param  array  $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
        return $this;
    }

    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    public function jsonSerialize()
    {
        return $this->attributes;
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        if (! isset($this->table)) {
            // Simple pluralizer fallback or need Str helper
            $className = basename(str_replace('\\', '/', get_class($this)));
            $this->table = strtolower($className) . 's'; 
        }

        return $this->table;
    }

    /**
     * Begin querying the model.
     *
     * @return \RactStudio\FrameStudio\Database\Query\Builder
     */
    public static function query()
    {
        return (new static)->newQuery();
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @return \RactStudio\FrameStudio\Database\Query\Builder
     */
    public function newQuery()
    {
        return app('db')->table($this->getTable());
    }

    /**
     * Handle dynamic method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->newQuery()->$method(...$parameters);
    }

    /**
     * Save the model to the database.
     *
     * @return bool
     */
    public function save()
    {
        $query = $this->newQuery();

        if ($this->exists) {
            $this->performUpdate($query);
        } else {
            $this->performInsert($query);
        }

        return true;
    }

    protected function performInsert($query)
    {
        // Simple insert wrapper using WPDB via Connection/Builder
        // Ideally Builder has insert() method. Assuming it does or we use DB::table
        
        // For now, let's use the DB facade helper to be safe if Builder is incomplete
        global $wpdb;
        $table = $query->calculateTableName(); // We need to expose table name
        
        $wpdb->insert($table, $this->attributes);
        $this->attributes[$this->primaryKey] = $wpdb->insert_id;
        $this->exists = true;
    }

    protected function performUpdate($query)
    {
        global $wpdb;
        $table = $query->calculateTableName();
        
        $wpdb->update(
            $table, 
            $this->attributes, 
            [$this->primaryKey => $this->attributes[$this->primaryKey]]
        );
    }
    
    public function delete()
    {
        global $wpdb;
        $table = $this->newQuery()->calculateTableName();
        $wpdb->delete($table, [$this->primaryKey => $this->attributes[$this->primaryKey]]);
        $this->exists = false;
        return true;
    }

    public static function all()
    {
        $instance = new static;
        global $wpdb;
        $table = $instance->newQuery()->calculateTableName();
        $results = $wpdb->get_results("SELECT * FROM {$table}", ARRAY_A);
        
        return array_map(function($item) use ($instance) {
            return $instance->newFromBuilder($item);
        }, $results);
    }
    
    public static function find($id)
    {
        $instance = new static;
        global $wpdb;
        $table = $instance->newQuery()->calculateTableName();
        $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$table} WHERE {$instance->primaryKey} = %d", $id), ARRAY_A);
        
        if (!$row) return null;
        
        return $instance->newFromBuilder($row);
    }
    
    public function newFromBuilder($attributes = [])
    {
        $model = new static((array) $attributes);
        $model->exists = true;
        return $model;
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }
}
