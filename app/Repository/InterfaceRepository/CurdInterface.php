<?php


namespace App\Repository\InterfaceRepository;

interface CurdInterface
{
    public function create(array $array):array ;

    public function delete($id):bool ;

    public function update($id,$data):bool ;

    public function select();

    public function find(int $id);
}
