<?php

namespace App\Controllers;

use App\Models\DblpModel;
use App\Models\Pid;
use DomainException;

class Dblp extends BaseController
{
    function author(string $name)
    {
        $model = model(DblpModel::class);
        

        // Récupération des infos de l'auteur
        $author_data = $model->get_author_data($name);

        if (!isset($author_data['result']['hits']['hit'][0]['info'])) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Auteur '$name' non trouvé dans DBLP.");
        }

        $author_info = $author_data['result']['hits']['hit'][0]['info'];

        $pid = Pid::from_url($author_info['url']);

        // Récupération des publications
        $publications = $model->get_publications($pid);

        // Passage des données à la vue
        return view('dblp_view', [
            'author'       => $author_info,
            'publications' => $publications
        ]);
    }
}

readonly class Faker implements \ArrayAccess
{
    function __construct(private string $value) {}

    function __get(string $name)
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    function offsetExists(mixed $offset): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    function offsetGet(mixed $offset): mixed
    {
        return $this;
    }

    /**
     * @inheritDoc
     */
    function offsetSet(mixed $offset, mixed $value): void
    {
        throw new DomainException('read-only');
    }

    /**
     * @inheritDoc
     */
    function offsetUnset(mixed $offset): void
    {
        throw new DomainException('read-only');
    }

    function __tostring()
    {
        return $this->value;
    }
}
