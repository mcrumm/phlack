<?php

trait ParameterTrait
{
    public function toMethodName($parameter)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $parameter)));
    }
}
