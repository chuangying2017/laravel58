<?php


namespace App\Repository\Admin;


use App\Model\User;
use App\Repository\InterfaceRepository\CurdInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminRepository implements CurdInterface
{

    public function create(array $array): array
    {
        $createArr = [
            'password' => Hash::make($array['password']),
            'name' => $array['name'],
            'customerNum' => $array['maxCustomer'],
            'status' => $array['status'],
        ];

        try{
            DB::beginTransaction();
            $user = User::create($createArr);

            if ($user)
            {
                $user->role()->attach([$array['adminRole']]);
            }else{
                throw  new \Exception('添加失败!');
            }
            $result = true;
            DB::commit();
        }catch (\Exception $exception)
        {
            $result = false;
            DB::rollBack();
        }
            return status($result);
    }

    public function delete($id): bool
    {
        $find = User::find($id);

        if (empty($find))
        {
            return false;
        }

        $find->role()->detach($find->id);

        $find->status = User::STATUS_DELETE;

        $find->save();

        $find->delete();

        return true;
    }

    public function update($id, $data): bool
    {
            $find = User::find($id);

            $updateData = [
                'name' => $data['name'],
                'customerNum'=>$data['maxCustomer'],
            ];

            $find->fill($updateData);

            $find->save();

            $find->role()->detach();

            $find->role()->toggle([$data['adminRole']]);

            return true;
    }

    public function select($with = true)
    {
            $query = User::query();

            if ($with)
            {
                $query->with(['role']);
            }

            return $query->get();
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function find(int $id)
    {
        return User::query()->with('role')->find($id);
    }

    public function editStatus($id, $status)
    {
        $find = User::find($id);

        if (empty($find))
        {
            return false;
        }

        $find->status = $status;

        return $find->save();
    }
}
