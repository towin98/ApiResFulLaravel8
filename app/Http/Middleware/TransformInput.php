<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*Recibimos el valor de esa transformacion de cada uno de los controladores*/
    public function handle(Request $request, Closure $next, $transformer)
    {
        $transformedInput = [];

        /*Recoremos cada uno de los campos recibidos */
        foreach ($request->request->all() as $input => $value) {
            $transformedInput[$transformer::originalAttribute($input)] = $value;
        }

        /* reemplazar*/
        $request->replace($transformedInput);

        $response = $next($request);

        /*Validamos si es una exception y si es un error de validacion */
        if (isset($response->exception) && $response->exception instanceof ValidationException) {
            /*obtenemos datos de las respuesta*/
            $data = $response->getData();

            /*transformar errores*/
            $transformedErrors = [];

            foreach ($data->error as $campo => $error) {
                $transformedField = $transformer::transformedAttribute($campo);

                /*Construimos la nueva lista de errores*/
                $transformedErrors[$transformedField] = str_replace($campo, $transformedField, $error);
            }
            
            $data->error = $transformedErrors;

            $response->setData($data);
        }
        return $response;
    }
}
