<?php

namespace Pupper\Pupper;

class Event
{
    /** @var string $name */
    private $name;
    /** @var string $value */
    private $value;

    /**
     * @param string $name
     * @param string $value
     */
    public function __construct(string $name = null, string $value = null)
    {
        if (null !== $name) {
            $this->name = $name;
        }
        if (null !== $value) {
            $this->value = $value;
        }
    }

    /**
     * @param string $body
     * @return Event
     * @throws \RuntimeException
     */
    public static function parse(string $body): Event
    {
        $json = json_decode($body, true);
        if (!array_key_exists('name', $json) || !array_key_exists('value', $json)) {
            throw  new \RuntimeException('name & value expected, got ' . implode(', ', array_keys($json)));
        }
        return (new self)
            ->setName($json['name'])
            ->setValue($json['value']);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Event
     */
    public function setName(string $name): Event
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return Event
     */
    public function setValue(string $value): Event
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function build(): string
    {
        return json_encode([
            'name' => $this->name,
            'value' => $this->value
        ]);
    }
}
