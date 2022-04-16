<?php

namespace core\TestFactory;

interface PhoneFactoryInterface
{
    public function create($data = []);
}

class PhoneFactory
{
    public function create($data = []): Phone
    {
        return new Phone($data);
    }
}

class SmartphoneFactory
{
    public function create($data = []): Smartphone
    {
        return new Smartphone($data);
    }
}

interface PhoneInterface
{
    public function getTitle(): string;
    public function getDescription(): string;
    public function getFunctions(): array;
}

class Phone implements PhoneInterface
{
    public $title;
    public $description;
    public $functions;

    public function __construct($data = [])
    {
        foreach (get_class_vars(__CLASS__) as $fieldTitle => $fieldValue) {
            if (isset($data[$fieldTitle])) {
                $this->$fieldTitle = $data[$fieldTitle];
            }
        }
    }

    public function getTitle(): string
    {
        if (empty($this->title)) {
            return '';
        } else {
            return $this->title;
        }
    }

    public function getDescription(): string
    {
        if (empty($this->description)) {
            return '';
        } else {
            return $this->description;
        }
    }

    public function getFunctions(): array
    {
        if (empty($this->functions)) {
            return [];
        } else {
            return $this->functions;
        }
    }
}

class Smartphone implements PhoneInterface
{
    public $title;
    public $description;
    public $functions;

    public function __construct($data = [])
    {
        foreach (get_class_vars(__CLASS__) as $fieldTitle => $fieldValue) {
            if (isset($data[$fieldTitle])) {
                $this->$fieldTitle = $data[$fieldTitle];
            }
        }
    }

    public function getTitle(): string
    {
        if (empty($this->title)) {
            return '';
        } else {
            return $this->title;
        }
    }

    public function getDescription(): string
    {
        if (empty($this->description)) {
            return '';
        } else {
            return $this->description;
        }
    }

    public function getFunctions(): array
    {
        if (empty($this->functions)) {
            return [];
        } else {
            return $this->functions;
        }
    }
}
