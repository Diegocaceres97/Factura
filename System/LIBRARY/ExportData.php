<?php
declare (strict_types=1);
use Slam\Excel\Helper as ExcelHelper;
class ExportData
{
    public function exportarExcel(array $array,$filename,$title){
        $arrayData = new ArrayIterator($array);
        $columnCollection = new ExcelHelper\ColumnCollection([
            new ExcelHelper\Column('','',   15,     new ExcelHelper\CellStyle\Text()) //proporcionaremos estilo a las columnas de excel
            //ademas de la longitud(15) y el parametro que sigue es el estilo proporcionado en la direccion
        ]);
        $filename = sprintf('Excel/'.$filename,__DIR__,uniqid());//lugar excel
        $phpExcel = new ExcelHelper\TableWorkbook($filename);//creamos el archivo tipo en la sgte direccion
        $worksheet = $phpExcel->addWorksheet($title);//creamos la hoja dle tipo excel

        //agregaremos informacion a esa hoja de tipo excel creada
        $table = new ExcelHelper\Table($worksheet,0,0,'Data '.$title,$arrayData);
        $table->setColumnCollection($columnCollection);//estilos a las columnas

        //escribimos la tabla y cerramos la conexion
        $phpExcel->writeTable($table);
        $phpExcel->close();
    }
}

?>