<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Payment extends REST_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index_get() {
        $this->load->model("Payments_model");
        //Should have a better way to validate that these variables are set and have the correct data types
        //It would be better to check if the variables and set separately that way you can send back an error saying a required parameter is missing
        $limit = (isset($_GET["limit"]) && intval($_GET["limit"])>=0)?(int)$_GET["limit"]:100;
        $offset = (isset($_GET["offset"]) && intval($_GET["offset"])>=0)?(int)$_GET["offset"]:0;
        if (isset($_GET["page"])) {
            //if page is set override offset by multiplying $limit * $page
            $page = (intval($_GET["page"])>=1)?(int)$_GET["page"]:1;
            //page is NOT zero base, user should enter page number starting from 1
            //we should subtract 1 from page to bring it to zero base so the offsetting works
            $offset = ($page-1) * $limit;
        }
        $search = (!empty($_GET["search"]))?$_GET["search"]:false;

        $payments = $this->Payments_model->get_payments($search, $limit, $offset);
        if ($payments) {
            $this->response($payments, REST_Controller::HTTP_OK);
        }
        else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Payments could not be found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function typeahead_get() {
        $this->load->model("Payments_model");
        $search = (!empty($_GET["query"]))?$_GET["query"]:false;
        $limit = (isset($_GET["limit"]) && intval($_GET["limit"])>=0)?(int)$_GET["limit"]:10;
        $physicians = $this->Payments_model->searchPhysicians($search, $limit);
        if ($physicians) {
            $this->response($physicians, REST_Controller::HTTP_OK);
        }
        else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Physicians could not be found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function reseed_post() {
        set_time_limit(0); //this will take a while
        $this->load->model("Installer_model");
        if (!$this->Installer_model->resetAndSeed()) {
            $this->set_response([
                'status' => TRUE,
                'message' => 'Done',
                'inserted' => $status["rowsInserted"]
            ], REST_Controller::HTTP_OK);
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Something broke'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

    }

    //Instead of creating the spreadsheets for each request
    //I would probably look to set up some sort of caching and "queue" system
    //So when a user requests a spreadsheet the server doesn't automatically generate one as soon as they click the button
    //It will generate a token for the request (probably a hashed value of their search term) and insert the request into a queue
    //Then another process on the server can go through the queue and the server will not be generating multiple spreadsheets at the same time if a lot of users are on the site
    //After the request is put into the queue the ajax response can go back to the user with a link they have to follow later on (can possibly give an estimate based on the size of the queue)
    //The response could also have a field for the user to enter an email address and another process on the server could mail out when the spreadsheets are ready to users who signed up to be alerted
    public function export_post() {
        $input = json_decode(file_get_contents("php://input"), true) ? : [];
        $search = (!empty($_POST["search"]))?$_POST["search"]:false;
        if ($search !== false) {
            $this->load->helper('payments_db_columns_helper');
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $db_columns = get_payments_db_columns();
            $index = 1;
            //header
            foreach ($db_columns as $col) {
                $sheet->setCellValueByColumnAndRow($index++, 1, $col);
            }
            $this->load->model("Payments_model");
            $payments = $this->Payments_model->get_payments($search, false, false);
            if ($payments) {
                $rowIndex = 2;
                $colIndex = 1;
                foreach ($payments["results"] as $row) {
                    $isFirst = true;
                    foreach ($row as $col) {
                        if ($isFirst) {
                            $isFirst = false; //skips the id row
                        }
                        else {
                            $sheet->setCellValueByColumnAndRow($colIndex++, $rowIndex, $col);
                        }
                    }
                    $colIndex = 1;
                    $rowIndex++;
                }
            }
            else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Payments could not be found'
                ], REST_Controller::HTTP_NOT_FOUND);
                return;
            }

            $writer = new Xlsx($spreadsheet);
            
            $filename = $search;
    
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');
        } else {
            $this->set_response([
                'status' => FALSE,
                'message' => 'Set a search value',
                'search' => $input
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

}
