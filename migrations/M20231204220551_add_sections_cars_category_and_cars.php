<?php

namespace Sprint\Migration;


class M20231204220551_add_sections_cars_category_and_cars extends Version
{
    protected $description = "Добавляем sections категорий автомобилей и sections самих авто соответственно классу ";

    protected $moduleVersion = "4.6.1";

    protected array $arCarsSections=  array(
        0 =>
            array (
                'NAME' => 'Премиум',
                'CODE' => 'premium',
                'SORT' => '500',
                'ACTIVE' => 'Y',
                'XML_ID' => NULL,
                'DESCRIPTION' => '',
                'DESCRIPTION_TYPE' => 'text',
                'CHILDS' =>
                    array (
                        0 =>
                            array (
                                'NAME' => 'Audi A8',
                                'CODE' => 'audi-a8',
                                'SORT' => '500',
                                'ACTIVE' => 'Y',
                                'XML_ID' => NULL,
                                'DESCRIPTION' => 'Эдгар Кац',
                                'DESCRIPTION_TYPE' => 'text',
                            ),
                    ),
            ),
        1 =>
            array (
                'NAME' => 'Комфорт',
                'CODE' => 'komfort',
                'SORT' => '500',
                'ACTIVE' => 'Y',
                'XML_ID' => NULL,
                'DESCRIPTION' => '',
                'DESCRIPTION_TYPE' => 'text',
                'CHILDS' =>
                    array (
                        0 =>
                            array (
                                'NAME' => 'Skoda Octavia',
                                'CODE' => 'skoda-octavia',
                                'SORT' => '500',
                                'ACTIVE' => 'Y',
                                'XML_ID' => NULL,
                                'DESCRIPTION' => 'Василевский Николай',
                                'DESCRIPTION_TYPE' => 'text',
                            ),
                        1 =>
                            array (
                                'NAME' => 'Ford Mondeo',
                                'CODE' => 'ford-mondeo',
                                'SORT' => '500',
                                'ACTIVE' => 'Y',
                                'XML_ID' => NULL,
                                'DESCRIPTION' => 'Купчин Сергей',
                                'DESCRIPTION_TYPE' => 'text',
                            ),
                    ),
            ),
        2 =>
            array (
                'NAME' => 'Стандарт',
                'CODE' => 'standart',
                'SORT' => '500',
                'ACTIVE' => 'Y',
                'XML_ID' => NULL,
                'DESCRIPTION' => '',
                'DESCRIPTION_TYPE' => 'text',
                'CHILDS' =>
                    array (
                        0 =>
                            array (
                                'NAME' => 'Volkswagen Caddy',
                                'CODE' => 'volkswagen-caddy',
                                'SORT' => '500',
                                'ACTIVE' => 'Y',
                                'XML_ID' => NULL,
                                'DESCRIPTION' => 'Сидоров Александр',
                                'DESCRIPTION_TYPE' => 'text',
                            ),
                        1 =>
                            array (
                                'NAME' => 'Volkswagen Transporter',
                                'CODE' => 'volkswagen-transporter',
                                'SORT' => '500',
                                'ACTIVE' => 'Y',
                                'XML_ID' => NULL,
                                'DESCRIPTION' => 'Василий Уткин',
                                'DESCRIPTION_TYPE' => 'text',
                            ),
                        2 =>
                            array (
                                'NAME' => 'Renault Kangoo',
                                'CODE' => 'renault-kangoo',
                                'SORT' => '500',
                                'ACTIVE' => 'Y',
                                'XML_ID' => NULL,
                                'DESCRIPTION' => 'Саня Авдевич',
                                'DESCRIPTION_TYPE' => 'text',
                            ),
                    ),
            ),
    );

    protected  $iblockId;

    /**
     * @throws Exceptions\HelperException
     * @return bool|void
     */
    public function up()
    {
        $helper = $this->getHelperManager();

        $this->iblockId = $helper->Iblock()->getIblockIdIfExists(
            'CARS_FOR_BOOKING',
            'cars_for_booking'
        );

        $helper->Iblock()->addSectionsFromTree($this->iblockId, $this->arCarsSections);
    }

    public function down()
    {
        $helper = $this->getHelperManager();
        foreach ($this->arCarsSections as $section){
            $helper->Iblock()->deleteSectionIfExists($this->iblockId, $section["CODE"]);
        }
    }
}
