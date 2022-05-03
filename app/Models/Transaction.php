<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Transaction extends Model
{
    use HasFactory, HasUuid;

    /**
     * The table associated with the model
     * 
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The primary key for the model
     * 
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * The type of primary key
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates whether primary key auto-increments
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * Allows the given itens on the array to be used on the static function create;
     * 
     * @var array
     */
    protected $fillable = array('title', 'value', 'type');

    /**
     * Set of rules to validate POST inputs
     * 
     * @return array
     */
    public function rules()
    {
        return array(
            'title' => 'required|string',
            'value' => 'required|integer',
            'type'  => 'required|string|in:income,outcome'
        );
    }

    /**
     * Set of feedback message for validation breaking
     * 
     * @return array
     */
    public function feedback()
    {
        return array(
            'required' => 'Field :atribute is mandatory',
            'type.in'  => "invalid value, only 'income' or 'outcome' values"
        );
    }
}
