<?php
namespace App\Src\modules\repository;

class RepositoriesContext
{
    public array $repositories;
    public function __construct(array $data_repositories)
    {
        $this->repositories = $data_repositories;
    }
    public function get(): array
    {
        return $this->repositories;
    }

    public function getRepository($name, $arguments)
    {
        foreach ($this->repositories as $repository){
            $data_repository = $repository->$name($arguments);
        }
    }
    public function __call($name, $arguments){

    }
}
