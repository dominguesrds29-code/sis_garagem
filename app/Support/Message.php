<?php

namespace App\Support;

class Message
{
    
    private $title;
    private $text;
    private $type;
    private $okButton;
    private $cancelButton;
    private $route;
    private $action;
    private $callback;
    private $id;
    
    public function __construct()
    {
        $this->title = 'Mensagem';
        $this->text = 'Sua Mensagem Aqui';
        $this->type = 'success';
        $this->okButton = 'OK';
        $this->cancelButton = 'Cancelar';
        $this->route = null;
        $this->action = null;
        $this->callback = null;
        $this->id = null;
    }
    
    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }
    
    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * @return mixed
     */
    public function getOkButton()
    {
        return $this->okButton;
    }
    
    /**
     * @return mixed
     */
    public function getCancelButton()
    {
        return $this->cancelButton;
    }
    
    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }
    
    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }
    
    /**
     * @return mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function info($title, $text): Message
    {
        $this->title = $title;
        $this->text = $text;
        $this->type = 'info';
        return $this;
    }
    
    public function warning($title, $text): Message
    {
        $this->title = $title;
        $this->text = $text;
        $this->type = 'warning';
        return $this;
    }
    
    public function error($title, $text): Message
    {
        $this->title = $title;
        $this->text = $text;
        $this->type = 'error';
        return $this;
    }
    
    public function success($title, $text): Message
    {
        $this->title = $title;
        $this->text = $text;
        $this->type = 'success';
        return $this;
    }
    
    public function customMsg($title, $text, $type, $okButton, $cancelButton, $route, $action, $callback, $id): Message
    {
        $this->title = $title;
        $this->text = $text;
        $this->type = $type;
        $this->okButton = $okButton;
        $this->cancelButton = $cancelButton;
        $this->route = $route;
        $this->action = $action;
        $this->id = $id;
        return $this;
    }
    
    public function render()
    {
        return [
            'title' => $this->getTitle(),
            'text' => $this->getText(),
            'type' => $this->getType(),
            'okButton' => $this->getOkButton(),
            'cancelButton' => $this->getCancelButton(),
            'route' => $this->getRoute(),
            'action' => $this->getAction(),
            'callback' => $this->getCallback(),
            'id' => $this->getId(),
        ];
    }
    
}
