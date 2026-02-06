<?php

namespace RactStudio\FrameStudio\Events;

class Dispatcher
{
    /**
     * The registered event listeners.
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * Register an event listener with the dispatcher.
     *
     * @param  string|array  $events
     * @param  mixed  $listener
     * @return void
     */
    public function listen($events, $listener)
    {
        foreach ((array) $events as $event) {
            $this->listeners[$event][] = $listener;
            
            // Also hook into WordPress actions if necessary
            // add_action($event, ...); 
        }
    }

    /**
     * Determine if a given event has listeners.
     *
     * @param  string  $eventName
     * @return bool
     */
    public function hasListeners($eventName)
    {
        return isset($this->listeners[$eventName]);
    }

    /**
     * Fire an event and call the listeners.
     *
     * @param  string|object  $event
     * @param  mixed  $payload
     * @return array|null
     */
    public function dispatch($event, $payload = [])
    {
        // If event is an object, use its class name
        $eventName = is_object($event) ? get_class($event) : $event;

        // If no listeners, just return
        if (! isset($this->listeners[$eventName])) {
             // Fallback to WP do_action if needed?
             // do_action($eventName, ...$payload);
             return;
        }

        $responses = [];

        foreach ($this->listeners[$eventName] as $listener) {
            $response = call_user_func_array($listener, is_array($payload) ? $payload : [$payload]);
            $responses[] = $response;
        }

        return $responses;
    }
}
