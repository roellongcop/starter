<?php

namespace app\components;

use app\helpers\App;
use app\widgets\JsonEditor;
use yii\helpers\Inflector;
use yii\helpers\Json;

class FormatterComponent extends \yii\i18n\Formatter
{
    public function asStripTags($value)
    {
        return strip_tags($value);
    }

    public function asAgo($value)
    {
        $today = new \DateTime('now');
        $datetime = new \DateTime($value);
        $interval = $today->diff( $datetime );
        $suffix = ( $interval->invert ? ' ago' : ' to go' );
        
        if ( $v = $interval->y >= 1 ) return self::pluralize( $interval->y, 'year' ) . $suffix;
        if ( $v = $interval->m >= 1 ) return self::pluralize( $interval->m, 'month' ) . $suffix;
        if ( $v = $interval->d >= 28 ) return self::pluralize( 4, 'week' ) . $suffix;
        if ( $v = $interval->d >= 21 ) return self::pluralize( 3, 'week' ) . $suffix;
        if ( $v = $interval->d >= 14 ) return self::pluralize( 2, 'week' ) . $suffix;
        if ( $v = $interval->d >= 7 ) return self::pluralize( 1, 'week' ) . $suffix;
        if ( $v = $interval->d >= 1 ) return self::pluralize( $interval->d, 'day' ) . $suffix;
        if ( $v = $interval->h >= 1 ) return self::pluralize( $interval->h, 'hour' ) . $suffix;
        if ( $v = $interval->i >= 1 ) return self::pluralize( $interval->i, 'minute' ) . $suffix;

        if ($interval->s == 0) {
            return 'Just now';
        }
        
        return $this->pluralize( $interval->s, 'second' ) . $suffix;
    }

    private function pluralize( $count, $text )
    {
        return $count . (($count == 1)? " {$text}": " {$text}s");
    }

    public function asFulldate($value)
    {
        return $this->asDateToTimezone($value);
    }

    public function asDateToTimezone($date='', $format='F d, Y h:i:s A', $timezone="")
    {
        if (!$timezone) {
            if (($timezone = App::setting('system')->timezone) == null) {
                $timezone = Setting::GENERAL['timezone']['default'];
            }
        }

        $date = ($date)? $date: date('Y-m-d h:i:s A');

        $usersTimezone = new \DateTimeZone($timezone);
        $l10nDate = new \DateTime($date);
        $l10nDate->setTimeZone($usersTimezone);

        return $l10nDate->format($format);
    }

    public function asController2Menu($value)
    {
        $string = ucwords(
            str_replace('-', ' ', Inflector::titleize($value))
        );

        $string = str_replace('Controller', '', $string);

        return trim($string);
    }

    public function asBoolString($value)
    {
        return $value ? 'True': 'False';
    }

    public function asEncode($value)
    {
        return Json::encode($value);
    }

    public function asDecode($value)
    {
        return Json::decode($value, true);
    }

    public function asJsonEditor($value)
    {
        return JsonEditor::widget([
            'data' => $value,
        ]);
    }

    public function asQuery2ControllerID($value)
    {
        $get_called_class = explode("\\", $value);
        return Inflector::camel2id(substr(end($get_called_class), 0, -5));
    }

    public function asFileSize($bytes)
    {
        $gb = 1073741824;
        $mb = 1048576;
        $kb = 1024;

        if ($bytes >= $gb) {
            $bytes = number_format($bytes / $gb, 2) . ' GB';
        }
        elseif ($bytes >= $mb) {
            $bytes = number_format($bytes / $mb, 2) . ' MB';
        }
        elseif ($bytes >= $kb) {
            $bytes = number_format($bytes / $kb, 2) . ' KB';
        }
        elseif ($bytes > 1) {
            $bytes = number_format($bytes) . ' bytes';
        }
        elseif ($bytes == 1) {
            $bytes = number_format($bytes) . ' byte';
        }
        else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public function asDaterangeToSingle($date_range, $return='start')
    {
        $dates = explode(' - ', $date_range);
        $start = date("Y-m-d", strtotime($dates[0])); 
        $end = date("Y-m-d", strtotime($dates[1])); 

        return ($return == 'start')? $start: $end;
    }
}