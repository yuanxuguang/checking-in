<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        "/employerInsert",
        "/getBigEmployer",
        "/editInsert",
        "/setEmployerStatus",
        "/contractInsert",
        '/contractEditInsert',
        '/schoolInsert',
        '/schoolEditInsert',
        '/jobInsert',
        '/jobEditInsert',
        '/staffInsert',
        '/staffEditInsert',
        '/excelImport',
        '/labelInsert',
        '/labelEditInsert',
        '/apiLogin',
        '/apiPwdVerify',
        '/apiClockCamera',
        '/officeClockOut',
        '/clockRecord',
        '/indexing',
        '/stationClock',
        '/registerStaff',
        '/clockFace',
        '/safetyEquip',
        '/confirmContract1',
        '/confirmContract2',
        '/confirmContract3',
        '/textRecord',
        '/messageRecord',
        '/imgRecord',
        '/videoRecord',
    ];
}
