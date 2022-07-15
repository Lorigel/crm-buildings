<?php

if(!function_exists('format_price'))
{
    function format_price($price)
    {
        if(!$price){
            return;
        }

        return '€ ' . number_format($price, 2, '.', '');
    }
}

if(!function_exists('format_date'))
{
    function format_date($date)
    {
        if(!$date){
            return;
        }

        return date('d/m/Y', strtotime($date));
    }
}

if(!function_exists('legal_forms'))
{
    function legal_forms()
    {
        return [
            [
                'value' => 'two_family',
                'name' => __('Bifamiliare')
            ],
            [
                'value' => 'condominium',
                'name' => __('Condominio')
            ],
            [
                'value' => 'physical_person',
                'name' => __('Persona fisica')
            ]
        ];
    }
}

if(!function_exists('format_option_values'))
{
    function format_option_values($data)
    {
        return !empty($data) ? $data->map(function($item){
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        }) : [];
    }
}