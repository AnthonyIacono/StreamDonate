<?php
namespace Plinq;

use \RecursiveArrayIterator as RecursiveArrayIterator;

/**
 * Plinq is a native implementation of language-integrated query (linq) for php (v >= 5.3.1)
 * @version 1.0.0
 */
class Plinq extends RecursiveArrayIterator
{
    const PLINQ_CLOSURE_RETURN_TYPE_BOOL = 'bool';
    const PLINQ_CLOSURE_RETURN_TYPE_OBJECT = 'object';
    const PLINQ_CLOSURE_RETURN_TYPE_ARRAY = 'array';
    const PLINQ_ORDER_ASC = 'asc';
    const PLINQ_ORDER_DESC = 'desc';

    const PLINQ_ORDER_TYPE_NUMERIC = 1;
    const PLINQ_ORDER_TYPE_ALPHANUMERIC = 2;
    const PLINQ_ORDER_TYPE_DATETIME = 3;


    /**
     * Plinq::RecursiveArrayIterator()
     * Ctor
     *
     * @param Array $dataSource an array or a Plinq object as data source
     */
    public function __construct(Array &$dataSource = array())
    {
        parent::__construct($dataSource);
    }

    /**
     * @static
     * @param $datasource
     * @return Plinq
     */
    public static function factory($datasource) {
        $plinq = new Plinq($datasource);
        return $plinq;
    }

    /**
     * Plinq::Where()
     * Filters the Plinq object according to closure return result.
     *
     * @param ObjectClosure $closure     a closure that returns boolean
     * @return Plinq    Filtered results according to $closure
     */
    public function Where($closure)
    {
        return $this->GetApplicables($closure);
    }

    /**
     * Plinq::Skip()
     * Skips first $count item and returns remaining items
     *
     * @param int $count    skip count
     * @return Plinq
     */
    public function Skip($count)
    {
        $this->rewind();
        return new self(array_slice((Array)$this, $count, $this->count()));
    }

    /**
     * Plinq::Take()
     * Takes first $count item and returns them
     *
     * @param int $count    take count
     * @return  Plinq
     */
    public function Take($count)
    {
        return $this->GetApplicables(function($k, $v){ return true; }, $count, self::PLINQ_CLOSURE_RETURN_TYPE_BOOL);
    }

    /**
     * Determines if all of the items in this object satisfies $closure
     *
     * @param ObjectClosure $closure    a closure that returns boolean
     * @return bool
     */
    public function All($closure)
    {
        return ($this->count() == $this->GetApplicables($closure)->count());
    }

    /**
     * Determines if any of the items in this object satisfies $closure
     *
     * @param ObjectClosure
     * @return bool
     */
    public function Any($closure)
    {
        return ($this->Single($closure) !== null);
    }

    /**
     * Computes the average of items in this object according to $closure
     *
     * @param ObjectClosure $closure    a closure that returns any numeric type (int, float etc.)
     * @return double   Average of items
     */
    public function Average($closure)
    {
        $this->rewind();
        $resulTotal = 0;
        $averagable = 0;

        $total = $this->count();
        for($i = 0; $i < $total; $i++)
        {
            $value = $this->current();
            $key = $this->key();
            $this->next();

            if(!is_numeric(($result = call_user_func_array($closure, array($key, $value)))))
                continue;

            $resulTotal += $result;
            $averagable++;
        }
        return (($averagable == 0)? 0 : ($resulTotal/$averagable));
    }

    private function Order($closure, $direction = self::PLINQ_ORDER_ASC)
    {
        $applicables = $this->GetApplicables($closure, 0, self::PLINQ_CLOSURE_RETURN_TYPE_OBJECT);
        $applicables->rewind();

        $sortType = self::PLINQ_ORDER_TYPE_NUMERIC;
        if(is_a($applicables->current(), 'DateTime'))
            $sortType = self::PLINQ_ORDER_TYPE_DATETIME;
        elseif(!is_numeric($applicables->current()))
            $sortType = self::PLINQ_ORDER_TYPE_ALPHANUMERIC;

        if($sortType == self::PLINQ_ORDER_TYPE_DATETIME)
        {
            $p = new self($applicables->ToArray());
            $applicables = $p->Select(function($k, $v){ return $v->getTimeStamp(); });
            $sortType = self::PLINQ_ORDER_TYPE_NUMERIC;
        }
        $applicables = $applicables->ToArray();

        if($direction == self::PLINQ_ORDER_ASC)
            asort($applicables, (($sortType == self::PLINQ_ORDER_TYPE_NUMERIC)? SORT_NUMERIC : SORT_LOCALE_STRING));
        else
            arsort($applicables, (($sortType == self::PLINQ_ORDER_TYPE_NUMERIC)? SORT_NUMERIC : SORT_LOCALE_STRING));

        $ordered = new self();
        foreach($applicables as $key => $value)
            $ordered[$key] = $this[$key];

        return $ordered;
    }

