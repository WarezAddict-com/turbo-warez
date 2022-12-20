<?php

namespace Turbo\MovieDatabase;

class Utilz {
	
    public function makeMagnet($info_hash, $filename, $trackers) {

        if (is_array($trackers)) {
            $trackers = implode('&tr=', array_map('urlencode', $trackers));
        } else {
            $trackers = urlencode($trackers);
        }
        return 'magnet:?xt=urn:btih:' . $info_hash . '&dn=' . urlencode($filename) . '&tr=' . $trackers;
    }

}
