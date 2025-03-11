<?php

namespace Config;

use App\Helpers\Remote;
use CodeIgniter\Config\BaseService;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    private static ?array $dblp_remotes = null;

    static function dblp_remotes(): array
    {
        if (self::$dblp_remotes === null) {
            $cache              = \Config\Services::cache();
            self::$dblp_remotes = [
                new Remote('dblp.org', $cache),
                new Remote('dblp.uni-trier.de', $cache),
                new Remote('dblp2.uni-trier.de', $cache),
                new Remote('dblp.dagstuhl.de', $cache),
            ];
        };
        return self::$dblp_remotes;
    }

    static function dblp_domain(): string
    {
        foreach (self::dblp_remotes() as $r) {
            if ($r->is_online) {
                return $r->domain;
            }
        }
        return self::dblp_remotes()[0]->domain;
    }
}
