<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @OA\Schema(
 *     schema="User",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="prenom", type="string"),
 *     @OA\Property(property="nom", type="string"),
 *     @OA\Property(property="image", type="string", nullable=true,format="file"),
 *     @OA\Property(property="adresse", type="string"),
 *     @OA\Property(property="telephone", type="string"),
 *     @OA\Property(property="email", type="string"),
 *     @OA\Property(property="password", type="string"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 */
class User extends  Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prenom',
        'nom',
        'image',
        'adresse',
        'telephone',
        'email',
        'password',
        'role_id'
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


        public function role()
        {
            return $this->belongsTo(Role::class);
        }


        public function isAdmin()
    {
        
        return $this->role_id === 1;
    }

  public function UserAll()
  {
     return $this->role_id	 === [1,2,3];
  }

   public function User()
   {
    return  $this->role_id === [1,2];
   }

  public function produits()
  {
      return $this->hasMany(Produits::class, 'jardinier_id');
  }

  public function commentaires()
  {
      return $this->hasMany(Commentaire::class);
  }
// Dans le modèle User
public function isJardinier()
{
    return $this->role_id	 === 2 ;
}

public function messages()
{
    return $this->hasMany(Message::class, 'envoyeur_id')
                ->orWhere('receveur_id', $this->id);
}

public function categories()
{
    return $this->hasMany(Categories::class);
}
public function videos()
{
    return $this->hasMany(Video::class);
}
}