    /**
     * Orders this objects items in ascending order according to the selected key in closure
     *
     * @param ObjectClosure $closure    a closure that selects the order key, key can be anything
     * @return Plinq    Ordered items
     */
    public function OrderBy($closure)
    {
        return $this->Order($closure, self::PLINQ_ORDER_ASC);
    }

    /**
     * Orders this objects items in descending order according to the selected key in closure
     *
     * @param ObjectClosure $closure    a closure that selects the order key, key can be anything
     * @return Plinq    Ordered items
     */
    public function OrderByDescending($closure)
    {
        return $this->Order($closure, self::PLINQ_ORDER_DESC);
    }

    /**
     * Gets the maximimum item value according to $closure
     *
     * @param ObjectClosure $closure    a closure that returns any numeric type (int, float etc.)
     * @return  numeric Maximum item value
     */
    public function Max($closure)
    {
        $this->rewind();
        $max = null;
        $total = $this->count();
        for($i = 0; $i < $total; $i++)
        {
            $value = $this->current();
            $key = $this->key();
            $this->next();

            if(!is_numeric(($result = call_user_func_array($closure, array($key, $value)))))
                continue;

            if(is_null($max))
                $max = $result;
            elseif($max < $result)
                $max = $result;

        }

        return $max;
    }

    /**
     * Gets the minimum item value according to $closure
     *
     * @param ObjectClosure $closure    a closure that returns any numeric type (int, float etc.)
     * @return  numeric Minimum item value
     */
    public function Min($closure)
    {
        $this->rewind();
        $min = null;
        $total = $this->count();
        for($i = 0; $i < $total; $i++)
        {
            $value = $this->current();
            $key = $this->key();
            $this->next();

            if(!is_numeric(($result = call_user_func_array($closure, array($key, $value)))))
                continue;

            if(is_null($min))
                $min = $result;
            elseif($min > $result)
                $min = $result;
        }

        return $min;
    }

    /**
     * Creates a new Plinq object from items that are determined by $closure
     *
     * @param ObjectClosure $closure    a closure that returns an item to append, item can be any type.
     * @return Plinq
     */
    public function Select($closure)
    {
        return $this->GetApplicables($closure, 0, self::PLINQ_CLOSURE_RETURN_TYPE_OBJECT);
    }

    /**
     * Creates a new Plinq object from items which are a form of Array according to $closure
     *
     * @param ObjectClosure $closure    a closure that returns an item that is a form of Array.
     * @return Plinq
     */
    public function SelectMany($closure)
    {
        $applicables = $this->GetApplicables($closure, 0, self::PLINQ_CLOSURE_RETURN_TYPE_OBJECT);
        $many = new self();

        foreach($applicables as $applicable)
        {
            if(!is_a($applicable, 'ArrayIterator')
                && !is_array($applicable))
                continue;

            foreach($applicable as $applicablePart)
                $many[] = $applicablePart;
        }

        return $many;
    }

    /**
     * Concatenates this with given $array
     *
     * @param Array $array
     * @return Plinq
     */
    public function Concat(Array $array)
    {
        $this->rewind();
        $array = new \ArrayIterator($array);
        $array->rewind();
        $total = $array->count();
        for($i = 0; $i < $total; $i++)
        {
            $value = $array->current();
            $key = $array->key();
            $array->next();

            $this[$key] = $value;
        }

        return $this;
    }

    /**
     * Returns distinct item values of this
     *
     * @return Plinq    Distinct item values of this
     */
    public function Distinct()
    {
        $this->rewind();
        return new self(array_unique((Array)$this));
    }

