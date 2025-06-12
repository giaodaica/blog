<?php

use Carbon\Carbon;

if (!function_exists('formatDate')) {
    function formatDate($date) {
        return Carbon::parse($date)
            ->locale('vi')
            ->isoFormat('dddd, DD/MM/YYYY - hh:mmA');
    }
}
