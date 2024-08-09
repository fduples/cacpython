<?php

class CodModel {
    private $dataFile = '../scripts/cues.json';

    public function getAll() {
        $data = file_get_contents($this->dataFile);
        return json_decode($data, true);
    }

    public function getByKey($key) {
        $data = $this->getAll();
        return isset($data[$key]) ? $data[$key] : null;
    }

    public function create($key, $value) {
        $data = $this->getAll();
        $data[$key] = $value;
        return $this->save($data);
    }

    public function update($key, $value) {
        return $this->create($key, $value);
    }

    public function delete($key) {
        $data = $this->getAll();
        if (isset($data[$key])) {
            unset($data[$key]);
            return $this->save($data);
        }
        return false;
    }

    private function save($data) {
        return file_put_contents($this->dataFile, json_encode($data, JSON_PRETTY_PRINT));
    }
}
