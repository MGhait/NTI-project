<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // to pass the options for enum role there is two ways
    // first way isn't too good for database
//    public static function getRoleOptions()
//    {
//        $type = DB::select(DB::raw('SHOW COLUMNS FROM users WHERE Field = "role"'))[0]->Type;
//        preg_match('/^enum\((.*)\)$/', $type, $matches);
//        $values = array();
//        foreach(explode(',', $matches[1]) as $value){
//            $values[] = trim($value, "'");
//        }
//        return $values;
//    }

    //second one
    const ROLE_ADMIN = 'admin';
    const ROLE_EDITOR = 'editor';
    const ROLE_SUPERVISOR = 'supervisor';
    public static function getRoleOptions()
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_EDITOR,
            self::ROLE_SUPERVISOR,
        ];
    }
    // we can use it in controller now (enjoy ^_^)
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'logName',
        'fullName',
        'password',
        'role'
    ];


    public function policies(): BelongsToMany
    {
        return $this->belongsToMany(Policy::class, 'policy_users');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
