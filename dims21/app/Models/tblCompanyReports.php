<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tblCompanyReports extends Model
{
    protected $connection = 'sqlsrv3';
    protected $table = 'tblCOMPANYREPORTS';
    protected $primaryKey = 'ReportType';
}
