<?php

namespace RactStudio\FrameStudio\Database;

class Connection
{
    /**
     * The active PDO connection.
     *
     * @var \wpdb
     */
    protected $wpdb;

    /**
     * Create a new database connection instance.
     *
     * @return void
     */
    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
    }

    /**
     * Get the underlying WPDB instance.
     *
     * @return \wpdb
     */
    public function getWpdb()
    {
        return $this->wpdb;
    }

    /**
     * Begin a fluent query against a database table.
     *
     * @param  string  $table
     * @return \RactStudio\FrameStudio\Database\Query\Builder
     */
    public function table($table)
    {
        return (new Query\Builder($this))->from($table);
    }
    
    /**
     * Get the table prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->wpdb->prefix;
    }
}
