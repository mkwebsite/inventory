<?php
App::uses('Component', 'Controller');

class CommonComponent extends Component { 
    
    
    public function uploadFileImage($imageData,$destination){
        $imageType = array('image/jpeg','image/png','image/gif','image/bmp','application/pdf',
            'application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-powerpoint','application/vnd.openxmlformats-officedocument.presentationml.presentation');
        if(!in_array($imageData['type'], $imageType)){
            $response['error'] = true;
            $response['msg'] = 'Invalid file type, please select only image files';
            return $response;
        }
        if($imageData['error']==1){
            $response['error'] = true;
            $response['msg'] = 'Some error occurred';
            return $response;
        }
        $ext = array_reverse(explode(".",$imageData['name']));
        $imageArray = explode(".",$imageData['name']);
        $filename = str_replace(" ","_",rand().".".end($imageArray));
        if(!is_dir($destination)) {
            mkdir($destination);
        }
        if(move_uploaded_file($imageData['tmp_name'], $destination.$filename)){
            $response['error'] = false;
            $response['filename'] = $filename;
            return $response;
        }else{
            $response['error'] = true;
            $response['msg'] = 'Can not upload, please try again later';
            return $response;
        }
    }
	
    public function fileName(){ 
        $filename = 'salesorder_details';
        return str_replace(" ","_",$filename);
    }
	
    public function createExcelFile($data=[],$type='Excel', $name='salesorder_details'){

		$this->layout =false;
        $this->autoRender =false;
        header("Content-type: application/vnd.ms-excel;charset:UTF-8");
        //$name = $this->fileName();
        $filename =  $name.".xlsx";
        header("Content-Disposition: attachment; filename=".$filename);
		
		App::import('Vendor', 'phpexcel', array('file'=>'phpexcel/PHPExcel.php'));
		
        //require_once(ROOT . DS . 'Vendor' . DS  . 'phpexcel' . DS .'PHPExcel.php');
        //require_once(ROOT . DS . 'Vendor' . DS  . 'phpexcel' . DS .'PHPExcel'. DS .'Writer'. DS .'Excel2007.php');
        $objPHPExcel = new \PHPExcel();
        //$objPHPExcel->getProperties()->setCreator("Runnable.com");
        //$objPHPExcel->getProperties()->setLastModifiedBy("Runnable.com");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX,generated using PHP classes.");
        $objPHPExcel->setActiveSheetIndex(0);
        $counter=0;
        foreach($data as $key1=> $val){
            $column =0;
            $rowColumn=0;
            foreach($val as $key2 => $value){
                if($counter==0){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column++,$key1+1,$key2);
                }
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($rowColumn++,$key1+2,$value);
            }
            $counter=1;
        }
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        return true;
    } 
}

?>
