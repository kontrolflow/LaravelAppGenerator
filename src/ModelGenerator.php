<?php

namespace kontrolflow\LaravelAppGenerator;

class ModelGenerator {

    var $app;

    var $model;

    function __construct($model, $app) {
        $this->model = $model;
        $this->app = $app;
        $this->generate();
    }

    private function generate() {
        //var_dump($this->model['dbProperties']);
        $this->generateFolders();
        $this->generateRoute();
        $this->generateController();
        $this->generateModel();
        $this->generateCreateForm();
        $this->generateEditForm();
    }

    private function generateFolders() {

        $folder =  $this->app['root'] . '/resources/views/models/';
        if(is_dir($folder)) {
            echo 'The folder ' . $folder . ' exists. <br>';
        } else {
            echo 'The folder ' . $folder . ' does not exist. Creating now. <br>';
            mkdir($folder, 0777);
            if(is_dir($folder)) {
                echo 'Folder Creation Succeeded. <br>';
            } else {
                echo 'Folder Creation Failed. <br>';
            }
        }

        $folder =  $this->app['root'] . '/resources/views/models/' . $this->model['camelCase'];
        if(is_dir($folder)) {
            echo 'The folder ' . $folder . ' exists. <br>';
        } else {
            echo 'The folder ' . $folder . ' does not exist. Creating now. <br>';
            mkdir($folder, 0777);
            if(is_dir($folder)) {
                echo 'Folder Creation Succeeded. <br>';
            } else {
                echo 'Folder Creation Failed. <br>';
            }
        }
    }

    private function generateRoute() {
		// Get Contents of web.php
		$routeFilePath = $this->app['root'] . '/routes/web.php';
        $routeFileContents = file_get_contents($routeFilePath);
		
		//Insert Creation Validation Fields into Controller
        $routeFileContents .= "\n\nRoute::resource('".$this->model['route']."', '".$this->model['NoSpaces']."Controller');";

        //Save Modifications
        file_put_contents($routeFilePath, $routeFileContents);
	}
	
	private function generateController() {

        $routeTag = '#ROUTE#';
        $pluralCamelCaseTag = 'camelCasePlural';
        $NoSpacesTag = 'NoSpaces';
        $camelCaseTag = 'camelCase';
        $NameTag = 'Name';

        //Get Controller Template
        $controllerTemplate = dirname(__FILE__) . '/../templates/Controller.php';
        $controller = file_get_contents($controllerTemplate);

        //Insert Data Into Template
        $controller = preg_replace('/NoSpaces/', $this->model['NoSpaces'], $controller);
        $controller = preg_replace('/Name/', $this->model['Name'], $controller);
        $controller = preg_replace('/camelCasePlural/', $this->model['camelCasePlural'], $controller);
        $controller = preg_replace('/camelCase/', $this->model['camelCase'], $controller);
        $controller = preg_replace('/#ROUTE#/', $this->model['route'], $controller);

        //Save Modified Template into File
        $folder =  $this->app['root'] . '/app/Http/Controllers';
        file_put_contents($folder . '/'. $this->model['NoSpaces'] .'Controller.php', $controller);
    }

    private function generateCreateForm() {

        //Generate Form Fields
        $formFields = '';
        foreach ($this->model['createForm'] as $field => $data) {
            $propertyName = $field;
            $propertyReadable = $data[0];

            $formPropertyTemplateFile = dirname(__FILE__) . '/../templates/formPropertyText.txt';
            $formPropertyTemplate = file_get_contents($formPropertyTemplateFile);

            $formField = preg_replace('/\$property\$/', $propertyName, $formPropertyTemplate);
            $formField = preg_replace('/\$propertyReadable\$/', $propertyReadable, $formField);

            $formFields .= $formField;
        }

        //Insert Form Fields into Create Form Template
        $createFormTemplate = dirname(__FILE__) . '/../templates/create.blade.php';
        $createForm = file_get_contents($createFormTemplate);

        $finishedForm = preg_replace('/\$modelDisplayName\$/', $this->model['Name'], $createForm);
        $finishedForm = preg_replace('/#ROUTE#/', $this->model['route'], $finishedForm);
        $finishedForm = preg_replace('/\$formFields\$/', $formFields, $finishedForm);

        //Save Modified Template into File
        $folder =  $this->app['root'] . '/resources/views/models/' . $this->model['camelCase'];
        file_put_contents($folder . '/create.blade.php', $finishedForm);

    }

