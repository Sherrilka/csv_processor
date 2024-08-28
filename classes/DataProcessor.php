<?php

class DataProcessor
{
    private $file_men;
    private $file_women;

    function __construct($file_men, $file_women) {
        $this->file_men = $file_men;
        $this->file_women = $file_women;
    }

    public function getAllData() {
        $handle = fopen($this->file_men, 'r');

        $header = fgetcsv($handle);

        $all_data = array();
        while(($data = fgetcsv($handle)) !== false && $data[0]) {
            $new_data = $data;
            $new_data[] = "male";
            $all_data[] = $new_data;
        }

        fclose($handle);
        
        $handle = fopen($this->file_women, 'r');

        $header = fgetcsv($handle);

        while(($data = fgetcsv($handle)) !== false && $data[0]) {
            $new_data = $data;
            $new_data[] = "female";
            $all_data[] = $new_data;
        }

        fclose($handle);

        return $all_data;
    }
    
    public function getByYear() {
        $data = $this->getAllData();

        $years = array_unique(array_column($data, 1));
        sort($years);

        $result = '
            <div class="w-50 m-auto mt-5">
            <b>Oscaři podle roku</b>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Rok</th>
                        <th scope="col">Herečka</th>
                        <th scope="col">Herec</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($years as $year) {
            $records = array_filter($data, function($y) use ($year) {
                return $y[1] === $year;
            });
            usort($records, function($a, $b) {
                return strcmp($a[5], $b[5]);
            });

            $text = '<tr><th scrope="row">'.$year.'</th>';

            foreach ($records as $record) {
                $text .= '<td>'.$record[3].' ('.trim($record[2]).')<br>'.$record[4].'</td>';
            }
            $text .= '</tr>';
            $result .= $text;
        }
        $result .= '</tbody></table>';

        return $result;
    }

    public function getByMovie() {
        $data = $this->getAllData();

        $count = array_count_values(array_column($data, 4));
        $repeated = array_filter($count, function($c) {
            return $c > 1;
        });

        $repeated = array_map(function($key) use ($repeated) {
            return $key;
        }, array_keys($repeated));
        sort($repeated);

        $result = '
            <b>Oscaři podle filmu</b>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Film</th>
                        <th scope="col">Rok</th>
                        <th scope="col">Herečka</th>
                        <th scope="col">Herec</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($repeated as $movie) {
            $records = array_filter($data, function ($year) use ($movie) {
                return $year[4] === $movie; 
            });
            usort($records, function($a, $b) {
                return strcmp($a[5], $b[5]);
            });

            $text = '<tr><th scrope="row">'.$movie.'</th><td>'.$records[0][1].'</td>';
            foreach ($records as $record) {
                $text .= '<td>'.$record[3].'</td>';
            }
            $text .= '</tr>';
            $result .= $text;
        }
        $result .= '</tbody></table></div>';

        return $result;
    }

    public function getData() {
        $years = $this->getByYear();
        $movies = $this->getByMovie();
        $result = $years.$movies;

        return $result;
    }
} 

?>