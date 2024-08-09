<?php

require_once 'CodModel.php';

class CodController {
    private $model;

    public function __construct() {
        $this->model = new CodModel();
    }

    public function handleRequest() {
        $action = $_POST['action'];
        $key = $_POST['key'] ?? null;
        $value = $_POST['value'] ?? null;

        switch ($action) {
            case 'create':
                echo json_encode($this->model->create($key, $value));
                break;
            case 'read':
                echo json_encode($this->model->getByKey($key));
                break;
            case 'update':
                echo json_encode($this->model->update($key, $value));
                break;
            case 'delete':
                echo json_encode($this->model->delete($key));
                break;
            case 'getAll':
                echo json_encode($this->model->getAll());
                break;
            default:
                echo json_encode(['error' => 'Acción no válida']);
                break;
        }
    }
}

$controller = new CodController();
$controller->handleRequest();
