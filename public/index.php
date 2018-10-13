<html lang="en">
<head>
    <title>PHP MiniProj: Creating Table from CSV</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Creating Table from CSV</h2>
    <p>This is the mini project to create bootstrap table from CSV file.</p>
<?php
    main::start("sample.csv");
?>
</div>
</body>
</html>
<?php

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
    static public function table($records) {
        $table = '<table class="table table-striped">';
        $table .= '<thead>';
        $table .= '<tr>';

        $titles=array();
        foreach ($records as $key=>$value) {
            foreach ($value as $key2=>$value2) {
                $titles[] = $key2;
            }
        }
        $table .= '<th scope="col">#</th>';
        foreach (array_unique($titles) as $key=>$value) {
            $table .= '<th scope="col">' . htmlspecialchars($value) . '</th>';
        }
        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '<tbody>';
        $index = 1;
        foreach($records as $key=>$value) {
            $table .='<tr>';
            $table .= '<th scope="row">' . htmlspecialchars($index) . '</th>';
            foreach ($value as $key2=>$value2){
                $table .= '<td>' . htmlspecialchars($value2) . '</td>';
            }
            $index++;
            $table .= '</tr>';
        }
        $table .= '</tbody>';

        $table .= '</table>';
        return $table;
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