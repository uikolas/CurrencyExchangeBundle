<?php

namespace CurrencyExchangeBundle\CurrencyPair;

class CurrencyPair
{
    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * CurrencyPair constructor.
     * @param string $from
     * @param string $to
     */
    public function __construct($from, $to)
    {
        $this->from = strtoupper($from);
        $this->to   = strtoupper($to);
    }

    /**
     * @param string $from
     * @param string $to
     * @return CurrencyPair
     */
    public static function create($from, $to)
    {
        return new self($from, $to);
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }
}