    /**
     * Intersects an Array with this
     *
     * @param Array $array  Array to intersect
     * @return Plinq    intersected items
     */
    public function Intersect(Array $array)
    {
        $this->rewind();
        return new self(array_intersect((Array)$this, $array));
    }

    /**
     * Finds different items
     *
     * @param Array $array
     * @return  Plinq   Returns different items of this and $array
     */
    public function Diff(Array $array)
    {
        $this->rewind();
        return new self(array_diff((Array)$this, $array));
    }

    /**
     * Plinq::ElementAt()
     *
     * @param int $index
     * @return  Object  Item at $index
     */
    public function ElementAt($index)
    {
        $this->rewind();
        //$values = array_values($this);        
        //return $values[$index];
        return $this->offsetGet($index);
    }

    /**
     * Groups the object according to the $closure generated key
     *
     * @param ObjectClosure $closure    a closure that returns an item as key, item can be any type.
     * @return
     */
    public function GroupBy($closure)
    {
        $this->rewind();
        $groups = new self();
        $total = $this->count();
        for($i = 0; $i < $total; $i++)
        {
            $value = $this->current();
            $key = $this->key();
            $this->next();

            $result = call_user_func_array($closure, array($key, $value));
            if(!isset($groups[$result]))
                $groups[$result] = new self();

            $groups[$result][$key] = $value;
        }
        return $groups;
    }

    /**
     * Plinq::First()
     *
     * @return  Object  Item at index 0
     */
    public function First()
    {
        $this->rewind();
        return $this->current();
    }

    /**
     * Plinq::Last()
     *
     * @return  Object  Last item in this
     */
    public function Last()
    {
        $this->rewind();
        return $this->ElementAt(($this->count()-1));//$this->offsetGet($this->count()-1);
    }

    /**
     * Gets first one item from this according $closure
     *
     * @param ObjectClosure $closure    a closure that returns boolean.
     * @return Plinq    The first item from this according $closure
     */
    public function Single($closure)
    {
        $applicables = $this->GetApplicables($closure, 1);
        $applicables->rewind();
        return $applicables->current();
    }

    private function GetApplicables($closure, $count = 0, $closureReturnType = self::PLINQ_CLOSURE_RETURN_TYPE_BOOL)
    {
        $this->rewind();
        $applicables = new self();

        $total = $this->count();
        $totalApplicable = 0;
        for($i = 0; $i < $total; $i++)
        {
            $stored = $this->current();
            $storedKey = $this->key();
            $this->next();

            if($count > 0 && $totalApplicable >= $count)
                break;

            switch($closureReturnType)
            {
                case self::PLINQ_CLOSURE_RETURN_TYPE_BOOL:
                    if(!is_bool(($returned = call_user_func_array($closure, array($storedKey, $stored)))) || !$returned)
                        continue;

                    $applicables[$storedKey] = $stored;
                    $totalApplicable++;
                    break;
                case self::PLINQ_CLOSURE_RETURN_TYPE_OBJECT:
                    $applicables[$storedKey] = call_user_func_array($closure, array($storedKey, $stored));
                    $totalApplicable++;
                    break;
            }


        }

        /*
        $totalApplicable = 0;
        foreach($this as $storedKey => $stored)
        {            
            if($count > 0 && $totalApplicable >= $count)
                break;
            
            switch($closureReturnType)
            {   
                case self::PLINQ_CLOSURE_RETURN_TYPE_BOOL:                    
                    if(!is_bool(($returned = call_user_func_array($closure, array($storedKey, $stored)))) || !$returned)
                        continue;
                        
                    $applicables[$storedKey] = $stored;
                    $totalApplicable++;                                            
                break;
                case self::PLINQ_CLOSURE_RETURN_TYPE_OBJECT:
                    $applicables[$storedKey] = call_user_func_array($closure, array($storedKey, $stored));
                    $totalApplicable++;                        
                break;    
            }
        }          
        */
        return $applicables;
    }

    /**
     * Creates an Array object from this
     *
     * @return Array    Plinq as Array
     */
    public function ToArray()
    {
        $this->rewind();
        return (Array)$this;
    }


}