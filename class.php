<?php

use \Bitrix\Main\Diag\Debug;
use \Bitrix\Main\Loader;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

class CarsBooking extends CBitrixComponent
{
    private array $timeForBooking = array();

    private function getTimeForBooking(): bool
    {
        if (!empty($_GET["booking_from"]) && !empty($_GET["booking_to"])) {
            $time[0] = strtotime($_GET["booking_from"]);
            $time[1] = strtotime($_GET["booking_to"]);
            $this->timeForBooking = $this->checkTimeInterval($time);
            return true;
        } else return false;
    }

    private function getAvailableCarsForUser(): array
    {
        $arAvailableCarsCategory = array();
        $arAvailableCars = array();
        $res = CIBlockSection::GetList(array("SORT" => "ASC"), array("IBLOCK_ID" => $this->arParams["IBLOCK_ID"], "SECTION_ID" => false), false, array("ID", "CODE", "NAME"), false);
        while ($result = $res->GetNext()) {
            if (CIBlockSectionRights::UserHasRightTo($this->arParams["IBLOCK_ID"], $result["ID"],
                "section_element_bind")) {
                $arAvailableCarsCategory[] = $result;
            }
        }

        foreach ($arAvailableCarsCategory as $category) {
            $arCars = CIBlockSection::GetList(array("SORT" => "ASC"), array("IBLOCK_ID" => $this->arParams["IBLOCK_ID"], "SECTION_ID" => $category["ID"]), false, array(), false);
            while ($car = $arCars->GetNext()) {
                $car["CAR_CLASS"] = $category["NAME"];
                $arAvailableCars[] = $car;
            }
        }
        return $arAvailableCars;
    }

    private function checkModules(): void
    {
        if (!Loader::includeModule("iblock")) {
            throw new \Exception('Не загружены модули необходимые для работы компонента');
        }
    }

    private function isNonOccurrenceCar($section_id, array $timeInterval): bool
    {
        $arrElement = CIBlockElement::GetList(array("SORT" => "ASC"), array("SECTION_ID" => $section_id),
            false, false, array("ID", "NAME"));
        while ($element = $arrElement->GetNext()) {
            if (!$this->isNonOccurenceElementBooking($this->arParams["IBLOCK_ID"], $element["ID"], $timeInterval)) {
                return false;
            }
        }
        return true;
    }

    private function isNonOccurenceElementBooking($iblockId, $elementId, $timeInterval): bool
    {
        $interval = array();
        $arProperty = CIBlockElement::GetProperty($iblockId, $elementId, array("sort" => "asc"), array());
        while ($property = $arProperty->GetNext()) {
            $interval[] = strtotime($property["VALUE"]);
        }
        $interval = $this->checkTimeInterval($interval);
        if ($timeInterval[1] < $interval[0] || $timeInterval[0] > $interval[1]) {
            return true;
        } else {
            return false;
        }
    }

    private function checkTimeInterval(array $timeInterval): array
    {
        if ($timeInterval[0] > $timeInterval[1]) {
            $t = $timeInterval[0];
            $timeInterval[0] = $timeInterval[1];
            $timeInterval[1] = $t;
            return $timeInterval;
        } else return $timeInterval;
    }

    public function getResult(): void
    {
        $carsForResult = array();
        $availableCars = $this->getAvailableCarsForUser();
        foreach ($availableCars as $car) {
            if ($this->isNonOccurrenceCar($car["ID"], $this->timeForBooking)) {
                $carsForResult[] = $car;
            }
        }
        $this->arResult["ITEMS"] = $carsForResult;
    }

    public function executeComponent(): void
    {
        $this->checkModules();

        if ($this->getTimeForBooking()) {
            $this->getResult();
        }
        $this->includeComponentTemplate();
    }
}