<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

// use Illuminate\Database\Eloquent\Relations\HasOne;
use ArrayAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\Xot\Contracts\ModelProfileContract;
use Modules\Xot\Contracts\ModelWithUserContract;
use Modules\Xot\Database\Factories\ProfileFactory;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Tags\HasTags;
use Spatie\Tags\Tag;

/**
 * Modules\Xot\Models\Profile.
 *
 * @property int                         $id
 * @property string|null                 $post_type
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $updated_at
 * @property string|null                 $created_by
 * @property string|null                 $updated_by
 * @property string|null                 $deleted_by
 * @property string|null                 $first_name
 * @property string|null                 $last_name
 * @property string|null                 $email
 * @property string|null                 $phone
 * @property string|null                 $address
 * @property int|null                    $user_id
 * @property string|null                 $bio
 * @property string|null                 $emails
 * @property string|null                 $mobiles
 * @property string|null                 $envelope_id
 * @property int|null                    $is_signed
 * @property int                         $company_selected_id
 * @property string                      $company_data_requests
 * @property string|null                 $nexi_transaction_code
 * @property Collection<int, Permission> $permissions
 * @property int|null                    $permissions_count
 * @property Collection<int, Role>       $roles
 * @property int|null                    $roles_count
 * @property Collection<int, Tag>        $tags
 * @property int|null                    $tags_count
 * @property User|null                   $user
 *
 * @method static ProfileFactory  factory($count = null, $state = [])
 * @method static Builder|Profile newModelQuery()
 * @method static Builder|Profile newQuery()
 * @method static Builder|Profile permission($permissions)
 * @method static Builder|Profile query()
 * @method static Builder|Profile role($roles, $guard = null)
 * @method static Builder|Profile whereAddress($value)
 * @method static Builder|Profile whereBio($value)
 * @method static Builder|Profile whereCompanyDataRequests($value)
 * @method static Builder|Profile whereCompanySelectedId($value)
 * @method static Builder|Profile whereCreatedAt($value)
 * @method static Builder|Profile whereCreatedBy($value)
 * @method static Builder|Profile whereDeletedBy($value)
 * @method static Builder|Profile whereEmail($value)
 * @method static Builder|Profile whereEmails($value)
 * @method static Builder|Profile whereEnvelopeId($value)
 * @method static Builder|Profile whereFirstName($value)
 * @method static Builder|Profile whereId($value)
 * @method static Builder|Profile whereIsSigned($value)
 * @method static Builder|Profile whereLastName($value)
 * @method static Builder|Profile whereMobiles($value)
 * @method static Builder|Profile whereNexiTransactionCode($value)
 * @method static Builder|Profile wherePhone($value)
 * @method static Builder|Profile wherePostType($value)
 * @method static Builder|Profile whereUpdatedAt($value)
 * @method static Builder|Profile whereUpdatedBy($value)
 * @method static Builder|Profile whereUserId($value)
 * @method static Builder|Profile withAllTags((ArrayAccess | Tag | array | string) $tags, ?string $type = null)
 * @method static Builder|Profile withAllTagsOfAnyType($tags)
 * @method static Builder|Profile withAnyTags((ArrayAccess | Tag | array | string) $tags, ?string $type = null)
 * @method static Builder|Profile withAnyTagsOfAnyType($tags)
 * @method static Builder|Profile withoutTags((ArrayAccess | Tag | array | string) $tags, ?string $type = null)
 *
 * @mixin IdeHelperProfile
 *
 * @property string|null $surname
 *
 * @method static Builder|Profile whereSurname($value)
 *
 * @mixin \Eloquent
 */
class Profile extends BaseModel implements ModelWithUserContract, ModelProfileContract
{
    // spatie
    use HasRoles;
    use HasTags;

    /**
     * Undocumented variable.
     */
    protected string $guard_name = 'web';

    /**
     * @var string[]
     */
    protected $fillable = ['id', 'user_id'];

    /*
     * Undocumented function.
     */
    public function user(): BelongsTo
    {
        // $user = TenantService::model('user'); //no bisgna guardare dentro config(auth  etc etc
        // $user_class = \get_class($user);
        $userClass = getUserClass();

        return $this->belongsTo($userClass);
    }
}
