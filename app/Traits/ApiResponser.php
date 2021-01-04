<?php

namespace App\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

/**
 *
 */
trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {

        if ($collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

        /** Obtenemos el primer elemento por medio de first()
         * Luego obtenemos la propiedad en el modelo que es el transformer a utilizar
        */
        $transformador = $collection->first()->transformer;

        $collection = $this->filterData($collection, $transformador); /*filtramos por los atributos deseados*/
        $collection = $this->sortData($collection, $transformador);/*Ordenamos la data*/
        $collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformador);
        $collection = $this->cacheResponse($collection);
        
        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $instance, $code = 200)
    {
        $transformer = $instance->transformer;
		$instance = $this->transformData($instance, $transformer);

        return $this->successResponse($instance, $code);
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }
    
    protected function filterData(Collection $collection, $transformador)
	{
        foreach (request()->query() as $attributeUrl => $value) {
            $attribute = $transformador::originalAttribute($attributeUrl);
            if (isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value);
            }
        }      
		
		return $collection;
    }

    protected function sortData(Collection $collection, $transformador)
	{
		if (request()->has('sort_by')) {
            /*BuyerTransformer::originalAttribute(request()->sort_by);*/
            $attribute = $transformador::originalAttribute(request()->sort_by);
    
            /** sortBy(attribute) sortBy recibe atributo  */
			$collection = $collection->sortBy->{$attribute};
		}
		return $collection;
    }

    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50',
        ];

        Validator::validate(request()->all(), $rules);

        /*saber pagina actual*/
        $page = LengthAwarePaginator::resolveCurrentPage();

        $elemPage = 15;
        if (request()->has('per_page')) {
            $elemPage = (int)request()->per_page;
        }
        /**
         * divide slice(desde, hasta cuantos) 
         * */
        $result = $collection->slice(($page - 1) * $elemPage, $elemPage)->values();

        /* recibe = Resultado , tamaño real de collection, elemetos por pagina, pagina actual, array - serie de opciones */
        $paginated = new LengthAwarePaginator($result, $collection->count(), $elemPage, $page, [

            /*No permite construir tambien cual podria ser la proxima paginate o anterior*/
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginated->appends(request()->all());

        return $paginated;

    }

       /**
    *Este metodo hara uso de los transform de cada modelo
    *para asi dar una respuesta transformada
    */
    protected function transformData($data, $transformador)
    {
        $transformation = fractal($data, new $transformador);
        return $transformation->toArray();
    }

    protected function cacheResponse($data)
    {
        /*url actual*/
        $url = request()->url();

        $queryParams = request()->query();

        /*Ordena por su clave*/
        ksort($queryParams);

        $queryString = http_build_query($queryParams);
        
        /*armamos la url*/
        $fullUrl = "{$url}?{$queryString}";

        /**Recibimos la url en que estamos ya que va a ser una key. 
         * por defecto esta en segundos.
         * --- La cache funciona basicamente cuando por ejemplo:
         * ---- hacemos una accion sobre la base de datos y volvemos a consultar
         * ----- esta no se mostrara hasta que el tiempo transcurrido pase, ya que 
         * ----- el sistema seguira consultando en la cache los datos mas no en la DB. 
        */
        return Cache::remember($fullUrl, 1, function () use ($data){
            return $data;
        });
    }
}
