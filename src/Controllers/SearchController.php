<?php
namespace ADM\WPPlugin\Controllers;

use ADM\WPPlugin\Base;
use ADM\WPPlugin\Oauth2;
use ADM\WPPlugin\Api;

if (file_exists(ABSPATH . 'wp-load.php')) {
    require_once(ABSPATH . 'wp-load.php');
}

class SearchController extends Base\ActionController
{
    public static function partners()
    {
        $params = self::$params;
        $search = $params['query'];
        $accountAssosiations = Api\Search::getAccountAssosiations($search);
        $accounts[] = array(
            'value' => '',
            'label' => __('No Results', ADMWPP_TEXT_DOMAIN))
        ;
        if ($accountAssosiations) {
            $accounts = array();
            foreach ($accountAssosiations as $key => $value) {
                $accounts[] = array(
                    'value' => $key,
                    'label' => $value
                );
            }
        }
        echo json_encode($accounts);
        die();
    }

    public static function autoComplete()
    {
        $params = self::$params;
        $search = $params['query'];
        $courses = Api\Search::getCoursesTitles($search);
        $coursesTitles = array();
        if ($courses) {
            $coursesTitles = array();
            foreach ($courses as $key => $value) {
                $coursesTitles[] = array(
                    'value' => $value,
                    'label' => $value
                );
            }
        }
        echo json_encode($coursesTitles);
        die();
    }
}
