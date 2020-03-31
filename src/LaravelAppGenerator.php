<?php

namespace kontrolflow\LaravelAppGenerator;

class LaravelAppGenerator
{
    var $app;

	function __construct()
	{
        // Get The Formatted Application Requirements
        $app = new AppToGenerate;
        $this->app = $app->app;

        $this->init();
	}

     private function init() {

	    //


        // Generate Needed Folders


	    // Generate Models
        foreach($this->app['models'] as $model) {
            new ModelGenerator($model, $this->app);
        }

    }

}
