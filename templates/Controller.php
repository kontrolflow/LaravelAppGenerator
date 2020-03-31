<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use RedBeanPHP\R;

class NoSpacesController extends Controller
{
    public function index()
    {
        $response['pageTitle'] = 'Name Listing';
        $response['cardHeader'] = 'Name Listing <a class="btn btn-danger btn-sm float-right" href="'. SITE .'/#ROUTE#/create" role="button">Add</a>';

        $fields = \App\NoSpaces::indexFields();

        $response['tableHeader'] = '';
        foreach ($fields as $prop => $display) {
            $response['tableHeader'] .= '<th scope="col">'. $display .'</th>';
        }

        $response['tableBody'] = '';
        $camelCasePlural = R::findAll(strtolower ( 'camelCase' ));
        foreach($camelCasePlural as $camelCase) {
            $response['tableBody'] .= '<tr>';
            foreach ($fields as $prop => $display) {
                $response['tableBody'] .= '<td><a href="/#ROUTE#/'.$camelCase->id.'">'. $camelCase->$prop .'</a></td>';
            }
            $response['tableBody'] .= '</tr>';
        }

        $response['javascript'] = '';

        return view('bs.table', $response);
    }

    public function create()
    {
        return view('models.camelCase.create');
    }

    public function store()
    {
        // Get Validation Settings
        $validationFields = \App\NoSpaces::createFormValidations();

        // Perform Validations
        request()->validate($validationFields);

        // Scaffold New Name
        $camelCase = R::dispense( strtolower ('camelCase') );

        // Assign Form Input to New Name
        $storeFields = \App\NoSpaces::storedFieldsFromForm();
        foreach($storeFields as $prop) {
            $camelCase->$prop = request($prop);
        }

        // Store New Name
        $id = R::store( $camelCase );

        // Show New Name
        return redirect('/#ROUTE#/' . $id);
    }

    public function show($id)
    {
        $camelCase = R::load( strtolower ('camelCase'), $id );

        $response['pageTitle'] = 'Name of ID #'.$camelCase->id;

        $editUrl = SITE . '/#ROUTE#/' . $id . '/edit';
        $response['cardHeader'] = $camelCase->name;
        $response['cardHeader'] .= '<a class="btn btn-danger btn-sm float-right" href="'. $editUrl .'" role="button">Edit</a>';

        $response['tableHeader'] = '<th scope="col-6">Property</th><th scope="col-6">Value</th>';

        $response['tableBody'] = '';
        $showFields = \App\NoSpaces::showFields();
        foreach ($showFields as $prop => $display) {
            $response['tableBody'] .= '<tr>';
            $response['tableBody'] .= '<td>'. $display .'</td>';
            $response['tableBody'] .= '<td>'. $camelCase->$prop .'</td>';
            $response['tableBody'] .= '</tr>';
        }

        $response['javascript'] = '';

        return view('bs.table', $response);

    }

    public function edit($id)
    {
        $camelCase = R::load(strtolower ( 'camelCase'), $id );
        $response['camelCase'] = $camelCase;
        $response['deleteUrl'] = '/#ROUTE#/' . $camelCase->id;
        return view('models.camelCase.edit', $response);
    }

    public function update($id)
    {
        $camelCase = R::load( strtolower ('camelCase'), $id );

        // Get Validation Settings
        $validationFields = \App\NoSpaces::editFormValidations();

        // Perform Validations
        request()->validate($validationFields);

        // Assign Form Input to Name Being Edited
        $updateFields =\App\NoSpaces::updatedFieldsFromForm();
        foreach($updateFields as $prop) {
            $camelCase->$prop = request($prop);
        }

        // Update the NoSpaces
        R::store( $camelCase );

        // Redirect to Update NoSpaces
        return redirect('/#ROUTE#/' . $camelCase->id);

    }

    public function destroy($id)
    {
        $camelCase = R::load( strtolower ('camelCase'), $id );

        R::trash( $camelCase );

        return redirect('/#ROUTE#');
    }
}
