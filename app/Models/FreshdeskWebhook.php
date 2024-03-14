<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreshdeskWebhook extends Model
{
    use HasFactory;

    protected $table = 'freshdesk_webhook';

    protected $fillable = [
        'id',
        'cc_emails',
        'fwd_emails',
        'reply_cc_emails',
        'ticket_cc_emails',
        'fr_escalated',
        'spam',
        'email_config_id',
        'group_id',
        'priority',
        'requester_id',
        'responder_id',
        'source',
        'company_id',
        'status',
        'subject',
        'association_type',
        'support_email',
        'to_emails',
        'product_id',
        'freshdesk_id',
        'type',
        'due_by',
        'fr_due_by',
        'is_escalated',
        'custom_fields',
        'created_at',
        'updated_at',
        'associated_tickets_count',
        'tags',
    ];
}
