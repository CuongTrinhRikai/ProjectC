<?php

namespace App\Services\System;

use App\Events\UserCreated;
use App\Exceptions\CustomGenericException;
use App\Exceptions\EncryptedPayloadException;
use App\Exceptions\NotDeletableException;
use App\Exceptions\ResourceNotFoundException;
use App\Exceptions\RoleNotChangeableException;
use App\Helper\Ekcms\uploadImageHelper;
use App\Model\Role;
use App\Services\Service;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserService extends Service
{
    public function __construct(User $user, Role $role)
    {
        parent::__construct($user);
        $this->role = $role;
    }

    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query()->where('company_id', $data->company_id);
       
        if (isset($data->keyword) && $data->keyword !== null) {
            $query->where('name', 'LIKE', '%' . $data->keyword . '%');
        }
        if (isset($data->role) && $data->role !== null) {
            $query->where('role_id', $data->role);
        }
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }
        if ($pagination) {
            return $query->orderBy('id', 'DESC')->with('role')->paginate(PAGINATE);
        }
        return $query->orderBy('id', 'DESC')->with('role')->get();
    }
    public function getRoles()
    {
        $mapped = array();
        $roles = $this->role->orderBy('name', 'ASC')->get();
        foreach ($roles as $role) {
            $mapped[$role->id] = translate($role->name);
        }
        return $mapped;
    }

    public function indexPageData($request)
    {
        return [
            'items' => $this->getAllData($request),
            'roles' => $this->getRoles()
        ];
    }

    public function createPageData($request)
    {
        return [
            'roles' => $this->getRoles()
        ];
    }

    public function store($request)
    {
        \DB::transaction(function () use ($request) {
            $data = $request->except('_token');

            $file = $request->file('image');

            if ($request->hasFile('image')) {
                $data['image'] = uploadImageHelper::uploadImage($file, '/uploads/users');
            }
            if ($request->set_password_status == '1') {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            $token = $this->generateToken(24);
            $data['token'] = $token;
            $user = $this->model->create($data);
            try {
                event(new UserCreated($user, $token));
                return $user;
            } catch (\Exception $e) {
            }
        });
    }

    public function editPageData($request, $id)
    {
        $user = $this->itemByIdentifier($id);
        return [
            'item' => $user,
            'roles' => $this->getRoles()
        ];
    }

    public function update($request, $id)
    {
        try {
            $data = $request->except('_token');
            $file = $request->file('image');

            if ($request->hasFile('image')) {
                if ($request->image) {
                    $path = public_path('uploads/users');

                    if (!empty($request->image) && file_exists($path . '/' . $request->image)) {

                        unlink(($path . '/' . $data->image));
                    }
                }

                $data['image'] = uploadImageHelper::uploadImage($file, '/uploads/users');
            }

            $user = $this->itemByIdentifier($id);
            if (isset($request->role_id) && ($user->id == 1 && $request->role_id != 1)) {
                throw new RoleNotChangeableException(translate('The role of the specific user cannot be changed.'));
            }

            return $user->update($data);
        } catch (\Exception $e) {
            throw new CustomGenericException($e->getMessage());
        }
    }

    public function delete($request, $id)
    {
        if ($id == 1) {
            throw new NotDeletableException();
        }
        $user = $this->itemByIdentifier($id);
        return $user->delete();
    }

    public function generateToken($length)
    {
        $token = generateToken($length);
        $check = $this->model->where('token', $token)->exists();
        if ($check) {
            $token = generateToken($length);
        }
        return $token;
    }

    public function findByEmailAndToken($email, $token)
    {
        try {
            $decryptedToken = decrypt($token);
        } catch (\Exception $e) {
            throw new EncryptedPayloadException('Invalid encrypted data');
        }
        $user = $this->model->where('email', $email)->where('token', $decryptedToken)->first();
        if (!isset($user)) {
            throw new ResourceNotFoundException(translate("User doesn't exist in our system."));
        }
        return $user;
    }
    public function findByEmail($email)
    {
        $user = $this->model->where('email', $email)->first();
        if (!isset($user)) {
            throw new ResourceNotFoundException(translate("User doesn't exist in our system."));
        }
        return $user;
    }

    public function resetPassword($request)
    {
        $user = $this->itemByIdentifier($request->id);
        return $user->update([
            'password' => Hash::make($request->password)
        ]);
    }
}
