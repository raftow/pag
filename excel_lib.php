<?php
function fill_worksheet(&$active_sheet, $title_sheet, $header, $data, $isAvail)
{        
        $_alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W'); 
                
        
        $last_letter = $_alphabet[count($header)];
        $all_header_row = 'A1:'.$last_letter.'1';
        
        $active_sheet->getStyle($all_header_row)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $active_sheet->getStyle($all_header_row)->getFill()->getStartColor()->setARGB('FF12926E');
        
        
        $active_sheet->getStyle('B1')->getFont()->setName('Candara');
        $active_sheet->getStyle('B1')->getFont()->setSize(20);
        $active_sheet->getStyle('B1')->getFont()->setBold(true);
        $active_sheet->getStyle('B1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
        $active_sheet->getStyle('B1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
        $active_sheet->getStyle('D1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
        $active_sheet->getStyle('E1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
        
        
        $active_sheet->setCellValue('B1', $title_sheet);
        $active_sheet->setCellValue('D1', PHPExcel_Shared_Date::PHPToExcel( gmmktime(0,0,0,date('m'),date('d'),date('Y')) ));
        $active_sheet->getStyle('D1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX15);
        $active_sheet->setCellValue('E1',AfwDateHelper::currentHijriDate("hdate_long"));
        
        $icol = 0;
        foreach($header as $nom_col => $desc)
        {
            $col_letter = $_alphabet[count($header)-$icol];    
            $cellpos= $col_letter.'3';
            $active_sheet->setCellValue($cellpos, $desc);
            $active_sheet->getColumnDimension($col_letter)->setAutoSize(true);    
            $icol++;
        }
        
        $irow = 4;
        foreach($data as $id => $tuple)
        {
                $icol = 0;
                foreach($header as $nom_col => $desc)
                {
                     $cellpos= $_alphabet[count($header)-$icol].$irow;
                     $active_sheet->getStyle($cellpos)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                     $active_sheet->setCellValue($cellpos, $tuple[$nom_col]);
                     $icol++;
                }
                $irow++;
        }
        
        $lastrow = 4 + count($data) - 1; 
        
        $all_data_grid = 'A4:'.$last_letter.$lastrow;
        
        
        $styleThinBlackBorderOutline = array(
        	'borders' => array(
        		'outline' => array(
        			'style' => PHPExcel_Style_Border::BORDER_THIN,
        			'color' => array('argb' => 'FF000000'),
        		),
        	),
        );
        $active_sheet->getStyle($all_data_grid)->applyFromArray($styleThinBlackBorderOutline);
        
        $grid_header_row = 'A3:'.$last_letter.'3';
        
        $active_sheet->getStyle($grid_header_row)->applyFromArray(
        		array(
        			'font'    => array(
        				'bold'      => true
        			),
        			'alignment' => array(
        				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        			),
        			'borders' => array(
        				'top'     => array(
         					'style' => PHPExcel_Style_Border::BORDER_THIN
         				)
        			),
        			'fill' => array(
        	 			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
        	  			'rotation'   => 90,
        	 			'startcolor' => array(
        	 				'argb' => 'FFA0A0A0'
        	 			),
        	 			'endcolor'   => array(
        	 				'argb' => 'FFFFFFFF'
        	 			)
        	 		)
        		)
        );
        
        $active_sheet->getStyle('A3')->applyFromArray(
        		array(
        			'alignment' => array(
        				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        			),
        			'borders' => array(
        				'left'     => array(
         					'style' => PHPExcel_Style_Border::BORDER_THIN
         				)
        			)
        		)
        );
        
        $active_sheet->getStyle('B3')->applyFromArray(
        		array(
        			'alignment' => array(
        				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        			)
        		)
        );
        
        $active_sheet->getStyle('E3')->applyFromArray(
        		array(
        			'borders' => array(
        				'right'     => array(
         					'style' => PHPExcel_Style_Border::BORDER_THIN
         				)
        			)
        		)
        );
        
        // Unprotect a cell
        $active_sheet->getStyle('B1')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
        
        /*
        // Add a drawing to the worksheet
        echo date('H:i:s') , " Add a drawing to the worksheet" , EOL;
        $objDrawing = new PHPExcel_Worksheet_Drawing();
        $objDrawing->setName('PHPExcel logo');
        $objDrawing->setDescription('PHPExcel logo');
        $objDrawing->setPath('./images/phpexcel_logo.gif');
        $objDrawing->setHeight(36);
        $objDrawing->setCoordinates('D24');
        $objDrawing->setOffsetX(10);
        $objDrawing->setWorksheet($active_sheet);
         */
        
        // Set page orientation and size
        $active_sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $active_sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        
        // Rename first worksheet
        $active_sheet->setTitle($title_sheet);
}

function prepareDataGridForWorksheet($obj, $liste_obj, $objme, $lang="ar")
{
        $cols_retrieve   = array();
        $cols_show       = array();
        $data            = array();
        $isAvail         = array();
        
        if(!is_object($obj)) 
        {
                /*$file_dir_name = dirname(__FILE__);
                include("$file_dir_name/../afw/afw.php");*/
                $objme::_error("missed object for excel_lib::prepareDataGridForWorksheet method ".var_export($obj,true)); 
        
        }
        
        $cols_retrieve = AfwUmsPagHelper::getExportExcelHeader($obj, $lang);
        //die(var_export($cols_retrieve,true));  
        //AFWDebugg::print_str('fin for each '.__LINE__);
        if(count($cols_retrieve) != 0)
        $header = &$cols_retrieve;
        else
        $header = array("description"=>"AAA");
        //AFWDebugg::log("**************************************\n");
        //AFWDebugg::log($cols_retrieve,true);
        
        //AFWDebugg::print_str('foreach  '.__LINE__);
        
        
        $arr_active_ids = array();
        
        foreach($liste_obj as $id => $val)
        {
                if(AfwUmsPagHelper::userCanDoOperationOnObject($val,$objme,'display'))
        	{
                        $objIsActive = $val->isActive(); 
        		$tuple = array();
        		if(count($header) != 0)
                        {
        			foreach ($header as $col => $desc)
        			{
        			    if($desc=="AAA")
        			    {
        			        $tuple["description"] = $val->__toString();    
                                    }
                                    else
                                    {
        				switch ($desc["TYPE"])
        				{
        					case 'FK'     : 
                                                        $objs = $val->get($col, "object", "", false);
                					if(empty($desc["CATEGORY"])) 
                                                        {
                                                              if($objs) $tuple[$col] = $objs->getDisplay();
                                                        }
                					else
                                                        {
                                                              if(count($objs))
                                                              {
                						$str  = "";
                						foreach ($objs as $instance) $str .= $instance.'<br>';
                						$tuple[$col] = $str;
                					      }
                					}
                					break;
        					case 'MFK'    : 
                                                        $objs = $val->get($col, "object", "", false);
                                                        
                                                        if(count($objs))
                                                        {
                                                           //echo "$col : <br>";
                                                           //die(var_export($objs,true));     
        					           $str  = "";
        					           foreach ($objs as $instance) $str .= $instance.'<br>';
        					           $tuple[$col] = $str;
        					        }
        					        break;
        					case 'ANSWER' : 
                                                        $tuple[$col] = $val->decode($col);
        					        break;
        					case 'YN' : 
                                                        $tuple[$col] = $val->translate(strtoupper($val->decode($col)),$lang);
        					        break;        
        					default       : 
                                                        $tuple[$col] = $val->decode($col,"NO-URL");
        					        break;
        				}
        			    }
        			}
        		}
        		$data[$id] = $tuple;
        		$isAvail[$id] = $objIsActive;
                        if($isAvail[$id]) $arr_active_ids[] = $id;
        		// $count_liste_obj++;
        	}
        	
        }
        
        //die(var_export($header,true));
        
        return array($header, $data, $isAvail, implode(",",$arr_active_ids));
}
?>