<?php

namespace App\Support;

class Notify
{

    private $text;
    private $actionText;
    private $actionTextColor;
    private $backgroundColor;
    private $pos;
    private $duration;

    function __construct()
    {
        $this->pos = 'bottom-right';
        $this->actionText = 'OK';
        $this->actionTextColor = '#FFF';
        $this->duration = 5000;
    }

    function getText()
    {
        return $this->text;
    }

    function getActionTextColor()
    {
        return $this->actionTextColor;
    }

    function getActionText()
    {
        return $this->actionText;
    }

    function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    function getPos()
    {
        return $this->pos;
    }


    public function getDuration()
    {
        return $this->duration;
    }

    public function success(string $message): Notify
    {
        $this->text = $message;
        $this->backgroundColor = '#1abc9c';
        return $this;
    }

    public function error(string $message): Notify
    {
        $this->text = $message;
        $this->backgroundColor = '#e2a03f';
        return $this;
    }

    public function info(string $message): Notify
    {
        $this->text = $message;
        $this->backgroundColor = '#2196f3';
        return $this;
    }

    public function warning(string $message): Notify
    {
        $this->text = $message;
        $this->backgroundColor = '#e2a03f';
        return $this;
    }

    public function primary(string $message): Notify
    {
        $this->text = $message;
        $this->backgroundColor = '#4361ee';
        return $this;
    }

    public function custom(string $message, string $actionTextColor, string $actionText, string $backgroundColor, string $pos, int $duration): Notify
    {
        $this->text = $message;
        $this->actionTextColor = $actionTextColor;
        $this->actionText = $actionText;
        $this->backgroundColor = $backgroundColor;
        $this->pos = $pos;
        $this->duration = $duration;
        return $this;
    }

    public function render()
    {
        return [
            'text' => $this->getText(),
            'backgroundColor' => $this->getBackgroundColor(),
            'actionTextColor' => $this->getActionTextColor(),
            'actionText' => $this->getActionText(),
            'pos' => $this->getPos(),
            'duration' => $this->getDuration()
        ];
    }

}
