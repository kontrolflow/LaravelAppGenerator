<?php

namespace kontrolflow\LaravelAppGenerator;

class LaravelAppGenerator
{

	public static function test()
	{
		echo 'Hello World';
	}

    public static function init() {

        $app = new AppToGenerate;
        $app->init();


        $file = '/var/www/laravelApp/app/LaravelAppGenerator/sandbox/test.txt';

        // Open the file to get existing content
        $current = file_get_contents($file);

        // Append a new person to the file
        $current .= "John Smith\n";

        echo $current;

        // Write the contents back to the file
        //file_put_contents($file, $current);

    }


}
