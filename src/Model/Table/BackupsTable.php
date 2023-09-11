<?php 

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\Database\StatementInterface;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;

class BackupsTable extends Table{

  public function initialize(array $config): void{

    $this->addBehavior('Timestamp');

  }

  public function exportDatabase()
  {
    $dataSource = ConnectionManager::get('default');
    $database = $dataSource->config()['database'];

    // SQL header comments
    $content  = "--\n";
    $content .= "-- Pierre Baron \n";
    $content .= "-- export de la base `" . $database . "` au " . date("d-m-Y") . "\n";
    $content .= "--\n\n\n";

    // SQL comments
    $content .= "-- -----------------------------\n";
    $content .= "-- creation de la base `" . $database . "`\n";
    $content .= "-- -----------------------------\n";
    $content .= "CREATE DATABASE `" . $database . "` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;\n";
    $content .= "USE `" . $database . "`;\n\n";
    $content .= "-- --------------------------------------------------------\n\n";

    $tables = $this->getConnection()->query('show tables')->fetchAll('assoc');

    foreach ($tables as $tableRow) {
        foreach ($tableRow as $table) {
            // SQL comments
            $content .= "--\n";
            $content .= "-- Structure de la table `" . $table . "`\n";
            $content .= "--\n";
            
            $tableInfo = $this->getConnection()->query("show create table `" . $table . "`")->fetchAll('assoc');
            
            foreach ($tableInfo as $tableInfoRow) {
                $content .= $tableInfoRow['Create Table'] . ";\n\n";
                $content .= "--\n";
                $content .= "-- entrees dans la table `" . $table . "`\n";
                $content .= "--\n";

                $entries = $this->getConnection()->query("SELECT * FROM `" . $table . "`")->fetchAll('assoc');

                foreach ($entries as $entry) {
                    $content .= "INSERT INTO " . $table . " (";

                    $i = 0;
                    foreach ($entry as $entryKey => $entryValue) {
                        $entryKey = addslashes($entryKey);
                        $content .= "`" . $entryKey . "`";
                        $i++;
                        if ($i < count($entry))
                            $content .= ", ";
                    }

                    $content .= ") VALUES (";

                    $j = 0;
                    foreach ($entry as $entryValue) {
                        $entryValue = addslashes($entryValue);
                        $content .= "'" . $entryValue . "'";
                        $j++;
                        if ($j < count($entry))
                            $content .= ", ";
                    }

                    $content .= ");\n";
                }

                $content .= "\n\n";
                $content .= "-- --------------------------------------------------------\n\n\n";
            }
        }
    }

    // Create backup file
    $d['fname'] = 'sis' . "_" . date("d-m-Y_H-i-s") . ".sql";
    $filename = 'uploads' . DS . 'sql_dump' . DS . 'sis' . "_" . date("d-m-Y_H-i-s") . ".sql";
    $file = new File($filename, true);
    $d['file'] = $filename;
    $d['database'] = $database;
    $d['content'] = $content;

    if ($file->append($content, true)) {
        return $d;
    } else {
        return false;
    }
}

}
