<?php
/**
 * Created by PhpStorm.
 * User: Riyaz Varangal
 * Date: 10/6/18
 * Time: 10:24 PM
 */

main::start("FL_insurance_sample.csv");
class main{
    static public function start($filename)
    {
        $records=csv::getRecords($filename);
        print_r($records);
        foreach($records as $record){

            //print_r($record);
            $array = $record->returnArray();
            print_r($array);
        }
        //$record= recordFactory::create();
        //

    }
}

class csv{
    static public function getRecords($filename){
        $file=fopen($filename,"r");
        $fieldNames=array();
        $count=0;
        while(! feof($file))
        {
            $values= fgetcsv($file);
            if($count == 0)
            {
                $fieldNames[]=$values;
            }
            else{
                $records[]=recordFactory::create($fieldNames, $values);
            }
            $count++;

        }
        fclose($file);
        return $records;

    }
}
class record{
    public function _construct(Array $fieldNames=null,$values =  null)
    {

        $record= array_combine($fieldNames,$values);
        print_r($record);
        //$record= (object) $record;
        foreach($record as $property => $value){
            $this->createProperty($property, $value);
        }

    }
    public function returnArray()
    {
        $array = (array) $this;
        return $array;

    }
    public function createProperty($name='First',$value='Krutika')
    {
        $this->{$name} = $value;
        //return $html;
    }

}
class recordFactory{

    public static function create(Array $fieldNames=null,Array $values = null){

        $record=new record($fieldNames,$values);
        return $record;
    }

}