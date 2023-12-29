<?php

namespace IBoot\Core\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class SystemSetting extends BaseModel
{
    use HasFactory, Notifiable;

    const FILE_SYSTEM = 'File System';
    const BUNNY_CDN = 'disk_bunnycdn';
    const S3 = 'disk_s3';
    const LOCAL = 'disk_local';
    const EMAIL_CONFIG = 'Email Config';
    const TRANSPORT_SMTP = 'smtp';
    const TRANSPORT_SES = 'ses';

    protected $guarded = [];

    protected $table = 'system_settings';
}
