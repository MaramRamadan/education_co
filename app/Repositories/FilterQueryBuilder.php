<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\TransactionRepository;
use Illuminate\Database\Eloquent\Builder;

class FilterQueryBuilder
{
    private $user;
    private $transactionRepository;
    private $filterConstraints;

    public function __construct(User $user, TransactionRepository $transactionRepository)
    {
        $this->user = $user;
        $this->transactionRepository = $transactionRepository;
        $this->filterConstraints = [];
    }

    public function buildQuery(array $filterKeys): Builder
    {
        $this->prepareFilterConstraints($filterKeys);

        return $this->user
            ->whereHas('transactions', function ($query) {
                $this->applyFilterConstraintsToQuery($query);
            })
            ->with(['transactions' => function ($query) {
                $this->applyFilterConstraintsToQuery($query);
            }])
            ->has('transactions');
    }

    private function prepareFilterConstraints(array $filterKeys): void
    {
        foreach ($filterKeys as $filterKey => $filterValue) {
            $filterValue = $this->prepareDataToQuery($filterValue);
            if ($filterKey === 'status') {
                $this->addFilterConstraint('status_code', 'whereIn', $this->transactionRepository->getStatusCode($filterValue));
            }
            if ($filterKey === 'currency') {
                $this->addFilterConstraint('Currency', 'whereIn', $filterValue);
            }
            if ($filterKey === 'date') {
                $this->addFilterConstraint('payment_date', 'whereBetween', $filterValue);
            }
            if ($filterKey === 'amount') {
                $this->addFilterConstraint('paid_amount', 'whereBetween', $filterValue);
            }

            // add more filter key here ...
        }
    }

    private function prepareDataToQuery($data): array
    {
        $data = explode(",", $data);
        sort($data);
        return $data;
    }

    private function addFilterConstraint(string $key, string $condition, $value): void
    {
        $this->filterConstraints[] = compact('key', 'condition', 'value');
    }

    private function applyFilterConstraintsToQuery($query): void
    {
        foreach ($this->filterConstraints as $constraint) {
            $condition = $constraint['condition'];
            $query->$condition($constraint['key'], $constraint['value']);
        }
    }
}
