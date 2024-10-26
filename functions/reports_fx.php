<?php
    include_once('../functions/general.php');
    use PhpOffice\PhpWord\TemplateProcessor;
    use PhpOffice\PhpWord\IOFactory;
    use PhpOffice\PhpWord\Settings;
    use PhpOffice\PhpWord\PhpWord;
    use PhpOffice\PhpWord\SimpleType\Jc;
    use PhpOffice\PhpWord\SimpleType\VerticalJc; 
    global $conn;

//* REPORT CREATION *//
    if(isset($_POST['generate'])) {
        global $conn, $sem;

        // Get POST data
        $report = $_POST['report'];
        $batch = $_POST['batch_id'];
        $year = "2024-2025";
        $date = date("Y-m-d");

        if($report == 'requirement') {
            // First query to get document counts
            $query1 = "SELECT 
                        COUNT(*) AS total_scholars,  
                        COUNT(DISTINCT CASE 
                            WHEN sub_complete.complete_docs = 3 THEN s.scholar_id 
                            END) AS complete_scholars,  
                        COUNT(DISTINCT CASE 
                            WHEN (sub_complete.complete_docs < 3 OR sub_incomplete.incomplete_docs > 0) THEN s.scholar_id 
                            END) AS incomplete_scholars  
                    FROM scholar s
                    LEFT JOIN (
                        SELECT 
                            scholar_id, 
                            COUNT(DISTINCT doc_type) AS complete_docs 
                        FROM submission 
                        WHERE acad_year = ? AND sem = ? AND doc_status = 'APPROVED' 
                        AND doc_type IN ('COR', 'GRADES', 'SOCIAL')  
                        GROUP BY scholar_id
                    ) sub_complete ON s.scholar_id = sub_complete.scholar_id
                    LEFT JOIN (
                        SELECT 
                            scholar_id, 
                            COUNT(DISTINCT doc_type) AS incomplete_docs 
                        FROM submission 
                        WHERE acad_year = ? AND sem = ? AND (doc_status != 'APPROVED' OR doc_status IS NULL) 
                        AND doc_type IN ('COR', 'GRADES', 'SOCIAL')  
                        GROUP BY scholar_id
                    ) sub_incomplete ON s.scholar_id = sub_incomplete.scholar_id
                    WHERE s.batch_no = ?";
            
            $stmt1 = $conn->prepare($query1);
            $stmt1->bind_param('sssss', $year, $sem, $year, $sem, $batch);
            $stmt1->execute();
            $document_count = $stmt1->get_result()->fetch_assoc();

            // Second query to get scholars' full data
            $query2 = "SELECT s.scholar_id, s.batch_no, s.status,
                        s.last_name, s.first_name, s.middle_name,
                        s.school, s.course, s._address,
                        s.contact, s.email, s.remarks,
                        COALESCE(MAX(CASE WHEN sub.doc_type = 'COR' THEN sub.doc_status END), 'MISSING') AS COR,
                        COALESCE(MAX(CASE WHEN sub.doc_type = 'GRADES' THEN sub.doc_status END), 'MISSING') AS GRADES,
                        COALESCE(MAX(CASE WHEN sub.doc_type = 'SOCIAL' THEN sub.doc_status END), 'MISSING') AS SOCIAL
                    FROM scholar s
                    LEFT JOIN submission sub ON s.scholar_id = sub.scholar_id 
                        AND sub.acad_year = ? 
                        AND sub.sem = ?
                    WHERE s.batch_no = ?
                    GROUP BY 
                        s.scholar_id, s.batch_no, s.status,
                        s.last_name, s.first_name, s.middle_name, 
                        s.school, s.course, s._address,
                        s.contact, s.email, s.remarks
                    ORDER BY s.scholar_id";

            $stmt2 = $conn->prepare($query2);
            $stmt2->bind_param('sss', $year, $sem, $batch);
            $stmt2->execute();
            $full_data = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);

            // Load and populate the DOCX template
            $templatePath = "../assets/SCHOLAR-PROFILE-AND-REQUIREMENTS-REPORT.docx";
            $templateProcessor = new TemplateProcessor($templatePath);

            // Set the main placeholders
            $templateProcessor->setValue('Batch', $batch);
            $templateProcessor->setValue('Semester', $sem);
            $templateProcessor->setValue('School_Year', $year);
            $templateProcessor->setValue('Date', $date);
            $templateProcessor->setValue('Scholars', isset($document_count['total_scholars']) ? $document_count['total_scholars'] : 0);
            $templateProcessor->setValue('Complete', isset($document_count['complete_scholars']) ? $document_count['complete_scholars'] : 0);
            $templateProcessor->setValue('Missing', isset($document_count['incomplete_scholars']) ? $document_count['incomplete_scholars'] : 0);

            // Save the populated template to a temporary DOCX file
            $populatedTemplatePath = "../assets/temp_populated_report.docx";
            $templateProcessor->saveAs($populatedTemplatePath);

            // Load the populated DOCX file into PHPWord for further editing
            $phpWord = IOFactory::load($populatedTemplatePath);

            // Get the first section from the populated document
            $section = $phpWord->getSections()[0];

            // Define font and paragraph styles
            $headerFontStyle = array('name' => 'Arial Narrow', 'bold' => true, 'size' => 10);
            $contentFontStyle = array('name' => 'Arial Narrow', 'bold' => false, 'size' => 10);
            $centeredParagraphStyle = array(
                'alignment' => 'center',
                'valign' => 'middle'
            );
            $leftAlignedParagraphStyle = array(
                'alignment' => 'left',
                'valign' => 'top'
            );

            // Iterate over each scholar and create a new table
            foreach ($full_data as $data) {
                $table = $section->addTable();

                // Header Row: SCHOLAR DETAILS and A.Y. SEMESTER REQUIREMENTS
                $table->addRow();
                $table->addCell(5400, array('gridSpan' => 2))->addText('SCHOLAR DETAILS', $headerFontStyle, $centeredParagraphStyle);
                $table->addCell(3900, array('gridSpan' => 2))->addText('A.Y. ' . $year . ' SEMESTER ' . $sem . ' REQUIREMENTS', $headerFontStyle, $centeredParagraphStyle);

                // Row 1: Scholar ID and COR
                $table->addRow();
                $table->addCell(1600)->addText('SCHOLAR ID', $headerFontStyle, $centeredParagraphStyle);
                $table->addCell(3700)->addText($data['scholar_id'], $contentFontStyle, $centeredParagraphStyle);
                $table->addCell(1100)->addText('COR', $headerFontStyle, $centeredParagraphStyle);
                $table->addCell(2850)->addText($data['COR'], $contentFontStyle, $centeredParagraphStyle);

                // Row 2: Name and GRADES
                $table->addRow();
                $table->addCell(1600)->addText('NAME', $headerFontStyle, $centeredParagraphStyle);
                $table->addCell(3700)->addText($data['last_name'] . ', ' . $data['first_name'] . ' ' . $data['middle_name'], $contentFontStyle, $centeredParagraphStyle);
                $table->addCell(1100)->addText('GRADES', $headerFontStyle, $centeredParagraphStyle);
                $table->addCell(2850)->addText($data['GRADES'], $contentFontStyle, $centeredParagraphStyle);

                // Row 3: School and SOCIAL
                $table->addRow();
                $table->addCell(1600)->addText('SCHOOL', $headerFontStyle, $centeredParagraphStyle);
                $table->addCell(3700)->addText($data['school'], $contentFontStyle, $centeredParagraphStyle);
                $table->addCell(1100)->addText('SOCIAL', $headerFontStyle, $centeredParagraphStyle);
                $table->addCell(2850)->addText($data['SOCIAL'], $contentFontStyle, $centeredParagraphStyle);

                // Row 4: Course and Remarks (spanning)
                $table->addRow();
                $table->addCell(1600)->addText('COURSE', $headerFontStyle, $centeredParagraphStyle);
                $table->addCell(3700)->addText($data['course'], $contentFontStyle, $centeredParagraphStyle);
                $table->addCell(3920, array('gridSpan' => 2))->addText('REMARKS', $headerFontStyle, $centeredParagraphStyle);

                // Row 5: Address
                $table->addRow();
                $table->addCell(1600)->addText('ADDRESS', $headerFontStyle, $centeredParagraphStyle);
                $table->addCell(3700)->addText($data['_address'], $contentFontStyle, $centeredParagraphStyle);

                // Row 6: Contact Number
                $table->addRow();
                $table->addCell(1600)->addText('CONTACT NUMBER', $headerFontStyle, $centeredParagraphStyle);
                $table->addCell(3700)->addText($data['contact'], $contentFontStyle, $centeredParagraphStyle);

                // Row 7: Email
                $table->addRow();
                $table->addCell(1600)->addText('EMAIL', $headerFontStyle, $centeredParagraphStyle);
                $table->addCell(3700)->addText($data['email'], $contentFontStyle, $centeredParagraphStyle);

                // Add a break between tables
                $section->addTextBreak(2);
            }
                $section->addText('--Nothing Follows--', $contentFontStyle, $centeredParagraphStyle);

            // Save the DOCX file temporarily
            $docxFilePath = "../assets/temp_report.docx";
            $phpWord->save($docxFilePath);

            // Convert DOCX to PDF using TCPDF
            Settings::setPdfRendererName(Settings::PDF_RENDERER_TCPDF);
            Settings::setPdfRendererPath('../vendor/tecnickcom/tcpdf/');

            $pdfFileName = "Profile-Requirement-Report_Batch-".$batch."_Year-".$year."_Sem-$sem.pdf";
            $pdfFilePath = "../assets/$pdfFileName";

            $phpWord = IOFactory::load($docxFilePath);
            $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');
            $pdfWriter->save($pdfFilePath);

            // Delete the temporary DOCX file
            unlink($docxFilePath);
            unlink($populatedTemplatePath);

            // Insert report details into the database
            $title = "Scholar Profile and Requirements Report for Batch $batch - A.Y. $year - Semester $sem";
            $report_type = "requirement";
            $summary = "
                <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>
                SCHOLAR PROFILE AND REQUIREMENTS REPORT<br>
                A.Y. $year Semester $sem </h3><br>

                Batch Number: <strong> $batch </strong>

                <p> This report provides a comprehensive overview of the profile and current requirement status of scholars under the Dr. Pio Valenzuela Scholarship Program for Semester <strong> $sem </strong> of S.Y. <strong> $year </strong>. As of <strong>".$date."</strong>, there are a total of <strong>".$document_count['total_scholars']."</strong> scholars enrolled in the program for Batch Number <strong>".$batch."</strong>. The full report presents the profile of scholars and the current status of their requirements, along with the total number of scholars who have completed their requirements, and the number of scholars with missing requirements. This report is crucial for monitoring the progress of scholars and ensuring that they meet the program's criteria and obligation. </p>
                <br>
                    
                Total Number of Scholars: <strong>".$document_count['total_scholars']."</strong> <br>
                Total Number of Scholars with Complete Requirements: <strong>".$document_count['complete_scholars']."</strong> <br>
                Total Number of Scholars with Missing Requirements: <strong>".$document_count['incomplete_scholars']."</strong> <br> <br>
            "; // Placeholder for the summary

        } elseif($report == 'status') {
            // Query to get scholar counts by status
            $query = "SELECT 
                        COUNT(*) AS total_scholars,
                        COUNT(CASE WHEN status = 'ACTIVE' THEN 1 END) AS active_scholars,
                        COUNT(CASE WHEN status = 'PROBATION' THEN 1 END) AS probation_scholars,
                        COUNT(CASE WHEN status = 'DROPPED' THEN 1 END) AS dropped_scholars,
                        COUNT(CASE WHEN status = 'LOA' THEN 1 END) AS loa_scholars,
                        COUNT(CASE WHEN status = 'GRADUATED' THEN 1 END) AS graduated_scholars
                    FROM scholar
                    WHERE batch_no = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $batch);
            $stmt->execute();
            $result = $stmt->get_result();
            $scholar_count = $result->fetch_assoc();

            // Query to get scholar details
            $query = "SELECT 
                        scholar_id, 
                        last_name, 
                        first_name, 
                        COALESCE(NULLIF(middle_name, ''), 'N/A') AS middle_name,
                        status 
                    FROM scholar 
                    WHERE batch_no = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s', $batch);
            $stmt->execute();
            $result = $stmt->get_result();
            $status_data = $result->fetch_all(MYSQLI_ASSOC);

            // Load and modify DOCX template
            $templatePath = "../assets/SCHOLAR-STATUS-REPORT-_TEMPLATE.docx";
            $templateProcessor = new TemplateProcessor($templatePath);

            // Replace placeholders in the template
            $templateProcessor->setValue('Batch', $batch);
            $templateProcessor->setValue('Semester', $sem);
            $templateProcessor->setValue('School_Year', $year);
            $templateProcessor->setValue('Date', $date);
            $templateProcessor->setValue('Scholars', isset($scholar_count['total_scholars']) ? $scholar_count['total_scholars'] : 0);
            $templateProcessor->setValue('Active', isset($scholar_count['active_scholars']) ? $scholar_count['active_scholars'] : 0);
            $templateProcessor->setValue('Probation', isset($scholar_count['probation_scholars']) ? $scholar_count['probation_scholars'] : 0);
            $templateProcessor->setValue('Dropped', isset($scholar_count['dropped_scholars']) ? $scholar_count['dropped_scholars'] : 0);
            $templateProcessor->setValue('Absence', isset($scholar_count['loa_scholars']) ? $scholar_count['loa_scholars'] : 0);
            $templateProcessor->setValue('Graduates', isset($scholar_count['graduated_scholars']) ? $scholar_count['graduated_scholars'] : 0);

            $templateProcessor->cloneRow('SCHOLAR_ID', count($status_data));
            // Loop to replace scholar-specific placeholders
            foreach ($status_data as $index => $status_data) {
                $templateProcessor->setValue('SCHOLAR_ID#' . ($index + 1), $status_data['scholar_id']);
                $templateProcessor->setValue('LAST_NAME#' . ($index + 1), $status_data['last_name']);
                $templateProcessor->setValue('FIRST_NAME#' . ($index + 1), $status_data['first_name']);
                $templateProcessor->setValue('MIDDLE_NAME#' . ($index + 1), $status_data['middle_name']);
                $templateProcessor->setValue('STATUS#' . ($index + 1), $status_data['status']);
            }

            // Save the DOCX file temporarily
            $docxFilePath = "../assets/temp_report.docx";
            $templateProcessor->saveAs($docxFilePath);
            
            // Convert DOCX to PDF using TCPDF
            Settings::setPdfRendererName(Settings::PDF_RENDERER_TCPDF);
            Settings::setPdfRendererPath('../vendor/tecnickcom/tcpdf/');

            $pdfFileName = "Scholar-Status-Report_Batch-".$batch."_Year-".$year."_Sem-$sem.pdf";
            $pdfFilePath = "../assets/$pdfFileName";
            
            $phpWord = IOFactory::load($docxFilePath);
            $pdfWriter = IOFactory::createWriter($phpWord, 'PDF');
            $pdfWriter->save($pdfFilePath);

            // Delete the temporary DOCX file
            unlink($docxFilePath);

            // Insert report into the database
            $title = "Scholar Status Report for Batch {$batch} - A.Y. {$year} - Semester {$sem}";
            $report_type = "status";
            $summary = "
                <h3>DR. PIO VALENZUELA SCHOLARSHIP PROGRAM <br>
                SCHOLAR STATUS REPORT<br>
                A.Y. $year Semester $sem </h3><br>
                    
                Batch Number: <strong>$batch</strong>

                <p> This report provides an overview of the current status of scholars under the Dr. Pio Valenzuela Scholarship Program for the school year <strong>$year</strong>. As of <strong>$date</strong>, there are a total of <strong>".$scholar_count['total_scholars']."</strong> scholars enrolled in the program for Batch Number <strong>$batch</strong>. This report presents the current status of scholars under the Dr. Pio Valenzuela Scholarship Program, along with the total number of scholars based on their status: </p>
                <br>
                Total Active Scholars: <strong>".$scholar_count['active_scholars']."</strong> <br>
                Total Dropped Scholars: <strong>".$scholar_count['probation_scholars']."</strong> <br>
                Total Dropped Scholars: <strong>".$scholar_count['dropped_scholars']."</strong> <br>
                Total Scholars on Leave of Absence: <strong>".$scholar_count['loa_scholars']."</strong> <br>
                Total Graduated Scholars: <strong>".$scholar_count['graduated_scholars']."</strong> <br>
            "; // Placeholder, update if needed
        }

            $insertQuery = "INSERT INTO reports (batch_no, title, report_type, creation_date, acad_year, sem, file_name, summary) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param('ssssssss', $batch, $title, $report_type, $date, $year, $sem, $pdfFileName, $summary);
            $stmt->execute();
            header('Location: '.$_SERVER['PHP_SELF']);
    }
?>
