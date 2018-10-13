<?php
/**
 * Created by PhpStorm.
 * User: Riyaz Varangal
 * Date: 10/6/18
 * Time: 10:24 PM
 */
main::start("sample.csv");
class main{
    static public function start($filename)
    {
        $records=csv::getRecords($filename);

        foreach($records as $record) {
            $array = $record->returnArray();
        }
        //$record= recordFactory::create();
        $csv = new CSVFile('sample.csv');
        $table = html::table($csv);
        print_r($table);
    }
}

class CSVFile extends SplFileObject {
    private $keys;
    public function __construct($file) {
        parent::__construct($file);
        $this->setFlags(SplFileObject::READ_CSV);
    }
    public function rewind() {
        parent::rewind();
        $this->keys = parent::current();
        parent::next();
    }
    public function current() {
        return array_combine($this->keys, parent::current());
    }
    public function getKeys() {
        return $this->keys;
    }
}
class html {
/*    public static function tableRow($row) {
        $html = "<tr> $row </tr>";
        return $html;
    }*/
    static public function table($records) {
        $html = '<html lang="en">';
        $html .= '<head>';
        $html .= '<title>PHP MiniProj: Creating Table from CSV</title>';
        $html .= '<meta charset="utf-8">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
        $html .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">';
        $html .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
        $html .= '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
        $html .= '</head>';
        $html .= '<body>';
        $html .= '<div class="container">';
        $html .= '<h2>Creating Table from CSV</h2>';
        $html .= '<p>This ia the mini project to create bootstrap table from CSV file.</p>';
        $html .= '<table class="table table-striped">';
        $html .= '<thead>';
        $html .= '<tr>';
        //$headings = array_shift($records);
        //$headings = array_keys($records);

        $titles=array();
        foreach ($records as $key=>$value) {
            foreach ($value as $key2=>$value2) {
                $titles[] = $key2;
            }
        }
        $html .= '<th scope="col">#</th>';
        foreach (array_unique($titles) as $key=>$value) {
            $html .= '<th scope="col">' . htmlspecialchars($value) . '</th>';
        }
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        $index = 1;
        foreach($records as $key=>$value) {
            $html .='<tr>';
            $html .= '<th scope="row">' . htmlspecialchars($index) . '</th>';
            foreach ($value as $key2=>$value2){
                $html .= '<td>' . htmlspecialchars($value2) . '</td>';
            }
            $index++;
            $html .= '</tr>';
        }
        $html .= '</tbody>';

        $html .= '</table>';
        $html .= '</div>';
        $html .= '</body>';
        $html .= '</html>';
        return $html;
    }
}

class csv {
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
                //print_r($values);
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