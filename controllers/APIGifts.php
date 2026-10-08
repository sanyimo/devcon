<?php

namespace Controllers;

use Model\Gift;
use Model\Record;

class APIGifts {

    public static function index() {

        if(!is_admin()) {
            echo json_encode([]);
            return;
        }

        $gifts = Gift::all();

        $giftsWithTotals = [];
        foreach($gifts as $gift) {
            $giftArray = (array) $gift;
            $giftArray['total'] = Record::totalArray(['gift_id' => $gift->id, 'pack_id' => "1"]);
            $giftsWithTotals[] = $giftArray;
        }

        echo json_encode($giftsWithTotals);
        return;
        
    }
}