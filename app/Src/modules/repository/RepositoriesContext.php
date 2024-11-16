<?php

namespace App\Src\modules\repository;

use Mockery\Exception;

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

    protected function getRepository($name, $arguments = [])
    {
        foreach ($this->repositories as $repository) {
            if (method_exists($repository, $name)) {
                return (new $repository())->$name($arguments);
            }
        }
        throw new Exception("Репозиторий не найден", 500);
    }

    public function __call($name, $arguments)
    {
        return $this->getRepository($name, $arguments);
    }
}
