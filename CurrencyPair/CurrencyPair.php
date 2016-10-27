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
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     */
    public function setFrom($from)
    {
        $this->from = strtoupper($from);
    }

    /**
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string $to
     */
    public function setTo($to)
    {
        $this->to = strtoupper($to);
    }
}