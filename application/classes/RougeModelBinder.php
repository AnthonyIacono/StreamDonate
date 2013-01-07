<?php

class RougeModelBinder extends Extendable {
    /**
     * @var RougeModelBinder
     */
    public static $singleton = null;

    public static function changeSingleton(RougeModelBinder $s) {
        self::$singleton = $s;
    }

    public function bindModelFromPrefixedMembers($object, $prefix, $modelType = null) {
        $data = (array)$object;

        foreach($data as $k => $v) {
            if(strpos($k, $prefix) === 0) {
                continue;
            }

            unset($data[$k]);
        }

        if(count(array_keys($data)) == 0) {
            return null;
        }

        foreach($data as $k => $v) {
            unset($data[$k]);
            $data[substr($k, strlen($prefix))] = $v;
        }

        $data = (object)$data;

        $modelType = null === $modelType ? 'MySQLRecord' : $modelType;

        // if the model type is just a class (there is no :: indicating a function call
        if(strpos($modelType, '::') === false) {
            if(method_exists($modelType, 'modelBinder')) {
                $model = call_user_func_array($modelType . '::modelBinder', array($data));
            }
            else {
                $model = new $modelType();

                foreach($data as $k => $v) {
                    $model->{$k} = $v;
                }
            }
        }
        else {
            $model = call_user_func_array($modelType, array($data));
        }

        return $model;
    }
}

if(RougeModelBinder::$singleton === null) {
    RougeModelBinder::changeSingleton(new RougeModelBinder());
}