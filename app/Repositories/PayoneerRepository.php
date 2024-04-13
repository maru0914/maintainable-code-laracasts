<?php

namespace App\Repositories;

use App\Contracts\PayoneerRepositoryInterface;
use App\Models\PaymentPayoneer;

class PayoneerRepository implements PayoneerRepositoryInterface
{
    public function getFields(): array
    {
        return [
          (object)[
              'name' => 'email',
              'type' => 'text',
              'label' => 'Email',
              'required' => true,
              'style' => 'col-xl-12',
          ],
        ];
    }
    public function getValues(int $userId)
    {
        //
    }

    public function store(int $userId, array $data): PaymentPayoneer
    {
        return PaymentPayoneer::updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }
    public function delete(int $userId)
    {
        //
    }
    public function makePrimary(int $userId)
    {
        //
    }
}
