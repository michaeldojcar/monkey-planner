<?php

namespace App\Http\Controllers\Admin;


/**
 * Class ManageNextcloudUserController
 *
 * Příklad použití bread controlleru.
 *
 * @package App\Http\Controllers\ControlPanel
 */
class EventController
{
    protected $bread_model = "Event";
    protected $bread_model_namespace = "App";

    /**
     * Stringy se skloňováním.
     *
     * @var array
     */
    protected $bread_strings
        = [
            "name"           => "událost",
            "name_2p"        => "události",
            "name_4p"        => "událost",
            "name_plural"    => "události",
            "name_plural_2p" => "událostí",
            "name_plural_4p" => "události",
        ];

    protected $viewPrefix = "admin";
    protected $routePrefix = "admin";

    protected $paginateLimit = 10;

    /**
     * Sloupce vypsané v browse zobrazení.
     *
     * @var array
     */
    protected $browse_columns
        = [
            [
                'name'    => 'name',
                'display' => 'Název události',
            ],
            [
                'name'    => 'type',
                'display' => 'Typ',
            ],
            [
                'name'    => 'from',
                'display' => 'Začátek',
            ],
            [
                'name'    => 'to',
                'display' => 'Konec',
            ],
        ];

    /**
     * Data zobrazená v single zobrazeních (add/edit/read).
     * Nové vstupy lze validovat pomocí Laravel Request validátoru.
     *
     * @var array
     */
    protected $single_rows
        = [
            [
                'type'      => 'string',
                'name'      => 'name',
                'display'   => 'Název události',
                'validator' => 'required',
            ],
            [
                'type'      => 'select',
                'name'      => 'type',
                'display'   => 'Typ',
                'validator' => 'required',
                'options'   => [
                    [
                        'title' => 'událost',
                        'value' => 0,
                    ],
                    [
                        'title' => 'hra',
                        'value' => 1,
                    ],
                    [
                        'title' => 'program',
                        'value' => 2,
                    ],
                ],
            ],
            [
                'type'      => 'string',
                'name'      => 'short',
                'display'   => 'Perex',
                'validator' => 'required',
            ],

            [
                'type'      => 'datetime',
                'name'      => 'from',
                'display'   => 'Začátek',
                'validator' => 'required',
            ],

            [
                'type'      => 'datetime',
                'name'      => 'to',
                'display'   => 'Konec',
                'validator' => 'required',
            ],


            [
                'type'      => 'string',
                'name'      => 'content',
                'display'   => 'Obsah',
                'validator' => '',
            ],
            [
                'type'      => 'number',
                'name'      => 'parent_event_id',
                'display'   => 'Nadřazená událost',
                'validator' => 'nullable|numeric',
            ],
        ];
}
