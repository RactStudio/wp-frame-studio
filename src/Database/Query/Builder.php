<?php

namespace RactStudio\FrameStudio\Database\Query;

use RactStudio\FrameStudio\Database\Connection;

class Builder
{
    /**
     * The database connection instance.
     *
     * @var \RactStudio\FrameStudio\Database\Connection
     */
    protected $connection;

    /**
     * The table which the query is targeting.
     *
     * @var string
     */
    protected $from;

    /**
     * The columns that should be returned.
     *
     * @var array
     */
    protected $columns;

    /**
     * The where constraints for the query.
     *
     * @var array
     */
    protected $wheres = [];

    /**
     * The orderings for the query.
     *
     * @var array
     */
    protected $orders = [];

    /**
     * The maximum number of records to return.
     *
     * @var int
     */
    protected $limit;

    /**
     * The number of records to skip.
     *
     * @var int
     */
    protected $offset;

    /**
     * Create a new query builder instance.
     *
     * @param  \RactStudio\FrameStudio\Database\Connection  $connection
     * @return void
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Set the table which the query is targeting.
     *
     * @param  string  $table
     * @return $this
     */
    public function from($table)
    {
        $this->from = $table;
        return $this;
    }

    /**
     * Add a basic where clause to the query.
     *
     * @param  string  $column
     * @param  string|null  $operator
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $this->wheres[] = compact('column', 'operator', 'value', 'boolean');
        return $this;
    }

    /**
     * Add an "order by" clause to the query.
     *
     * @param  string  $column
     * @param  string  $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->orders[] = compact('column', 'direction');
        return $this;
    }

    /**
     * Set the "limit" value of the query.
     *
     * @param  int  $value
     * @return $this
     */
    public function limit($value)
    {
        $this->limit = $value;
        return $this;
    }

    /**
     * Get the prefixed table name.
     *
     * @return string
     */
    public function calculateTableName()
    {
        return $this->connection->getPrefix() . $this->from;
    }

    /**
     * Execute the query as a "select" statement.
     *
     * @param  array  $columns
     * @return array
     */
    public function get($columns = ['*'])
    {
        $this->columns = $columns;
        $sql = $this->toSql();
        
        // Use WPDB to execute
        // For simplicity, naive implementation
        return $this->connection->getWpdb()->get_results($sql);
    }
    
    /**
     * Get the SQL representation of the query.
     *
     * @return string
     */
    public function toSql()
    {
        // Construct SQL statement string based on $wheres, $orders, $limit, etc.
        // This is a minimal implementation placeholder
        
        $table = $this->connection->getPrefix() . $this->from;
        
        $sql = "SELECT * FROM {$table}";
        
        if (!empty($this->wheres)) {
            $sql .= " WHERE " . $this->compileWheres();
        }
        
        if (!empty($this->orders)) {
             $sql .= " ORDER BY " . $this->compileOrders();
        }
        
        if (isset($this->limit)) {
            $sql .= " LIMIT {$this->limit}";
        }
        
        return $sql;
    }
    
    protected function compileWheres()
    {
        // Basic compilation
        $sql = array();
        foreach($this->wheres as $where)
        {
             $value = is_numeric($where['value']) ? $where['value'] : "'" . esc_sql($where['value']) . "'";
             $sql[] = "{$where['column']} {$where['operator']} {$value}";
        }
        return implode(' AND ', $sql);
    }
    
    protected function compileOrders()
    {
        $sql = array();
        foreach($this->orders as $order)
        {
            $sql[] = "{$order['column']} {$order['direction']}";
        }
        return implode(', ', $sql);
    }
}
