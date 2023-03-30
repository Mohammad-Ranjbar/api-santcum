<?php
namespace App\Repositories;
use mysql_xdevapi\Collection;

interface PostRepositoryInterface{
    public function getAll();

    public function getPost($id);
}
