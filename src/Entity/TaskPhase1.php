<?php
// src/Entity/Task.php
namespace App\Entity;

class TaskPhase1
{
    protected $address;
    protected $icon;
    protected $color;

    public function getLocation()
    {
        return $this->address;
    }

    public function setLocation($address)
    {
        $this->address = $address;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setIcon($icon = null)
    {
        $this->icon = $icon;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color = null)
    {
        $this->color = $color;
    }
}
?>
