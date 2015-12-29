<?php

namespace Crummy\Phlack\WebHook\Reply;

use Crummy\Phlack\Common\Hash;

class Reply extends Hash
{
    protected $required = ['text'];
    protected $defaults = ['text' => ''];

    /**
     * @param mixed $data
     */
    public function __construct($data = [])
    {
        if (!is_array($data) && !empty($data)) {
            $data = ['text' => $data];
        }

        parent::__construct($data);
    }

    /**
     * Returns only the text value.
     *
     * @return array
     */
    public function toArray()
    {
        return ['text' => $this->data['text']];
    }
}
