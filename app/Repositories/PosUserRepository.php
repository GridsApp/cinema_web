<?php

namespace App\Repositories;

use App\Interfaces\PosUserRepositoryInterface;

use App\Models\PosUser;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class PosUserRepository implements PosUserRepositoryInterface
{

    public function getUserById($id)
    {

        try {
            return PosUser::where('id', $id)
                ->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function getUserByUsername($username , $branch_id)
    {

        try {
            $user = PosUser::where('username', $username)
                ->where('branch_id' , $branch_id)
                ->whereNull('deleted_at')->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("User with Username {$username} not found .");
        }
        return $user;
        
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
    public function getManagerByIdAndPin($id, $pincode, $branch_id)
    {
        try {
            $manager = PosUser::whereNull('deleted_at')
                ->where('role', 'manager')
                ->where('id', $id)
                ->where('pincode', $pincode)
                ->where('branch_id', $branch_id)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException("manager with Pin {$pincode} and Id {$id} not found .");
        }

        return $manager;
    }
}
