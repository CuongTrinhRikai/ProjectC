<?php

namespace App\Services\System;

use App\Exceptions\NotDeletableException;
use App\Model\Role;
use App\Services\Service;
use App\User;

class RoleService extends Service
{
    public function __construct(Role $role, User $user)
    {
        parent::__construct($role);
        $this->user = $user;
    }

    public function mapPermission($permissions)
    {
        $mappedPermissions = [];
        foreach ($permissions as $permission) {
            $decoded = json_decode($permission);
            if (is_array($decoded)) {
                foreach ($decoded as $per) {
                    array_push($mappedPermissions, $per);
                }
            } else {
                array_push($mappedPermissions, $decoded);
            }
        }
        return $mappedPermissions;
    }
    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query();

        if (isset($data->keyword) && $data->keyword !== null) {
            $query->where('name', 'LIKE', '%' . $data->keyword . '%');
        }
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }
        if ($pagination) {
            return $query->orderBy('id', 'DESC')->with('users')->paginate(10);
        }
        return $query->orderBy('id', 'DESC')->with('users')->get();
    }

    public function indexPageData($request)
    {
        return ['items' => $this->getAllData($request)];
    }
    public function store($request)
    {
        $data = $request->except('_token');
        $data['permissions'] = $this->mapPermission($request->permissions);
        return $this->model->create($data);
    }
    public function editPageData($request, $id)
    {
        $role = $this->itemByIdentifier($id);
        return [
            'item' => $role
        ];
    }
    public function update($request, $id)
    {
        $role = $this->itemByIdentifier($id);
        $data = $request->except('_token');
        $data['permissions'] = $this->mapPermission($data['permissions']);
        $checkRoleUsers = $this->user->where('role_id', $id)->get();
        $role->update($data);
        $role = $this->itemByIdentifier($id);
        if ($checkRoleUsers != null || isset($checkRoleUsers)) {
            foreach ($checkRoleUsers as $user) {
                if (getRoleCache($user) != null) {
                    clearRoleCache($user);
                    setRoleCache($user);
                }
            }
        }
        return $role;
    }

    public function delete($request, $id)
    {
        $role = $this->itemByIdentifier($id);
        if ($role->users->count() > 0) {
            throw new NotDeletableException('The role is associated to the users.');
        }
        return $role->delete();
    }
}
