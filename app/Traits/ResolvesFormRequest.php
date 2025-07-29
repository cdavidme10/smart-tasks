<?php

namespace App\Traits;

use Illuminate\Foundation\Http\FormRequest;

trait ResolvesFormRequest
{
    protected function resolveFormRequest(string $class): FormRequest
    {
        $request = app()->make($class);
        $request->setContainer(app());
        $request->setRedirector(app('redirect'));
        $request->validateResolved();
        app()->instance('request', $request);

        return $request;
    }
}
