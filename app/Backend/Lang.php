<?php

namespace App\Backend;

class Lang
{
    public function getVocativ(string $string)
    {
        $string = preg_replace('/\s+/', '', $string);
        $string = mb_strtolower($string);
        $string = ucfirst($string);

        $last1 = mb_substr($string, -1);
        $last2 = mb_substr($string, -2);
        $last3 = mb_substr($string, -3);

        $without1 = mb_substr($string, 0, -1);
        $without2 = mb_substr($string, 0, -2);

        /**
         * Jednoduchá síta.
         */

        // Nesklonná jména (Ami, Stacy)
        if ($last1 == 'i' || $last1 == 'y' || $last2 == 'ie' || $last1 == 'e' || $last1 == 'o' || $last2 == 'th')
        {
            $vocativ = $string;
        }
        // Vzor žena / vzor předseda
        if ($last1 == 'a')
        {
            $vocativ = $without1 . 'o';
        }

        // Petr / Alexandr
        if ($last1 == 'r')
        {
            $vocativ = $without1 . 'ře';
        }

        // Vzor pán
        if (
            $last1 == 'l' || $last1 == 'b' || $last2 == 'ín' || $last2 == 'in' || $last1 == 'n' || $last1 == 'v'
            || $last1 == 't'
            || $last1 == 'm'
            || $last2 == 'ph'
            || $last2 == 'ur'
        )
        {
            $vocativ = $string . 'e';
        }

        // Vzor muž
        if ($last2 == 'el' || $last2 == 'ěj' || $last1 == 'š' || $last1 == 'ř' || $last1 == 'č' || $last1 == 'j')
        {
            $vocativ = $string . 'i';
        }

        if ($last1 == 'c' || $last1 == 's')
        {
            $vocativ = $string . 'i';
        }

        // "Aláh" / "Abduláh"
        if ($last2 == 'áh' || $last2 == 'ah')
        {
            $vocativ = $string . 'u';
        }

        // Latinské "achiles"
        if ($last2 == 'es')
        {
            $vocativ = $without1;
        }
        //Latisnké "prometheus"
        if ($last2 == 'us')
        {
            $vocativ = $without2 . 'e';
        }

        if ($last3 == 'vel')
        {
            $vocativ = $without2 . 'le';
        }

        if ($last2 == 'ek')
        {
            $vocativ = $without2 . 'ku';
        }


        if (empty($vocativ))
        {
            $vocativ = $string;
        }

        return $vocativ;

    }


    /**
     * Převede string do underscore tvaru.
     *
     * @param string $string
     *
     * @return string
     */
    public function toUnderScore(string $string)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }

    /**
     * @param $count
     * @param $one
     * @param $two
     * @param $five
     *
     * @return mixed
     */
    public function sayCount(int $count, $one, $two, $five)
    {
        if ($count == 0)
        {
            return $five;
        }
        if ($count == 1)
        {
            return $one;
        }
        elseif ($count >= 2 && $count <= 4)
        {
            return $two;
        }
        else
        {
            return $five;
        }
    }

}