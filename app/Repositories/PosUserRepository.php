<?php

namespace App\Repositories;

use App\Interfaces\PosUserRepositoryInterface;
use App\Interfaces\TokenRepositoryInterface;
use App\Models\PosUser;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;


class PosUserRepository implements PosUserRepositoryInterface
{


    private TokenRepositoryInterface $tokenRepository;


    public function __construct(TokenRepositoryInterface $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function getUserById($id)
    {

        try {
            return PosUser::where('id', $id)
                ->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function getUserByUsername($username)
    {


        try {
            $user = PosUser::where('username', $username)
                ->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("User with Username {$username} not found .");
        }
        return $user;
        // return PosUser::whereNull('deleted_at')
        //     ->where('username', $username)
        //     ->first();
    }
    public function getManagers($branch_id)
    {
        try {
            $managers = PosUser::whereNull('deleted_at')
                ->where('role', 'manager')
                ->where('branch_id', $branch_id)
                ->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $managers;
    }
    public function getManagersByPin($id, $pincode,$branch_id)
    {
        try {
            $manager = PosUser::whereNull('deleted_at')
                ->where('role', 'manager')
                // ->where('id', $id)
                ->where('pincode', $pincode)
                ->where('branch_id', $branch_id)
                ->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        // dd($manager);
        return $manager;
    }
}
