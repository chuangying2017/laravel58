<?php


namespace App\Repository\InterfaceRepository;

interface CurdInterface
{
    public function create(array $array):array ;

    public function delete():bool ;

    public function update():bool ;

    public function select();

    public function find(int $id);
}
