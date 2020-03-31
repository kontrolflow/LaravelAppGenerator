<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    public static function indexFields(){
        return array('id' => 'ID', 'name' => 'Name', 'description' => 'Description');
    }

    public static function createFormValidations()
    {
        $validationFields = [];

        $validationFields['name'] = 'required';
        $validationFields['description'] = 'required';

        return $validationFields;
    }

    public static function storedFieldsFromForm()
    {
        return array('name', 'description', 'inventor', 'dateInvented');
    }

    public static function showFields()
    {
        return array('id' => 'ID', 'name' => 'Name', 'description' => 'Description', 'inventor'=>'Inventor', 'dateInvented'=>'Date Invented');
    }

    public static function editFormValidations()
    {
        $validationFields = [];

        $validationFields['name'] = 'required';
        $validationFields['description'] = 'required';

        return $validationFields;
    }

    public static function updatedFieldsFromForm()
    {
        return array('name', 'description', 'inventor', 'dateInvented');
    }
}
