<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'amount',
        'base_amount',
        'tip_percentage',
        'currency',
        'donor_name',
        'donor_email',
        'anonymous',
        'allow_contact',
        'status',
        'payment_method',
        'transaction_id',
        'message',
        'donation_type',
        'processing_fee',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'base_amount' => 'decimal:2',
        'tip_percentage' => 'decimal:2',
        'anonymous' => 'boolean',
        'allow_contact' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }

    public function getFormattedAmount(): string
    {
        return number_format($this->amount, 2);
    }

    public function getFormattedBaseAmount(): string
    {
        return number_format($this->base_amount, 2);
    }

    public function getFormattedTipPercentage(): string
    {
        return number_format($this->tip_percentage, 1);
    }
}
