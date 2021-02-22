<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Crypt;

class Hash
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        foreach ($request->all() as $key => $value) {
            if (gettype($value) == 'array') {
                $request[$key] = $this->unHashing($value);
            } else {
                if (strstr($key, '_id') != '' || $key === 'id') {
                    $request[$key] = Crypt::decrypt($value);
                }
            }
        }

        $response = $next($request);

        $collection = $response->original;

        $collection = json_decode(json_encode($collection));

        if (gettype($collection) == 'array') {
            foreach ($collection as $key => $value) {
                if (gettype($value) == 'object') $value = (array) $value;

                if (gettype($value) == 'array') {
                    if (gettype($collection) == 'object') $collection  = (array) $collection;
                    $collection[$key] = $this->hashing($value);
                } else {
                    if (strstr($key, '_id') != '' || $key === 'id') {
                        if (gettype($collection) == 'object') $collection  = (array) $collection;
                        $collection[$key] = Crypt::encrypt($value);
                    }
                }
            }
        }

        $response->setContent(json_encode($collection));

        return $response;
    }

    public function unHashing($data)
    {
        foreach ($data as $key => &$value) {
            if (gettype($value) == 'array') {
                $value = $this->unHashing($value);
            } else if (gettype($value) == 'string' || gettype($value) == 'integer') {
                if (strstr($key, '_id') != '' || $key === 'id') {
                    $value = Crypt::decrypt($value);
                }
            }
        }
        return $data;
    }

    public function hashing($data)
    {
        foreach ($data as $key => &$value) {
            if (gettype($value) == 'object') $value = (array) $value;

            if (gettype($value) == 'array') {
                $value = $this->hashing($value);
            } else if (gettype($value) == 'string' || gettype($value) == 'integer') {
                if (strstr($key, '_id') != '' || $key === 'id') {
                    $value = Crypt::encrypt($value);
                }
            }
        }

        return $data;
    }
}
