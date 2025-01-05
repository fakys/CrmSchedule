<?php
namespace App\Src\access\models;

use Illuminate\Support\Facades\Route;

class AccessModel{
    protected string $access;

    protected $route;

    protected string $redirect_route;

    protected $description;

    public function setAccess(string $access): AccessModel
    {
        $this->access = $access;
        return $this;
    }

    public function setRoute($route)
    {
        $this->route = $route;
        return $this;
    }


    public function setRedirectRoute(string $route): AccessModel
    {
        $this->redirect_route = $route;
        return $this;
    }

    public function setDescription($description){
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccess()
    {
        return $this->access;
    }

    /**
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }


    /**
     * @return string
     */
    public function getRedirectRoute()
    {
        return $this->redirect_route;
    }


    public function getDescription(){
        return $this->description;
    }
}
