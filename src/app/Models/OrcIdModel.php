<?php

namespace App\Models;

use App\ValueObjects\Affiliation;
use CodeIgniter\Model;

final class OrcIdModel extends Model
{
    function get_affiliations(string $orcid)
    {
        // todo: use a remote
        $orcidUrl = "https://pub.orcid.org/v3.0/{$orcid}/employments";
        $xml      = simplexml_load_file($orcidUrl);
        if (!$xml) return null;

        return self::parse_orcid_affiliations($xml);
    }

    /**
     * @return Affiliation[]
     */
    private static function parse_orcid_affiliations(\SimpleXMLElement $xml): array
{
    $affiliations = [];

    // Loop over each affiliation group in the "activities" namespace
    foreach ($xml->children('activities', true)->{'affiliation-group'} as $group) {
        // Loop over each employment summary in the "employment" namespace
        foreach ($group->children('employment', true)->{'employment-summary'} as $employment) {
            // Get common elements (all common elements are in the "common" namespace)
            $common = $employment->children('common', true);

            // Extract department and role
            $department = (string)$common->{'department-name'};
            $role = (string)$common->{'role-title'};

            // Extract start year (if available)
            $start_year = null;
            if (isset($common->{'start-date'})) {
                $startDate = $common->{'start-date'}->children('common', true);
                $start_year = isset($startDate->year) ? (int)$startDate->year : null;
            }

            // Extract end year (if available)
            $end_year = null;
            if (isset($common->{'end-date'})) {
                $endDate = $common->{'end-date'}->children('common', true);
                $end_year = isset($endDate->year) ? (int)$endDate->year : null;
            }

            // Extract organization data
            $org = $common->{'organization'}->children('common', true);
            $institution = (string)$org->{'name'};

            // Extract address data from the organization
            $address = $org->{'address'}->children('common', true);
            $city = (string)$address->{'city'};
            $region = (string)$address->{'region'}; // may be empty if not provided
            $country = (string)$address->{'country'};

            // Create the Affiliation object and add it to the list
            $affiliations[] = new Affiliation(
                $institution,
                $department,
                $role,
                $city,
                $region,
                $country,
                $start_year,
                $end_year
            );
        }
    }

    return $affiliations;
}

}
