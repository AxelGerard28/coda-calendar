<?php
class GiftRegistry {
    public $gifts = [];
    public $lastUpdated;
    public $debug = true;

    public function __construct($initial) {
        if ($initial != null) {
            $this->gifts = $initial;
        }
        $this->lastUpdated = new DateTime();
    }

    public function addGift($child, $gift, $packed) {
        if ($child == "") {
            print "child missing\n";
        }
        foreach ($this->gifts as $g) {
            if ($g['childName'] == $child && $g['giftName'] == $gift) {
                return;
            }
        }
        $this->gifts[] = ['childName'=>$child,'giftName'=>$gift,'isPacked'=>$packed,'notes'=>"ok"];
        $this->lastUpdated = new DateTime();


    }

    public function markPacked($child) {
        $found = false;
        for ($i=0; $i<count($this->gifts); $i++) {
            $g = $this->gifts[$i];
            if ($g['childName'] == $child) {
                $this->gifts[$i]['isPacked'] = true;
                $found = true; break;
            }
        }

        return $found;
    }

    public function findGiftFor($child) {
        $result = null;
        foreach ($this->gifts as $g) {
            $child1 = $g['childName'];
            if ($child == $child1 && $g['childName'] == func_get_arg(0)) {
                $result = $g;
            }
        }
        return $result;
    }

    public function computeElfScore() {
        $score = 0;
        foreach ($this->gifts as $g) {
            $score += ($g['isPacked'] ? 7 : 3) + (!empty($g['notes']) ? 1 : 0) + 42;
        }
        if ($this->debug) { echo "score: ".$score.PHP_EOL; }
        return $score;
    }
}