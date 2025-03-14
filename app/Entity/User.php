<?php

namespace App\Entity;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property integer $id
 * @property string $username Логин
 * @property string $password Пароль
 * @property bool $deleted Удален
 * @property bool $blocked Заблокирован
 * @property bool $afk afk
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * @return UserInfo|array
     */
    public function getInfo()
    {
        return $this->hasOne(UserInfo::class, 'user_id', 'id')->get()?
            $this->hasOne(UserInfo::class, 'user_id', 'id')->get()[0]
            :[];
    }

    /**
     * @return UserDocumet|array
     */
    public function getDocument()
    {
        return $this->hasOne(UserDocumet::class, 'user_id', 'id')->get()?
            $this->hasOne(UserDocumet::class, 'user_id', 'id')->get()[0]
            :[];
    }

    public function getGroupsUser()
    {
        return $this->hasOne(GroupUser::class, 'users_id', 'id')->get();
    }

    /**
     * Возвращает все группы пользователя в массиве
     * @return UserGroup[]
     */
    public function getUserGroups()
    {
        $groups_user = $this->hasOne(GroupUser::class, 'users_id', 'id')->get();
        $groups = [];
        if($groups_user){
            foreach($groups_user as $group){
                $groups[] =  UserGroup::where(['id'=>$group->group_id])->first();
            }
        }
        return $groups;
    }

    public function getFio()
    {
        $info = $this->getInfo();
        if ($info) {
            return "{$info->last_name} {$info->first_name} {$info->patronymic}";
        }
        return '';
    }
}
