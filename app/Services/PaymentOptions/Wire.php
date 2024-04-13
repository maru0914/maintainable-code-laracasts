<?php

namespace App\Services\PaymentOptions;

use App\Contracts\PaymentOption;
use App\Contracts\WireRepositoryInterface;
use Exception;
use Throwable;

class Wire implements PaymentOption
{
    public function __construct(protected WireRepositoryInterface $wireRepository)
    {
    }

    public function getFields()
    {
        return $this->wireRepository->getFields();
    }

    public function getValues(int $userId)
    {

    }

    public function store(int $userId, array $data)
    {
        try {
            $fields = $this->getFields();
            $wireDetails = [];
            foreach ($fields as $field) {
                if (isset($data[$field->name])) {
                    $wireDetails[$field->name] = $data[$field->name];
                } else {
                    throw new Exception("Missing field: {$field->name}");
                }
            }
            return $this->wireRepository->store($userId, $wireDetails);

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
