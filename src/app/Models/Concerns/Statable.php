<?php

namespace App\Models\Concerns;

use Exception;
use SM\Factory\FactoryInterface;
use SM\SMException;
use SM\StateMachine\StateMachine;

trait Statable
{
    /**
     * @var StateMachine $stateMachine
     */
    protected $stateMachine;

    public function stateMachine()
    {
        if (!$this->stateMachine) {
            try {
                $this->stateMachine = app(FactoryInterface::class)->get($this, self::SM_CONFIG);
            } catch (Exception $e) {
                throw($e);
            }
        }
        return $this->stateMachine;
    }

    public function stateIs()
    {
        return $this->stateMachine()->getState();
    }

    public function transition($transition)
    {
        try {
            return $this->stateMachine()->apply($transition);
        } catch (SMException $e) {
            return dd($e);
        }
    }

    public function transitionAllowed($transition)
    {
        return $this->stateMachine()->can($transition);
    }
}
