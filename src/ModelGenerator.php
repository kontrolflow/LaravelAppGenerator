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
        //$this->generateController();
        //$this->generateModel();
        //$this->generateCreateForm();
        //$this->generateEditForm();
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
        $routeFileContents .= "\n\nRoute::resource('".$this->model['route']."', '".$this->model['noSpaces']."Controller');";

        //Save Modifications
        file_put_contents($routeFilePath, $routeFileContents);
	}
	
	private function generateController() {
        //var_dump($this->model['createForm']);
        $validationFields = '';
        foreach($this->model['createForm'] as $prop => $data) {
            $validationFields .= "\t\t" . '$validationFields["' . $prop . '"] = "' . $data[2] . '";' . "\n";
        }
        echo $validationFields;

        //Insert Creation Validation Fields into Controller
        $createFormTemplate = dirname(__FILE__) . '/../templates/Controller.php';
        $createForm = file_get_contents($createFormTemplate);
        $finishedForm = preg_replace('/\$validationFields\$/', $validationFields, $createForm);
        //$finishedForm = preg_replace('/\$formFields\$/', $formFields, $finishedForm);

        //Save Modified Template into File
//        $folder =  $this->app['root'] . 'app/Http/Controllers/' . $this->model['name'];
        $folder =  $this->app['root'] . '/app/Http/Controllers';
        file_put_contents($folder . '/TestController.php', $finishedForm);
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
        $finishedForm = preg_replace('/\$modelDisplayName\$/', $this->model['displayName'], $createForm);
        $finishedForm = preg_replace('/\$formFields\$/', $formFields, $finishedForm);

        //Save Modified Template into File
        $folder =  $this->app['root'] . '/resources/views/models/' . $this->model['name'];
        file_put_contents($folder . '/create.blade.php', $finishedForm);

    }

}
