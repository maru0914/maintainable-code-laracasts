<?php

namespace App\Services\PaymentOptions;

use App\Contracts\PaymentOption;
use App\Repositories\WiseRepository;
use Exception;
use Throwable;

class Wise implements PaymentOption
{
    public function __construct(protected WiseRepository $wiseRepository)
    {
    }

    public function getFields(): array
    {
        return $this->wiseRepository->getFields();
    }
    public function getValues(int $userId)
    {

    }
    public function store(int $userId, array $data)
    {
        try {
            $fields = $this->getFields();
            $wiseDetails = [];
            foreach ($fields as $field) {
                if(isset($data[$field->name])) {
                    $wiseDetails[$field->name] = $data[$field->name];
                } else {
                    throw new Exception("Missing field: {$field->name}");
                }
            }
            return $this->wiseRepository->store($userId, $wiseDetails);
        } catch (Throwable $th) {
            throw $th;
        }

    }
    public function delete(int $userId)
    {

    }
    public function makePrimary(int $userId)
    {

    }
}
