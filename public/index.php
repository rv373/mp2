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
        //print_r(count($records));

        foreach($records as $record){
            //print_r($record);
            $array = $record->returnArray();
            //print_r($array);

        }
        //$record= recordFactory::create();
        $data = array (
            array ( "class"=>"1styear","branch"=>"IT","Exam"=>"SEM1","student name"=>"Alex","Bio"=>"Good Boy"),
            array ( "class"=>"2ndyear","branch"=>"Finance","Exam"=>"SEM1","student name"=>"Mark","Bio"=>"Intelligent" ),
            array ( "class"=>"2ndyear", "branch"=>"IT","Exam"=>"SEM1","student name"=>"Shaun","Bio"=>"Football Player" ),
            array ( "class"=>"1styear","branch"=>"Finance","Exam"=>"SEM2","student name"=>"Mike","Bio"=>"Sport Player" ),
            array ( "class"=>"1styear","branch"=>"IT","Exam"=>"SEM2","student name"=>"Martin","Bio"=>"Smart"),
            array ( "class"=>"1styear","branch"=>"IT","Exam"=>"SEM1","student name"=>"Philip","Bio"=>"Programmer"  )
        );

        $csv = new CSVFile('sample.csv');
/*        foreach ($csv as $line)
        {
            var_dump($line);
        }*/

        $table = html::table($csv);
        print_r($table);


    }

}

class CSVFile extends SplFileObject
{
    private $keys;

    public function __construct($file)
    {
        parent::__construct($file);
        $this->setFlags(SplFileObject::READ_CSV);
    }

    public function rewind()
    {
        parent::rewind();
        $this->keys = parent::current();
        parent::next();
    }

    public function current()
    {
        return array_combine($this->keys, parent::current());
    }

    public function getKeys()
    {
        return $this->keys;
    }
}
class html {
/*    public static function tableRow($row) {
        $html = "<tr> $row </tr>";
        return $html;
    }*/
    static public function table($records) {
/*        $html = '<html lang="en">');
        $html = '<head>';
  $html = '<title>Bootstrap Example</title>';
  $html = '<meta charset="utf-8">';
        $html = '<meta name="viewport" content="width=device-width, initial-scale=1">';
          $html = '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">';
            $html = '<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
          $html = '<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
        $html = '</head>';
                $html = '<body>';
        $html = '<div class="container">';
        $html = '<h2>Basic Table</h2>';
        $html = '<p>The .table class adds basic styling (light padding and only horizontal dividers) to a table:</p>';
                $html = '<body>';*/
        $html = '<table class="table">';
        $html .= '<tr>';
        //$headings = array_shift($records);
        //$headings = array_keys($records);
        //print_r(count($headings));

        $titles=array();
        foreach ($records as $key=>$value){
            foreach ($value as $key2=>$value2) {
                $titles[] = $key2;
            }
        }
        foreach (array_unique($titles) as $key=>$value) {
            $html .= '<th>' . htmlspecialchars($value) . '</th>';
        }

        //echo $html;
        $html .= '</tr>';
        foreach($records as $key=>$value){
            $html .='<tr>';
            foreach ($value as $key2=>$value2){
                $html .= '<td>' . htmlspecialchars($value2) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
        /*$html = '</div>';*/
/*                $html = '</body>';
                        $html = '</html>';*/
        return $html;
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
        //print_r($record);
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