<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\TransactionRepository;

class UserRepository implements UserRepositoryInterface
{
    protected $transRepo;
    protected $user;
    protected $filterConstraints;

    public function __construct(User $user, TransactionRepository $transactionRepository)
    {
        $this->user = $user;
        $this->transRepo = $transactionRepository;
        $this->filterConstraints = [];
    }

    /**
     * Get all users with transactions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return $this->user->with('transactions')->get();
    }

    /**
     * Filter users by currency, status code, amount, and date.
     *
     * @param array $filterKeys
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filter($filterKeys)
    {

        $filterQueryBuilder = new FilterQueryBuilder($this->user, $this->transRepo);
        return $filterQueryBuilder->buildQuery($filterKeys)->get();
    }
}
