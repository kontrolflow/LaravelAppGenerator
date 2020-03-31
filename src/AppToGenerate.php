<?php

namespace kontrolflow\LaravelAppGenerator;

class AppToGenerate
{
    var $app = [];

    private function appDetails() {
        $this->app['name'] = 'Tool Directory';
        $this->app['root'] = '/var/www/generation';
        //$this->app['root'] = '/var/www/laravelApp/app/LaravelAppGenerator/sandbox';
        $this->app['address'] = 'http://apps.abinsay.com';
        $this->app[''] = '';
    }

    private function modelDetails() {

        $model['Name'] = 'Tool'; // Spaces Allowed
        $model['NoSpaces'] = 'Tool'; // Used in Model
        $model['camelCase'] = 'tool'; // Used everywhere
        $model['camelCasePlural'] = 'tools';

        $model['pluralNoSpaces'] = 'Tools';
        $model['pluralName'] = 'Tools';

        $model['route'] = 'tools'; // Used in route creation

        $model['dbProperties'] = array('id, name, description, inventor, dateInvented');

        $model['index'] = array('id, name, description');

        $model['createForm'] = array();
        $model['createForm']['name'] = array('Name', 'text', 'required');
        $model['createForm']['description'] = array('Description', 'text', 'required');
        $model['createForm']['inventor'] = array('Inventor', 'text', 'required');
        $model['createForm']['dateInvented'] = array('Date Invented', 'text', 'required');

        $model['store'] = array('name, description, inventor, dateInvented');

        $model['show'] = array('id' => 'ID', 'name' => 'Name', 'description' => 'Description', 'inventor'=>'Inventor', 'dateInvented'=>'Date Invented');

        $model['editForm']['name'] = array('Name', 'text', 'required');
        $model['editForm']['description'] = array('Description', 'text', 'required');
        $model['editForm']['inventor'] = array('Inventor', 'text', 'required');
        $model['editForm']['dateInvented'] = array('Date Invented', 'text', 'required');

        $model['update'] = array('name, description, inventor, dateInvented');

        $this->app['models'][] = $model;
    }

    public function __construct() {
        $this->appDetails();
        $this->modelDetails();
    }

}