    private function generateEditForm() {

        //Generate Form Fields
        $formFields = '';
        foreach ($this->model['editForm'] as $prop => $data) {
            $propDisplay = $data[0];

            $formInputTemplateFile = dirname(__FILE__) . '/../templates/editFormInputText.blade.php';
            $formInputTemplate = file_get_contents($formInputTemplateFile);

            $formField = preg_replace('/MpropM/', $prop, $formInputTemplate);
            $formField = preg_replace('/MpropDisplayM/', $propDisplay, $formField);
            $formField = preg_replace('/McamelCaseM/', $this->model['camelCase'], $formField);

            $formFields .= $formField;
        }

        //Insert Form Fields into Create Form Template
        $editFormTemplate = dirname(__FILE__) . '/../templates/edit.blade.php';
        $editForm = file_get_contents($editFormTemplate);

        $editForm = preg_replace('/#ROUTE#/', $this->model['route'], $editForm);
        $editForm = preg_replace('/Name/', $this->model['Name'], $editForm);
        $editForm = preg_replace('/camelCase/', $this->model['camelCase'], $editForm);
        $editForm = preg_replace('/\$formFields\$/', $formFields, $editForm);

        //Save Modified Template into File
        $folder =  $this->app['root'] . '/resources/views/models/' . $this->model['camelCase'];
        file_put_contents($folder . '/edit.blade.php', $editForm);

    }


    private function generateModel() {
        $indexFields = '';
        foreach($this->model['index'] as $prop => $data) {
            $indexFields .= "\t\t" . '$fields["' . $prop . '"] = "' . $data . '";' . "\n";
        }

        $createFormValidationFields = '';
        foreach($this->model['createForm'] as $prop => $data) {
            $createFormValidationFields .= "\t\t" . '$fields["' . $prop . '"] = "' . $data[2] . '";' . "\n";
        }

        $storedFieldsFromForm = '';
        foreach($this->model['store'] as $prop) {
            $storedFieldsFromForm .= "\t\t" . '$fields[] = "' . $prop . '";' . "\n";
        }

        $showFields = '';
        foreach($this->model['show'] as $prop => $data) {
            $showFields .= "\t\t" . '$fields["' . $prop . '"] = "' . $data . '";' . "\n";
        }

        $editFormValidations = '';
        foreach($this->model['editForm'] as $prop => $data) {
            $editFormValidations .= "\t\t" . '$fields["' . $prop . '"] = "' . $data[2] . '";' . "\n";
        }

        $updatedFieldsFromForm = '';
        foreach($this->model['update'] as $prop) {
            $updatedFieldsFromForm .= "\t\t" . '$fields[] = "' . $prop . '";' . "\n";
        }

        //Get Model Template
        $modelTemplate = dirname(__FILE__) . '/../templates/Model.php';
        $model = file_get_contents($modelTemplate);

        //Insert Data Into Template
        $model = preg_replace('/NoSpaces/', $this->model['NoSpaces'], $model);
        $model = preg_replace('/\$indexFields;/', $indexFields, $model);
        $model = preg_replace('/\$createFormValidationFields;/', $createFormValidationFields, $model);
        $model = preg_replace('/\$storedFieldsFromForm;/', $storedFieldsFromForm, $model);
        $model = preg_replace('/\$showFields;/', $showFields, $model);
        $model = preg_replace('/\$editFormValidations;/', $editFormValidations, $model);
        $model = preg_replace('/\$updatedFieldsFromForm;/', $updatedFieldsFromForm, $model);

        //Save Modified Template into File
        $file =  $this->app['root'] . '/app/'. $this->model['NoSpaces'] .'.php';
        file_put_contents($file, $model);

        echo "round";
    }
}
