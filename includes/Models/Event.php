<?php

namespace BeetleTracking\Models;

class Event
{
    protected $category;
    protected $name;

    public $params = array();
    public $settings = array(
        'delay' => 0
    );

    public function __construct($name, $category, $params = [])
    {
        $this->name = $name;
        $this->category = $category;

        if (is_array($params)) {
            $this->params = array_merge($this->params, $params);
        }
    }

    public function addParams($data)
    {
        if (is_array($data)) {
            $this->params = array_merge($this->params, $data);
        }
    }

    public function addSettings($data)
    {
        if (is_array($data)) {
            $this->settings = array_merge($this->settings, $data);
        }
    }

    /**
     * @return array
     */
    public function getEvent()
    {
        return [
            'name' => $this->name,
            'params' => $this->params,
            'settings' => $this->settings,
            'category' => $this->category
        ];
    }

    public function get($key)
    {
        return isset($this->{$key}) ? $this->{$key} : null;
    }
}
